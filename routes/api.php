<?php

use App\Http\Controllers\Api\ChatController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('users', function () {
    return User::get(['id', 'profile', 'name']);
});
Route::controller(ChatController::class)->prefix('chat')->group(function () {
    Route::get('/get/{dmId}/{sender_id}', 'index');
    Route::post('store', 'chatStore');
    Route::get('mark/{message_id}/seen', 'markAsSeen');
});
