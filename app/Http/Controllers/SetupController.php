<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalSetup;
use Illuminate\Support\Facades\Auth;

class SetupController extends Controller
{
    public function ClientSetup (){
        $authStatus = false;
        if(Auth::check()) $authStatus = true;

        return response() ->json([
            'success' => true,
            'authStatus' => $authStatus
        ]);
    }
    public function GetGlobalSetup()
    {

       // return response()->json(['message' => Auth::check()]);

        try {
            $data = GlobalSetup::pluck('SetupValue', 'SetupName')->all();
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

    public function SetAuthorsNumber(Request $req)
    {
        try {
            GlobalSetup::where('SetupName', 'authorsPublCount')->update(['SetupValue' => $req->number]);
            return response()->json([
                'success' => true,
                'message' => 'Setup changed'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function SetAutoCheck(Request $req)
    {
        return $req;
    }
}
