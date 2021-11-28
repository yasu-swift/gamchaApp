<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;

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

// ユーザー登録
Route::post('/register', [RegisterController::class, 'register']);

// ログイン
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// コメントの登録はできるがroom/commentの一覧は見れない
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('rooms', RoomController::class);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('users', UserController::class);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('rooms.comments', CommentController::class);
});



// 一覧は見れるが登録ができない
Route::group([['api']], function () {
    Route::apiResource('rooms', App\Http\Controllers\Api\RoomController::class)
    ->except(['create', 'store', 'edit', 'update', 'destroy']);
});
Route::group([['api']], function () {
    Route::apiResource('users', App\Http\Controllers\Api\UserController::class)
    ->except(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::group([['api']], function () {
    Route::apiResource('rooms.comments', App\Http\Controllers\Api\CommentController::class)
    ->except(['create', 'store', 'edit', 'update', 'destroy']);
});
