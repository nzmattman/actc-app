<template>
  <InputStandard
    :type="InputType.PASSWORD"
    :label="passwordLabel"
    validation="required|password:12,20"
    name="password"
    suffix-icon="eyeClosed"
    @suffix-icon-click="handleIconClick"
  />

  <InputStandard
    :type="InputType.PASSWORD"
    :label="passwordConfirmationLabel"
    validation="required|confirm:password"
    name="password_confirmation"
    suffix-icon="eyeClosed"
    @suffix-icon-click="handleIconClick"
  />
</template>

<script setup lang="ts">
import InputStandard from '@/components/form/InputStandard.vue';
import { InputType } from '@/entities';
import { handleIconClick } from '@/utils/Icon';

interface Props {
  passwordLabel?: string;
  passwordConfirmationLabel?: string;
}

withDefaults(defineProps<Props>(), {
  passwordLabel: 'Password',
  passwordConfirmationLabel: 'Confirm Password',
});
</script>
