export const handleIconClick = ({
  props,
}: {
  props: { suffixIcon: string; type: string };
}) => {
  props.suffixIcon = props.suffixIcon === 'eyeOpen' ? 'eyeClosed' : 'eyeOpen';
  props.type = props.type === 'password' ? 'text' : 'password';
};
