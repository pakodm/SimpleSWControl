import { Routes } from '@angular/router';
// import { NgModule, ModuleWithProviders } from '@angular/core';

import { AuthComponent } from './components/auth/auth.component';
import { LoginComponent } from './components/login/login.component';

export const authRoutes: Routes = [
    {
        path: 'acceso',
        component: AuthComponent,
        children: [
            {
                path: '',
                component: LoginComponent
            },
            {
                path: 'olvide-password',
                redirectTo: '',
            },
            {
                path: '**',
                redirectTo: ''
            },
        ],
    },
];

// export const authRoutes: ModuleWithProviders = RouterModule.forChild(routes);
