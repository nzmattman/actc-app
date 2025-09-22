<template>
  <AuthenticatedLayout title="Notifications" :backRoute="route('dashboard')">
    <Head title="Notifications" />

    <header>
      <h3 class="heading">Notifications</h3>
    </header>

    <div class="space-y-2">
      <template v-for="group in notificationList">
        <NotificationGroup
          v-if="group.data.length"
          :key="`${group.heading}-${group.data.length}`"
          :heading="group.heading"
          :notifications="group.data"
        />
      </template>

      <p v-if="!notifications.length">You have no notifications.</p>

      <WhenVisible
        :always="!reachedEnd"
        :params="{
          only: ['notifications', 'pagination'],
          data: {
            page: pagination.current_page + 1,
          },
          preserveUrl: true,
        }"
      >
        <template #fallback>
          <div class="loading__group" v-for="n in 2" :key="n">
            <div class="loading__row">
              <div
                class="loading__block animate-pulse"
                style="--block-height: 35px"
              ></div>
            </div>
            <div
              class="loading__row"
              v-for="x in 3"
              :key="x"
              style="--count: 1"
            >
              <div
                class="loading__block animate--pulse"
                style="--block-height: 25px"
              ></div>
            </div>
          </div>
        </template>
      </WhenVisible>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { Notification } from '@/entities';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NotificationGroup from '@/pages/Notifications/Components/NotificationGroup.vue';
import { Head, WhenVisible } from '@inertiajs/vue3';
import {
  isToday,
  isWithinInterval,
  isYesterday,
  parseISO,
  startOfDay,
  subDays,
  subMonths,
} from 'date-fns';
import { computed } from 'vue';

interface Props {
  notifications: Notification[];
  pagination: any;
}

const props = defineProps<Props>();

const reachedEnd = computed(() => {
  return props.pagination.current_page >= props.pagination.last_page;
});

interface NotificationGroup {
  today: {
    heading: string;
    data: Notification[];
  };
  yesterday: {
    heading: string;
    data: Notification[];
  };
  week: {
    heading: string;
    data: Notification[];
  };
  month: {
    heading: string;
    data: Notification[];
  };
  older: {
    heading: string;
    data: Notification[];
  };
}

const notificationList = computed<NotificationGroup>(() => {
  const groups: NotificationGroup = {
    today: {
      heading: 'Today',
      data: [],
    },
    yesterday: {
      heading: 'Yesterday',
      data: [],
    },
    week: {
      heading: 'Last Week',
      data: [],
    },
    month: {
      heading: 'Last Month',
      data: [],
    },
    older: {
      heading: 'Older',
      data: [],
    },
  };

  if (!props.notifications) {
    return groups;
  }

  const now = new Date();

  // Define time boundaries using date-fns
  const yesterdayStart = startOfDay(subDays(now, 1));
  const oneWeekAgo = startOfDay(subDays(now, 7));
  const oneMonthAgo = startOfDay(subMonths(now, 1));

  props.notifications.forEach((notification) => {
    const createdDate = parseISO(notification.created);

    if (isToday(createdDate)) {
      groups.today.data.push(notification);
    } else if (isYesterday(createdDate)) {
      groups.yesterday.data.push(notification);
    } else if (
      isWithinInterval(createdDate, {
        start: oneWeekAgo,
        end: yesterdayStart,
      })
    ) {
      groups.week.data.push(notification);
    } else if (
      isWithinInterval(createdDate, {
        start: oneMonthAgo,
        end: oneWeekAgo,
      })
    ) {
      groups.month.data.push(notification);
    } else {
      groups.older.data.push(notification);
    }
  });

  return groups;
});
</script>

<style scoped>
.loading__group {
  margin-top: 2rem;
}
</style>
