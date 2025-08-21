<template>
  <div class="notification-dot">
    <span></span>
  </div>
</template>

<style scoped>
.notification-dot {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 0.5rem;
  height: 0.5rem;
  z-index: 20;
  border-radius: 50%;
  background-color: var(--red);
}

span {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: var(--red);
  animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

@keyframes ping {
  75%,
  to {
    transform: scale(2);
    opacity: 0;
  }
}
</style>
