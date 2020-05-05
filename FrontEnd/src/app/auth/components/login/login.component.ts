import { Component, OnInit, Inject } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';

import { NP_AUTH_CONFIG_DATA } from '../../auth.config';
import { NpAuthResult, NpAuthService } from '../../services/auth.service';
import { getDeepFromObject } from '../../helpers';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public form: FormGroup;

  user: any = {
    username: 'test@test.com',
    password: ''
  };
  provider = '';
  showMessages: any = {};
  redirectDelay = 0;

  messages: string[] = [];
  errors: string[] = [];
  submitted = false;
  returnUrl: string;


  constructor(private fb: FormBuilder, protected service: NpAuthService,
    @Inject(NP_AUTH_CONFIG_DATA) protected config: {}, protected router: Router,
    private route: ActivatedRoute) {

    this.redirectDelay = this.getConfigValue('forms.login.redirectDelay');
    this.provider = this.getConfigValue('forms.login.provider');
    this.showMessages = this.getConfigValue('forms.login.showMessages');

    //   this.form = this.fb.group({
    //     username: ['testUser', Validators.compose([Validators.required])],
    //     password: ['nuevaContraseñaCambiada004', Validators.compose([Validators.required])]
    //     // uname: [null, []], password: [null, []]
    // });
  }

  ngOnInit() {
    /*
    this.form = this.fb.group({
        username: [null, Validators.compose([Validators.required])],
        password: [null, Validators.compose([Validators.required])]
        // uname: [null, []], password: [null, []]
    });
    */
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/dashboard';
  }

  login(): void {
    this.errors = this.messages = [];
    this.submitted = true;

    this.service.authenticate(this.provider, this.user).subscribe((result: NpAuthResult) => {
      this.submitted = false;
      if (result.isSuccess()) {
        this.messages = result.getMessages();
        this.router.navigate(['/dashboard'], { queryParams: { returnUrl: this.returnUrl } });
      } else {
        console.log(result);
        this.errors = result.getErrors();
      }

      /*const redirect = result.getRedirect();
      if (redirect) {
        setTimeout(() => {
          return this.router.navigateByUrl(redirect);
        }, this.redirectDelay);
      }*/
      // this.router.navigate(['/'], { queryParams: { returnUrl: this.returnUrl } });
    });
  }

  getConfigValue(key: string): any {
    return getDeepFromObject(this.config, key, null);
  }
}
