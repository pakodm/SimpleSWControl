import { HttpResponse } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';

import { NpAuthResult } from '../services/auth.service';
import { deepExtend, getDeepFromObject } from '../helpers';

export abstract class NpAbstractAuthProvider {

  protected defaultConfig: any = {};
  protected config: any = {};

  setConfig(config: any): void {
    this.config = deepExtend({}, this.defaultConfig, config);
  }

  getConfigValue(key: string): any {
    return getDeepFromObject(this.config, key, null);
  }

  abstract authenticate(data?: any): Observable<NpAuthResult>;

  abstract refreshToken(token?: any): Observable<NpAuthResult>;

  abstract logout(token?: any): Observable<NpAuthResult>;

  /*
  abstract requestPassword(data?: any): Observable<NpAuthResult>;

  abstract resetPassword(data?: any): Observable<NpAuthResult>;
  */
  protected createFailResponse(data?: any): HttpResponse<Object> {
    return new HttpResponse<Object>({ body: {}, status: 401 });
  }

  protected createSuccessResponse(data?: any): HttpResponse<Object> {
    return new HttpResponse<Object>({ body: {}, status: 200 });
  }

  protected getJsonSafe(res: HttpResponse<Object>): any {
    return res.body;
  }
}
