<?php

namespace App\Http\Controllers;

use App\Http\Requests\RankRequest;
use App\Models\Ranks;

class RankController extends Controller
{
    public function CreateRank(RankRequest $req) {
        try {
            $new = new Ranks();
            $new->RankName = $req->rankName;
            $new->save();
            return [
                'success' => true,
                'message' => ['Вчере звання додано'],
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
