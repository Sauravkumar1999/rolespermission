<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaViewController;
use App\Http\Controllers\UnAuthemticatedController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UnAuthemticatedController::class, 'welcome']);

Auth::routes();
Route::group(['prefix' => 'auth', 'controller' => UnAuthemticatedController::class], function () {
    Route::get('/google-auth', 'googleAuth')->name('auth.google');
    Route::get('/google-callback', 'googleCallback')->name('auth.google.callback');
});
Route::group(['middleware' => 'auth'], function () {
    Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('/get-expire', 'getSessionExpiration')->name('getSessionExpiration');
    });
    Route::prefix('user')->controller(App\Http\Controllers\UserController::class)->group(function () {

        // -------- User Routes
        Route::middleware('permission:user.show')->get('/', 'user')->name('user');
        Route::middleware('permission:user.update|user.delete')->post('/', 'process')->name('user.process');
        Route::middleware('permission:user.permission.update')->post('/permission/{id}/update', 'permissionUpdate')->name('permission.update');
        Route::middleware('permission:user.permission.show')->get('/permission/{id}/all', 'permissionAll')->name('permission.all');

        // -------- Profile Routes
        Route::middleware('permission:user.show')->get('/profile', 'Profile')->name('user.profile');

        // -------- Role Routes
        Route::prefix('role')->group(function () {
            Route::middleware('permission:role.show')->get('/', 'role')->name('role');
            Route::middleware('permission:role.create|role.update|role.delete')->post('/', 'roleProcess')->name('role.process');
            Route::middleware('permission:role.permission.show')->get('/permission/{id}/all', 'permissionRoleAll')->name('role.permission.all');
            Route::middleware('permission:role.permission.update')->post('/permission/{id}/update', 'permissionRoleUpdate')->name('role.permission.update');
        });

        // -------- Permission Routes
        Route::prefix('permission')->group(function () {
            Route::middleware('permission:permission.show')->get('/', 'permission')->name('permission');
            Route::middleware('permission:permission.update|permission.delete')->post('/', 'permissionProcess')->name('permission.process');
        });
    });


    Route::controller(App\Http\Controllers\ScheduleController::class)->prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:schedule.show');
        Route::post('/', 'index')->name('update')->middleware('permission:schedule.update');
        Route::get('/{id}', 'index')->name('delete')->middleware('permission:schedule.delete');
    });
    Route::controller(App\Http\Controllers\TranslationController::class)->prefix('translations')->group(function () {
        Route::get('/', 'index')->name('translations.index')->middleware('permission:translations.show');
        Route::post('/', 'process')->name('translations.process')->middleware('permission:translations.create|translations.update|translations.delete');
        Route::get('/{slug}/lang', 'language')->name('translations.language')->middleware('permission:translations.show');
        Route::post('/{slug}/lang', 'languageProcess')->name('translations.languageProcess')->middleware('permission:translations.create|translations.update|translations.delete');
        Route::get('change/{slug}', 'change')->name('translations.change')->middleware('permission:translations.change');
    });

    Route::controller(App\Http\Controllers\ChatController::class)->prefix('chat')->name('chat.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:chat.show');
        Route::get('/{user}/inbox', 'chatInbox')->name('inbox')->middleware('permission:chat.create');
        Route::post('/', 'message')->name('message');
    });

    Route::controller(MediaViewController::class)->group(function () {
        Route::get('/image/{media}', 'displayImage')->name('media.image.display');
        Route::get('/show/{filename}', 'showImage')->name('media.file.display');
        // Route::get('/download-s3-objects/{file}', 'downloadS3Objects')->name('media.s3-objects.download');
    });
});
