<?php

namespace App\Http\Controllers;

use App\Models\TechBuzzWords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TechBuzzWordsController extends Controller
{

    /**
     * returns a name based on the query string.
     *
     * @return JsonResponse
     */
    public function getName(Request $request): JsonResponse
    {
        $keyword = $request->get('x');
        if(!trim($keyword)) {
            return response()->json(['error' => "missing query parameter 'x'"])->setStatusCode(400);;
        }
        $techs = explode(',', $keyword);
        $techs = array_map(fn($tech) => trim($tech) ,$techs);
        $models = TechBuzzWords::query()
            ->whereIn('key', $techs)->get()->keyBy('key');
//        some of the keywords don't exist
        if($models->count() < count($techs)) {
            $inexistingWords = [];
            foreach($techs as $techBuzzWord) {
                if(!isset($models[$techBuzzWord])) {
                    $inexistingWords[] = $techBuzzWord;
                }
            }
            return response()->json(['error' => [
                'code' => 'inexisting_words',
                'inexisting_words' => $inexistingWords
            ]])->setStatusCode(422);
        }
        else {
            $finalResult = [];
            foreach($techs as $tech) {
                $finalResult[] = $models[$tech]->value;
            }
            return response()->json([
                'name' => implode(' ', $finalResult)
            ]);
        }
    }

    /**
     * Returns a list of keys matching fully or partially the querystring key
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchTech(Request $request): JsonResponse
    {
        $tech = $request->get('tech');
        return response()->json(\App\Models\TechBuzzWords::query()->where('key', 'like', "$tech%")->pluck('key'));
    }
}
