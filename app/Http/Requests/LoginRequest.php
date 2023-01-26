<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest {
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
      'email.required' => 'The email field is required',
      'email.string' => 'The email must be a string',
      'email.email' => 'The email field must be a valid email address',

      'password.required' => 'The password field is required',
      'password.string' => 'The password field must be a string',
    ];
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules(): array {
    return [
      'email' => 'required|string|email',
      'password' => 'required|string',
    ];
  }

  protected function failedValidation(Validator $validator): void {
    $responseException = response()->json(['errors' => $validator->errors()], 422);

    throw new HttpResponseException($responseException);
  }
}
