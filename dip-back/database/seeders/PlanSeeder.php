<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Controllers\PlanController;
use App\Models\GlobalSetup;

use DateTime;


class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pc = new PlanController();
        $yearNow = date('Y');
        $dateNow = new DateTime();
        $controleDate = new DateTime($yearNow . '-08-31');
        if ($dateNow <= $controleDate) {
            $yearNow -= 1;
        }
        $setup = GlobalSetup::pluck('SetupValue','SetupName')->all();
        for($i = $yearNow; $i > $yearNow - 5; $i--){
            $plans = $pc->CreatePlan($i, $setup);
            $pc->Saver($plans);
        }
    }
}
