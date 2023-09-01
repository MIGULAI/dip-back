<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LangRequest;
use App\Models\Languages;

class LangConroller extends Controller
{
    public function CreateLang(LangRequest $req)
    {
        try {
            $newPubl = new Languages();
            $newPubl->LanguageName = $req->langName;
            $newPubl->LanguageShortName = $req->langShortName;
            $newPubl->save();
            return [
                'success' => true,
                'message' => ['Мову додано'],
                'data' => [
                    'id' => $newPubl->id
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
