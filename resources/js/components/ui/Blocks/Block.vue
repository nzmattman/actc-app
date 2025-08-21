<template>
  <div class="block" :class="classList">
    <template v-if="withInner">
      <div class="block__inner">
        <slot></slot>
      </div>
    </template>
    <template v-else>
      <slot></slot>
    </template>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  full?: boolean;
  withInner?: boolean;
  inline?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  inline: true,
});

const classList = computed(() => {
  const classes = [];

  if (props.full) {
    classes.push('block--full');
  }

  if (props.inline) {
    classes.push('block--inline');
  }

  return classes;
})
</script>

<style scoped>

.block {

}

.block--inline {
  padding-inline: var(--site-padding);
}

.block--full {
  padding-block: var(--site-padding);
}

.block__inner {
  padding: 1.5rem;
}
</style>

<style>
.block header h4 {
  margin: 0;
  font-size: 1.5rem;
}
</style>
