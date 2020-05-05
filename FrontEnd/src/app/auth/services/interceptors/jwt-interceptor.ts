import { Injectable, Injector } from '@angular/core';
import { Router } from '@angular/router';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/switchMap';
import * as moment from 'moment';

import { NpAuthService } from '../auth.service';
import { NpAuthJWTToken } from '../token.service';

@Injectable()
export class NbAuthJWTInterceptor implements HttpInterceptor {

  private refreshing = false;

  constructor(private injector: Injector, private router: Router) { }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

    return this.authService.getToken().switchMap((token: NpAuthJWTToken) => {
      if (token && token.isValid()) {
        const JWT = `Bearer ${token.getValue()}`;
        req = req.clone({
          setHeaders: {
            Authorization: JWT,
          },
        });
        if (moment.unix(token.getPayload().exp).diff(moment(), 'minutes') < 5) {
          if (!this.refreshing) {
            // console.log('menos de 5 min, Aquí frank');
            this.refreshing = true;
            this.authService.refreshToken('email', token).subscribe((data) => {
              // console.log(data);
              this.refreshing = false;
            });
          }
        }
      } else {
        this.router.navigate(['acceso']);
      }
      return next.handle(req);
    });
  }

  protected get authService(): NpAuthService {
    return this.injector.get(NpAuthService);
  }

}
