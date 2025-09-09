import { DiscountType } from '@/entities';

export interface Discount {
  id: string;
  success: boolean;
  message: string;
  type?: string;
  value?: number;
}

export interface CalculatedDiscount {
  id: string;
  discountValue: number;
  discount: number;
  value: number;
  type: DiscountType;
}
