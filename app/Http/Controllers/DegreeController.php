<?php

namespace App\Http\Controllers;

use App\Http\Requests\DegreeRequest;
use App\Models\Degree;

class DegreeController extends Controller
{
    public function CreateDegree(DegreeRequest $req) {
        try {
            $new = new Degree();
            $new->DegreeName = $req->degreeName;
            $new->save();
            return [
                'success' => true,
                'message' => ['Науковий ступінь додано'],
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
