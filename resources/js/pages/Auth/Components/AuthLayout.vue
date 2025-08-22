<template>
  <section class="holder holder--small">
    <Link :href="route('login')">
      <Logo />
    </Link>

    <header v-if="heading">
      <h1 class="heading">{{ heading }}</h1>
    </header>

    <div v-if="slots.text">
      <slot name="text"></slot>
    </div>

    <div class="auth__form">
      <AuthStatus :status="status" />

      <slot></slot>
    </div>
  </section>
</template>

<script setup lang="ts">
import AuthStatus from '@/pages/Auth/Components/AuthStatus.vue';
import { Link } from '@inertiajs/vue3';
import Logo from '@ui/LogoView.vue';

interface Props {
  status?: string;
  heading?: string;
}

defineProps<Props>();
const slots = defineSlots();
</script>

<style>
.auth__form footer {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  flex-direction: row;
}

.steps {
  display: grid;
  grid-template-columns: 200px 1fr;
}

.steps aside {
}
</style>
