<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Publication;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class MonitoringController extends Controller
{
  private function getDays($dateStart, $dateEnd)
  {
    $days = floor((strtotime($dateEnd) - strtotime($dateStart)) / (60 * 60 * 24));
    return $days;
  }

  private function isTodayPlan($plan): bool
  {
    $today = date('Y-m-d');
    $dateStart =  $plan->Year . '-09-01';
    $dateEnd =  ++$plan->Year . '-08-31';
    if ($today >= $dateStart && $today <= $dateEnd) {
      return true;
    }
    return false;
  }

  function get_highest(object $arr)
  {
    $firstKey = 0;
    $max = $arr->$firstKey; // set the highest object to the first one in the array
    foreach ($arr as $obj) { // loop through every object in the array
      $num = $obj; // get the number from the current object
      if ($num > $max) { // If the number of the current object is greater than the maxs number:
        $max = $obj; // set the max to the current object
      }
    }
    return $max; // Loop is complete, so we have found our max and can return the max object
  }

  private function calculate($raw): array
  {
    $resultTeses = [];
    foreach ($raw as $teses) {
      $arrayOfDigits = (object)[];
      foreach ($teses as $secondkey => $tese) {
        $tesesOne = $tese;
        $maxErrorsCount = 0;
        foreach ($teses as $teseTwo) {
          $digit = abs($teseTwo - $tesesOne);
          if ($digit > 120) $maxErrorsCount++;
          if ($digit > 90) $maxErrorsCount++;
          if ($digit > 60) $maxErrorsCount++;
        }
        $arrayOfDigits->$secondkey = $maxErrorsCount;
      }
      $maxValue = $this->get_highest($arrayOfDigits);

      foreach ($arrayOfDigits as $lastkey => $value) {
        if ($value == $maxValue) {
          unset($teses[$lastkey]);
        }
      }
      if (count($teses) != 0) {
        $avg = floor(array_sum($teses) / count($teses));
        array_push($resultTeses, $avg);
      }
    }
    return $resultTeses;
  }

  public function getPlanId(Request $request)
  {
    $planId = $request->input('planid');
    $plan = Plan::where('id', $planId)->first();
    if (!$this->isTodayPlan($plan)) {
      return response()->json([
        'success' => false,
        'message' => 'План не актуален',
      ]);
    }
    $authorId = $plan->AuthorId;
    $planList =  Plan::where('AuthorId', $authorId)->get();
    $publList = (object)[];
    foreach ($planList as $planOne) {
      $year = $planOne->Year;
      $dateStart =  $year . '-09-01';
      $dateEnd =  ($year + 1) . '-08-31';
      $publsByPlan = Publication::join('publication_authors', 'publications.id', 'publication_authors.Publication')->where('Author', $authorId)->whereBetween('publications.PublicationDate', [$dateStart, $dateEnd])->get();
      // get teses`s days
      $teses = $publsByPlan->where('Type', 1)->pluck('PublicationDate');
      $tesesDays = [];
      foreach ($teses as $tese) {
        $tesesDays[] = $this->getDays($dateStart, $tese);
      }
      // get articles`s days
      $articles = $publsByPlan->where('Type', 2)->pluck('PublicationDate');
      $articlesDays = [];
      foreach ($articles as $article) {
        $articlesDays[] = $this->getDays($dateStart, $article);
      }
      // get scopus`s days
      $scopus = $publsByPlan->where('Type', 3)->pluck('PublicationDate');
      $scopusDays = [];
      foreach ($scopus as $scopu) {
        $scopusDays[] = $this->getDays($dateStart, $scopu);
      }
      // get monographs`s days
      $monographs = $publsByPlan->where('Type', 4)->pluck('PublicationDate');
      $monographsDays = [];
      foreach ($monographs as $monograph) {
        $monographsDays[] = $this->getDays($dateStart, $monograph);
      }
      sort($tesesDays);
      sort($articlesDays);
      sort($scopusDays);
      sort($monographsDays);

      $publList->$year = (object)[
        'teses' => $tesesDays,
        'articles' => $articlesDays,
        'scopus' => $scopusDays,
        'monographs' => $monographsDays,
      ];
    }
    $years = get_object_vars($publList);
    $teseses = [];
    foreach ($years as $year => $value) {
      $teses = $value->teses;
      foreach ($teses as $key => $tese) {
        if (!isset($teseses[$key])) $teseses[$key] = [];
        array_push($teseses[$key], $tese);
      }
    }

    $articleses = [];
    foreach ($years as $year => $value) {
      $articles = $value->articles;
      foreach ($articles as $key => $article) {
        if (!isset($articleses[$key])) $articleses[$key] = [];
        array_push($articleses[$key], $article);
      }
    }
    $scopuses = [];
    foreach ($years as $year => $value) {
      $scopus = $value->scopus;
      foreach ($scopus as $key => $scopu) {
        if (!isset($scopuses[$key])) $scopuses[$key] = [];
        array_push($scopuses[$key], $scopu);
      }
    }

    $monographses = [];
    foreach ($years as $year => $value) {
      $monographs = $value->monographs;
      foreach ($monographs as $key => $monograph) {
        if (!isset($monographses[$key])) $monographses[$key] = [];
        array_push($monographses[$key], $monograph);
      }
    }
    $resultScopus = $this->calculate($scopuses);

    $resultTeses = $this->calculate($teseses);
    $resultArticles = $this->calculate($articleses);
    $resultMonographs = $this->calculate($monographses);
    return response()->json([
      'success' => true,
      'data' => [
        'teses' => $resultTeses,
        'articles' => $resultArticles,
        'resultScopus' => $resultScopus,
        'resultMonographs' => $resultMonographs,
      ],
    ]);
  }
}
