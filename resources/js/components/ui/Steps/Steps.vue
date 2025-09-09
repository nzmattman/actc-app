
<template>
  <BlackBlock class="steps">
    <StepDonut :steps="steps" :step="step"/>
    <div>
      <h3>{{ current }}</h3>
      <h4 v-if="next">Next: {{ next }}</h4>
    </div>
  </BlackBlock>
</template>

<script setup lang="ts">
import StepDonut from '@/components/ui/Steps/StepDonut.vue';
import BlackBlock from '@/components/ui/Blocks/BlackBlock.vue';

interface Props {
  current: string;
  next?: string;
  steps: number;
  step: number;
}

defineProps<Props>();
</script>

<style scoped>
.steps {
  display: grid;
  grid-template-columns: 130px 1fr;
  gap: 1rem;
}

.steps div {
  text-align: right;
}
</style>
