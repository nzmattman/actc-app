<template>
  <Head title="Welcome" />
  <GuestLayout
    :backgroundDesktop="BackgroundDesktop"
    :backgroundMobile="BackgroundMobile"
    :align="VAlign.BOTTOM"
  >
    <section>
      <Logo />

      <header>
        <h1 class="heading">Welcome to your home of Australian Calisthenics</h1>
      </header>

      <div class="cont">
        Our app is your gateway to the vibrant world of Calisthenics. Grown,
        learn, be inspired with a variety of specially designed programs and
        connect with an active community of like-minded people.
      </div>

      <footer>
        <ButtonStandard :href="route('login')" useLink showArrow>
          Login
        </ButtonStandard>
        <ButtonStandard
          :href="route('register.step-one')"
          useLink
          ghost
          showArrow
        >
          Sign Up
        </ButtonStandard>
      </footer>
    </section>
  </GuestLayout>
</template>

<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

import ButtonStandard from '@/components/ui/ButtonStandard.vue';
import Logo from '@/components/ui/LogoView.vue';
import { VAlign } from '@/entities';
import BackgroundDesktop from '@img/guest/welcome-desktop.jpg';
import BackgroundMobile from '@img/guest/welcome-mobile.jpg';
</script>
