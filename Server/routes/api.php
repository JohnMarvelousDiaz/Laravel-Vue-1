<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PostController;

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


Route::post('register',[AuthController::class,'store']);
Route::post('login',[AuthController::class,'auth']);
Route::middleware('auth:sanctum')->post('logout',[AuthController::class,'destroy']);
Route::middleware('auth:sanctum')->get('check/auth',[AuthController::class,'checkAuth']);
Route::middleware('auth:sanctum')->get('check/guest',[AuthController::class,'checkGuest']);
Route::middleware('auth:sanctum')->post('post',[PostController::class,'store']);
Route::middleware('auth:sanctum')->get('post/general/{page}',[PostController::class, 'general']);
