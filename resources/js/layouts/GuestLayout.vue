<template>
  <MasterLayout>
    <div>
      <figure class="background">
        <Image :desktop="backgroundDesktop" :mobile="backgroundMobile" />
      </figure>
      <main class="guestLayout" :class="classList">
        <slot></slot>
      </main>
    </div>
  </MasterLayout>
</template>

<script setup lang="ts">
import { VAlign } from '@/entities';
import MasterLayout from '@/layouts/MasterLayout.vue';
import BackgroundDesktop from '@img/guest/auth-desktop.jpg';
import BackgroundMobile from '@img/guest/auth-mobile.jpg';
import Image from '@ui/Image.vue';
import { computed } from 'vue';

interface Props {
  backgroundDesktop?: string;
  backgroundMobile?: string;
  align?: VAlign;
}

const props = withDefaults(defineProps<Props>(), {
  align: VAlign.TOP,
  backgroundDesktop: BackgroundDesktop,
  backgroundMobile: BackgroundMobile,
});

const classList = computed(() => {
  const classes = [];

  if (props.align) {
    classes.push(`v-align--${props.align}`);
  }

  return classes;
});
</script>

<style>
.guestLayout {
  color: var(--text-color);
  overflow: auto;
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100dvh;
  padding: var(--site-padding);
  background: rgba(0, 0, 0, 0.2);
}

.background {
  width: 100%;
  height: 100dvh;
  position: fixed;
  inset: 0;
  z-index: 1;
}

.background img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.v-align--top {
  justify-content: flex-start;
}
.v-align--center {
  justify-content: center;
}
.v-align--bottom {
  justify-content: flex-end;
}

.guestLayout > section,
.guestLayout footer {
  display: flex;
  flex-direction: column;
  gap: 4rem;
}

.guestLayout footer {
  gap: 1rem;
  align-items: start;
}
</style>
