import type { FormKitNode, FormKitPlugin } from '@formkit/core';

const legends = ['checkbox_multi', 'radio_multi', 'repeater', 'transferlist'];

const addAsteriskToLabel = (node: FormKitNode) => {
  const { props } = node;

  if (props.type === 'form' || props.type === 'group') {
    return;
  }

  if (Array.isArray(props.parsedRules) && props.parsedRules.length) {
    const hasRequiredRule = !!props.parsedRules.filter(
      (rule) => rule.name === 'required',
    ).length;

    if (hasRequiredRule) {
      const legendOrLabel = legends.includes(
        `${node.props.type}${node.props.options ? '_multi' : ''}`,
      )
        ? 'legend'
        : 'label';

      const schemaFn = node.props.definition.schema;
      node.props.definition.schema = (sectionsSchema = {}) => {
        sectionsSchema[legendOrLabel] = {
          children: [
            '$label',
            {
              $el: 'span',
              if: '$state.required',
              attrs: {
                class: '$classes.asterisk',
              },
              children: ['*'],
            },
          ],
        };

        return schemaFn(sectionsSchema);
      };
    }
  }
};

export const createRequiredPlugin = (): FormKitPlugin => {
  return (node: FormKitNode) => {
    node.on('created', () => {
      addAsteriskToLabel(node);
    });

    node.on('prop:validation', () => {
      addAsteriskToLabel(node);
    });
  };
};
