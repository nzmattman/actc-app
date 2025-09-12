<template>
  <AuthenticatedLayout
    title="Subscriptions"
    :backRoute="route('profile.index')"
  >
    <Head title="Subscriptions" />

    <div class="space-y-2">
      <BlockContent>
        <Deferred data="subscription">
          <template #fallback>
            <div class="loading__group">
              <div class="loading__row">
                <div
                  class="loading__block animate-pulse"
                  style="--block-height: 45px"
                ></div>
              </div>
              <div
                class="loading__row"
                v-for="x in 2"
                :key="x"
                style="--count: 2"
              >
                <div
                  class="loading__block animate--pulse"
                  style="--block-height: 25px"
                ></div>
              </div>
            </div>
          </template>

          <header>
            <h4>Your current subscription</h4>
          </header>
          <div>
            <strong> {{ subscription.name }} </strong><br />
            {{ subscription.price }} per {{ subscription.frequency }}
          </div>

          <br />
          <button @click.prevent="handleConfirm" class="link">
            Cancel Subscription
          </button>
        </Deferred>
      </BlockContent>

      <BlockContent>
        <Deferred data="invoices">
          <template #fallback>
            <div class="loading__group">
              <div
                class="loading__row"
                v-for="x in 5"
                :key="x"
                style="--count: 3"
              >
                <div
                  class="loading__block animate--pulse"
                  v-for="n in 3"
                  :key="n"
                  style="--block-height: 25px"
                ></div>
              </div>
            </div>
          </template>

          <header>
            <h4>Your subscription invoices</h4>
          </header>

          <table class="table">
            <thead>
              <tr>
                <th>Date</th>
                <th class="text--right">Total</th>
                <th class="text--right">Download</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in invoices" :key="item.id">
                <td>{{ item.date }}</td>
                <td class="text--right">{{ item.total }}</td>
                <td class="text--right">
                  <a :href="item.download" target="_blank">Download</a>
                </td>
              </tr>
            </tbody>
          </table>
        </Deferred>
      </BlockContent>
    </div>

    <ConfirmDialog />
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { Subscription, SubscriptionInvoice } from '@/entities';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deferred, Head, useForm } from '@inertiajs/vue3';
import BlockContent from '@ui/Blocks/BlockContent.vue';
import { ConfirmDialog } from 'primevue';
import { useConfirm } from 'primevue/useconfirm';

interface Props {
  invoices?: SubscriptionInvoice[];
  subscription: Subscription;
}

defineProps<Props>();

const confirm = useConfirm();
const form = useForm({});

const confirmAction = async () => {
  return new Promise((resolve) => {
    confirm.require({
      message: `Are you sure you want to proceed?`,
      header: 'Confirmation',
      icon: 'pi pi-exclamation-triangle',
      rejectProps: {
        label: 'Cancel',
        severity: 'secondary',
        outlined: true,
      },
      acceptProps: {
        label: 'Ok',
      },
      accept: () => resolve(true),
      reject: () => resolve(false),
    });
  });
};

const handleConfirm = async () => {
  const confirmed = await confirmAction();

  if (confirmed) {
    try {
      form.post(route('subscriptions.cancel'), {
        onError: (error) => console.warn(error),
      });
    } catch (e) {
      console.warn(e);
    }
  }
};
</script>
