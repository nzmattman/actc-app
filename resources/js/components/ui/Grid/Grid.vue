<template>
  <section class="grid" :class="count ? ` grid--${count}` : null">
    <slot></slot>
  </section>
</template>

<script setup lang="ts">
interface Props {
  count: number;
}

defineProps<Props>();
</script>

<style scoped>
.grid {
  display: grid;
  grid-template-columns: repeat(v-bind(count), minmax(0, 1fr));
  gap: 1rem;
}
</style>
