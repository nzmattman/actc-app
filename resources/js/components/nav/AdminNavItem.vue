<template>
  <li v-if="route().has(href)" :class="active ? 'active' : ''">
    <Link :href="route(href)">
      <span class="admin__nav-icon" v-if="slots.default">
        <slot></slot>
      </span>
      <span class="admin__nav-title">{{ title }}</span>
    </Link>

    <template v-if="slots.sub">
      <ul>
        <slot name="sub"></slot>
      </ul>
    </template>
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
const slots = defineSlots();

const active = computed(() => {
  return route().current(props.href) || route().current(`${props.href}.*`);
});
</script>
