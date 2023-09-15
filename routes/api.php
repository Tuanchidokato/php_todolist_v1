<?php

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

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('registration', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);



Route::post('auth/register',[\App\Http\Controllers\AuthController_v2::class,'register']);
Route::post('auth/login',[\App\Http\Controllers\AuthController_v2::class,'login']);
Route::middleware(['json.unauthorized','auth:sanctum'])->group(function(){
    Route::get('/auth/getDetail',[\App\Http\Controllers\AuthController_v2::class,'getDetail']);
    Route::post('/auth/addPost',[\App\Http\Controllers\PostController::class,'addPost']);
    Route::post('/auth/addCate',[\App\Http\Controllers\PostController::class,'addCategory']);
    Route::get('/auth/getAll',[\App\Http\Controllers\PostController::class,'getAllPost']);
    Route::put('/auth/updatePost/{post_id}',[\App\Http\Controllers\PostController::class,'updatePost']);
    Route::delete('/auth/deletePost/{post_id}',[\App\Http\Controllers\PostController::class,'deletePost']);
});


