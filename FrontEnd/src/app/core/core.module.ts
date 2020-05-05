import { ModuleWithProviders, NgModule, Optional, SkipSelf } from '@angular/core';
import { CommonModule } from '@angular/common';

import {
    AuthModule,
    NomiProAuthProvider,
    NpAuthJWTToken,
    NbAuthJWTInterceptor,
    NP_AUTH_CONFIG_WRAPPER_TOKEN
} from '../auth';
import { throwIfAlreadyLoaded } from './import-module-guard';
import { HTTP_INTERCEPTORS } from '@angular/common/http/';

const NP_CORE_PROVIDERS = [
    ...AuthModule.forRoot({
        providers: {
            email: {
                service: NomiProAuthProvider,
            }
        }
    }).providers,
];

const SERVICES = [];

@NgModule({
  imports: [
    CommonModule
  ],
  exports: [
    AuthModule
  ],
  providers: [
    ...SERVICES
  ],
  declarations: []
})
export class CoreModule {

    static forRoot(): ModuleWithProviders {
        return <ModuleWithProviders>{
            ngModule: CoreModule,
            providers: [
                ...NP_CORE_PROVIDERS,
                ...SERVICES,
                { provide: NP_AUTH_CONFIG_WRAPPER_TOKEN, useClass: NpAuthJWTToken },
                { provide: HTTP_INTERCEPTORS, useClass: NbAuthJWTInterceptor, multi: true }
            ],
        };
    }

    constructor(@Optional() @SkipSelf() parentModule: CoreModule) {
        throwIfAlreadyLoaded(parentModule, 'CoreModule');
    }
}
