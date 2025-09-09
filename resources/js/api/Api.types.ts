import { AxiosRequestConfig } from 'axios';

import { Method } from '@/api';

export type Parameter = string | number;

export interface Config<T = {}, T2 = any> extends AxiosRequestConfig {
  method?: Method;
  data?: T;
  params?: T2;
  urlParameters?: null | Parameter[];
  file?: boolean;
}

export interface ApiResponse<T = any> {
  data: T;
  status: number;
}

export interface ApiErrorResponse {
  message: string;
  errors: string[];
}
