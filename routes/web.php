<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CommentController;
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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('rooms', RoomController::class)
->only(['create', 'store', 'edit', 'update', 'destroy'])
->middleware('auth');

Route::resource('rooms', RoomController::class)
->only(['show', 'index']);

Route::resource('rooms.comments', CommentController::class)
->only(['create', 'store', 'edit', 'update', 'destroy'])
->middleware('auth');

//API
// Auth::routes();

// Route::get('/result/ajax', 'RoomController@getData');

// Route::get('/home', 'RoomController@index')->name('home');

// Route::post('/add', 'RoomController@index')->name('add');

require __DIR__ . '/auth.php';
