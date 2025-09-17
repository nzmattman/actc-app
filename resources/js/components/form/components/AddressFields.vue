<template>
  <InputStandard
    :type="InputType.TEXT"
    label="Address"
    validation="required"
    name="street_address"
    :value="address?.street_address"
    id="form--street-address"
  />

  <InputStandard
    :type="InputType.TEXT"
    label="Address 2"
    name="street_address_2"
    :value="address?.street_address_2"
    id="form--street-address-2"
  />

  <InputStandard
    :type="InputType.TEXT"
    label="Suburb"
    name="suburb"
    :value="address?.suburb"
    id="form--suburb"
  />

  <InputStandard
    :type="InputType.TEXT"
    label="City"
    name="city"
    :value="address?.city"
    id="form--city"
  />

  <InputStandard
    :type="InputType.SELECT"
    label="State"
    name="state_id"
    :value="address?.state_id"
    validation="required"
    :options="states"
    id="form--state"
  />

  <InputStandard
    :type="InputType.TEXT"
    label="Postcode"
    name="postcode"
    :value="address?.postcode"
    validation="required"
    id="form--postcode"
  />
</template>

<script setup lang="ts">
import InputStandard from '@/components/form/InputStandard.vue';
import {
  Address,
  AddressComponents,
  InputType,
  KeyValueString,
  SelectList,
} from '@/entities';
import { getNode } from '@formkit/core';
import { Loader } from '@googlemaps/js-api-loader';
import { onMounted } from 'vue';
// eslint-disable-next-line no-undef
import Autocomplete = google.maps.places.Autocomplete;

interface Props {
  states: SelectList[];
  address?: Address;
}

const props = defineProps<Props>();

const initSearch = () => {
  const autoComplete = new google.maps.places.Autocomplete(
    document.querySelector('#form--street-address'),
    {
      types: ['address'],
      componentRestrictions: { country: 'AU' },
    },
  );
  // avoid paying for data that you don't need by restricting the
  // set of place fields that are returned to just the formatted address,
  // address components and geometry.
  autoComplete.setFields([
    'formatted_address',
    'address_component',
    'geometry',
  ]);

  // when the user selects an address from the drop-down,
  // populate the address fields
  autoComplete.addListener('place_changed', () => fillInAddress(autoComplete));
};

const fillInAddress = (autoComplete: Autocomplete) => {
  const place = autoComplete.getPlace();
  if (!place.address_components) {
    return;
  }

  const addressComponents: AddressComponents = {
    subpremise: 'short_name',
    street_number: 'short_name', // street number
    route: 'long_name', // street name
    locality: 'long_name', // suburb (au)
    sublocality_level_1: 'short_name', // suburb (nz)
    administrative_area_level_2: 'short_name', // city
    administrative_area_level_1: 'short_name', // state
    country: 'short_name', // country
    postal_code: 'short_name', // post_code
  };

  const addressData: KeyValueString = {};
  for (const component of place.address_components) {
    const addressType: string = component.types[0];
    const key = addressComponents[addressType];
    if (key) {
      // @ts-ignore (google doesn't offer a string signature for this type)
      addressData[addressType] = component[key];
    }
  }

  const address: Address = {
    street_address: findAddress(addressData),
    suburb: addressData.locality,
    city: addressData.administrative_area_level_2,
    state: addressData.administrative_area_level_1,
    region: addressData.administrative_area_level_1,
    country: addressData.country,
    postcode: addressData.postal_code,
  };

  setChildren(address);
};

const setChildren = (address: Address) => {
  const streetAddress = getNode('form--street-address');
  if (streetAddress) {
    streetAddress.input(address.street_address);
  }

  const suburb = getNode('form--suburb');
  if (suburb) {
    suburb.input(address.suburb);
  }

  const city = getNode('form--city');
  if (city) {
    city.input(address.city);
  }

  const state = getNode('form--state');
  if (state) {
    const stateValue = props.states.find((item) => item.code === address.state);
    if (stateValue) {
      state.input(stateValue.__original);
    }
  }

  const postcode = getNode('form--postcode');
  if (postcode) {
    postcode.input(address.postcode);
  }
};

const findAddress = (addressData: KeyValueString): string => {
  const numbers = [];
  if (addressData.subpremise) {
    numbers.push(addressData.subpremise);
  }

  if (addressData.street_number) {
    numbers.push(addressData.street_number);
  }

  return numbers.length
    ? `${numbers.join('/')} ${addressData.route}`
    : addressData.route;
};

const loader = new Loader({
  apiKey: import.meta.env.VITE_GOOGLE_MAPS_API_KEY,
  version: 'weekly',
  libraries: ['places'],
});

onMounted(async () => {
  await loader.importLibrary('places');
  initSearch();
});
</script>
