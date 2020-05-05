import { Injector, ModuleWithProviders, NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { MatIconModule, MatCardModule, MatInputModule, MatCheckboxModule, MatButtonModule } from '@angular/material';
import { FlexLayoutModule } from '@angular/flex-layout';

// NomiPro
import { NpAuthService } from './services/auth.service';
import { NpAuthSimpleToken, NpAuthJWTToken, NpTokenService } from './services/token.service';
import { NpBasicAuthProvider } from './providers/basic-auth.provider';
import { NomiProAuthProvider } from './providers/laravel-auth.provider';
import {
  defaultConfig,
  NP_AUTH_CONFIG_DATA,
  NB_AUTH_USER_CONFIG_TOKEN,
  NP_AUTH_PROVIDERS_TOKEN,
  NP_AUTH_CONFIG_WRAPPER_TOKEN,
  NP_AUTH_INTERCEPTOR_HEADER,
  NpAuthConfig
} from './auth.config';
import { authRoutes } from './auth.routes';
import { deepExtend } from './helpers';
import { LoginComponent } from './components/login/login.component';
import { AuthComponent } from './components/auth/auth.component';

export function npAuthServiceFactory(config: any, tokenService: NpTokenService, injector: Injector) {
  const providers = config.providers || {};

  for (const key in providers) {
    if (providers.hasOwnProperty(key)) {
      const provider = providers[key];
      const object = injector.get(provider.service);
      object.setConfig(provider.config || {});
    }
  }
  return new NpAuthService(tokenService, injector, providers);
}

export function npOptionsFactory(options) {
  return deepExtend(defaultConfig, options);
}

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(authRoutes),
    MatIconModule,
    MatCardModule,
    MatInputModule,
    MatCheckboxModule,
    MatButtonModule,
    FlexLayoutModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  declarations: [
    LoginComponent,
    AuthComponent
  ],
  exports: [
    AuthComponent,
    LoginComponent,
  ]
})
export class AuthModule {
  static forRoot(npAuthConfig?: NpAuthConfig): ModuleWithProviders {
    return <ModuleWithProviders>{
      ngModule: AuthModule,
      providers: [
        { provide: NB_AUTH_USER_CONFIG_TOKEN, useValue: npAuthConfig },
        { provide: NP_AUTH_CONFIG_DATA, useFactory: npOptionsFactory, deps: [NB_AUTH_USER_CONFIG_TOKEN] },
        { provide: NP_AUTH_PROVIDERS_TOKEN, useValue: {} },
        { provide: NP_AUTH_CONFIG_WRAPPER_TOKEN, useClass: NpAuthJWTToken },
        { provide: NP_AUTH_INTERCEPTOR_HEADER, useValue: 'Authorization' },
        {
          provide: NpAuthService,
          useFactory: npAuthServiceFactory,
          deps: [NP_AUTH_CONFIG_DATA, NpTokenService, Injector],
        },
        NpTokenService,
        NpBasicAuthProvider,
        NomiProAuthProvider,
      ],
    };
  }
}
