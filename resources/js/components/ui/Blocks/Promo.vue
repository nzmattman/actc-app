<template>
  <article
    class="promo block__content"
    :class="slots.image ? ' promo--with-image' : ''"
  >
    <figure v-if="slots.image">
      <slot name="image"></slot>
    </figure>
    <div>
      <header v-if="slots.header">
        <slot name="header"></slot>
      </header>

      <slot></slot>

      <footer v-if="href">
        <ButtonStandard :href="href" full :size="Size.SMALL" :useLink="true">
          {{ buttonText ?? 'Find out more' }}
        </ButtonStandard>
      </footer>
    </div>
  </article>
</template>
<script setup lang="ts">
import { Size } from '@/entities';
import ButtonStandard from '@ui/ButtonStandard.vue';

interface Props {
  href?: string;
  buttonText?: string;
}

defineProps<Props>();
const slots = defineSlots();
</script>

<style>
.promo {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

.promo--with-image {
  @container (width > 400px) {
    grid-template-columns: 33% 1fr;
  }
}

.promo figure img,
.promo figure svg {
  width: 100%;
}

.promo h4,
.promo p {
  margin: 0;
}

.promo h4 {
  font-size: 1rem;
  line-height: 1;
  margin-bottom: 0.5rem;
}

header {
  margin-bottom: 1rem;
}
</style>
