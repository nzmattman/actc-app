<template>
  <MasterLayout>
    <main>
      <header
        class="app__header"
        :class="backRoute ? ' app__header--with-back' : ''"
      >
        <aside v-if="backRoute">
          <span>
            <Link :href="backRoute">
              <IconArrowLeft />
            </Link>
          </span>
        </aside>

        <div>
          <h1 v-if="title">{{ title }}</h1>
        </div>

        <nav>
          <Link href="/" class="has-notification">
            <IconBell />
            <NotificationDot />
          </Link>
          <Link :href="route('password.confirm')">
            <IconUser />
          </Link>
        </nav>
      </header>

      <section class="app__body" :class="bodyClassList">
        <div :class="bodyInnerClassList">
          <slot> </slot>
        </div>
      </section>

      <footer class="app__footer">
        <nav>
          <NavItem href="dashboard" title="Home">
            <IconHome />
          </NavItem>
          <NavItem href="clubs" title="Clubs">
            <IconClub />
          </NavItem>
          <NavItem href="dashboard" title="Home">
            <IconHome />
          </NavItem>
          <NavItem href="dashboard" title="Home">
            <IconHome />
          </NavItem>
        </nav>
      </footer>
    </main>
  </MasterLayout>
</template>

<script setup lang="ts">
import NavItem from '@/components/nav/NavItem.vue';
import MasterLayout from '@/layouts/MasterLayout.vue';

import { Link } from '@inertiajs/vue3';
import IconArrowLeft from '@svg/icon-arrow-left.svg?component';
import IconBell from '@svg/icon-bell.svg?component';
import IconClub from '@svg/icon-club.svg?component';
import IconHome from '@svg/icon-home.svg?component';
import IconUser from '@svg/icon-user.svg?component';
import NotificationDot from '@ui/NotificationDot.vue';
import { computed } from 'vue';

interface Props {
  title?: string;
  backRoute?: string;
  hasFixedTitle?: boolean;
  fullWidth?: boolean;
  fullHeight?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  fullWidth: false,
  fullHeight: false,
});

const bodyClassList = computed(() => {
  const classes = [];

  if (props.hasFixedTitle) {
    classes.push('app__body--has-fixed-title');
  }

  if (!props.fullHeight) {
    classes.push('app__body--not-full-height');
  }

  return classes;
});

const bodyInnerClassList = computed(() => {
  const classes = [];

  if (!props.fullWidth) {
    classes.push('holder');
  }

  return classes;
});
</script>

<style>
main {
  display: grid;
  grid-template-rows: var(--header-height) 1fr var(--footer-height);
  height: 100vh;
}

.app__body {
  overflow: auto;
}

.app__body--not-full-height {
  padding-block: var(--site-padding);
}

.app__body--has-fixed-title {
  margin-top: var(--header-height);
}

.app__header,
.app__footer {
  padding-inline: var(--site-padding);
  padding-block: calc(var(--site-padding) / 2);
}

.app__header {
  --back: 20px;
  --nav: 55px;
  display: grid;
  grid-template-columns: 1fr var(--nav);
  gap: 1.5rem;
  align-items: center;
}

.app__header--with-back {
  grid-template-columns: var(--back) 1fr var(--nav);
}

main svg,
main a {
  display: block;
}

.app__header svg {
  height: 20px;
}

.app__header h1 {
  margin: 0;
  font-size: var(--font-size);
}

.app__header aside,
.app__header nav {
  line-height: 0;
  font-size: 0;
}

.app__header aside a {
  color: var(--white);
}

.app__header nav {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
}

.has-notification {
  position: relative;
}
.has-notification .notification-dot {
  position: absolute;
  right: 0;
  top: 0;
}

.app__footer {
  background: var(--black-600);
}

.app__footer nav {
  display: flex;
  justify-content: space-between;
}

.app__footer a {
  color: var(--grey);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  font-size: 0.75rem;
}

.app__footer a.active {
  color: var(--gold);
}

.app__footer svg {
  height: 1.25rem;
}
</style>
