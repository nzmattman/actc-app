<template>
  <Link :href="route(item.route)" class="block__content block__content--thin">
    <figure>
      <component :is="is" />
      <figcaption>
        <h4>
          {{ item.name }}
        </h4>
        <h5>
          {{ item.title }}
        </h5>
      </figcaption>
    </figure>
  </Link>
</template>

<script setup lang="ts">
import { ModuleListItem } from '@/entities';
import { Link } from '@inertiajs/vue3';
import { computed, defineAsyncComponent } from 'vue';

interface Props {
  item: ModuleListItem;
}

const props = defineProps<Props>();

const is = computed(() => {
  return defineAsyncComponent(
    () => import(`@svg/icon-${props.item.icon}.svg?component`),
  );
});
</script>

<style scoped>
a {
  display: block;
}

figure {
  text-align: center;
}

figcaption {
  margin-top: 1rem;
}

svg {
  height: 40px;
  margin-inline: auto;
}

h4,
h5 {
  color: var(--white);
  margin: 0;
}

h4 {
  font-size: 1.2rem;
  line-height: 1;
}
h5 {
  font-size: 1rem;
  line-height: 1;
  font-weight: normal;
  margin-top: 0.25rem;
}
</style>
