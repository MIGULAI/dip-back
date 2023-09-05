<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker;

class PublicationSeeder extends Seeder
{
    private function generateStudent(): int
    {
        $faker = Faker\Factory::create();
        $id = DB::table('authors')->insertGetId([
            'Orcid' => $faker->regexify('[0-9]{15}') . $faker->regexify('[A-Z]{1}'),
            'SerName' => $faker->lastName,
            'Name' => $faker->name,
            'Patronic' => $faker->name,
            'SerNameEng' => $faker->lastName,
            'NameEng' => $faker->name,
            'PatronicEng' => $faker->name,
            'Position' => 2,
            'Department' => 2,
            'Specialty' => 1,
            'Degree' => 1,
            'Rank' => 1,
            'PlanningStatus' => false
        ]);
        return $id;
    }

    private function generatePublicationToPlan(int $planId, int $publId)
    {
        DB::table('publication_plans')->insert([
            'Publication' => $publId,
            'Plan' => $planId
        ]);
    }
    private function generatePublicationToAuthor(int $authorId, int $publId)
    {
        DB::table('publication_authors')->insert([
            'Author' => $authorId,
            'Publication' => $publId
        ]);
    }

    private function generatePublication(object $plan, int $type)
    {
        $faker = Faker\Factory::create();
        $startPage = $faker->numberBetween(1, 200);
        $endPage = $faker->numberBetween($startPage, 250);
        $dateStart = $plan->Year . '-09-01';
        $dateEnd = ($plan->Year + 1) . '-08-31';

        $publId = DB::table('publications')->insertGetId([
            'Name' => $faker->company,
            'UPP' => ($endPage - $startPage + 1) * 0.1031,
            'StartPage' => $startPage,
            'EndPage' => $endPage,
            'PublicationNumber' => $faker->regexify('[A-Za-z0-9]{20}'),
            'PublicationDate' => $faker->dateTimeBetween($dateStart, $dateEnd),
            'DOI' => $faker->url,
            'Type' => $type,
            'Language' => 1,
            'Publisher' => 1,
            'Country' => 1
        ]);
        $rundomPlansNumber = rand(0, 3);
        $plans = DB::table('plans')->where('Year', $plan->Year)->get();
        foreach ($plans as $key => $value) {
            if ($plans[$key]->id === $plan->id) {
                $plans->forget($key);
            }
        }
        $this->generatePublicationToPlan($plan->id, $publId);
        $this->generatePublicationToAuthor($plan->AuthorId, $publId);

        while ($rundomPlansNumber > 0) {
            $rundomPlan = $faker->randomElement($plans);
            foreach ($plans as $key => $value) {
                if ($plans[$key]->id === $rundomPlan->id) {
                    $plans->forget($key);
                }
            }
            $this->generatePublicationToPlan($rundomPlan->id, $publId);
            $this->generatePublicationToAuthor($rundomPlan->AuthorId, $publId);
            $rundomPlansNumber--;
        }
        $numberOfAuthor = 1 + $rundomPlansNumber;
        $studentCount = 0;
        if ($numberOfAuthor === 1 && $type !== 1) {
            $studentCount =  $faker->boolean(70) ? 1 : ( $faker->boolean(70) ? 0 : 2);
        } elseif ($numberOfAuthor === 2  && $type !== 1) {
            $studentCount =  $faker->boolean(90) ? 1 : ($faker->boolean(60) ? 0 : 2);
        }
        while ($studentCount > 0) {
            $idStudent = $this->generateStudent();
            $this->generatePublicationToAuthor($idStudent, $publId);
            $studentCount--;
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = DB::table('plans')->get();
        foreach ($plans as $plan) {
            $corupted = false;
            $faker = Faker\Factory::create();
            $theses = $faker->boolean(70) ? $plan->Theses : ($faker->boolean(50) ? $plan->Theses + 1 : $plan->Theses  - 1);
            $profetionalArticles = $faker->boolean(70) ? $plan->ProfetionalArticles : ($faker->boolean(50) ? $plan->ProfetionalArticles + 1 : $plan->ProfetionalArticles  - 1);
            $scopus = $faker->boolean(70) ? $plan->Scopus : ($faker->boolean(50) ? $plan->Scopus + 1 : $plan->Scopus  - 1);
            $manuals = $faker->boolean(70) ? $plan->Manuals : ($faker->boolean(50) ? $plan->Manuals + 1 : $plan->Manuals  - 1);

            if ($theses > 0) {
                while ($theses !== 0) {
                    $this->generatePublication($plan, 1);
                    $theses -= 1;
                }
            }
            if ($profetionalArticles > 0) {
                while ($profetionalArticles !== 0) {
                    $this->generatePublication($plan, 2);
                    $profetionalArticles -= 1;
                }
            }
            if ($scopus > 0) {
                while ($scopus !== 0) {
                    $this->generatePublication($plan, 3);
                    $scopus -= 1;
                }
            }
            if ($manuals > 0) {
                while ($manuals !== 0) {
                    $this->generatePublication($plan, 4);
                    $manuals -= 1;
                }
            }
        }
    }
}
