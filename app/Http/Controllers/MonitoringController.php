<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function getPlanId(Request $request)
    {
        $planId = $request->input('planid');
        $plan = Plan::where('id', $planId)->first();
        $authorId = $plan->AuthorId;
        return response()->json([
            'success' => true,
            'plan' => $plan,
            'planId' => $planId
        ]);
    }
}
