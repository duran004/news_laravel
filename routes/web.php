<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainCategoryController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
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

Route::prefix('category')->withoutMiddleware(VerifyCsrfToken::class)
    ->group(function () {
        Route::get('get/{id?}', [CategoryController::class, 'get_categories']);
        Route::post('update/{id}', [CategoryController::class, 'update_category']);
        Route::post('create', [CategoryController::class, 'create_category']);
        Route::post('update/main-category/{id}', [CategoryController::class, 'update_main_category']);
        Route::post('update/image/{id}', [CategoryController::class, 'update_image']);
        Route::post('delete/{id}', [CategoryController::class, 'delete_category']);
    });

Route::prefix('maincategory')->withoutMiddleware(VerifyCsrfToken::class)
    ->group(function () {
        Route::get('get/{id?}', [MainCategoryController::class, 'get_main_categories']);
        Route::post('create', [MainCategoryController::class, 'create_main_category']);
        Route::post('update/{id}', [MainCategoryController::class, 'update_main_category']);
        Route::post('update/image/{id}', [MainCategoryController::class, 'update_image']);
        Route::post('delete/{id}', [MainCategoryController::class, 'delete_main_category']);
    });

Route::prefix('news')->withoutMiddleware(VerifyCsrfToken::class)
    ->group(function () {
        Route::get('get/{id?}', [NewsController::class, 'get_news']);
        Route::post('create', [NewsController::class, 'create_news']);
        Route::post('update/{id}', [NewsController::class, 'update_news']);
        Route::post('update/image/{id}', [NewsController::class, 'update_image']);
        Route::post('delete/{id}', [NewsController::class, 'delete_news']);
    });
Route::prefix('images')->withoutMiddleware(VerifyCsrfToken::class)
    ->group(function () {
        Route::get('test', [ImageController::class, 'test']);
        Route::get('download', [ImageController::class, 'download'])->name('files.download');
    });
