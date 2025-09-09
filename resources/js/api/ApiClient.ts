import axios, {
  AxiosError,
  AxiosInstance,
  AxiosRequestConfig,
  AxiosResponse,
} from 'axios';

export enum HttpStatusCode {
  CSRF_EXPIRED = 419,
}

export interface LocalAxiosConfig extends AxiosRequestConfig {
  isRetryRequest?: boolean;
}

export const ApiClient = (): AxiosInstance => {
  const options = {
    baseURL: import.meta.env.VITE_BASE_API_URL,
    withCredentials: true,
    withXSRFToken: true,
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
    },
  };

  const client = axios.create(options);

  client.interceptors.request.use((config) => {
    return config;
  });

  client.interceptors.response.use(
    (response: AxiosResponse) => {
      return response;
    },
    async (error: AxiosError) => {
      console.log('did we hit here?', error);
      if (!error.response || !error.config) {
        return Promise.reject(error);
      }

      const config = error.config as LocalAxiosConfig;

      if (
        error.response.status === HttpStatusCode.CSRF_EXPIRED &&
        !config.isRetryRequest
      ) {
        // If the error has status code 419,
        // lets try to refresh the CSRF token and run it again
        await client.get('sanctum/csrf-cookie');

        // set a config flag so we don't get stuck in a loop
        config.isRetryRequest = true;

        return client.request(config);
      }

      return Promise.reject(error);
    },
  );

  client.interceptors.response.use(
    (response) => {
      const excludeURLsRegex =
        /\b(csrf-cookie|auth\/login|auth\/logout|save)\b/;
      if (excludeURLsRegex.test(response.request.responseURL)) {
        return response;
      }

      // Check if the response content type is JSON
      if (response.headers['content-type'].indexOf('application/json') === -1) {
        throw new Error('Response is not JSON');
      }
      // If it is JSON, return the response
      return response;
    },
    (error) => {
      // Do something with response error
      return Promise.reject(error);
    },
  );

  return client;
};
