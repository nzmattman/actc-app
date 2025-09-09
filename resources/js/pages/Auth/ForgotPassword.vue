<template>
  <GuestLayout>
    <Head title="Forgot Password" />
    <AuthLayout heading="Forgot Password">
      <template #text>
        Forgot your password? No problem. Just let us know your email address
        and we will email you a password reset link that will allow you to
        choose a new one.
      </template>

      <BlackBlock>
        <ForgotPasswordForm :status="status" />
      </BlackBlock>
    </AuthLayout>
  </GuestLayout>
</template>

<script setup lang="ts">
import BlackBlock from '@/components/ui/Blocks/BlackBlock.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthLayout from '@/pages/Auth/Components/AuthLayout.vue';
import ForgotPasswordForm from '@/pages/Auth/Components/ForgotPasswordForm.vue';
import { Head } from '@inertiajs/vue3';

interface Props {
  status?: string;
}

defineProps<Props>();
</script>
