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
