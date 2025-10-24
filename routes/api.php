<?php

use App\Http\Controllers\PlugNmeetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/plugnmeet/create-room', [PlugNmeetController::class, 'create'])->name('plugnmeet.create-room');
Route::post('/plugnmeet/join-room', [PlugNmeetController::class, 'join'])->name('plugnmeet.join-room');
