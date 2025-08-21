<template>
  <Head :title="name" />
  <AuthenticatedLayout
    :title="state"
    :backRoute="route('clubs')"
    has-fixed-title
  >
    <Nav :state="state" :clubs="clubs.length" :slug="slug" />
    <Block :inline="false">
      <div class="club-state__list space-y-2">
        <Promo
          v-for="item in clubs"
          :key="item.id"
          :href="route('clubs.club', { slug, club: item.id })"
          buttonText="See Details"
        >
          <template #header>
            <h4>{{ item.name }}</h4>

            <p>{{ item.address }}</p>
          </template>
        </Promo>
      </div>
    </Block>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ClubListItem } from '@/entities';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Nav from '@/Pages/Clubs/components/Nav.vue';
import { Head } from '@inertiajs/vue3';
import Block from '@ui/Blocks/Block.vue';
import Promo from '@ui/Blocks/Promo.vue';
import { onMounted } from 'vue';

interface Props {
  clubs: ClubListItem[];
  state: string;
  slug: string;
  name: string;
}

defineProps<Props>();

onMounted(() => {
  localStorage.setItem('clubs.state.view', 'listing');
});
</script>

<style scoped>
.club-state__list {
  display: grid;
  gap: 2rem;
  grid-template-rows: 1fr;

  @container (width > 600px) {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
