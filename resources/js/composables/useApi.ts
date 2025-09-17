import { Api, Method } from '@/api';
import { ApiResponse, Config } from '@/api/Api.types.ts';

export const useApi = () => {
  return {
    ...Api,

    async post<T = any>(url: string, data?: any): Promise<ApiResponse<T>> {
      const config: Config = {
        method: Method.POST,
        url,
        data,
      };

      return this.request(config);
    },

    async patch<T = any>(url: string, data?: any): Promise<ApiResponse<T>> {
      const config: Config = {
        method: Method.PATCH,
        url,
        data,
      };

      return this.request(config);
    },

    async destroy<T = any>(url: string, data?: any): Promise<ApiResponse<T>> {
      const config: Config = {
        method: Method.DELETE,
        url,
        data,
      };

      return this.request(config);
    },
  };
};
