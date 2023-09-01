<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\GlobalSetup;
use App\Models\Plan;
use App\Models\Publication;
use App\Models\PublicationPlan;
use DateTime;

class PlanController extends Controller
{
    public function GetYearsList()
    {
        try {
            $years = Plan::distinct()->pluck('Year')->toArray();

            return response()->json([
                'success' => true,
                'message' => 'Years was selected',
                'data' => [
                    'years' => array_reverse($years)
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function GetPlansByYear(Request $req)
    {
        try {
            $plans = Plan::where('Year', $req->year)->get();
            foreach ($plans as $plan) {
                $plan->AuthorSerName = Author::where('id', $plan->AuthorId)->first()->SerName;
                $plan->AuthorName = Author::where('id', $plan->AuthorId)->first()->Name;
                $plan->AuthorPatronic = Author::where('id', $plan->AuthorId)->first()->Patronic;
            }
            return response()->json([
                'success' => true,
                'message' => 'Plans was found',
                'data' => [
                    'plans' => $plans
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function CheckIsAuthorHavePlanOnYear($authorId, $year)
    {
        $plan = Plan::where('AuthorId', $authorId)->where('Year', $year)->get();
        if (count($plan) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function CreatePlan($planingYear, $setup): array
    {

        $authors = Author::where('PlanningStatus', '1')->get();
        $plans = [];
        foreach ($authors as $author) {
            if ($this->CheckIsAuthorHavePlanOnYear($author->id, $planingYear)) {
                break;
            }
            $plan = new Plan();
            $plan->AuthorId = $author->id;
            $plan->AuthorName = $author->Name;
            $plan->AuthorSername = $author->SerName;
            $plan->AuthorPatronic = $author->Patronic;
            $plan->Year = $planingYear;
            $planingYear % intval($setup['thesesYears']) == 0 ? $plan->Theses = intval($setup['thesesNumber']) :  $plan->Theses = 0;
            $planingYear % intval($setup['paYears']) == 0 ? $plan->ProfetionalArticles = intval($setup['paNumber']) :  $plan->ProfetionalArticles = 0;
            $planingYear % intval($setup['scopusYears']) == 0 ? $plan->Scopus = intval($setup['scopusNumber']) :  $plan->Scopus = 0;
            $planingYear % intval($setup['manualsYears']) == 0 ? $plan->Manuals = intval($setup['manualsNumber']) :  $plan->Manuals = 0;
            array_push($plans, $plan);
        }
        return $plans;
    }

    public function CreatePlanByForYear(Request $req)
    {
        try {
            $planingYear = intval($req->year);
            $setup = GlobalSetup::pluck('SetupValue', 'SetupName')->all();
            $plans = $this->CreatePlan($planingYear, $setup);
            if(count($plans) === 0){
                return response()->json([
                    'success' => false,
                    'message' => "Неможлииво сформувати план."
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => "Plan on {$planingYear} year created",
                'data' => [
                    'plans' => $plans,
                    'setup' => $setup
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function Saver($plans): bool
    {
        foreach ($plans as $plan) {
            $newPlan = new Plan();
            $newPlan->AuthorId = $plan['AuthorId'];
            $newPlan->Year = $plan['Year'];
            $newPlan->Theses = $plan['Theses'];
            $newPlan->ProfetionalArticles = $plan['ProfetionalArticles'];
            $newPlan->Scopus = $plan['Scopus'];
            $newPlan->Manuals = $plan['Manuals'];
            $newPlan->save();
        }
        return true;
    }

    public function SavePlan(Request $req)
    {
        try {
            $plans = $req->plan;
            $this->Saver($plans);
            return response()->json([
                'success' => true,
                'message' => 'Plan was successfully added'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function CalculatePlans()
    {
        try {
            $plans = Plan::all();
            foreach ($plans as $plan) {
                $planDataStart = new DateTime($plan->Year . '-08-31');
                $planDataEnd = new DateTime((intval($plan->Year) + 1) . '-08-31');
                $planDataStart = date($planDataStart->format('Y-m-d'));
                $planDataEnd = date($planDataEnd->format('Y-m-d'));
                $planedAuthor = $plan->AuthorId;
                $publicationsByDate = Publication::join('publication_authors', 'publications.id', 'publication_authors.Publication')
                    ->whereBetween('PublicationDate', [$planDataStart, $planDataEnd])
                    ->orWhere('PublicationDate', $planDataStart)
                    ->get();
                $publicationsByDate = $publicationsByDate->where('Author', $planedAuthor);

                if (count($publicationsByDate)) {
                    foreach ($publicationsByDate as $publ) {
                        $isHere  = PublicationPlan::where('Publication', $publ->id)
                            ->where('Plan', $plan->id)->first();
                        if (!$isHere) {
                            $pp = new PublicationPlan();
                            $pp->Publication = $publ->id;
                            $pp->Plan = $plan->id;
                            $pp->save();
                        }
                    }
                    $publAndPlans = Publication::join('publication_plans', 'publications.id', 'publication_plans.Publication')
                        ->where('Plan', $plan->id)
                        ->get();
                    $counter = [
                        'Theses' => $plan->Theses,
                        'ProfetionalArticles' => $plan->ProfetionalArticles,
                        'Scopus' => $plan->Scopus,
                        'Manuals' => $plan->Manuals
                    ];
                    foreach ($publAndPlans as $publPlan) {
                        $type = Publication::where('id', $publPlan->Publication)->first()->Type;
                        ($type == 1 && $counter['Theses'] != 0) && $counter['Theses'] -= 1;
                        ($type == 2 && $counter['ProfetionalArticles'] != 0) && $counter['ProfetionalArticles'] -= 1;
                        ($type == 3 && $counter['Scopus'] != 0) && $counter['Scopus'] -= 1;
                        ($type == 4 && $counter['Manuals'] != 0) && $counter['Manuals'] -= 1;
                    }

                    $countSum = $counter['Manuals'] + $counter['Scopus'] + $counter['ProfetionalArticles'] + $counter['Theses'];
                    if ($countSum == 0) {
                        Plan::where('id', $plan->id)->update(['Stat' => true]);
                    }
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Plans recalculated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function GetPlanById(Request $req)
    {
        try {
            $plan = Plan::where('id', $req->id)->first();
            return response()->json([
                'success' => true,
                'message' => 'Plan founded',
                'data' => [
                    'plan' => $plan
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
