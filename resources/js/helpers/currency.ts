export function formatCurrency(
  amount: number,
  maximumFractionDigits = 2,
): string {
  return new Intl.NumberFormat('en-AU', {
    style: 'currency',
    currency: 'AUD',
    maximumFractionDigits: maximumFractionDigits,
  }).format(amount);
}

export function formatCurrencyWithoutDollarSign(
  amount: string | number,
): string {
  if (typeof amount === 'string') {
    amount = parseFloat(amount);
  }

  return formatCurrency(amount).replace(/[^\d.,-]/g, '');
}
