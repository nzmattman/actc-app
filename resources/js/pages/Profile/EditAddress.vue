<template>
  <Head title="Edit Address" />
  <AuthenticatedLayout title="Edit Address" :backRoute="route('profile.index')">
    <Block>
      <section class="space-y-3">
        <header>
          <h1 class="heading">Edit Address</h1>
        </header>

        <div>Update your address information.</div>

        <div>
          <AlertView :status="Status.SUCCESS" v-if="status">
            {{ status }}
          </AlertView>
          <FormKit
            type="form"
            :actions="false"
            @submit="submitHandler"
            :incomplete-message="false"
          >
            <AddressFields :states="states" :address="address" />

            <div class="formkit-outer">
              <ButtonStandard
                :size="Size.FULL"
                :loading="isLoading"
                :disabled="isLoading"
                type="submit"
              >
                Save
              </ButtonStandard>
            </div>
          </FormKit>
        </div>
      </section>
    </Block>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddressFields from '@/components/form/components/AddressFields.vue';
import { Address, SelectList, Size, Status } from '@/entities';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import { Head } from '@inertiajs/vue3';
import AlertView from '@ui/AlertView.vue';
import Block from '@ui/Blocks/Block.vue';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
  status?: string;
  states: SelectList;
  address: Address;
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
    form.patch(route('profile.address.update'))(formData, node);
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
