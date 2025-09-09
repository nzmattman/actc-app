import { Method } from '@/api/Api.enums.ts';
import { AxiosError, AxiosResponse } from 'axios';
import {
  ApiErrorResponse,
  ApiResponse,
  Config,
  Parameter,
} from './Api.types.ts';
import { ApiClient } from './ApiClient.ts';
import { ApiError } from './errors/ApiError.ts';

export const Api = {
  client: ApiClient(),
  defaults: {
    method: Method.GET,
    params: null,
  },

  /**
   * Request Methods
   */
  async request(config: Config): Promise<ApiResponse> {
    const requestConfig: Config = {
      ...this.defaults,
      ...config,
    };

    if (config.file) {
      requestConfig.responseType = 'blob';
    }

    const urlParameters: Parameter[] = [this.getPath(requestConfig)];
    if (requestConfig.urlParameters) {
      urlParameters.push(...requestConfig.urlParameters);
    }

    requestConfig.url = this.buildUrl(urlParameters);

    try {
      const response = await this.client.request(requestConfig);

      return this.afterRequest(response, requestConfig);
    } catch (err) {
      const error = err as AxiosError<ApiErrorResponse>;
      const message = error.response?.data.message
        ? error.response.data.message
        : error.message;
      let errors = error.response?.data.errors || {};
      if (config.file) {
        // @ts-ignore
        errors = JSON.parse(await error.response.data.text()).errors;
      }
      const status = error?.response?.status || 500;
      throw new ApiError(message, status, errors);
    }
  },

  afterRequest(response: AxiosResponse, config?: Config): ApiResponse {
    return {
      data: config?.file
        ? {
            data: response.data,
            filename: response.headers['content-disposition']
              .split('filename=')[1]
              .replaceAll('"', ''),
          }
        : response.data,
      status: response.status,
    };
  },

  getPath(config: Config): string {
    // if the request has a url, use that
    if (config.url) {
      return config.url;
    }

    // no path was found, return base
    return '/';
  },

  buildUrl(args: Parameter[]): string {
    return args
      .join('/')
      .replace(/\/+/g, '/')
      .replace(/^(.+):\//, '$1://')
      .replace(/^file:/, 'file:/')
      .replace(/\/(\?|&|#[^!])/g, '$1')
      .replace(/\?/g, '&')
      .replace('&', '?');
  },
};
