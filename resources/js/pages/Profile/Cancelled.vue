<template>
  <Head title="Cancelled" />
  <AuthenticatedLayout title="Cancelled" :isCancelled="true">
    <Block>
      <section class="space-y-3">
        <header>
          <h1 class="heading">Cancelled</h1>
        </header>

        <div>
          <p>Your profile has been cancelled.</p>
          But don't worry, you can re-activate it below.
        </div>

        <div>
          <ButtonStandard :href="route('register.step-three')" as="Link">
            Re-activate account
          </ButtonStandard>

          <div class="logout">
            <Link :href="route('auth.logout')">Logout</Link>
          </div>
        </div>
      </section>
    </Block>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonStandard from '@/components/ui/ButtonStandard.vue';
import { Head } from '@inertiajs/vue3';
import Block from '@ui/Blocks/Block.vue';
</script>

<style scoped>
.logout {
  margin-top: 1rem;
}
</style>
