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
import { useSwal } from '@/composables';
import { Head, useForm } from '@inertiajs/vue3';
import Block from '@ui/Blocks/Block.vue';
import ButtonStandard from '@ui/ButtonStandard.vue';
import { ref } from 'vue';

interface Props {
  status?: string;
}

defineProps<Props>();

const swal = useSwal();
const form = useForm({
  password: '',
});

const isLoading = ref(false);

const handleDelete = async () => {
  const response = await swal.confirm('Are you sure?', {
    text: 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
    content: {
      element: 'input',
      attributes: {
        placeholder: 'Confirm your password',
        type: 'password',
      },
    },
  });

  console.log(response);

  if (!response.isCancelled) {
    form.password = response;
    console.log('we have confirmed');
    isLoading.value = true;
    form.delete(route('profile.destroy'), {
      preserveScroll: true,
      onSuccess: () => {
        console.log('success?');
      },
      onError: (e) => {
        console.log('error', e);
        console.warn(e.message);
        swal.error('Sorry, there was an error with your request.');
      },
      onFinish: () => {
        isLoading.value = false;
      },
    });
  }
};
</script>
