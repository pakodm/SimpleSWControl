import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { FormsModule } from '@angular/forms';
import { MatIconModule, MatCardModule, MatInputModule, MatCheckboxModule, MatButtonModule } from '@angular/material';
import { Observable } from 'rxjs/Observable';
import { InjectionToken } from '@angular/core';
import { RouterTestingModule } from '@angular/router/testing';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { FormBuilder } from '@angular/forms';
import { NP_AUTH_CONFIG_DATA } from '../../auth.config';
import { NpAuthResult, NpAuthService } from '../../services/auth.service';
import { getDeepFromObject } from '../../helpers';

import { LoginComponent } from './login.component';

describe('LoginComponent', () => {
  let component: LoginComponent;
  let fixture: ComponentFixture<LoginComponent>;

  beforeEach(async(() => {
    const authServiceStub = {
      authenticate: function(): Observable<boolean> {
        return Observable.of(true);
      }
    };
    interface NpAuthConfig {
      forms?: any;
      providers?: any;
    }
    TestBed.configureTestingModule({
      declarations: [LoginComponent],
      imports: [FormsModule, MatIconModule, MatCardModule, MatInputModule, MatCheckboxModule,
        MatButtonModule, RouterTestingModule, BrowserAnimationsModule],
      providers: [FormBuilder,
        { provide: NpAuthService, useValue: authServiceStub },
        { provide: NP_AUTH_CONFIG_DATA, useValue: new InjectionToken<NpAuthConfig>('Nomipro auth config') }
      ]
    })
      .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LoginComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
