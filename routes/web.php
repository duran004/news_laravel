<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainCategoryController;
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

use App\Livewire\Counter;

Route::get('/counter', Counter::class);
Route::get('/counter2', [Counter::class, 'get_counter']);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('test', [TestController::class, 'test_methodu']);

Route::group([
    'prefix' => 'api',

], function () {
    Route::prefix('user')
        ->group(function () {
            Route::post('create', [UserController::class, 'create_user']);
            Route::get('get', [UserController::class, 'get_user']);
            Route::post('login', [UserController::class, 'login']);
            Route::get('logout', [UserController::class, 'logout']);
            Route::prefix('get')->group(function () {
                Route::get('{user_id}', [UserController::class, 'get_user_from_id']);
            });
        });

    Route::prefix('category')
        ->group(function () {
            Route::get('get/{id?}', [CategoryController::class, 'get_categories']);
            Route::post('update/{id}', [CategoryController::class, 'update_category']);
            Route::post('create', [CategoryController::class, 'create_category']);
            Route::post('update/main-category/{id}', [CategoryController::class, 'update_main_category']);
            Route::post('update/image/{id}', [CategoryController::class, 'update_image']);
            Route::post('delete/{id}', [CategoryController::class, 'delete_category']);
        });

    Route::prefix('maincategory')
        ->group(function () {
            Route::get('get/{id?}', [MainCategoryController::class, 'get_main_categories']);
            Route::post('create', [MainCategoryController::class, 'create_main_category']);
            Route::post('update/{id}', [MainCategoryController::class, 'update_main_category']);
            Route::post('update/image/{id}', [MainCategoryController::class, 'update_image']);
            Route::post('delete/{id}', [MainCategoryController::class, 'delete_main_category']);
        });

    Route::prefix('news')
        ->group(function () {
            Route::get('get/{id?}', [NewsController::class, 'get_news']);
            Route::post('create', [NewsController::class, 'create_news']);
            Route::post('update/{id}', [NewsController::class, 'update_news']);
            Route::post('update/image/{id}', [NewsController::class, 'update_image']);
            Route::post('delete/{id}', [NewsController::class, 'delete_news']);
        });
    Route::prefix('images')
        ->group(function () {
            Route::post('create-temp-url', [ImageController::class, 'create_temp_url']);
            Route::get('download', [ImageController::class, 'download'])->name('files.download');
            Route::post('upload', [ImageController::class, 'upload']);
            Route::post('find-by-name', [ImageController::class, 'find_by_name']);
            Route::post('delete', [ImageController::class, 'delete']);
            Route::post('update', [ImageController::class, 'update_image']);
        });
    Route::prefix('mail')
        ->group(function () {
            Route::post('send', [MailController::class, 'send_mail']);
        });
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'role:Editor'],
], function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('admin.index');
});

Route::group([
    'prefix' => 'admin',
], function () {
    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    Route::get('/forgot-password', function () {
        return view('admin.forgot-password');
    })->name('admin.forgot-password');
    Route::post('/forgot-password-post', [UserController::class, 'forgot_password'])->name('admin.forgot-password-post');
});


Route::post('test', [TestController::class, 'test_methodu']);