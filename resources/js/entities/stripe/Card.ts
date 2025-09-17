export interface Card {
  id: string;
  brand: string;
  expiry: string;
  card: string;
  default: boolean;
  isLoadingRemove?: boolean;
  isLoadingDefault?: boolean;
}
