import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { AlertService } from '../shared/services/alert.service';
import * as utils from '../shared/utils';

const server = utils.getAPIBaseUrl();

@Injectable()
export class CatalogosService {

  constructor(private http: HttpClient, private alert: AlertService) { }

  getMe() {
    return this.http.post(`${server}/api/me`, {})
      .catch((error) => this.alert.errorHandler(error));
  }

}
