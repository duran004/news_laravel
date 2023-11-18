<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('test', [TestController::class, 'test_methodu']);


Route::prefix('user')->withoutMiddleware(VerifyCsrfToken::class)
->group(function () {
    Route::post('create', [UserController::class, 'create_user']);
    Route::get('get', [UserController::class, 'get_user']);
    Route::post('login', [UserController::class, 'login']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::prefix('get')->group(function () {
        Route::get('{user_id}', [UserController::class, 'get_user_from_id']);
    });
});