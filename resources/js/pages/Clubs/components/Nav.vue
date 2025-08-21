<template>
  <header class="club-nav">
    <Block>
      <p>
        Explore {{ clubs }} club{{ clubs > 1 ? 's' : '' }} throughout
        {{ state }}.
      </p>
      <aside>
        <Link
          :href="route('clubs.state', { slug })"
          :class="route().current('clubs.state') ? 'active' : ''"
        >
          <IconList />
        </Link>
        <Link
          :href="route('clubs.map', { slug })"
          :class="route().current('clubs.map') ? 'active' : ''"
        >
          <IconMap />
        </Link>
      </aside>
    </Block>
  </header>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import IconList from '@svg/icon-list.svg?component';
import IconMap from '@svg/icon-map.svg?component';
import Block from '@ui/Blocks/Block.vue';

interface Props {
  state: string;
  slug: string;
  clubs: number;
}

defineProps<Props>();
</script>

<style>
.club-nav {
  position: fixed;
  left: 0;
  top: var(--header-height);
  width: 100%;
  margin: 0;
}

.club-nav > div {
  display: grid;
  grid-template-columns: 1fr 50px;
}

.club-nav aside {
  display: flex;
  gap: 1rem;
}

.club-nav svg {
  height: 20px;
}

.club-nav a {
  color: var(--grey);
}

.club-nav a.active {
  color: var(--gold);
}
</style>
