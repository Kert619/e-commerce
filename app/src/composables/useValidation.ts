import * as yup from 'yup';

// Define the schema types
const requiredSchema = yup
  .mixed()
  .transform((val) =>
    val == null || val == undefined || val == '' ? undefined : val
  )
  .required();
const emailSchema = yup.string().email();

// Define the validate function
const validate = async (
  schema: yup.StringSchema | yup.MixedSchema,
  value: string,
  label: string
): Promise<boolean | string> => {
  try {
    await schema.label(label).validate(value);
    return true;
  } catch (error) {
    return (error as yup.ValidationError).message;
  }
};

// Export the useValidation function
export function useValidation() {
  const required = (val: string, label: string) =>
    validate(requiredSchema, val, label);

  const email = (val: string, label: string) =>
    validate(emailSchema, val, label);

  return {
    required,
    email,
  };
}
