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

      <section v-if="results.length">
        <SectionHeading
          title="Latest comp results"
          subTitle="Today 11:40"
          href="dashboard"
          :useArrow="true"
        />
        <Block>
          <Grid :count="3">
            <ResultPromo :item="item" v-for="item in results" :key="item.id" />
          </Grid>
        </Block>
      </section>
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
import { Head, usePage } from '@inertiajs/vue3';
import Block from '@ui/Blocks/Block.vue';
import Grid from '@ui/Grid/Grid.vue';
import SectionHeading from '@ui/SectionHeading.vue';

interface Props {
  modules: ModuleListItem[];
  routines: RoutineListItem[];
  results: ResultsListItem[];
}

defineProps<Props>();

const user = usePage().props.auth.user;
</script>
