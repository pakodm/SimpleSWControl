import { TestBed, inject } from '@angular/core/testing';
import { InjectionToken } from '@angular/core';
import { NpAuthService } from './auth.service';
import { Injectable, Optional, Inject, Injector } from '@angular/core';

import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/switchMap';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';

import { NpAbstractAuthProvider } from '../providers/abstract-auth.provider';
import { NP_AUTH_PROVIDERS_TOKEN } from '../auth.config';
import { NpAuthSimpleToken, NpTokenService } from './token.service';

describe('AuthService', () => {
  beforeEach(() => {
    const authServiceStub = {
      authenticate: function(): Observable<boolean> {
        return Observable.of(true);
      }
    };
    interface NpAuthProvider {
      [key: string]: any;
    }
    TestBed.configureTestingModule({
      providers: [NpTokenService, Injector,
        { provide: NpAuthService, useValue: authServiceStub },
        { provide: NP_AUTH_PROVIDERS_TOKEN, useValue: new InjectionToken<NpAuthProvider>('Nomipro auth provider') }
      ]
    });
  });

  it('should be created', inject([NpAuthService], (service: NpAuthService) => {
    expect(service).toBeTruthy();
  }));
});
