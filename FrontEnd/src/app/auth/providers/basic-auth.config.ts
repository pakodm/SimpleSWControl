export interface NpAuthBasicModuleConfig {
    alwaysFail?: boolean;
    rememberMe?: boolean;
    endpoint?: string;
    method?: string;
    redirect?: {
      success?: string | null;
      failure?: string | null;
    };
    defaultErrors?: string[];
    defaultMessages?: string[];
}

export interface NpAuthBasicResetModuleConfig extends NpAuthBasicModuleConfig {
    resetPasswordTokenKey?: string;
}

export interface NpAuthBasicProviderConfig {
    baseEndpoint?: string;
    login?: boolean | NpAuthBasicModuleConfig;
    requestToken?: boolean | NpAuthBasicModuleConfig;
    requestSessionData?: boolean | NpAuthBasicModuleConfig;
    register?: boolean | NpAuthBasicModuleConfig;
    requestPass?: boolean | NpAuthBasicModuleConfig;
    resetPass?: boolean | NpAuthBasicResetModuleConfig;
    logout?: boolean | NpAuthBasicResetModuleConfig;
    token?: {
      key?: string;
      getter?: Function;
    };
    errors?: {
      key?: string;
      getter?: Function;
    };
    messages?: {
      key?: string;
      getter?: Function;
    };
    validation?: {
      password?: {
        required?: boolean;
        minLength?: number | null;
        maxLength?: number | null;
        regexp?: string | null;
      };
      email?: {
        required?: boolean;
        regexp?: string | null;
      };
      fullName?: {
        required?: boolean;
        minLength?: number | null;
        maxLength?: number | null;
        regexp?: string | null;
      };
    };
}
