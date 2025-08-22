
<template>
  <div class="steps">
    <StepDonut :steps="steps" :step="step"/>
    <div>
      <h3>{{ current }}</h3>
      <h4 v-if="next">Next: {{ next }}</h4>
    </div>
  </div>
</template>

<script setup lang="ts">
import StepDonut from '@/components/ui/Steps/StepDonut.vue';

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
  background: rgba(0, 0, 0, 0.5);
  padding: 1rem;
  border-radius: var(--radius);
}

.steps div {
  text-align: right;
}

.steps h3 {
  font-size: 2rem;
  margin: 0;
}

.steps h4 {
  font-size: 1rem;
  margin: 0;
  font-weight: normal;
}
</style>
