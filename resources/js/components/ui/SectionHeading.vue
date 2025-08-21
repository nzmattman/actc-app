<template>
  <Block>
    <header>
      <h4 class="heading heading--small">
        {{ title }}
      </h4>
      <aside v-if="href">
        <Link :href="route(href)">
          <template v-if="useArrow">
            <IconArrowRight />
          </template>
          <template v-else> See all </template>
        </Link>
      </aside>
    </header>
  </Block>
</template>

<script setup lang="ts">
import IconArrowRight from '@svg/icon-arrow-right.svg?component';
import Block from '@ui/Blocks/Block.vue';
import { Link } from '@inertiajs/vue3';

interface Props {
  title: string;
  href?: string;
  useArrow?: boolean;
}

defineProps<Props>();
</script>

<style scoped>
header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 2rem;
}

header a {
  color: var(--white);
}

header svg {
  height: 20px;
}
</style>
