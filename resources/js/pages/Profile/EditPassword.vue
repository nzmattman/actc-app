<template>
  <Head title="Update Password" />
  <AuthenticatedLayout
    title="Update Password"
    :backRoute="route('profile.index')"
  >
    <Block>
      <section class="space-y-3">
        <header>
          <h1 class="heading">Update Password</h1>
        </header>

        <div>
          Ensure your account is using a long, random password to stay secure.
        </div>

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
            <InputStandard
              :type="InputType.PASSWORD"
              label="Current Password"
              validation="required"
              name="current_password"
              suffix-icon="eyeClosed"
              @suffix-icon-click="handleIconClick"
            />

            <PasswordFields passwordLabel="New Password" />

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
import InputStandard from '@/components/form/InputStandard.vue';
import PasswordFields from '@/components/form/components/PasswordFields.vue';
import { InputType, Size, Status } from '@/entities';
import { handleIconClick } from '@/utils/Icon';
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
    form.put(route('password.update'))(formData, node);
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
