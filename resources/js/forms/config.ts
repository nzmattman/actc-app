import { createErrorHandlerPlugin } from '@forms/plugins';
import {
  PasswordMessage,
  PasswordRule,
} from '@forms/rules/PasswordStrengthRule';

import IconArrowDown from '@svg/icon-arrow-down.svg?raw';
import IconTick from '@svg/icon-check.svg?raw';
import IconEyeClosed from '@svg/icon-eye-closed.svg?raw';
import IconEyeOpen from '@svg/icon-eye-open.svg?raw';

export default {
  icons: {
    eyeClosed: IconEyeClosed,
    eyeOpen: IconEyeOpen,
    arrowDown: IconArrowDown,
    tick: IconTick,
  },

  config: {
    debug: import.meta.env.VITE_DEBUG === 'true',
  },

  plugins: [createErrorHandlerPlugin()],

  rules: {
    password: PasswordRule,
  },

  messages: {
    en: {
      validation: {
        password: PasswordMessage,
      },
    },
  },
};
