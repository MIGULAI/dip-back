<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;


class PublisherController extends Controller
{
    public static function CreatePublisher($newPublisher){
        try {
            $newPubl = new Publisher();
            $newPubl->PublisherName = $newPublisher;
            $newPubl->save();
            return [true, $newPubl->id];
        } catch (\Throwable $th) {
            return [false, $th->getMessage()];
        }
    }
}
