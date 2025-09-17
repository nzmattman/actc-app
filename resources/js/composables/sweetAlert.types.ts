import type { ButtonList } from 'sweetalert/typings/modules/options/buttons';
import type { ContentOptions } from 'sweetalert/typings/modules/options/content';

export interface SweetAlertOptions {
  title?: string;
  text?: string;
  icon?: string;
  buttons?: ButtonList | Array<string | boolean>;
  content?: ContentOptions;
  className?: string;
  closeOnClickOutside?: boolean;
  closeOnEsc?: boolean;
  dangerMode?: boolean;
  timer?: number;
}

export interface SweetAlertValue {
  isConfirmed: boolean;
  isCancelled: boolean;
  isClosed: boolean;
}

export interface SweetAlertButton {
  text: string;
  className?: string;
}
