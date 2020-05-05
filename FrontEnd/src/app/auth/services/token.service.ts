import { Inject, Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Observable } from 'rxjs/Observable';

import 'rxjs/add/operator/do';
import 'rxjs/add/operator/switchMap';
import 'rxjs/add/observable/of';
import 'rxjs/add/operator/publish';

import { NP_AUTH_CONFIG_WRAPPER_TOKEN, NP_AUTH_CONFIG_DATA } from '../auth.config';
import { deepExtend, getDeepFromObject, urlBase64Decode } from '../helpers';

/**
 * Wrapper for simple (text) token
 */
@Injectable()
export class NpAuthSimpleToken {

  protected token = '';

  setValue(token: string) {
    this.token = token;
  }

  /**
   * Returns the token value
   * @returns string
   */
  getValue() {
    return this.token;
  }

  /**
   * Is non empty and valid
   * @returns {boolean}
   */
  isValid(): boolean {
    return !!this.token;
  }
}

/**
 * Wrapper for JWT token with additional methods.
 */
@Injectable()
export class NpAuthJWTToken extends NpAuthSimpleToken {

  /**
   * Returns payload object
   * @returns any
   */
  getPayload(): any {
    const parts = this.token.split('.');

    if (parts.length !== 3) {
      throw new Error(`The token ${this.token} is not valid JWT token and must consist of three parts.`);
    }

    const decoded = urlBase64Decode(parts[1]);
    if (!decoded) {
      throw new Error(`The token ${this.token} is not valid JWT token and cannot be decoded.`);
    }

    return JSON.parse(decoded);
  }

  /**
   * Returns expiration date
   * @returns Date
   */
  getTokenExpDate(): Date {
    const decoded = this.getPayload();
    if (!decoded.hasOwnProperty('exp')) {
      return null;
    }

    const date = new Date(0);
    date.setUTCSeconds(decoded.exp);

    return date;
  }

  /**
   * Is data expired
   * @returns {boolean}
   */
  isValid(): boolean {
    return super.isValid() && (!this.getTokenExpDate() || new Date() < this.getTokenExpDate());
  }

  /**
   * Get claim
   * @returns any
   */
  getClaim(claimName: string) {
    const decoded = this.getPayload();
    if (decoded.hasOwnProperty(claimName)) {
      return decoded[claimName];
    } else {
      return null;
    }
  }
}

/**
 * Provides access to the stored token.
 * By default returns NpAuthSimpleToken instance,
 * but you can inject NpAuthJWTToken if you need additional methods for JWT token.
 *
 * @example Injecting NpAuthJWTToken, so that NpTokenService will now return NpAuthJWTToken instead
 * of the default NpAuthSimpleToken
 *
 * ```
 * // import token and service into your AppModule
 * import { NP_AUTH_CONFIG_WRAPPER_TOKEN,  NpAuthJWTToken} from './auth';
 *
 * // add to a list of providers
 * providers: [
 *  // ...
 *  { provide: NP_AUTH_CONFIG_WRAPPER_TOKEN, useClass: NpAuthJWTToken },
 * ],
 * ```
 */
@Injectable()
export class NpTokenService {

  protected defaultConfig: any = {
    token: {
      key: 'access_token',

      getter: (): Observable<NpAuthSimpleToken> => {
        const tokenValue = localStorage.getItem(this.getConfigValue('token.key'));
        this.tokenWrapper.setValue(tokenValue);
        return Observable.of(this.tokenWrapper);
      },

      setter: (token: string|NpAuthSimpleToken): Observable<null> => {
        const raw = token instanceof NpAuthSimpleToken ? token.getValue() : token;
        localStorage.setItem(this.getConfigValue('token.key'), raw);
        return Observable.of(null);
      },

      deleter: (): Observable<null> => {
        localStorage.removeItem(this.getConfigValue('token.key'));
        return Observable.of(null);
      },
    },
  };
  protected config: any = {};
  protected token$: BehaviorSubject<any> = new BehaviorSubject(null);

  constructor(@Inject(NP_AUTH_CONFIG_DATA) protected options: any,
              @Inject(NP_AUTH_CONFIG_WRAPPER_TOKEN) protected tokenWrapper: NpAuthSimpleToken) {
    this.setConfig(options);

    this.get().subscribe(token => this.publishToken(token));
  }

  setConfig(config: any): void {
    this.config = deepExtend({}, this.defaultConfig, config);
  }

  getConfigValue(key: string): any {
    return getDeepFromObject(this.config, key, null);
  }

  /**
   * Sets the token into the storage. This method is used by the NbAuthService automatically.
   * @param {string} rawToken
   * @returns {Observable<any>}
   */
  set(rawToken: string): Observable<null> {
    return this.getConfigValue('token.setter')(rawToken)
      .switchMap(_ => this.get())
      .do((token: NpAuthSimpleToken) => {
        this.publishToken(token);
      });
  }

  /**
   * Returns observable of current token
   * @returns {Observable<NpAuthSimpleToken>}
   */
  get(): Observable<NpAuthSimpleToken> {
    return this.getConfigValue('token.getter')();
  }

  /**
   * Publishes token when it changes.
   * @returns {Observable<NpAuthSimpleToken>}
   */
  tokenChange(): Observable<NpAuthSimpleToken> {
    return this.token$.publish().refCount();
  }

  /**
   * Removes the token
   * @returns {Observable<any>}
   */
  clear(): Observable<any> {
    this.publishToken(null);

    return this.getConfigValue('token.deleter')();
  }

  protected publishToken(token: NpAuthSimpleToken): void {
    this.token$.next(token);
  }
}
