<template>
  <Head title="Results" />
  <AuthenticatedLayout
    title="Results"
    :backRoute="route('dashboard')"
    :backgroundDesktop="backgroundDesktop"
    :backgroundMobile="backgroundMobile"
  >
    <Block>
      <header>
        <h3>Results</h3>
      </header>

      Competition results from across the country.
    </Block>

    <div class="space">
      <Block>
        <div class="club-state__list space-y-2">
          <Promo
            v-for="item in states"
            :key="item.id"
            :href="route(item.route, { slug: item.slug })"
            buttonText="Explore"
          >
            <template #image>
              <IconAustralia :class="`aus--highlight-${item.state}`" />
            </template>
            <template #header>
              <h4>{{ item.name }}</h4>
              <p>Last updated {{ item.last_updated }}</p>
            </template>
          </Promo>
        </div>
      </Block>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import IconAustralia from '@svg/australia.svg?component';
import Block from '@ui/Blocks/Block.vue';
import Promo from '@ui/Blocks/Promo.vue';

import { ResultStateListItem } from '@/entities';
import {
  default as backgroundDesktop,
  default as backgroundMobile,
} from '@img/results-mobile.jpg';

interface Props {
  states: ResultStateListItem[];
}

defineProps<Props>();
</script>

<style scoped>
.space {
  margin-top: 45vh;
}
</style>
