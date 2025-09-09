<template>
  <GuestLayout>
    <Head title="Welcome to ACTC" />
    <AuthLayout heading="Welcome to ACTC">
      <template #text>
        <Steps
          current="User Details"
          next="Address Details"
          :step="1"
          :steps="3"
        />
      </template>
      <FormKit
        type="form"
        :actions="false"
        @submit="submitHandler"
        :incomplete-message="false"
      >
        <div class="space-y-2">
          <BlackBlock>
            <RegisterContactFields />

            <PasswordFields />
          </BlackBlock>

          <div class="formkit-outer">
            <ButtonStandard
              :size="Size.FULL"
              :loading="isLoading"
              :disabled="isLoading"
              type="submit"
            >
              Next
            </ButtonStandard>
          </div>
        </div>
      </FormKit>
    </AuthLayout>
  </GuestLayout>
</template>

<script setup lang="ts">
import PasswordFields from '@/components/form/components/PasswordFields.vue';
import RegisterContactFields from '@/components/form/components/RegisterContactFields.vue';
import BlackBlock from '@/components/ui/Blocks/BlackBlock.vue';
import Steps from '@/components/ui/Steps/Steps.vue';
import { Size } from '@/entities';
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthLayout from '@/pages/Auth/Components/AuthLayout.vue';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import { Head } from '@inertiajs/vue3';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
  canResetPassword?: boolean;
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
    form.post(route('register.step-one.save'))(formData, node);
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
