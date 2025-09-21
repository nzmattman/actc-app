import { loadStripe } from '@stripe/stripe-js';
import { ref } from 'vue';

export const useStripe = () => {
  const stripe = ref();
  const elements = ref();
  const appearance = {
    theme: 'flat',
    variables: {
      colorPrimary: '#a36f43',
      colorText: '#ffffff',
      borderRadius: '20px',
    },
    rules: {
      '.AccordionItem': {
        backgroundColor: 'rgba(0, 0, 0, 0.5)',
        border: 'none',
      },
      '.Input': {
        border: 0,
        borderRadius: '5px',
        padding: '15px 15px',
        color: '#212121',
      },
      '.Input:focus': {
        outline: 'none',
        boxShadow: 'none',
      },
      '.Input:focus-visible': {
        boxShadow: `inset 0 0 0 0 #ffffff,
              inset 0 0 0 1px #ffffff,
              inset 0 0 0 3px #a36f43`,
      },
    },
  };

  const load = async (clientSecret: string, paymentElementId: string) => {
    stripe.value = await loadStripe(import.meta.env.VITE_STRIPE_KEY);

    elements.value = stripe.value.elements({
      clientSecret,
      appearance,
    });

    const config = {
      wallets: {
        link: 'never',
      },
    };

    const paymentElement = elements.value.create('payment', config);
    paymentElement.mount(paymentElementId);

    return {
      stripe: stripe.value,
      elements: elements.value,
      paymentElement,
    };
  };

  const confirmSetup = async () => {
    const { setupIntent, error } = await stripe.value.confirmSetup({
      elements: elements.value,
      redirect: 'if_required',
      confirmParams: {
        expand: ['payment_method'],
      },
    });

    return {
      setupIntent,
      error,
    };
  };

  return {
    load,
    confirmSetup,
  };
};
