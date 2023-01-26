<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\{LoginRequest, RegisterRequest};
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\{JsonResponse};
use Illuminate\Support\Facades\{Auth, DB, Hash};

class AuthController extends Controller {
  use HttpResponses;

  public function loggedUser(): JsonResponse {
    return response()->json(Auth::user());
  }

  public function login(LoginRequest $request): JsonResponse {
    $credentials = $request->validated();

    if (!Auth::attempt($credentials)) {
      return $this->error('', 'Credentials do not match', 401);
    }

    $user = User::where('email', $credentials['email'])->first();

    DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

    $token = $user->createToken('API Token')->plainTextToken;

    return $this->success([
      'user' => $user,
      'token' => $token,
    ]);
  }

  public function logout(): JsonResponse {
    $user = Auth::user();

    DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

    return $this->success('', 'User logged out successfully');
  }

  public function register(RegisterRequest $request): JsonResponse {
    $credentials = $request->validated();

    $user = User::create([
      'name' => $credentials['name'],
      'email' => $credentials['email'],
      'password' => Hash::make($credentials['password']),
    ]);
    $token = $user->createToken('API Token')->plainTextToken;

    return $this->success([
      'user' => $user,
      'token' => $token,
    ]);
  }
}
