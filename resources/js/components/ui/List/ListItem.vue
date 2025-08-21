<template>
  <li class="list__item">
    <Link :href="route" class="list__item--link">
      <span>{{ title }}</span>
      <IconArrowRight />
    </Link>
  </li>
</template>

<script setup lang="ts">
import IconArrowRight from '@svg/icon-arrow-right.svg?component';
import { Link } from '@inertiajs/vue3';

interface Props {
  title: string;
  route: string;
}

defineProps<Props>();
</script>
