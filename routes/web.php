<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('/register', [CustomRegisteredUserController::class, 'store'])
    ->middleware(['guest']);

Route::middleware('auth','web')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/send-request', [UserController::class, 'sendFriendRequest'])->name('users.send-request');
    Route::get('/friend-requests', [UserController::class, 'getReceivedRequestList'])->name('friend-request.all');
    Route::post('/friend-requests/{request}/accept', [UserController::class, 'accept'])->name('friend-requests.accept');
    Route::post('/friend-requests/{request}/reject', [UserController::class, 'reject'])->name('friend-requests.reject');
    Route::post('chatify/{userId}', [ChatController::class, 'index'])->name('chatify.chat');
});
