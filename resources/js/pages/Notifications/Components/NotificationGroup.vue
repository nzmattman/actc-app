<template>
  <div class="notification__group" v-if="notificationsList.length">
    <h4 class="sub-heading">{{ heading }}</h4>

    <div class="notification__items">
      <div
        class="notification__item"
        v-for="item in notificationsList"
        :key="item.id"
      >
        <div>
          <strong>
            {{ item.heading }}
          </strong>
          <div>{{ item.message }}</div>
        </div>
        <div>
          {{ item.date }}
        </div>
        <div class="text--gold">{{ item.read ? 'Read' : 'Unread' }}</div>
        <div>
          <span @click="toggleMarkAsRead(item)">
            <IconMarkAsRead
              v-tooltip="item.read ? 'Mark as unread' : 'Mark as read'"
              v-if="!item.isMarkingAsRead"
            />
            <LoadingSpinner v-if="item.isMarkingAsRead" />
          </span>
          <span @click="handleDelete(item)">
            <IconDelete
              v-tooltip="'Delete notification'"
              v-if="!item.isDeleting"
            />
            <LoadingSpinner v-if="item.isDeleting" />
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import LoadingSpinner from '@/components/ui/LoadingSpinner.vue';
import { useApi, useToast } from '@/composables';
import { useConfirm } from '@/composables/confirm';
import { Notification } from '@/entities';
import { useNotificationStore } from '@/stores';
import IconMarkAsRead from '@svg/icon-eye-open.svg?component';
import IconDelete from '@svg/icon-trash.svg?component';
import { onMounted, ref } from 'vue';

interface Props {
  heading: string;
  notifications: Notification[];
}

const props = defineProps<Props>();

const notificationsList = ref<Notification[]>([]);

const confirm = useConfirm();
const toast = useToast();
const api = useApi();
const notificationStore = useNotificationStore();

const toggleMarkAsRead = async (item: Notification) => {
  item.isMarkingAsRead = true;
  const verb = item.read ? 'unread' : 'read';

  try {
    const response = await api.patch(
      route('notifications.toggle-read', { id: item.id }),
    );

    if (response.data.success) {
      if (item.read) {
        item.read = false;
        notificationStore.count = notificationStore.count + 1;
      } else {
        item.read = true;
        notificationStore.count = notificationStore.count - 1;
      }

      item.isMarkingAsRead = false;

      toast.pop('Success', `Notification marked as ${verb} successfully.`);
    } else {
      toast.popError(
        'Sorry, there was an error',
        `Unable to mark this notification as ${verb}.`,
      );
      item.isMarkingAsRead = false;
    }
  } catch (e: unknown) {
    const error = e as { message: string };
    console.warn(e);
    toast.popError('Sorry, there was an error', error.message);
    item.isMarkingAsRead = false;
  }
};

const handleDelete = async (item: Notification) => {
  const confirmed = await confirm.confirm();

  if (confirmed) {
    item.isDeleting = true;
    try {
      const response = await api.destroy(
        route('notifications.delete', { id: item.id }),
      );

      if (response.data.success) {
        notificationsList.value = notificationsList.value.filter(
          (itm: Notification) => {
            return itm.id !== item.id;
          },
        );

        item.isDeleting = false;
        if (!item.read) {
          notificationStore.count = notificationStore.count - 1;
        }

        toast.pop('Success', 'Notification deleted successfully.');
      } else {
        toast.popError(
          'Sorry, there was an error',
          'Unable to remove this notification.',
        );
        item.isDeleting = false;
      }
    } catch (e: unknown) {
      const error = e as { message: string };
      console.warn(e);
      toast.popError('Sorry, there was an error', error.message);
      item.isDeleting = false;
    }
  }
};

onMounted(() => {
  notificationsList.value = props.notifications;
});
</script>

<style scoped>
.notification__group {
  margin-top: 2rem;
}

.notification__items {
  margin-top: 1rem;
}

.notification__item {
  display: grid;
  grid-template-columns: 1fr 200px 80px 60px;
  gap: 0.5rem;
  align-items: center;
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
  border-radius: var(--radius);
  padding: 10px 20px;
  background-color: var(--black-300);
}

@media only screen and (max-width: 700px) {
  .notification__item {
    grid-template-columns: 1fr;
  }
}

.notification__item + .notification__item {
  margin-top: 1rem;
}

.notification__item > div:last-child {
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
  align-items: center;
}

.notification__item div:nth-child span {
  display: block;
  width: 20px;
}

.notification__item svg {
  height: 18px;
  cursor: pointer;
  margin: auto;
}
</style>
