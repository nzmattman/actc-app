<template>
    <GuestLayout>
        <Head title="Reset Password" />
        <AuthLayout heading="Reset Password">
            <ResetPasswordForm :email="email" :token="token" />
        </AuthLayout>
    </GuestLayout>
</template>

<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthLayout from '@/pages/Auth/Components/AuthLayout.vue';
import ResetPasswordForm from '@/pages/Auth/Components/ResetPasswordForm.vue';
import { Head } from '@inertiajs/vue3';

interface Props {
    email: string;
    token: string;
}

defineProps<Props>();
</script>
