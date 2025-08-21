import type { FormKitNode } from '@formkit/core';
import { FormKitValidationMessage } from '@/forms/form.types.ts';

const characterCheck = 'a-zA-Z!@#$%^&*()_+\\-=\\[\\]{};\':"\\\\|,.<>\\/';

const isLessThan = (value: string, min: number): boolean => {
  return value.length < min;
};
const isMoreThan = (value: string, max: number): boolean => {
  return value.length > max;
};

const validate = (value: string): boolean => {
  /**
   *  ^                                                   # Beginning of string
   *  (?= .* \d )                                         # Lookahead for a digit
   *  (?= .* a-zA-z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/ )   # Lookahead for a character
   *  ([a-zA-z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/\d]+ )    # Check for at least one number or one character or one special character
   *  $                                                   # End of string
   */
  const regex = new RegExp(
    `^(?=.*[\\d])(?=.*[${characterCheck}])([${characterCheck}\\d]+)$`
  );

  return !!value.match(regex);
};

const checkForDigit = (value: string): boolean => {
  const regex = new RegExp(`([\\d]+)`);
  return !!value.match(regex);
};

const checkForCharacter = (value: string): boolean => {
  const regex = new RegExp(`([${characterCheck}]+)`);
  return !!value.match(regex);
};

export const PasswordRule = (
  node: FormKitNode,
  min: number,
  max: number
): boolean => {
  const value = node.value as string;

  if (isLessThan(value, min)) {
    return false;
  }

  if (isMoreThan(value, max)) {
    return false;
  }

  return validate(value);
};

export const PasswordMessage = (message: FormKitValidationMessage) => {
  const value = message.node.value as string;
  const min = parseInt(message.args[0] as string, 10);
  const max = parseInt(message.args[1] as string, 10);

  const isLess = isLessThan(value, min);
  const isMore = isMoreThan(value, max);
  const containsNumber = checkForDigit(value);
  const containsCharacter = checkForCharacter(value);

  const messages = [];
  const between = `be between ${min} and ${max} characters`;
  const character = 'have at least one character';
  const number = 'have at least one number';
  const invalid = 'Invalid character entered.';
  const must = 'Password must';

  if (isLess || isMore) {
    messages.push(between);
  }

  if (!containsCharacter) {
    messages.push(character);
  }

  if (!containsNumber) {
    messages.push(number);
  }

  let isInvalid = false;
  if (messages.length < 1) {
    isInvalid = true;
    messages.push(...[between, character, number]);
  }
  const last = messages.pop();
  let messageString = `${isInvalid ? invalid : ''} ${must} ${messages.join(
    ', '
  )}`;

  if (messages.length > 0) {
    messageString += ' and';
  }
  messageString += ` ${last}`;

  return `${messageString}`;
};
