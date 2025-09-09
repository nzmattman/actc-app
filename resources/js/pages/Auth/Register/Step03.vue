<template>
  <GuestLayout>
    <Head title="Register: Payment Details" />
    <AuthLayout heading="Register: Payment Details">
      <template #text>
        <Steps current="Payment Details" :step="3" :steps="3" />
      </template>

      <div class="space-y-2">
        <BlackBlock>
          <h3>Summary</h3>
          <div class="cart__row">
            <div>Subtotal</div>
            <strong>{{ formatCurrency(value) }}</strong>
          </div>

          <DiscountCoupon :value="value" @value="setDiscountValue" />

          <template v-if="discountValue">
            <div class="cart__row">
              <div>
                Discount
                <small v-if="discountText">({{ discountText }})</small>
              </div>
              <strong>{{ formatCurrency(discountValue) }}</strong>
            </div>

            <div class="cart__row">
              <div>Subtotal</div>
              <strong>{{ formatCurrency(subTotal) }}</strong>
            </div>
          </template>

          <div class="cart__row">
            <strong>Monthly Recurring Total</strong>
            <strong>{{ formatCurrency(total) }}</strong>
          </div>
        </BlackBlock>

        <Stripe :intent="intent" @payment="handlePaymentMethod" />

        <FormKit
          type="form"
          :actions="false"
          @submit="submitHandler"
          :incomplete-message="false"
        >
          <div class="formkit-outer">
            <ButtonStandard
              :size="Size.FULL"
              :loading="isLoading"
              :disabled="isDisabled"
              type="submit"
            >
              Complete
            </ButtonStandard>
          </div>
        </FormKit>
      </div>

      <div class="text--center">
        <Link :href="route('auth.logout')">Logout</Link>
      </div>
    </AuthLayout>
  </GuestLayout>
</template>

<script setup lang="ts">
import BlackBlock from '@/components/ui/Blocks/BlackBlock.vue';
import DiscountCoupon from '@/components/ui/Discount/DiscountCoupon.vue';
import Stripe from '@/components/ui/Payments/Stripe.vue';
import Steps from '@/components/ui/Steps/Steps.vue';
import { CalculatedDiscount, DiscountType, Size } from '@/entities';
import { formatCurrency, percentToNumber } from '@/helpers';
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthLayout from '@/pages/Auth/Components/AuthLayout.vue';
import { FormKitNode } from '@formkit/core';
import { useForm } from '@formkit/inertia';
import { errorHandler } from '@forms/errors/errorHandler';
import { Head } from '@inertiajs/vue3';
import ButtonStandard from '@ui/ButtonStandard.vue';
import Decimal from 'decimal.js';
import { computed, reactive, ref } from 'vue';

interface Props {
  intent: string;
  value: number;
}

const props = defineProps<Props>();

const form = useForm();

const isLoading = ref(false);
const isDisabled = ref(true);
const discountValue = ref(0);
const discountText = ref('');

const formData = reactive({
  paymentMethodId: '',
  discountId: '',
});

const total = computed<number>(() => {
  let value = new Decimal(props.value);

  if (discountValue.value) {
    value = value.add(discountValue.value);
  }

  return value.toNumber();
});

const subTotal = computed<number>(() => {
  let value = new Decimal(props.value);

  if (discountValue.value) {
    value = value.add(discountValue.value);
  }

  return value.toNumber();
});

const handlePaymentMethod = (id: string) => {
  isDisabled.value = false;
  formData.paymentMethodId = id;
};

const submitHandler = async (_: any, node: FormKitNode | undefined) => {
  isLoading.value = true;
  isDisabled.value = true;

  if (node) {
    node.clearErrors();
  }

  try {
    form.post(route('register.step-three.save'))(formData, node);
    form.addon((on) => {
      on('finish', () => {
        isLoading.value = false;
        isDisabled.value = false;
      });
    });
  } catch (error) {
    console.warn(error);
    isLoading.value = false;
    isDisabled.value = false;
    // not using finally as this needs to stop loading before the alert is triggered
    await errorHandler(error, node);
  }
};

const setDiscountValue = (value: CalculatedDiscount) => {
  formData.discountId = value.id;

  discountValue.value = 0;
  discountText.value = '';

  if (value.type === DiscountType.VALUE) {
    discountValue.value = -value.discount;
  }

  if (value.type === DiscountType.PERCENT) {
    discountValue.value = -value.discountValue;
    discountText.value = `${percentToNumber(value.discount)}% off`;
  }
};
</script>

<style>
.cart__row {
  border-bottom: 1px solid rgba(255, 255, 255, 0.5);
  padding-bottom: 0.25rem;
}

.cart__row--no-border {
  border-bottom: 0;
  padding-bottom: 0;
}
</style>
