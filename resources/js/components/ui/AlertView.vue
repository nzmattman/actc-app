<template>
  <div :class="classList" v-if="!hide">
    <span class="alert__icon">
      <IconSuccess v-if="status === Status.SUCCESS" />
      <IconError v-if="status === Status.ERROR" />
      <IconInfo v-if="status === Status.INFO" />
      <IconWarning v-if="status === Status.WARNING" />
    </span>
    <div class="alert__body">
      <h4 v-if="heading">{{ heading }}</h4>
      <div>
        <slot> </slot>
      </div>
    </div>
    <div class="alert__close" @click="hide = true">
      <IconClose />
    </div>
  </div>
</template>

<script setup lang="ts">
import { Status } from '@/entities';
import IconClose from '@svg/icon-close.svg?component';
import IconError from '@svg/icon-error.svg?component';
import IconInfo from '@svg/icon-info.svg?component';
import IconSuccess from '@svg/icon-success.svg?component';
import IconWarning from '@svg/icon-warning.svg?component';
import { computed, ref } from 'vue';

interface Props {
  status: Status;
  heading?: string;
}

const props = defineProps<Props>();

const hide = ref(false);

const classList = computed(() => {
  const classes = ['alert'];

  if (props.status) {
    classes.push(`alert--${props.status}`);
  }

  return classes;
});
</script>

<style scoped>
.alert {
  border-left: 4px solid var(--grey);
  color: var(--white);
  padding: 0.75rem 1.5rem;
  display: grid;
  grid-template-columns: 25px 1fr 15px;
  align-items: center;
  gap: 1rem;
  background-color: var(--black-300);
  margin-bottom: 2rem;
}

.alert h4 {
  font-size: calc(var(--font-size) + 4px);
  margin-bottom: 0.25rem;
}

.alert--success {
  border-left-color: var(--alert-green);
}
.alert--success .alert__icon {
  color: var(--alert-green);
}

.alert--error {
  border-left-color: var(--alert-red);
}
.alert--error .alert__icon {
  color: var(--alert-red);
}

.alert--warning {
  border-left-color: var(--alert-orange);
}
.alert--warning .alert__icon {
  color: var(--alert-orange);
}

.alert--info {
  border-left-color: var(--alert-blue);
}
.alert--info .alert__icon {
  color: var(--alert-blue);
}

.alert__close {
  transition: opacity var(--transition);
  cursor: pointer;
}
.alert__close:hover {
  opacity: var(--opacity);
}
</style>
