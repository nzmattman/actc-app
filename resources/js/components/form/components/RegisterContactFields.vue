<template>
  <InputStandard
    :type="InputType.TEXT"
    label="First Name"
    validation="required"
    name="first_name"
    :value="user?.first_name"
  />

  <InputStandard
    :type="InputType.TEXT"
    label="Last Name"
    validation="required"
    name="last_name"
    :value="user?.last_name"
  />

  <InputStandard
    :type="InputType.EMAIL"
    label="Email Address"
    validation="required|email"
    name="email"
    :value="user?.email"
  />
</template>

<script setup lang="ts">
import InputStandard from '@/components/form/InputStandard.vue';
import { InputType } from '@/entities';
import { User } from '@/types';

interface Props {
  user?: User;
}

const props = defineProps<Props>();
</script>
