<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout :title="`Hello, ${user.first_name}`">
    <div class="space-y-2">
      <Block> What would you like to do today? </Block>

      <Block v-if="modules.length">
        <Grid :count="3">
          <ModuleItem :item="item" v-for="item in modules" :key="item.id" />
        </Grid>
      </Block>

      <section v-if="routines.length">
        <SectionHeading title="Featured routines" href="dashboard" />
        <RoutineSlider :items="routines" />
      </section>

      <Deferred data="results">
        <template #fallback>
          <Block>
            <div class="loading__group">
              <div class="loading__row" style="--count: 1">
                <div
                  class="loading__block animate-pulse"
                  style="--block-height: 45px"
                ></div>
              </div>
              <div class="loading__row" style="--count: 3">
                <div
                  class="loading__block animate--pulse"
                  style="--block-height: 200px"
                  v-for="x in 6"
                  :key="x"
                ></div>
              </div>
            </div>
          </Block>
        </template>

        <section v-if="results && results.length">
          <SectionHeading
            title="Latest comp results"
            href="results"
            :useArrow="true"
          />

          <Block>
            <Grid :count="3">
              <ResultPromo
                :item="item"
                v-for="item in results"
                :key="item.id"
                :route="
                  route('results.competition', {
                    slug: item.slug,
                    competition: item.id,
                  })
                "
              />
            </Grid>
          </Block>
        </section>
      </Deferred>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import ModuleItem from '@/components/module/ModuleItem.vue';
import ResultPromo from '@/components/results/ResultPromo.vue';
import RoutineSlider from '@/components/routine/RoutineSlider.vue';
import { ModuleListItem, RoutineListItem } from '@/entities';
import { ResultsListItem } from '@/entities/results';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deferred, Head, usePage } from '@inertiajs/vue3';
import Block from '@ui/Blocks/Block.vue';
import Grid from '@ui/Grid/Grid.vue';
import SectionHeading from '@ui/SectionHeading.vue';

interface Props {
  modules: ModuleListItem[];
  routines: RoutineListItem[];
  results?: ResultsListItem[];
}

defineProps<Props>();

const user = usePage().props.auth.user;
</script>
