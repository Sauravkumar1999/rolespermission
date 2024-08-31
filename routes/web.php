<?php

use App\Http\Controllers\MediaViewController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('/get-expire', 'getSessionExpiration')->name('getSessionExpiration');
    });
    Route::controller(App\Http\Controllers\UserController::class)->prefix('user')->group(function () {
        // ---------user routes
        Route::get('/', 'user')->name('user')->middleware('permission:user.show');
        Route::post('/', 'process')->name('user.process')->middleware('permission:user.edit|user.delete');
        Route::post('/permission/{id}/update', 'permissionUpdate')->name('permission.update')->middleware('permission:user.permission.update');
        Route::get('/permission/{id}/all', 'permissionAll')->name('permission.all')->middleware('permission:user.premission.show');

        // ---------role routes
        Route::get('/role', 'role')->name('role')->middleware('permission:role.show');
        Route::post('/role', 'roleProcess')->name('role.process')->middleware('permission:role.edit|role.delete');
        Route::get('/role/permission/{id}/all', 'permissionRoleAll')->name('role.permission.all')->middleware('permission:role.permission.show');
        Route::post('/role/permission/{id}/update', 'permissionRoleUpdate')->name('role.permission.update')->middleware('permission:role.permission.update');

        // -------- permission routes
        Route::get('/permission', 'permission')->name('permission')->middleware('permission:permission.show');
        Route::post('/permission', 'permissionProcess')->name('permission.process')->middleware('permission:permission.edit|permission.delete');
    });
    Route::controller(App\Http\Controllers\ChatController::class)->prefix('chat')->name('chat.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'message')->name('message');
    });
    Route::controller(App\Http\Controllers\ScheduleController::class)->prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    Route::controller(App\Http\Controllers\TranslationController::class)->prefix('translations')->group(function () {
        Route::get('/', 'index')->name('translations.index');
        Route::post('/', 'process')->name('translations.process');
        Route::get('/{slug}/lang', 'language')->name('translations.language');
        Route::post('/{slug}/lang', 'languageProcess')->name('translations.languageProcess');
        Route::get('change/{slug}', 'change')->name('translations.change');
    });
    Route::controller(MediaViewController::class)->group(function () {
        Route::get('/image/{media}', 'displayImage')->name('media.image.display');
        Route::get('/show/{filename}', 'showImage')->name('media.file.display');
        // Route::get('/download-s3-objects/{file}', 'downloadS3Objects')->name('media.s3-objects.download');
    });
});
