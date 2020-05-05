import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { HttpErrorResponse } from '@angular/common/http';
import 'rxjs/add/observable/throw';

import * as util from '../utils';

@Injectable()
export class AlertService {

  constructor() { }

  errorHandler(error: HttpErrorResponse): Observable<any> {
    console.log(error);
    return Observable.throw((error || 'Server error'));
  }

}
