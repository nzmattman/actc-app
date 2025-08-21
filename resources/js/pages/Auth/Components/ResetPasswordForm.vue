<template>
    <FormKit
        type="form"
        :actions="false"
        @submit="submitHandler"
        :incomplete-message="false"
    >
        <InputStandard
            :type="InputType.PASSWORD"
            label="Password"
            validation="required|password:12,20"
            name="password"
            suffix-icon="eyeClosed"
            @suffix-icon-click="handleIconClick"
        />

        <InputStandard
            :type="InputType.PASSWORD"
            label="Confirm Password"
            validation="required|confirm:password"
            name="password_confirmation"
            suffix-icon="eyeClosed"
            @suffix-icon-click="handleIconClick"
        />

        <div class="formkit-outer">
            <ButtonStandard
                :size="Size.FULL"
                :loading="isLoading"
                :disabled="isLoading"
                type="submit"
            >
                Reset Password
            </ButtonStandard>
        </div>
    </FormKit>
</template>

<script setup lang="ts">
import InputStandard from '@/components/form/InputStandard.vue';
import { InputType, Size } from '@/entities';
import { handleIconClick } from '@/utils/Icon';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
    email: string;
    token: string;
    admin?: boolean;
}

const props = defineProps<Props>();

const form = useForm();

const isLoading = ref(false);
const routeConfig = ref(undefined);

if (props.admin) {
    routeConfig.value = {
        authdriver: 'admin',
    };
}

const submitHandler = async (formData: any, node: FormKitNode | undefined) => {
    isLoading.value = true;

    if (node) {
        node.clearErrors();
    }

    formData.email = props.email;
    formData.token = props.token;

    try {
        form.post(route('password.store', routeConfig.value))(formData, node);
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
