<template>
  <AuthenticatedLayout
    title="Manage Credit Card"
    :backRoute="route('profile.index')"
  >
    <Head title="Manage Credit Card" />

    <div class="space-y-2">
      <div class="space-y-2">
        <h2 class="heading">My Cards</h2>
        <div>
          <ButtonStandard :href="route('profile.card.create')" as="Link">
            Add a new card
          </ButtonStandard>
        </div>
      </div>

      <Deferred data="cards">
        <template #fallback>
          <div class="loading__group">
            <div
              class="loading__row"
              v-for="x in 2"
              :key="x"
              style="--count: 3"
            >
              <div
                class="loading__block animate--pulse"
                style="--block-height: 180px"
                v-for="n in 3"
                :key="n"
              ></div>
            </div>
          </div>
        </template>

        <Grid :count="3">
          <article
            class="card block block__content"
            v-for="card in cardsList"
            :key="card.id"
            :class="card.default ? 'card--default' : ''"
          >
            <header>
              <h4>{{ card.brand }} {{ card.card }}</h4>
              <p>Expires {{ card.expiry }}</p>
            </header>

            <footer>
              <strong>
                {{ card.default ? 'Default' : '' }}
                <ButtonStandard
                  v-if="!card.default"
                  :size="Size.X_SMALL"
                  :ghost="true"
                  @click="markAsDefault(card)"
                  :loading="card.isLoadingDefault"
                  :disabled="card.isLoadingDefault"
                >
                  Mark as Default
                </ButtonStandard>
              </strong>
              <aside>
                <ButtonStandard
                  v-if="!card.default && cardsList.length > 1"
                  :size="Size.X_SMALL"
                  @click="removeCard(card)"
                  :loading="card.isLoadingRemove"
                  :disabled="card.isLoadingRemove"
                >
                  Remove
                </ButtonStandard>
              </aside>
            </footer>
          </article>
        </Grid>
      </Deferred>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import ButtonStandard from '@/components/ui/ButtonStandard.vue';
import Grid from '@/components/ui/Grid/Grid.vue';
import { useApi, useConfirm, useToast } from '@/composables';
import { Card, Size } from '@/entities';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Deferred, Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

interface Props {
  cards?: Card[];
}

const props = defineProps<Props>();

const toast = useToast();
const confirm = useConfirm();
const api = useApi();

const cardsList = ref();

const markAsDefault = async (card: Card) => {
  const response = await confirm.confirm(
    'Are you sure you want to make this your default card?',
  );

  if (response) {
    card.isLoadingDefault = true;
    try {
      const response = await api.patch(
        route('profile.card.default', { id: card.id }),
      );

      if (response.data.success) {
        cardsList.value.forEach((item: Card) => {
          item.default = false;
        });
        card.default = true;
        card.isLoadingDefault = false;
        toast.pop(
          'Success',
          'Card has been successfully marked as your new default',
        );
      } else {
        toast.popError(
          'Sorry, there was an error',
          'Unable to mark this card as default',
        );
        card.isLoadingDefault = false;
      }
    } catch (e) {
      console.warn(e);

      toast.popError('Sorry, there was an error', e.message);
      card.isLoadingDefault = false;
    }
  }
};

const removeCard = async (card: Card) => {
  const response = await confirm.confirm(
    'Are you sure you want to remove this card?',
  );

  if (response) {
    card.isLoadingRemove = true;
    try {
      const response = await api.destroy(
        route('profile.card.delete', { id: card.id }),
      );

      if (response.data.success) {
        cardsList.value = cardsList.value.filter((item: Card) => {
          return item.id !== card.id;
        });
        card.isLoadingRemove = false;
        toast.pop('Success', 'Card has been successfully removed');
      } else {
        toast.popError(
          'Sorry, there was an error',
          'Unable to remove this card',
        );
        card.isLoadingRemove = false;
      }
    } catch (e) {
      console.warn(e);
      toast.popError('Sorry, there was an error', e.message);
      card.isLoadingRemove = false;
    }
  }
};

watch(
  () => props.cards,
  () => {
    cardsList.value = props.cards;
  },
);
</script>

<style scoped>
.card--default {
  border: 1px solid var(--gold);
}

.card h4 {
  margin: 0;
}

.card footer {
  border-top: 1px solid var(--grey);
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  justify-content: space-between;
  align-items: center;
  padding-top: 1rem;
}
</style>
