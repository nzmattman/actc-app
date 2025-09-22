import { NotificationStore } from '@/stores/Notification.types.ts';
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useNotificationStore = defineStore(
  'Notifications',
  (): NotificationStore => {
    /**
     * store
     */
    const count = ref(0);

    /**
     * getters
     */

    /**
     * actions
     */

    return {
      count,
    };
  },
);
