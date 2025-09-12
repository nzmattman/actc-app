import '../css/app.css';

import { defaultConfig, plugin as formkitPlugin } from '@formkit/vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import Aura from '@primeuix/themes/aura';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import config from './forms/config';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./pages/**/*.vue'),
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(formkitPlugin, defaultConfig(config))
      .use(PrimeVue, {
        theme: {
          preset: Aura,
        },
      })
      .use(ToastService)
      .use(ConfirmationService)
      .component('Link', Link)
      .mount(el);
  },
  progress: {
    color: '#a36f43',
  },
});
