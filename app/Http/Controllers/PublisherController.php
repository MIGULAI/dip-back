<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublisherRequest;
use App\Models\Publisher;


class PublisherController extends Controller
{
    public function CreatePublisher(PublisherRequest $req)
    {
        try {
            $newPubl = new Publisher();
            $newPubl->PublisherName = $req->publisherName;
            $newPubl->save();
            return [
                'success' => true,
                'message' => ['Видавця додано'],
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
