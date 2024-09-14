<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\LangRequest;

use App\Models\Sponsor;
use App\Models\Place;
use App\Models\News;

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

    /**
     * @OA\Get(
     *   path="/places",
     *   summary="Get all places",
     *   description= "Show list of places",
     *   tags={"Places"},
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
     *      description="Show list of all places",
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
    public function places(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $places = Place::with(['category'])->get();

            $groupedPlaces = $places->groupBy(function($place) use ($lang) {
                $response = ($lang === 'es') ? $place->category->name_es : $place->category->name_en;
                return $response; 
            })->map(function($placesGroup) use ($lang) {
                return $placesGroup->map(function($place) use ($lang) {
                    return [
                        'id' => $place->id,
                        'title' => ($lang === 'es') ? $place->title_es : $place->title_en,
                        'image' => env('APP_URL').'/storage/'.$place->image
                    ];
                });
            });

            return response()->json([
                'success' => true,
                'data' => $groupedPlaces
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/places/{id}",
     *   summary="Get a place",
     *   description= "Show place details",
     *   tags={"Places"},
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
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Place ID",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *          description="Unique Place Identifier"
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="Show list of all places",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *  @OA\Response(
     *     @OA\MediaType(mediaType="application/json"),
     *     response=404,
     *     description="Place Not Found."
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
    public function place_details(LangRequest $request, $id): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $place = Place::with(['images'])->find($id);

            if (!$place)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('api.place_not_found', [], $lang)
                ], 404);

            $formattedPlace = [
                'id' => $place->id,
                'title' => ($lang === 'es') ? $place->title_es : $place->title_en,
                'description' => ($lang === 'es') ? $place->description_es : $place->description_en,
                'image' => env('APP_URL').'/storage/'.$place->image,
                'link' => $place->link,
                'gallery' => $place->images->map(function($image) {
                    return [
                        'id' => $image->id,
                        'place_id' => $image->place_id,
                        'image' => env('APP_URL').'/storage/'.$image->image,
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'data' => $formattedPlace
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/news",
     *   summary="Get all news",
     *   description= "Show list of news",
     *   tags={"News"},
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
     *      description="Show list of all news",
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
    public function news(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $news = News::with(['category'])->get();

            $groupedNews = $news->groupBy(function($new) use ($lang) {
                $response = ($lang === 'es') ? $new->category->name_es : $new->category->name_en;
                return $response; 
            })->map(function($newsGroup) use ($lang) {
                return $newsGroup->map(function($new) use ($lang) {
                    return [
                        'id' => $new->id,
                        'title' => ($lang === 'es') ? $new->title_es : $new->title_en,
                        'date' => $new->date,
                        'image' => env('APP_URL').'/storage/'.$new->image
                    ];
                });
            });

            return response()->json([
                'success' => true,
                'data' => $groupedNews
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/news/{id}",
     *   summary="Get a new",
     *   description= "Show new details",
     *   tags={"News"},
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
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="New ID",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *          description="Unique New Identifier"
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="Show list of all news",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *  @OA\Response(
     *     @OA\MediaType(mediaType="application/json"),
     *     response=404,
     *     description="New Not Found."
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
    public function new_details(LangRequest $request, $id): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $new = News::with(['category'])->find($id);

            if (!$new)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('api.new_not_found', [], $lang)
                ], 404);

            $formattedNew = [
                'id' => $new->id,
                'title' => ($lang === 'es') ? $new->title_es : $new->title_en,
                'content' => ($lang === 'es') ? $new->content_es : $new->content_en,
                'category' => ($lang === 'es') ? $new->category->name_es : $new->category->name_en,
                'date' => $new->date,
                'image' => env('APP_URL').'/storage/'.$new->image
            ];

            return response()->json([
                'success' => true,
                'data' => $formattedNew
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
