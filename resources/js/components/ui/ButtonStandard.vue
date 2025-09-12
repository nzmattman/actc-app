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
