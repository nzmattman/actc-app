<template>
  <component
    :is="componentType"
    :href="href"
    :class="classList"
    :disabled="disabled"
    v-bind="attrs"
  >
    <template v-if="loading">
      <LoaderSpinner />
      <span v-if="loadingText">{{ loadingText }}</span>
    </template>
    <template v-if="!loading">
      <slot></slot>
      <span class="arrow" v-if="showArrow">
        <IconArrowRight />
      </span>
    </template>
  </component>
</template>

<script setup lang="ts">
import { computed, useAttrs } from 'vue';

import { Size } from '@/entities';

import LoaderSpinner from '@/components/ui/LoadingSpinner.vue';
import IconArrowRight from '@svg/icon-arrow-right.svg?component';
import { Link } from '@inertiajs/vue3';

export interface Props {
  href?: string;
  size?: Size;
  disabled?: boolean;
  loadingText?: string;
  as?: string;
  showArrow?: boolean;

  loading?: boolean;
  active?: boolean;
  useLink?: boolean;
  ghost?: boolean;
  full?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  size: Size.SMALL,
  loading: false,
  disabled: false,
  loadingText: 'Loading...',
});

const attrs = useAttrs();

const componentType = computed(() => {
  if (props.useLink) {
    return 'Link';
  }

  if (props.as) {
    return props.as;
  }

  if (attrs.href) {
    return 'a';
  }

  return 'button';
});

const classList = computed(() => {
  const classList = ['button'];

  if (props.showArrow) {
    classList.push('button--with-arrow');
  }

  if (props.size) {
    classList.push(`button--${props.size}`);
  }

  if (props.disabled) {
    classList.push(`button--disabled`);
  }

  if (props.loading) {
    classList.push(`button--loading`);
  }

  if (props.ghost) {
    classList.push(`button--ghost`);
  }

  if (props.full) {
    classList.push(`button--full`);
  }

  return classList;
});
</script>

<style scoped>
.button {
  display: inline-flex;
  min-width: 170px;
  border-radius: 50px;
  background-color: var(--gold);
  color: var(--white);
  padding: 1rem 1.5rem;
  font-weight: bold;
  line-height: 1;
  border: 1px solid var(--gold);
  transition: background-color var(--transition);
  cursor: pointer;
  justify-content: center;
}

.button:hover {
  opacity: 1;
}

.button .arrow {
  width: 25px;
  height: 25px;
  display: flex;
  background-color: var(--white);
  color: var(--gold);
  border-radius: 50%;
  border: 1px solid var(--white);
  transition:
    background-color var(--transition),
    border-color var(--transition);
}

.button .arrow svg {
  margin: auto;
  width: 20%;
}

.button:hover,
.button--ghost {
  background-color: transparent;
}
.button:hover .arrow,
.button--ghost .arrow {
  border-color: var(--gold);
  background-color: transparent;
}

.button--ghost:hover {
  background-color: var(--gold);
}
.button--ghost:hover .arrow {
  background-color: var(--white);
  border: 1px solid var(--white);
}

.button--with-arrow,
.button--loading {
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
}

.button--loading {
  justify-content: center;
}
.button--loading svg {
  width: 20px;
}

.button--full {
  width: 100%;
}

.button--small {
  padding: 0.75rem 0.5rem;
}
</style>
