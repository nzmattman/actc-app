import type {
  FormKitEventListener,
  FormKitNode,
  FormKitPlugin,
} from '@formkit/core';
import { getValidationMessages } from '@formkit/validation';

export const scrollTo = (node: FormKitNode): void => {
  const element = document.getElementById(node.props.id as string);
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' });
  }
};

export const scrollToErrors = (node: FormKitNode): boolean => {
  if (!node || (node && !node.ledger)) {
    return false;
  }

  let foundError = false;
  node.walk((child: FormKitNode) => {
    if (foundError) {
      return;
    }

    const isBlocking = child.ledger.value('blocking');
    const hasErrors = child.ledger.value('errors');
    const hasBlockingMessages = Object.entries(
      child.context?.messages ?? {},
    ).some(([, value]) => value.blocking);

    // Check if this child has errors
    if (isBlocking || hasErrors || hasBlockingMessages) {
      // We found an input with validation errors
      scrollTo(child);
      // Stop searching
      foundError = true;
    }
  }, true);

  return foundError;
};

export const outputErrors = (node: FormKitNode): void => {
  const debug = node.config.rootConfig?.debug;
  console.log('debug mode', debug);

  if (!debug) {
    return;
  }

  const validations = getValidationMessages(node);
  validations.forEach((inputMessages, key) => {
    console.log('');
    console.group(key.name);
    console.log('value: ', key.value);
    inputMessages.map((message, index) => {
      console.log('error ', index + 1);
      console.log('  key: ', message.key);
      console.log('  type: ', message.type);
      console.log('  message: ', message.value);
    });
    console.groupEnd();
  });
};

export const createErrorHandlerPlugin = (): FormKitPlugin => {
  return (node: FormKitNode) => {
    node.on('created', () => {
      const { props } = node;

      if (props.type !== 'form') {
        return;
      }

      node.props.onSubmitInvalid = (node: FormKitNode) => {
        scrollToErrors(node);
        outputErrors(node);
      };

      node.on(
        'unsettled:errors',
        scrollToErrors as unknown as FormKitEventListener,
      );
    });
  };
};
