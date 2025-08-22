<template>
  <GuestLayout>
    <Head title="Register: Address Details" />
    <AuthLayout heading="Register: Address Details">
      <template #text>
        <Steps
          current="Address Details"
          next="Payment Details"
          :step="2"
          :steps="3"
        />
      </template>
      <FormKit
        type="form"
        :actions="false"
        @submit="submitHandler"
        :incomplete-message="false"
      >
        <AddressFields :states="states" />

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
      </FormKit>
    </AuthLayout>
  </GuestLayout>
</template>

<script setup lang="ts">
import AddressFields from '@/components/form/components/AddressFields.vue';
import Steps from '@/components/ui/Steps/Steps.vue';
import { SelectList, Size } from '@/entities';
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthLayout from '@/pages/Auth/Components/AuthLayout.vue';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import { Head } from '@inertiajs/vue3';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
  states: SelectList;
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
    form.post(route('register.step-two'))(formData, node);
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
