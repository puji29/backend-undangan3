<?php

use App\Http\Controllers\Api\ReservasiController;
use App\Http\Controllers\Api\UcapanController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/reservasis', ReservasiController::class);
Route::apiResource('/ucapans', UcapanController::class);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group([
    "middleware" => "auth:sanctum"
], function () {
    Route::get('userprofile', [AuthController::class, 'userprofile']);
    Route::get('logout', [AuthController::class, 'logout']);
});

