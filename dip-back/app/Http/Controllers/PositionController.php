<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;


class PositionController extends Controller
{
    public function GetPositions(){
        try {
            $data = [
                'positions' => Position::all('id', 'PositionName')
            ];
            return response()->json([
                'success' => false,
                'message' => 'Positions successfully found',
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
