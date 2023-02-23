<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalSetup;


class SetupController extends Controller
{
    public function getGlobalSetup(){
        try {
            $data = GlobalSetup::pluck('SetupValue','SetupName')->all();
            return response()->json([
                'success' => true,
                'message' => 'Global setup was found',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    } 
}
