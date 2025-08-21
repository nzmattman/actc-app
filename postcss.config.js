import autoprefixer from 'autoprefixer';
import postcssDiscardComments from 'postcss-discard-comments';
import postcssNested from 'postcss-nested';

export default {
  plugins: [autoprefixer, postcssNested, postcssDiscardComments],
};
