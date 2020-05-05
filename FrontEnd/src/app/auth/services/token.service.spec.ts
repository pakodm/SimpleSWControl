import { TestBed, inject } from '@angular/core/testing';

import { NpTokenService } from './token.service';

import { Inject, Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Observable } from 'rxjs/Observable';

import 'rxjs/add/operator/do';
import 'rxjs/add/operator/switchMap';
import 'rxjs/add/observable/of';
import 'rxjs/add/operator/publish';

import { NP_AUTH_CONFIG_WRAPPER_TOKEN, NP_AUTH_CONFIG_DATA } from '../auth.config';
import { deepExtend, getDeepFromObject, urlBase64Decode } from '../helpers';

describe('TokenService', () => {
  beforeEach(() => {
    const authServiceStub = {
      authenticate: function(): Observable<boolean> {
        return Observable.of(true);
      }
    };
    TestBed.configureTestingModule({
      providers: [NpTokenService,
        { provide: NpTokenService, useValue: authServiceStub }
      ]
    });
  });

  it('should be created', inject([NpTokenService], (service: NpTokenService) => {
    expect(service).toBeTruthy();
  }));
});
