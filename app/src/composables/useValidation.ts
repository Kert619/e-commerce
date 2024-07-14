import * as yup from 'yup';

// Define the schema types
const requiredSchema = yup
  .mixed()
  .transform((val) =>
    val === null || val === undefined || String(val).trim() === ''
      ? undefined
      : val
  )
  .required();
const emailSchema = yup.string().email();

// Define the validate function
const validate = async (
  schema: yup.StringSchema | yup.MixedSchema,
  value: string,
  message: string
): Promise<boolean | string> => {
  try {
    await schema.validate(value);
    return true;
  } catch (error) {
    return message;
  }
};

// Export the useValidation function
export function useValidation() {
  const required = (val: string, message = 'This field is required') =>
    validate(requiredSchema, val, message);

  const email = (val: string, message = 'This must be a valid email') =>
    validate(emailSchema, val, message);

  return {
    required,
    email,
  };
}
