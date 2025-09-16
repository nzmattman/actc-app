<template>
  <Link :href="route" class="block__content block__content--thin">
    <h6>{{ item.state }}</h6>
    <h4>{{ item.name }}</h4>
    <h5>{{ item.date }}</h5>
  </Link>
</template>

<script setup lang="ts">
import { ResultsListItem } from '@/entities/results';
import { Link } from '@inertiajs/vue3';

interface Props {
  item: ResultsListItem;
  route: string;
}

defineProps<Props>();
</script>

<style scoped>
a {
  display: block;
  text-align: center;
}

h4,
h5,
h6 {
  line-height: 1;
  margin: 0;
}

h6 {
  font-weight: 300;
  color: var(--white);
  font-size: 1rem;
}

a h4 {
  margin: 0.75rem 0 0.25rem;
}

h4 {
  font-size: 1.2rem;
}

h5 {
  font-size: 1rem;
  font-weight: normal;
}

h6 {
  font-size: 0.9rem;
}
</style>
