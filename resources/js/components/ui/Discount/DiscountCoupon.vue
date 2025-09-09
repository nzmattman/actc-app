<template>
  <div
    class="cart__row"
    :class="showDiscount ? ' cart__row--no-border' : ''"
  >
    <button @click="showDiscount = !showDiscount" class="add-discount">
      Add discount
    </button>
  </div>
  <div class="cart__row cart__row--discount" v-if="showDiscount">
    <input
      type="text"
      name="code"
      v-model="discountCode"
      placeholder="Enter your discount code"
      class="formkit-input"
    />
    <ButtonStandard
      :size="Size.SMALL"
      :loading="discountIsLoading"
      :disabled="discountIsLoading"
      @click="checkDiscount"
    >
      Apply
    </ButtonStandard>
    <div class="cart__row--discount-message" :class="discountClassList">
      {{ discountMessage }}
    </div>
  </div>
</template>

<script setup lang="ts">
import ButtonStandard from '@/components/ui/ButtonStandard.vue';
import { computed, ref } from 'vue';
import {CalculatedDiscount, Discount, DiscountType, Size } from '@/entities';
import { useApi } from '@/composables';
import Decimal from 'decimal.js';

interface Props {
  value: number;
}
const props = defineProps<Props>();

interface Emits {
    value: [payload: CalculatedDiscount];
}
const emit = defineEmits<Emits>();

const api = useApi();

const showDiscount = ref(false);
const discountCode = ref('');
const discountIsLoading = ref(false);
const discountMessage = ref('');
const discountValid = ref(false);

const discountClassList = computed(() => {
  if (discountValid.value) {
    return 'cart__row--discount-message-success';
  }

  return 'cart__row--discount-message-error';
});

const checkDiscount = async () => {
  discountIsLoading.value = true;
  discountMessage.value = '';

  try {
    const response = await api.post<Discount>(route('discount.check'), {
      code: discountCode.value,
    });

    discountValid.value = response?.data?.success ?? false;

    if (response.data.value) {
      calculateDiscountValue(response.data);
    }

    if (response.data.message) {
      discountMessage.value = response.data.message;
    }
  } catch (e) {
    discountIsLoading.value = false;
    console.warn(e);
  }

  discountIsLoading.value = false;
};

const calculateDiscountValue = (discount: Discount) => {
  const value = discount.value as number;

  if (discount.type === DiscountType.WEEKS) {
    emit('value', {
      discountValue: value,
      discount: value,
      value: value,
      type: DiscountType.WEEKS,
      id: discount.id,
    })
    return;
  }


  if (discount.type === DiscountType.VALUE) {
    const newValue = new Decimal(props.value).minus(value).toNumber();
    emit('value', {
      discountValue: value,
      discount: value,
      value: newValue,
      type: DiscountType.VALUE,
      id: discount.id,
    });

    return;
  }

  if (discount.type === DiscountType.PERCENT) {
    // calculate the percent difference
    const percentDifference = new Decimal(props.value).times(value).toDecimalPlaces(2).toNumber();

    const newValue = new Decimal(props.value).minus(percentDifference).toDecimalPlaces(2).toNumber();

    emit('value', {
      discount: value,
      discountValue: percentDifference,
      value: newValue,
      type: DiscountType.PERCENT,
      id: discount.id,
    });
  }
}
</script>

<style scoped>
.cart__row--discount-message {
  padding-bottom: 0.5rem;
}

.add-discount {
  background: none;
  border: 0;
  padding: 0;
  cursor: pointer;
  color: var(--gold);
  transition: opacity var(--transition);
}

.add-discount:hover {
  opacity: var(--opacity);
}

.cart__row--discount .formkit-input {
  width: auto;
  flex: 1;
}

.cart__row--discount-message {
  flex: 0 0 100%;
}

.cart__row--discount-message-success {
  color: var(--alert-green);
}

.cart__row--discount-message-error {
  color: var(--alert-red);
}
</style>
