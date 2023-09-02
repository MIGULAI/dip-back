<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
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

    public function CreatePosision(PositionRequest $req){
        try {
            $new = new Position();
            $new->PositionName = $req->positionName;
            $new->save();
            return [
                'success' => true,
                'message' => ['Посаду додано'],
                'data' => [
                    'id' => $new->id
                ]
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => [$th->getMessage()]
            ];
        }
    }
}
