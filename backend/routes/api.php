<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameController;

Route::get('/user', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'data' => [
            'title' => 'FOI',
            'message' => 'VAMBORA'
        ]
    ]);
});

Route::get('/games', [GameController::class, 'index']);
