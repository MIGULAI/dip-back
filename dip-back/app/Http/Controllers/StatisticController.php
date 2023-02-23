<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Publication;
use App\Models\Author;



class StatisticController extends Controller
{
    public function GetBasicStatistic(){
        try {

            $data = [
                'publicationsCount' => Publication::all()->count(),
                'authorsCount' => Author::all()->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Basic Statistic founded',
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
