import type { FormKitNode } from '@formkit/core';
import { nextTick } from 'vue';

interface Errors {
    [key: string]: string[];
}

export class ApiError extends Error {
    status: number;
    errors: Errors | undefined;

    constructor(message: string, status: number, errors?: Errors) {
        super(message);
        this.message = message;
        this.name = 'ApiError';
        this.status = status;
        this.errors = errors;
    }
}

export const errorHandler = async (
    err: unknown,
    node: FormKitNode | undefined,
): Promise<void | string> => {
    if (!node) {
        return;
    }

    const error = err as ApiError;

    const inputErrors: { [key: string]: string[] } = {};
    const flatErrors: string[] = [];
    if (error.errors) {
        for (const key in error.errors) {
            const errors = error.errors[key];
            if (errors.length) {
                inputErrors[key] = errors.map((err: string) => {
                    // replace with default error message
                    if (err.includes('field is required')) {
                        return 'This field is required';
                    }

                    return err;
                });

                flatErrors.push(...inputErrors[key]);
            }
        }
    }

    let { message } = error;

    // reset the main message if it is a laravel validation message
    if (
        error.message.includes('field is required') ||
        (flatErrors && flatErrors.indexOf(message) > -1)
    ) {
        message = 'Please complete all mandatory fields.';
    }

    if (error.message.includes('Unauthenticated')) {
        alert('Sorry + Your session has expired.\nPlease login again.');

        return 'logout';
    }

    // reset the main message if it is a laravel validation message
    const errorMessages = [message];

    node.setErrors(errorMessages, inputErrors);

    // scroll to the first server side error
    await nextTick();
    const fieldErrors = document.querySelectorAll('[data-errors]');
    if (fieldErrors.length) {
        fieldErrors[0].scrollIntoView({ behavior: 'smooth' });
    }
};
