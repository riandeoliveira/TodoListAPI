<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool {
    return true;
  }

  public function messages(): array {
    return [
      'name.required' => 'The name field is required',
      'name.string' => 'The name must be a string',
      'name.min' => 'The name must be greater than :min',
      'name.max' => 'The name must be less than :max',

      'email.required' => 'The email field is required',
      'email.string' => 'The email must be a string',
      'email.email' => 'The email field must be a valid email address',
      'email.min' => 'The email must be greater than :min',
      'email.max' => 'The email must be less than :max',
      'email.unique' => 'The provided email is already in use',

      'password.required' => 'The password field is required',
      'password.string' => 'The password field must be a string',
      'password.min' => 'The password must be greater than :min',
      'password.max' => 'The password must be less than :max',
    ];
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules(): array {
    return [
      'name' => 'required|string|min:3|max:255',
      'email' => 'required|string|email|min:10|max:255|unique:users',
      'password' => 'required|string|min:8|max:20',
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $responseException = response()->json(['errors' => $validator->errors()], 422);

    throw new HttpResponseException($responseException);
  }
}
