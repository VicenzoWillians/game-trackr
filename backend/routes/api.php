<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\GameController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });

    Route::get('/', function(Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => 'FOI',
                'message' => 'VAMBORA'
            ]
        ]);
    });


    Route::post('/logout', [AuthController::class, 'logout']);
});
