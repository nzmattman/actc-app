<template>
  <Head title="Clubs" />
  <AuthenticatedLayout
    title="Calisthenics Clubs"
    :backRoute="route('dashboard')"
  >
    <div class="space-y-2">
      <Block> Explore every Calisthenics Club, nationwide.</Block>

      <Block>
        <div class="club-state__list space-y-2">
          <Promo
            v-for="item in states"
            :key="item.index"
            :href="route(item.route, { slug: item.slug })"
            buttonText="Explore"
          >
            <template #image>
              <IconAustralia :class="`aus--highlight-${item.state}`" />
            </template>
            <template #header>
              <h4>{{ item.name }}</h4>
              <p>{{ item.count }} Clubs</p>
            </template>
          </Promo>
        </div>
      </Block>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ClubStateListItem } from '@/entities';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import IconAustralia from '@svg/australia.svg?component';
import Block from '@ui/Blocks/Block.vue';
import Promo from '@ui/Blocks/Promo.vue';

interface Props {
  states: ClubStateListItem[];
}

defineProps<Props>();
</script>

<style scoped></style>
