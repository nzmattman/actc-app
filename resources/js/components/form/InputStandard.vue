<template>
  <FormKit
    ref="fieldRef"
    :type="type as any"
    :validation="validation"
    :validation-label="validationLabel"
    :label="!info ? label : ''"
    :prefix-icon="prefixIcon"
    :suffix-icon="suffixIcon"
    :unit="unit"
    :number="
      type === InputType.NUMBER
        ? ('float' as 'float')
        : (undefined as undefined)
    "
    :id="idAttr"
    :value="value"
    :disabled="disabled"
    :decimals="false"
    select-icon="arrowDown"
    @input="(value: unknown) => handleInput(value)"
    @mousewheel="
      (e: MouseEvent) => {
        e.preventDefault();
      }
    "
  />
</template>

<script setup lang="ts">
import { InputType, Size } from '@/entities';
import { computed, ref } from 'vue';

export interface Props {
  label: string;
  validation?: string;
  validationLabel?: string;
  prefixIcon?: string;
  suffixIcon?: string;
  info?: string;
  size?: string;
  type?: InputType;
  textSize?: Size;
  id?: string;
  value?: string | number;
  classes?: object;
  help?: string;
  unit?: string;
  disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  size: Size.MEDIUM,
  type: InputType.TEXT,
});

const fieldRef = ref(null);

const idAttr = computed(() => {
  return props.id ?? `input-${Date.now()}`;
});

const emit = defineEmits(['input']);

const handleInput = (value: unknown) => {
  emit('input', value);
};
</script>
