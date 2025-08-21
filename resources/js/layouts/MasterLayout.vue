<template>
  <transition :name="`page`" mode="out-in" appear>
    <slot></slot>
  </transition>
</template>

<style>
.page-enter-active,
.page-leave-active {
  transition:
    opacity 300ms ease,
    translate 300ms ease;
}

.page-enter-from,
.page-leave-to {
  opacity: 0;
  translate: 30px 0;
}
</style>
