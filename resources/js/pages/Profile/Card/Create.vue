<template>
  <AuthenticatedLayout
    title="Add new Credit Card"
    :backRoute="route('profile.card')"
  >
    <Head title="Add new Credit Card" />

    <div class="space-y-2">
      <Stripe
        :intent="intent"
        @payment="handlePaymentMethod"
        :loading="isLoading"
      />
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import Stripe from '@/components/ui/Payments/Stripe.vue';
import { useToast } from '@/composables';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Props {
  intent: string;
}

defineProps<Props>();
const isLoading = ref();

const toast = useToast();
const form = useForm({
  paymentMethodId: '',
});

const handlePaymentMethod = (paymentMethod: string) => {
  isLoading.value = true;
  form.paymentMethodId = paymentMethod;
  form.patch(route('profile.card.store'), {
    preserveScroll: true,
    onSuccess: () => {
      console.log('success?');
    },
    onError: (e) => {
      console.warn(e.message);

      toast.popError('Sorry, there was an error', e.message);
    },
    onFinish: () => {
      isLoading.value = false;
    },
  });
};
</script>
