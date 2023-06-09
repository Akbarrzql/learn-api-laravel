<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/post',[PostController::class, 'store']);
    Route::post('/post/{id}',[PostController::class, 'update'])->middleware('owner-post');
    Route::delete('/post/{id}',[PostController::class, 'destroy'])->middleware('owner-post');
});

Route::get('/post',[PostController::class, 'index']);
Route::get('/post/{id}',[PostController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


