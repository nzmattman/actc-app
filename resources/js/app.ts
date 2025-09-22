import '../css/app.css';

import { defaultConfig, plugin as formkitPlugin } from '@formkit/vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { configureEcho } from '@laravel/echo-vue';
import Aura from '@primeuix/themes/aura';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import config from './forms/config';

configureEcho({
  broadcaster: 'reverb',
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./pages/**/*.vue'),
    ),
  setup({ el, App, props, plugin }) {
    const pinia = createPinia();

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
      .use(pinia)
      .component('Link', Link)
      .directive('tooltip', Tooltip)
      .mount(el);
  },
  progress: {
    color: '#a36f43',
  },
});
