<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\LangRequest;

use App\Models\Sponsor;

class MiscellaneousController extends Controller
{
    /**
     * @OA\Get(
     *   path="/sponsors",
     *   summary="Get all sponsors",
     *   description= "Show list of sponsors",
     *   tags={"Sponsors"},
     *   @OA\Parameter(
     *      name="lang",
     *      in="query",
     *      description="App language (es/en)",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *          format="text",
     *          description="Lang"
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="Show list of all sponsors",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=500,
     *      description="an ""unexpected"" error"
     *   ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sponsors(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $sponsors = Sponsor::with(['category'])->get();

            $groupedSponsors = $sponsors->groupBy(function($sponsor) use ($lang) {
                $response = ($lang === 'es') ? $sponsor->category->name_es : $sponsor->category->name_en;
                return $response; 
            })->map(function($sponsorsGroup) {
                return $sponsorsGroup->map(function($sponsor) {
                    return [
                        'id' => $sponsor->id,
                        'logo' => env('APP_URL').'/storage/'.$sponsor->logo,
                        'link' => $sponsor->link
                    ];
                });
            });;

            return response()->json([
                'success' => true,
                'data' => $groupedSponsors
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }
    
}
