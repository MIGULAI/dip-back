<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitController extends Controller
{
    public function Init()
    {
        $authStatus = false;
        if (Auth::check()) {
            $authStatus = true;
        }

        return response()->json([
            'success' => false,
            'config' => [
                'authStatus' => $authStatus
            ]
        ]);
    }
}
