<template>
  <GuestLayout>
    <Head title="Login" />
    <AuthLayout heading="Login" :status="status">
      <LoginForm />
    </AuthLayout>
  </GuestLayout>
</template>

<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthLayout from '@/pages/Auth/Components/AuthLayout.vue';
import LoginForm from '@/pages/Auth/Components/LoginForm.vue';
import { Head } from '@inertiajs/vue3';

interface Props {
  canResetPassword?: boolean;
  status?: string;
}
defineProps<Props>();
</script>
