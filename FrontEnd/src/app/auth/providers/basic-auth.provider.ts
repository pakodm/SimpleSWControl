import { Injectable } from '@angular/core';
import { HttpClient, HttpResponse, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { ActivatedRoute } from '@angular/router';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';

import { NpAuthResult } from '../services/auth.service';
import { NpAbstractAuthProvider } from './abstract-auth.provider';
import { NpAuthBasicProviderConfig } from './basic-auth.config';
import { getDeepFromObject } from '../helpers';
import { getAPIBaseUrl } from '../../shared/utils';

@Injectable()
export class NpBasicAuthProvider extends NpAbstractAuthProvider {

  protected defaultConfig: NpAuthBasicProviderConfig = {
    baseEndpoint: getAPIBaseUrl() + '/api/',
    login: {
      endpoint: 'login',
      method: 'post',
      redirect: {
        success: '/acceso/seleccionaEmpresa',
        failure: null,
      },
      defaultErrors: ['Usuario o contraseña no válido'],
      defaultMessages: ['Login OK'],
    },
    logout: {
      endpoint: 'login/',
      method: 'get',
    },
    errors: {
      key: 'status.message',
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

  constructor(protected http: HttpClient, private route: ActivatedRoute) {
    super();
  }

  authenticate(data?: any): Observable<NpAuthResult> {
    const method = this.getConfigValue('login.method');
    const url = this.getActionEndpoint('login');

    return this.http.request(method, url, { body: data, observe: 'response' })
      .map((res) => {
        if (this.getConfigValue('login.alwaysFail')) {
          throw this.createFailResponse(data);
        }
        return res;
      })
      .map((res) => {
        return new NpAuthResult(
          true,
          res,
          this.getConfigValue('login.redirect.success'),
          [],
          this.getConfigValue('messages.getter')('login', res),
          this.getConfigValue('token.getter')('login', res),
        );
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

  logout(): Observable<NpAuthResult> {
    const method = this.getConfigValue('logout.method');
    const url = this.getActionEndpoint('logout');

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

  refreshToken(token?: any): Observable<NpAuthResult> {
    return Observable.of(new NpAuthResult(false));
  }

  protected getActionEndpoint(action: string): string {
    const actionEndpoint: string = this.getConfigValue(`${action}.endpoint`);
    const baseEndpoint: string = this.getConfigValue('baseEndpoint');
    return baseEndpoint + actionEndpoint;
  }
}
