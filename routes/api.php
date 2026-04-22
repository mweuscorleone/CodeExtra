<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RantingController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create/users', [AuthController::class, 'store']);
Route::put('/user/update/{id}', [AuthController::class, 'update']);
Route::delete('/user/delete/{id}', [AuthController::class, 'destroy']);
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/user/logout', [AuthController::class, 'logout']);
});
Route::post('user/login', [AuthController::class, 'login']);
Route::get('users', [AuthController::class, 'index']);
Route::middleware('auth:sanctum')->post('product/rating', [RantingController::class, 'productRating']);