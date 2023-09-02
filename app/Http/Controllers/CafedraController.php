<?php

namespace App\Http\Controllers;

use App\Http\Requests\CafedraRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class CafedraController extends Controller
{
    public function CreateCafedra(CafedraRequest $req) {
        try {
            $new = new Department();
            $new->DepartmanName = $req->cafedraName;
            $new->idOrganization = 1;
            $new->save();
            return [
                'success' => true,
                'message' => ['Кафедру додано'],
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
