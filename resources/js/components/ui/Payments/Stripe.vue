<template>
  <div class="stripe-element">
    <div id="payment-element" v-if="!cardLast4">

    </div>

    <div class="card" v-if="cardLast4">
      <BlackBlock>
        <h3>Card Details</h3>
        <div>
          • • • • • • • • • • • • {{ cardLast4 }}
        </div>
        <div>
          {{ cardExpiry }}
        </div>
      </BlackBlock>
    </div>

    <div class="stripe-element__loader" v-if="isLoading">
      <LoadingSpinner />
    </div>
  </div>

</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import { useStripe, useToast } from '@/composables';
import { StripeCardElementChangeEvent } from '@stripe/stripe-js';
import BlackBlock from '@/components/ui/Blocks/BlackBlock.vue';
import LoadingSpinner from '@/components/ui/LoadingSpinner.vue';

interface Props {
  intent: string;
  loading?: boolean;
}

const props = defineProps<Props>();

const paymentEl = ref();
const cardLast4 = ref();
const cardExpiry = ref();
const isLoading = ref(false);

const stripe = useStripe();
const toast = useToast();
const emit = defineEmits(['payment']);

const saveCard = async () => {
  const { setupIntent, error } = await stripe.confirmSetup();
  isLoading.value = false;

  if (error) {
    console.log('this is the error');
    console.warn(error);
    toast.popError('Sorry, there was an error', error.message);
  } else {

    if (setupIntent.payment_method.card.last4) {
      cardLast4.value = setupIntent.payment_method.card.last4;
    }

    if (setupIntent.payment_method.card.exp_month && setupIntent.payment_method.card.exp_year) {
      const el = [];
      el.push(setupIntent.payment_method.card.exp_month.toString().padStart(2, '0'));
      el.push(setupIntent.payment_method.card.exp_year);

      cardExpiry.value = el.join('/');
    }

    emit('payment', setupIntent.payment_method.id);
  }
}

onMounted(async() => {
  const { paymentElement } = await stripe.load(props.intent, '#payment-element');
  paymentEl.value = paymentElement;

  paymentElement.addEventListener(
    'change',
    (event: StripeCardElementChangeEvent) => {
      if (event.complete) {
        isLoading.value = true;
        saveCard();
      }
    }
  );
})

watch(
  () => props.loading,
  () => {
    isLoading.value = props.loading
  },
);

</script>

<style>
.stripe-element {
  position: relative;
}

.stripe-element__loader {
  position: absolute;
  inset: 0;
  display: flex;
  background-color: rgba(0,0,0,0.4);
  border-radius: var(--radius);
}

.stripe-element__loader svg {
  width: 50px;
  margin: auto;
}
</style>

