<template>
  <Head title="Delete Account" />
  <AuthenticatedLayout
    title="Delete Account"
    :backRoute="route('profile.index')"
  >
    <Block>
      <section class="space-y-3">
        <header>
          <h1 class="heading">Delete Account</h1>
        </header>

        <div>
          Once your account is deleted, all of its resources and data will be
          permanently deleted. Before deleting your account, please download any
          data or information that you wish to retain.
        </div>

        <div>
          <ButtonStandard @click="handleDelete" :loading="isLoading">
            Delete
          </ButtonStandard>
        </div>
      </section>
    </Block>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useConfirm } from '@/composables';
import { Head, useForm } from '@inertiajs/vue3';
import Block from '@ui/Blocks/Block.vue';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
  status?: string;
}

defineProps<Props>();

const form = useForm({
  password: '',
});

const isLoading = ref(false);

const handleDelete = async () => {
};
</script>
