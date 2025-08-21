<template>
    <AlertView :status="Status.SUCCESS" v-if="status">
        <div v-if="status === 'verification-link-sent'">
            A new verification link has been sent to the email address you
            provided during registration.
        </div>
        <div v-else>
            {{ status }}
        </div>
    </AlertView>
</template>

<script setup lang="ts">
import { Status } from '@/entities';
import AlertView from '@ui/AlertView.vue';

interface Props {
    status?: string;
}

defineProps<Props>();
</script>
