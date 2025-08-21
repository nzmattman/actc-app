<template>
  <Head :title="item.name" />
  <AuthenticatedLayout
    :title="item.name"
    :backRoute="route(backRoute, { slug })"
  >
    <Block :inline="false">
      <div class="space-y-2">
        <article class="block__content">
          <div v-if="item.address">{{ item.address }}</div>
          <div v-if="item.address2">{{ item.address2 }}</div>
          <div v-if="item.suburb">{{ item.suburb }}</div>
          <div v-if="item.city">{{ item.city }}</div>
          <div v-if="item.postcode">{{ item.postcode }}</div>
          <div v-if="item.state">{{ item.state }}</div>
        </article>
        <article class="block__content">
          <div v-if="item.phone">
            T:
            <a :href="`tel: {{ item.phone }}`" class="inline">
              {{ item.phone }}
            </a>
          </div>
          <div v-if="item.email">
            E:
            <a :href="`mailto: {{ item.email }}`" class="inline">
              {{ item.email }}
            </a>
          </div>
          <div v-if="item.website">
            W:
            <a :href="item.website" class="inline" target="_blank">
              {{ item.website }}
            </a>
          </div>
        </article>
      </div>
    </Block>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ClubListItem } from '@/entities';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Block from '@ui/Blocks/Block.vue';
import { computed } from 'vue';

interface Props {
  item: ClubListItem;
  state: string;
  slug: string;
  name: string;
}

defineProps<Props>();

const backRoute = computed(() => {
  const view = localStorage.getItem('clubs.state.view');

  if (view === 'map') {
    return 'clubs.map';
  }

  return 'clubs.state';
});
</script>
