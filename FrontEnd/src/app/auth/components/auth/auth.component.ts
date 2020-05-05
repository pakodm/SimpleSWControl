import { Component, OnDestroy } from '@angular/core';

import { NpAuthService } from '../../services/auth.service';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.scss']
})
export class AuthComponent implements OnDestroy {

  subscrption: any;
  authenticated = false;
  token = '';

  constructor(protected auth: NpAuthService) {

    this.subscrption = auth.onAuthenticationChange()
      .subscribe((authenticated: boolean) => {
        this.authenticated = authenticated;
      });

  }

  ngOnDestroy(): void {
    this.subscrption.unsubscribe();
  }
}
