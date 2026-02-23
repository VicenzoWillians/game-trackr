<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json([
            ['id' => 1, 'title' => 'Counter-Strike 2', 'status' => 'Jogando', 'platform' => 'PC'],
            ['id' => 2, 'title' => 'Red Dead Redemption 2', 'status' => 'Concluído', 'platform' => 'PC'],
            ['id' => 3, 'title' => 'Hollow Knight', 'status' => 'Na fila', 'platform' => 'PC']
        ]);
    }
}
