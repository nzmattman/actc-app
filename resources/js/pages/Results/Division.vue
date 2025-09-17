<template>
  <Head :title="competition.name" />
  <AuthenticatedLayout
    :title="state"
    :backRoute="route('results.state', { slug: slug })"
  >
    <Nav :state="state" :code="code" :text="competition.name" />
    <Block :inline="false">
      <div class="club-state__list space-y-2">
        <Promo>
          <template #header>
            <div class="divider">
              <h4>{{ division }}</h4>

              <p v-if="competition.dates">{{ competition.dates }}</p>
            </div>
          </template>

          <div class="divider" v-if="aggregate || runner_up">
            <div class="row" v-if="aggregate">
              <h5>Aggregate</h5>
              {{ aggregate.name }}, {{ aggregate.points }}pts
            </div>

            <div class="row" v-if="runner_up">
              <h5>Runner Up</h5>
              {{ runner_up.name }}, {{ runner_up.points }}pts
            </div>
          </div>

          <div class="accordion">
            <Accordion multiple>
              <AccordionPanel
                v-for="item in items"
                :value="item.name"
                :key="item.name"
              >
                <AccordionHeader>
                  {{ item.name }}
                  <template #toggleicon>
                    <IconRight class="p-icon p-accordionheader-toggle-icon" />
                  </template>
                </AccordionHeader>
                <AccordionContent>
                  <ul v-if="item.places" class="results">
                    <li v-for="place in item.places" :key="place.name">
                      <strong>{{ place.position }}</strong>
                      <span>{{ place.name }}</span>
                      <span>{{ place.points }}pts</span>
                    </li>
                  </ul>
                </AccordionContent>
              </AccordionPanel>
            </Accordion>
          </div>
        </Promo>
      </div>
    </Block>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Nav from '@/Pages/Results/components/Nav.vue';
import { Head } from '@inertiajs/vue3';
import IconRight from '@svg/icon-arrow-right.svg?component';
import Block from '@ui/Blocks/Block.vue';
import Promo from '@ui/Blocks/Promo.vue';
import Accordion from 'primevue/accordion';
import AccordionContent from 'primevue/accordioncontent';
import AccordionHeader from 'primevue/accordionheader';
import AccordionPanel from 'primevue/accordionpanel';

interface Props {
  competition: {
    id: string;
    name: string;
    dates: string;
  };
  division: string;
  state: string;
  slug: string;
  code: string;
  aggregate?: {
    name: string;
    points: string;
  };
  runner_up?: {
    name: string;
    points: string;
  };
  items: {
    name: string;
    places: {
      name: string;
      position: string;
      points: string;
    }[];
  }[];
}

defineProps<Props>();
</script>

<style scoped>
.results {
  margin: 0;
  padding: 0;
  list-style: none;
}

.results li {
  margin: 0;
  padding: 0.5rem 0;
  display: grid;
  grid-template-columns: 30px 1fr 1fr;
  gap: 2rem;
}

.results li strong {
  color: var(--gold);
}
.results li span:last-child {
  text-align: right;
}

.row + .row {
  margin-top: 1rem;
}

.row h5 {
  color: var(--gold);
  font-size: calc(var(--font-size) + 10px);
  font-weight: 500;
}

.divider {
  border-bottom: 1px solid var(--grey);
  padding-bottom: 1rem;
}
</style>
