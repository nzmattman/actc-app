<template>
  <picture>
    <source :srcset="desktop" media="(min-width: 660px)" />
    <source :srcset="mobile" />
    <img :src="desktop" loading="lazy" />
  </picture>
</template>

<script setup lang="ts">
interface Props {
  desktop: string;
  mobile: string;
}

defineProps<Props>();
</script>
