// src/composables/useValidation.ts

import * as yup from 'yup';

// Define the schema types
const emailSchema = yup
  .string()
  .required('Email is required')
  .email('Invalid email');

const passwordSchema = yup.string().required('Password is required');

// Define the validate function
const validate = async (
  schema: yup.StringSchema,
  value: string
): Promise<boolean | string> => {
  try {
    await schema.validate(value);
    return true;
  } catch (error) {
    return (error as yup.ValidationError).message;
  }
};

// Export the useValidation function
export function useValidation() {
  const emailRules = [(val: string) => validate(emailSchema, val)];
  const passwordRules = [(val: string) => validate(passwordSchema, val)];

  return {
    emailRules,
    passwordRules,
  };
}
