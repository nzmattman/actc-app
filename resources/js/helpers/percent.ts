import Decimal from 'decimal.js';

// converts 20 to 0.2;
export const numberToPercent = (number: number): number => {
  return new Decimal(number).dividedBy(100).toNumber();
};

// converts 0.2 to 20;
export const percentToNumber = (percent: number): number => {
  return new Decimal(percent).times(100).toNumber();
};

// converts 3 to 1.03;
export const numberPercentToWholeNumber = (percent: number): number => {
  return new Decimal(numberToPercent(percent)).add(1).toNumber();
};

// rounds the number to the nearest decimal
export const roundTo = (value: number, decimalPlaces = 2) => {
  const factor = Math.pow(10, decimalPlaces);

  // convert to percent * 100
  let percent = new Decimal(value).times(factor).toNumber();

  // round it to the nearest whole number
  percent = Math.round(percent);

  // divide back to a 2 decimal place number
  return new Decimal(percent).div(factor).toNumber();
};
