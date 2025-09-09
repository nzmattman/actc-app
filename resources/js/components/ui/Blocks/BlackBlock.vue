<template>
  <div class="black-block">
    <slot></slot>
  </div>
</template>

<style>
.black-block {
  background: rgba(0, 0, 0, 0.5);
  padding: 1rem;
  border-radius: var(--radius);
}

.black-block h3 {
  font-size: 2rem;
  margin: 0;
}

.black-block h4 {
  font-size: 1rem;
  margin: 0;
  font-weight: normal;
}

</style>

