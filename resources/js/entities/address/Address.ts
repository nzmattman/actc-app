export interface Address {
  [key: string]: string | number | undefined;
  uuid?: string;
  street_address: string;
  street_address_2?: string;
  city?: string;
  suburb?: string;
  state: string;
  country: string;
  postcode: string;
}

export interface AddressComponents {
  [key: string]: string | undefined;
  subpremise: string;
  street_number: string;
  route: string;
  locality: string;
  administrative_area_level_1: string;
  administrative_area_level_2?: string;
  sublocality_level_1?: string;
  country: string;
  postal_code: string;
}
