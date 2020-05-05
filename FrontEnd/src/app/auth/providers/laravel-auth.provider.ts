import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';

import { NpAuthResult } from '../services/auth.service';
import { NpAbstractAuthProvider } from './abstract-auth.provider';
import { NpAuthBasicProviderConfig } from './basic-auth.config';
import { NpAuthJWTToken } from '../services/token.service';
import { getDeepFromObject } from '../helpers';
import { getAPIBaseUrl } from '../../shared/utils';

@Injectable()
export class NomiProAuthProvider extends NpAbstractAuthProvider {

  protected defaultConfig: NpAuthBasicProviderConfig = {
    baseEndpoint: getAPIBaseUrl() + '/api/',
    login: {
      endpoint: 'login',
      method: 'post',
      redirect: {
        success: '/dashboard',
        failure: '/acceso',
      },
      defaultErrors: ['Usuario o contraseña no válido'],
      defaultMessages: ['Login OK'],
    },
    logout: {
      endpoint: 'login/',
      method: 'get',
    },
    requestToken: {
      endpoint: 'login/token',
      method: 'post',
      redirect: {
        success: '/dummy',
        failure: '/acceso',
      },
      defaultErrors: ['No se ha podido obtener el token'],
      defaultMessages: ['Token OK'],
    },
    requestSessionData: {
      endpoint: 'system/personal/usuario/',
      method: 'get',
      defaultErrors: ['No se han podido obtener los datos de sesion'],
      defaultMessages: ['OK'],
    },
    token: {
      key: 'Token.access_token',
      getter: (module: string, res: HttpResponse<Object>) => getDeepFromObject(res.body,
        this.getConfigValue('token.key'),
        null),
    },
    errors: {
      key: 'error',
      getter: (module: string, res: HttpErrorResponse) => getDeepFromObject(res.error,
        this.getConfigValue('errors.key'),
        this.getConfigValue(`${module}.defaultErrors`)),
    },
    messages: {
      key: 'status.message',
      getter: (module: string, res: HttpResponse<Object>) => getDeepFromObject(res.body,
        this.getConfigValue('messages.key'),
        this.getConfigValue(`${module}.defaultMessages`)),
    },
  };

  private userId: number;
  private result: any;
  private lStorageKey = 'npData';

  constructor(protected http: HttpClient, private route: ActivatedRoute) {
    super();
    this.userId = 0;
  }

  authenticate(data?: any): Observable<NpAuthResult> {
    const method = this.getConfigValue('login.method');
    const url = this.getActionEndpoint('login');
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const reqBody = 'email=' + data.username + '&password=' + data.password;
    return this.http.request(method, url, { body: reqBody, headers: headers, observe: 'response' })
      .map((res) => {
        if (this.getConfigValue('login.alwaysFail')) {
          throw this.createFailResponse(data);
        }
        return res;
      })
      .map((res) => {
        const userId = getDeepFromObject(res.body, 'user_id', null);
        if (userId !== null) {
          return new NpAuthResult(
            true,
            res,
            this.getConfigValue('login.redirect.success'),
            [],
            [],
            this.getConfigValue('token.getter')('login', res),
          );
        } else {
          let errors = [];
          errors = this.getConfigValue('errors.getter')('login', res);
          return new NpAuthResult(
            false,
            res,
            this.getConfigValue('login.redirect.failure'),
            errors,
          );
        }
      })
      .catch((res) => {
        let errors = [];
        if (res instanceof HttpErrorResponse) {
          errors = this.getConfigValue('errors.getter')('login', res);
        } else {
          errors.push('Something went wrong.');
        }

        return Observable.of(
          new NpAuthResult(
            false,
            res,
            this.getConfigValue('login.redirect.failure'),
            errors,
          ));
      });
  }

  refreshToken(token?: NpAuthJWTToken): Observable<NpAuthResult> {
    // console.log(token.getPayload().companyId);
    const method = this.getConfigValue('requestToken.method');
    const url = this.getActionEndpoint('requestToken');
    const headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
    const reqBody = 'userId=' + token.getPayload().userId + '&companyId=' + token.getPayload().companyId;
    return this.http.request(method, url, { body: reqBody, headers: headers, observe: 'response' })
    .map((res) => {
      const userId = getDeepFromObject(res.body, 'User.IdUsuario', null);
        if (userId !== null) {
          return new NpAuthResult(
            true,
            res,
            null,
            [],
            [],
            this.getConfigValue('token.getter')('requestToken', res),
          );
        } else {
          return new NpAuthResult(false, res, null, null);
        }
      // return Observable.of(new NpAuthResult(false));
    })
    .catch((res) => {
      if (res instanceof HttpErrorResponse) {
        // this.alert.errorHandler(res.error);
      }
      return Observable.of(
        new NpAuthResult(false, res, null, null)
      );
    });
  }

  getSessionData(uid: number) {
    const method = this.getConfigValue('requestSessionData.method');
    const url = this.getActionEndpoint('requestSessionData') + uid;
  }

  logout(token: any): Observable<NpAuthResult> {
    const method = this.getConfigValue('logout.method');
    const url = this.getActionEndpoint('logout') + token['userId'];

    return Observable.of({})
      .switchMap((res: any) => {
        if (!url) {
          return Observable.of(res);
        }
        return this.http.request(method, url, { observe: 'response' });
      })
      .map((res) => {
        if (this.getConfigValue('logout.alwaysFail')) {
          throw this.createFailResponse();
        }

        return res;
      })
      .map((res) => {
        return new NpAuthResult(
          true,
          res,
          this.getConfigValue('logout.redirect.success'),
          [],
          this.getConfigValue('messages.getter')('logout', res));
      })
      .catch((res) => {
        let errors = [];
        if (res instanceof HttpErrorResponse) {
          errors = this.getConfigValue('errors.getter')('logout', res);
        } else {
          errors.push('Something went wrong.');
        }

        return Observable.of(
          new NpAuthResult(
            false,
            res,
            this.getConfigValue('logout.redirect.failure'),
            errors,
          ));
      });
  }

  protected getActionEndpoint(action: string): string {
    const actionEndpoint: string = this.getConfigValue(`${action}.endpoint`);
    const baseEndpoint: string = this.getConfigValue('baseEndpoint');
    return baseEndpoint + actionEndpoint;
  }

  protected setUpUserData(apiResponse: any) {
    this.result = {
      IdSesion: apiResponse.response.IdSesion,
      Usuario: apiResponse.response.Usuario,
    };
    localStorage.setItem(this.lStorageKey, JSON.stringify(this.result));
  }
}
