import { InjectionToken } from '@angular/core';

export interface NpAuthConfig {
    forms?: any;
    providers?: any;
}

export interface NpAuthProvider {
    [key: string]: any;
}

export const defaultConfig: any = {
    forms: {
        login: {
            redirectDelay: 500,
            provider: 'email',
            rememberMe: true,
            showMessages: {
                success: true,
                error: true,
            },
        },
        requestToken: {
            redirectDelay: 500,
            provider: 'email',
            rememberMe: true,
            showMessages: {
                success: true,
                error: true,
            },
        },
        register: {
            redirectDelay: 500,
            provider: 'email',
            showMessages: {
                success: true,
                error: true,
            },
            terms: true,
        },
        requestPassword: {
            redirectDelay: 500,
            provider: 'email',
            showMessages: {
                success: true,
                error: true,
            },
        },
        resetPassword: {
            redirectDelay: 500,
            provider: 'email',
            showMessages: {
                success: true,
                error: true,
            },
        },
        logout: {
            redirectDelay: 500,
            provider: 'email',
        },
        validation: {
            password: {
                required: true,
                minLength: 4,
                maxLength: 50,
            },
            username: {
                required: true,
            },
            fullName: {
                required: false,
                minLength: 4,
                maxLength: 50,
            },
        },
    },
};

export const NP_AUTH_CONFIG_DATA = new InjectionToken<NpAuthConfig>('Nomipro auth config');
export const NB_AUTH_USER_CONFIG_TOKEN = new InjectionToken<NpAuthConfig>('Nomipro auth user config');
export const NP_AUTH_PROVIDERS_TOKEN = new InjectionToken<NpAuthProvider>('Nomipro auth provider');
export const NP_AUTH_CONFIG_WRAPPER_TOKEN = new InjectionToken<NpAuthProvider>('Nomipro auth token');
export const NP_AUTH_INTERCEPTOR_HEADER = new InjectionToken<NpAuthProvider>('Nomipro Simple Interceptor Header');
