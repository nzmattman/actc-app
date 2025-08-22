<template>
  <div class="progress__container">
    <div class="donut__chart" :style="{ '--progress': progress }"></div>
    <div class="progress__text">
      <div class="step__count">{{ step }} of {{ steps }}</div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  steps: number;
  step: number;
}

const props = defineProps<Props>();

const progress = computed(() => {
  return (props.step / props.steps) * 100;
});
</script>

<style scoped>
.progress__container {
  --size: 90px;
  position: relative;
  width: var(--size);
  height: var(--size);
}

.donut__chart {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  position: relative;
  background: conic-gradient(
    from 0deg,
    var(--gold) 0deg,
    var(--gold) calc(var(--progress) * 3.6deg),
    #e8e8e8 calc(var(--progress) * 3.6deg),
    #e8e8e8 360deg
  );
  transition: all 0.3s ease;
}

.donut__chart::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: calc(var(--size) - 20px);
  height: calc(var(--size) - 20px);
  background: #ffffff;
  border-radius: 50%;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.progress__text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  z-index: 10;
  color: var(--black);
}

.step__count {
  font-size: 1rem;
  font-weight: bold;
  margin-bottom: 0.25rem;
  color: var(--gold);
  line-height: 0;
}

</style>
