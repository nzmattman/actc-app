<template>
  <GuestLayout>
    <Head title="Email Verification" />
    <AuthLayout heading="Email Verification" :status="status">
      <template #text>
        Thanks for signing up! Before getting started, could you verify your
        email address by clicking on the link we just emailed to you? If you
        didn't receive the email, we will gladly send you another.
      </template>

      <FormKit
        type="form"
        :actions="false"
        @submit="submitHandler"
        :incomplete-message="false"
      >
        <div class="formkit-outer">
          <ButtonStandard
            :size="Size.FULL"
            :loading="isLoading"
            :disabled="isLoading"
            type="submit"
          >
            Resend Verification Email
          </ButtonStandard>
        </div>

        <div class="text--center">
          <Link :href="route('logout')" class="link"> Logout </Link>
        </div>
      </FormKit>
    </AuthLayout>
  </GuestLayout>
</template>

<script setup lang="ts">
import { Size } from '@/entities';
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthLayout from '@/pages/Auth/Components/AuthLayout.vue';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import { Head, Link } from '@inertiajs/vue3';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
  status?: string;
}

defineProps<Props>();

const form = useForm();

const isLoading = ref(false);

const submitHandler = async (formData: any, node: FormKitNode | undefined) => {
  isLoading.value = true;

  if (node) {
    node.clearErrors();
  }

  try {
    form.post(route('verification.send'))(formData, node);
    form.addon((on) => {
      on('finish', () => {
        isLoading.value = false;
      });
    });
  } catch (error) {
    console.warn(error);
    isLoading.value = false;
    // not using finally as this needs to stop loading before the alert is triggered
    await errorHandler(error, node);
  }
};
</script>
