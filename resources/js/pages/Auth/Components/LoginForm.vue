<template>
  <FormKit
    type="form"
    :actions="false"
    @submit="submitHandler"
    :incomplete-message="false"
  >
    <InputStandard
      :type="InputType.EMAIL"
      label="Email Address"
      validation="required|email"
      name="email"
    />
    <InputStandard
      :type="InputType.PASSWORD"
      label="Password"
      validation="required"
      suffix-icon="eyeClosed"
      @suffix-icon-click="handleIconClick"
      name="password"
    />

    <FormKit
      type="checkbox"
      label="Remember Me"
      name="remember"
      :value="false"
      decorator-icon="tick"
    />

    <div class="formkit-outer">
      <ButtonStandard
        :size="Size.FULL"
        :loading="isLoading"
        :disabled="isLoading"
        type="submit"
      >
        Login
      </ButtonStandard>
    </div>

    <footer>
      <Link class="link" :href="route('password.request', routeConfig)">
        Forgot Password?
      </Link>

      <Link class="link" :href="route('register')"> Register </Link>
    </footer>
  </FormKit>
</template>

<script setup lang="ts">
import InputStandard from '@/components/form/InputStandard.vue';
import { InputType, Size } from '@/entities';
import { handleIconClick } from '@/utils/Icon';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import { Link } from '@inertiajs/vue3';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

const form = useForm();

const isLoading = ref(false);
const routeConfig = ref(undefined);

const submitHandler = async (formData: any, node: FormKitNode | undefined) => {
  isLoading.value = true;

  if (node) {
    node.clearErrors();
  }

  const localRoute = route('login.store', routeConfig.value);

  try {
    form.post(localRoute)(formData, node);
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
