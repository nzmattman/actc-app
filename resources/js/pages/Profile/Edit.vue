<template>
  <Head title="Edit Profile" />
  <AuthenticatedLayout title="Edit Profile" :backRoute="route('profile.index')">
    <Block>
      <section class="space-y-3">
        <header>
          <h1 class="heading">Edit Profile</h1>
        </header>

        <div>Update your account's profile information.</div>

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
            <RegisterContactFields :user="user" />

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
import RegisterContactFields from '@/components/form/components/RegisterContactFields.vue';
import { Size, Status } from '@/entities';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import { Head, usePage } from '@inertiajs/vue3';
import AlertView from '@ui/AlertView.vue';
import Block from '@ui/Blocks/Block.vue';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
  status?: string;
}

defineProps<Props>();

const user = usePage().props.auth.user;

const form = useForm();

const isLoading = ref(false);

const submitHandler = async (formData: any, node: FormKitNode | undefined) => {
  isLoading.value = true;

  if (node) {
    node.clearErrors();
  }

  try {
    form.patch(route('profile.update'))(formData, node);
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
