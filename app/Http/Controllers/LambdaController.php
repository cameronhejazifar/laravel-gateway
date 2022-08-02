<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LambdaController extends Controller
{
    public function lambda(Request $request): Response
    {
        return response([
            'success' => true,
        ]);
    }
}
