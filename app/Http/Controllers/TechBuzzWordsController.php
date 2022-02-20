<?php

namespace App\Http\Controllers;

use App\Models\TechBuzzWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TechBuzzWordsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getName(Request $request)
    {
        $keyword = $request->get('x');
        if(!trim($keyword)) {
            return response()->json(['error' => "missing query parameter 'x'"])->setStatusCode(400);;
        }
        $techs = explode(',', $keyword);
        $techs = array_map(fn($tech) => trim($tech) ,$techs);
        $res = TechBuzzWords::query()
            ->whereIn('key', $techs)->get()->keyBy('key');
        if($res->count() < count($techs)) {
            $missingWords = [];
            foreach($techs as $techBuzzWord) {
                if(!isset($res[$techBuzzWord])) {
                    $missingWords[] = $techBuzzWord;
                }
            }
            return response()->json(['error' => [
                'code' => 'missing_words',
                'missing_words' => $missingWords
            ]])->setStatusCode(422);
        }
        else {
            $finalResult = [];
            foreach($techs as $tech) {
                $finalResult[] = $res[$tech]->value;
            }
            return response()->json([
                // TODO: gérer le cas où un ou plusieurs nom de tech n'existe pas
                'name' => implode(' ', $finalResult)
            ]);
        }
    }

    public function searchTech(Request $request) {
        $tech = $request->get('tech');
        return response()->json(\App\Models\TechBuzzWords::query()->where('key', 'like', "$tech%")->pluck('key'));
    }
}
