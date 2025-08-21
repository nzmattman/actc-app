<template>
  <section>
    <swiper-container
      spaceBetween="30"
      slides-per-view="1.25"
      slidesOffsetAfter="30"
    >
      <swiper-slide v-for="item in items" :key="item.id">
        <article>
          <figure>
            <Link :href="route(item.route)"></Link>
            <Image :desktop="item.image" :mobile="item.image" />
            <figcaption>
              <Link :href="route(item.route)">
                <h4>{{ item.name }}</h4>
                <footer>
                  <span v-if="item.length">{{ item.length }}</span>
                  <span v-if="item.length && item.level"> | </span>
                  <span v-if="item.level">{{ item.level }}</span>
                </footer>
              </Link>
              <aside>
                <IconFavouriteFull v-if="item.isFavourite" />
                <IconFavourite v-else />
              </aside>
            </figcaption>
          </figure>
        </article>
      </swiper-slide>
    </swiper-container>
  </section>
</template>

<script setup lang="ts">
import { RoutineListItem } from '@/entities';
import { Link } from '@inertiajs/vue3';
import IconFavourite from '@svg/icon-favourite-empty.svg?component';
import IconFavouriteFull from '@svg/icon-favourite-full.svg?component';
import Image from '@ui/Image.vue';

interface Props {
  items: RoutineListItem[];
}

defineProps<Props>();
</script>

<style scoped>
section {
  padding-left: var(--site-padding);
}
figure {
  position: relative;
  overflow: hidden;
  border-radius: var(--radius);
}

figure:after {
  content: '';
  display: block;
  position: absolute;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.3);
  z-index: 1;
}

figcaption {
  position: absolute;
  bottom: 0;
  left: 0;
  z-index: 2;
  width: 100%;
  display: grid;
  grid-template-columns: 1fr 20px;
  gap: 1rem;
  padding: 1.5rem;
}

figcaption a {
  color: var(--white);
}

figcaption h4 {
  margin: 0;
  font-size: 1.25rem;
  line-height: 1;
}
</style>
