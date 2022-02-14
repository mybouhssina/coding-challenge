<?php

namespace App\Http\Controllers;

use App\Models\TechBuzzWords;
use Illuminate\Http\Request;

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
        $techs = explode(',', $keyword);
        $techs = array_map(fn($tech) => trim($tech) ,$techs);
        return response()->json([
            // TODO: gérer le cas où un ou plusieurs nom de tech n'existe pas
            'name' => TechBuzzWords::query()->whereIn('key', $techs)->pluck('value')->implode(' ')
        ]);
    }

    public function searchTech(Request $request) {
        $tech = $request->get('tech');
        return response()->json(\App\Models\TechBuzzWords::query()->where('key', 'like', "$tech%")->pluck('key'));
    }
}
