<template>
  <Link :href="route(href)" :class="{ active }">
    <slot></slot>
    <span>
      {{ title }}
    </span>
  </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
  href: string;
  title: string;
}

const props = defineProps<Props>();

const active = computed(() => {
  return route().current(props.href) || route().current(`${props.href}.*`);
});
</script>
