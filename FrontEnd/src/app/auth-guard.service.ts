import { Injectable } from '@angular/core';
import { CanActivate, CanActivateChild, Router, RouterStateSnapshot, ActivatedRouteSnapshot } from '@angular/router';
import { NpAuthService, NpTokenService, NpAuthJWTToken } from './auth/services';

@Injectable()
export class AuthGuard implements CanActivate, CanActivateChild {

  private tokenData: NpAuthJWTToken;

  constructor(private authService: NpAuthService, private router: Router,
    private tokenService: NpTokenService) {
    this.tokenService.get().subscribe((token: NpAuthJWTToken) => {
      this.tokenData = token;
    });
  }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    return this.authService.isAuthenticated()
      .do(authenticated => {
        if (!authenticated) {
          this.router.navigate(['acceso'], { queryParams: { returnUrl: state.url } });
        }
      });
  }

  canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    return this.canActivate(route, state);
  }
}
