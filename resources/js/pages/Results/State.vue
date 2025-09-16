<template>
  <Head :title="name" />
  <AuthenticatedLayout :title="state" :backRoute="route('results')">
    <Nav
      :state="state"
      :code="code"
      :text="`Competition results from across ${state}`"
    />
    <Block :inline="false">
      <div class="club-state__list space-y-2">
        <Promo v-for="item in competitions" :key="item.id">
          <template #header>
            <h4>{{ item.name }}</h4>

            <p>{{ item.dates }}</p>
          </template>

          <div class="accordion">
            <Accordion multiple>
              <AccordionPanel
                :value="section.name"
                v-for="section in item.sections"
                :key="section.name"
              >
                <AccordionHeader>
                  {{ section.name }}
                  <template #toggleicon>
                    <IconRight class="p-icon p-accordionheader-toggle-icon" />
                  </template>
                </AccordionHeader>
                <AccordionContent>
                  <ul v-if="section.divisions" class="list">
                    <li
                      v-for="division in section.divisions"
                      :key="division.name"
                    >
                      <Link
                        :href="
                          route('results.division', {
                            slug: slug,
                            competition: item.id,
                            section: section.slug,
                            division: division.slug,
                          })
                        "
                      >
                        <span>
                          {{ division.name }}
                        </span>
                        <IconRight />
                      </Link>
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
import { CompetitionItem } from '@/entities';
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
  competitions: CompetitionItem[];
  state: string;
  slug: string;
  name: string;
  code: string;
}

defineProps<Props>();
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
