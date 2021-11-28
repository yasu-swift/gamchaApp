<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/', [RoomController::class, 'index'])
    ->name('root');

Route::resource('users', UserController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('users', UserController::class)
    ->only(['show', 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('rooms', RoomController::class)
    ->middleware('auth')
    ->only(['create', 'store', 'edit', 'update', 'destroy']);

Route::resource('rooms', RoomController::class)
    ->only(['index', 'show']);

Route::resource('rooms.comments', CommentController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

require __DIR__ . '/auth.php';
