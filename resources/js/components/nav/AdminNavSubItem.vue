<template>
  <li v-if="route().has(href)" :class="active ? 'active' : ''">
    <Link :href="href">{{ title }}</Link>
  </li>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
  title: string;
  href: string;
}

const props = defineProps<Props>();

const active = computed(() => {
  return route().current(props.href) || route().current(`${props.href}.*`);
});
</script>
