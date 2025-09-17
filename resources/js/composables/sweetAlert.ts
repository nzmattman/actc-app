import swal from 'sweetalert';

import {
  SweetAlertButton,
  SweetAlertIcons,
  SweetAlertOptions,
  SweetAlertValue,
} from '@/composables';

const defaultOptions = {
  closeOnClickOutside: false,
  closeOnEsc: false,
  dangerMode: false,
  buttons: {
    confirm: { text: 'Ok', visible: true },
  },
};

export const SweetAlert = {
  // fire the alert type modal
  async alert(
    message: string,
    config?: SweetAlertOptions,
  ): Promise<SweetAlertValue> {
    const icon = SweetAlertIcons.INFO as string;
    const options = {
      ...defaultOptions,
      icon,
      title: message,
      ...config,
    };

    return swal({ ...options });
  },

  // fire the success type modal
  async success(
    message: string,
    config?: SweetAlertOptions,
  ): Promise<SweetAlertValue> {
    const icon = SweetAlertIcons.SUCCESS as string;
    const options = {
      ...defaultOptions,
      icon,
      title: message,
      ...config,
    };

    return swal({ ...options });
  },

  // fire the generic error type modal
  async error(
    message: string,
    config?: SweetAlertOptions,
  ): Promise<SweetAlertValue> {
    const icon = SweetAlertIcons.ERROR as string;
    const options = {
      ...defaultOptions,
      icon,
      title: message,
      ...config,
      className: 'swal--generic-error',
    };

    return swal({ ...options });
  },

  async confirm(
    message: string,
    config?: SweetAlertOptions,
    confirm?: SweetAlertButton,
    cancel?: SweetAlertButton,
  ): Promise<SweetAlertValue> {
    const icon = SweetAlertIcons.WARNING as string;
    const options = {
      ...defaultOptions,
      icon,
      title: message,
      dangerMode: true,
      buttons: {
        confirm: {
          text: 'Ok',
          visible: true,
          value: {
            isConfirmed: true,
            isCancelled: false,
            isClosed: false,
          },
        },
        close: {
          text: 'Cancel',
          visible: true,
          value: {
            isConfirmed: false,
            isCancelled: true,
            isClosed: false,
          },
        },
      },
      ...config,
    };

    if (confirm) {
      if (confirm.text) {
        options.buttons.confirm.text = confirm.text;
      }
      if (confirm.className) {
        options.buttons.confirm.className = confirm.className;
      }
    }

    if (cancel) {
      if (cancel.text) {
        options.buttons.close.text = cancel.text;
      }
      if (cancel.className) {
        options.buttons.close.className = cancel.className;
      }
    }

    const result = await swal({ ...options });

    if (result === null) {
      return {
        isConfirmed: false,
        isCancelled: false,
        isClosed: true,
      };
    }

    return result;
  },
};

export const useSwal = () => SweetAlert;
