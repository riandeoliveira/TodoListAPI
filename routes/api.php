<?php

declare(strict_types=1);

use App\Http\Controllers\{AuthController, UserController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::controller(AuthController::class)
  ->prefix('auth')
  ->group(function(): void {
    Route::middleware('auth:sanctum')->get('/logged-user', 'loggedUser');
    Route::middleware('auth:sanctum')->get('/logout', 'logout');
    Route::post('/login', 'login');
    Route::post('/register', 'register');
  });

Route::controller(UserController::class)
  ->prefix('users')
  ->group(function(): void {
    Route::get('/all', 'index');
  });
