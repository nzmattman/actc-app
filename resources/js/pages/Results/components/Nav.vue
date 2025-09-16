<template>
  <header class="result-nav">
    <Block :inline="false">
      <div>
        <header>
          <h3>{{ state }}</h3>
        </header>
        <p>{{ text }}</p>
      </div>
      <aside>
        <IconAustralia :class="`aus--highlight-${code}`" />
      </aside>
    </Block>
  </header>
</template>

<script setup lang="ts">
import IconAustralia from '@svg/australia.svg?component';
import Block from '@ui/Blocks/Block.vue';

interface Props {
  state: string;
  code: string;
  text: string;
}

defineProps<Props>();
</script>

<style>
.result-nav {
  margin-bottom: 2rem;
}

.result-nav p {
  margin: 0;
}

.result-nav > div {
  display: grid;
  grid-template-columns: 1fr 120px;
}

.result-nav aside {
  display: flex;
  gap: 1rem;
}

.result-nav svg {
  width: 100%;
}
</style>
