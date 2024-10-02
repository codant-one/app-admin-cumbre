<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\LangRequest;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\FavoriteRequest;
use App\Http\Requests\TokenRequest;

use App\Models\Sponsor;
use App\Models\Place;
use App\Models\News;
use App\Models\Schedule;
use App\Models\Speaker;
use App\Models\Talk;
use App\Models\Question;
use App\Models\Review;
use App\Models\Favorite;
use App\Models\Translation;
use App\Models\Map;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Token;

use Carbon\Carbon;

class MiscellaneousController extends Controller
{
    protected $monthNames = [
        'en' => [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ],
        'es' => [
            '01' => 'Ene',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dic',
        ],
    ];

    /**
     * @OA\Get(
     *   path="/home",
     *   summary="Get all the details for the app home page",
     *   description= "Show all the details for the app home page",
     *   tags={"Home"},
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
    public function home(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;

            $places = Place::where('is_popular', 1)->get();

            $groupedPlaces = $places->map(function($place) use ($lang) {
                return [
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
                    }),
                    'label' => ($lang === 'es') ? 'Conoce Cartagena de Indias' : 'Get to know Cartagena de Indias',
                    'type' => 'place'
                ];
            });

            $news = News::where('is_popular', 1)->get();

            $groupedNews = $news->map(function($new) use ($lang) {
                
                $date = Carbon::parse($new->date);
                $day = $date->format('d');
                $month = $this->monthNames[$lang][$date->format('m')];
                $year = $date->format('Y');

                $formattedDate = "{$day} {$month} {$year}";

                return [
                    'id' => $new->id,
                    'title' => ($lang === 'es') ? $new->title_es : $new->title_en,
                    'content' => ($lang === 'es') ? $new->content_es : $new->content_en,
                    'category' => ($lang === 'es') ? $new->category->name_es : $new->category->name_en,
                    'date' => $formattedDate,
                    'image' => env('APP_URL').'/storage/'.$new->image,
                    'label' =>$formattedDate,
                    'type' => 'new'
                ];
            });

            $sliders = array_merge($groupedNews->toArray(), $groupedPlaces->toArray());

            $schedules = Schedule::all()->map(function($schedule) use ($lang) {
                return [
                    'id' => $schedule->id,
                    'name' => ($lang === 'es') ? $schedule->name_es : $schedule->name_en,
                    'image' => env('APP_URL').'/storage/'.$schedule->image,
                ];
            });

            $speakers = Speaker::with(['position'])->where('is_popular', 1)->orderByRaw('order_id IS NULL, order_id ASC')->get();

            $groupedSpeakers = $speakers->map(function($speaker) use ($lang) {
                return [
                    'id' => $speaker->id,
                    'fullname' => $speaker->name . ' ' . $speaker->last_name,
                    'position' => ($lang === 'es') ? $speaker->position->name_es : $speaker->position->name_en,
                    'avatar' => $speaker->avatar ? env('APP_URL').'/storage/'.$speaker->avatar : null,
                    'description' => ($lang === 'es') ? $speaker->description_es : $speaker->description_en,
                    'social_links' => $speaker->social_links->map(function($speakerWraper) use ($lang) {
                        $social_network = $speakerWraper->social_network;
                        return [
                            'social_network_id' => $social_network->id,
                            'social_network' => $social_network->name,
                            'link' => $speakerWraper->link
                        ];
                    }),
                    'talks' => $speaker->talk_speaker->map(function($speakerWraper) use ($lang) {
                        $talk = $speakerWraper->talk;
                        return [
                            'id' => $talk->id,
                            'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                            'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A')
                        ];
                    })
                ];
            });

            $news = News::orderBy('date', 'desc')->limit(3)->get();

            $groupedNews = $news->map(function($new) use ($lang) {
                $date = Carbon::parse($new->date);
                $day = $date->format('d');
                $month = $this->monthNames[$lang][$date->format('m')];
                $year = $date->format('Y');

                $formattedDate = "{$day} {$month} {$year}";

                return [
                    'id' => $new->id,
                    'title' => ($lang === 'es') ? $new->title_es : $new->title_en,
                    'content' => ($lang === 'es') ? $new->content_es : $new->content_en,
                    'category' => ($lang === 'es') ? $new->category->name_es : $new->category->name_en,
                    'date' => $formattedDate,
                    'image' => env('APP_URL').'/storage/'.$new->image
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'sliders' => $sliders,
                    'schedules' => $schedules,
                    'speakers' => $groupedSpeakers,
                    'news' => $groupedNews
                ]
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

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
            $sponsors = Sponsor::with(['category'])->orderByRaw('order_id IS NULL, order_id ASC')->get();

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
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
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
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
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
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
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
                    $date = Carbon::parse($new->date);
                    $day = $date->format('d');
                    $month = $this->monthNames[$lang][$date->format('m')];
                    $year = $date->format('Y');
    
                    $formattedDate = "{$day} {$month} {$year}";

                    return [
                        'id' => $new->id,
                        'title' => ($lang === 'es') ? $new->title_es : $new->title_en,
                        'content' => ($lang === 'es') ? $new->content_es : $new->content_en,
                        'category' => ($lang === 'es') ? $new->category->name_es : $new->category->name_en,
                        'date' => $formattedDate,
                        'image' => env('APP_URL').'/storage/'.$new->image
                    ];
                });
            });

            $allNewsGroup = [
                ($lang === 'es') ? 'Todas' : 'All' => $news->map(function ($new) use ($lang) {
                    $date = Carbon::parse($new->date);
                    $day = $date->format('d');
                    $month = $this->monthNames[$lang][$date->format('m')];
                    $year = $date->format('Y');
            
                    $formattedDate = "{$day} {$month} {$year}";
            
                    return [
                        'id' => $new->id,
                        'title' => ($lang === 'es') ? $new->title_es : $new->title_en,
                        'content' => ($lang === 'es') ? $new->content_es : $new->content_en,
                        'category' => ($lang === 'es') ? $new->category->name_es : $new->category->name_en,
                        'date' => $formattedDate,
                        'image' => env('APP_URL') . '/storage/' . $new->image,
                    ];
                }),
            ];
            
            $groupedNews = collect($allNewsGroup)->merge($groupedNews);

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
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
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

            $date = Carbon::parse($new->date);
            $day = $date->format('d');
            $month = $this->monthNames[$lang][$date->format('m')];
            $year = $date->format('Y');
    
            $formattedDate = "{$day} {$month} {$year}";

            $formattedNew = [
                'id' => $new->id,
                'title' => ($lang === 'es') ? $new->title_es : $new->title_en,
                'content' => ($lang === 'es') ? $new->content_es : $new->content_en,
                'category' => ($lang === 'es') ? $new->category->name_es : $new->category->name_en,
                'date' => $formattedDate,
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
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }
    
    /**
     * @OA\Get(
     *   path="/schedules",
     *   summary="Get all schedules",
     *   description= "Show all schedules",
     *   tags={"Schedules"},
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
    public function schedules(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;

            $schedules = Schedule::all()->map(function($schedule) use ($lang) {
                return [
                    'id' => $schedule->id,
                    'name' => ($lang === 'es') ? $schedule->name_es : $schedule->name_en,
                    'image' => env('APP_URL').'/storage/'.$schedule->image,
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $schedules
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/schedules/{id}",
     *   summary="Get all talks by schedule Id",
     *   description= "Show all talks by schedule Id (Optional `token` to bring favorites and notifications information)",
     *   tags={"Schedules"},
     *   security={}, 
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
     *      description="Schedule ID",
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
     *      description="Show list of all sponsors",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *   @OA\Response(
     *     @OA\MediaType(mediaType="application/json"),
     *     response=404,
     *     description="Schedule Not Found."
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
    public function schedule_details(LangRequest $request, $id): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $schedule = Schedule::find($id);

            if (!$schedule)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('api.schedule_not_found', [], $lang)
                ], 404);

            $talks = Talk::with(['category'])->where('schedule_id', $id)->orderBy('date')->orderBy('hour')->get();
            $dayCounter = 0;

            $groupedTalks = $talks->groupBy(function($talk) {
                return $talk->date;
            })->mapWithKeys(function($talksByDate) use ($lang) {

                $date = Carbon::parse($talksByDate->first()->date);
                $day = $date->format('d');
                $month = $this->monthNames[$lang][$date->format('m')];
                $year = $date->format('Y');
                                   
                $formattedDate = "{$day} {$month}";

                $groupedByCategory = $talksByDate->groupBy(function($talk) use ($lang) {
                    return ($lang === 'es') ? $talk->category->name_es : $talk->category->name_en;
                })->map(function($talksGroup) use ($lang) {
                    return $talksGroup->map(function($talk) use ($lang) {
                        return [
                            'id' => $talk->id,
                            'schedule_id' => $talk->schedule_id,
                            'is_sponsor' => $talk->is_sponsor,
                            'rating' => $talk->rating,
                            'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                            'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A'),
                            'is_favorite' => Auth::guard('api')->user() ? ($talk->favorite ? 1 : 0) : 0,
                            'is_notification' => Auth::guard('api')->user() ? ($talk->notification ? 1 : 0) : 0,
                        ];
                    });
                });

                return [$formattedDate => $groupedByCategory];
            });

            return response()->json([
                'success' => true,
                'data' => $groupedTalks
            ], 200);
            
        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/talk/{id}",
     *   summary="Get a talk",
     *   description= "Show talk details (Optional `token` to bring favorites and notifications information)",
     *   tags={"Schedules"},
     *   security={}, 
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
     *      description="Talk ID",
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
     *     description="Talk Not Found."
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
    public function talk_details(LangRequest $request, $id): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $talk = Talk::with(['speakers.speaker'])->find($id);

            if (!$talk)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('api.talk_not_found', [], $lang)
                ], 404);

            $formattedTalk = [
                'id' => $talk->id,
                'schedule_id' => $talk->schedule_id,
                'is_sponsor' => $talk->is_sponsor,
                'rating' => $talk->rating,
                'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A'),
                'image' => env('APP_URL') . '/storage/' . $talk->image,
                'is_favorite' => Auth::guard('api')->user() ? ($talk->favorite ? 1 : 0): 0,
                'is_notification' => Auth::guard('api')->user() ? ($talk->notification ? 1 : 0): 0,
                'speakers' => $talk->speakers->map(function($speakerWrapper) use ($lang) {
                    $speaker = $speakerWrapper->speaker; // Accedemos al modelo 'speaker'
                    return [
                        'id' => $speaker->id,
                        'fullname' => $speaker->name . ' ' . $speaker->last_name,
                        'position' => ($lang === 'es') ? $speaker->position->name_es : $speaker->position->name_en,
                        'avatar' => $speaker->avatar ? env('APP_URL') . '/storage/' . $speaker->avatar : null
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'data' => $formattedTalk
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/speakers",
     *   summary="Get all speakers",
     *   description= "Show list of speakers (Optional `token` to bring favorites and notifications information)",
     *   tags={"Speakers"},
     *   security={}, 
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
    public function speakers(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $speakers = Speaker::with(['position'])->get();

            $groupedSpeakers = $speakers->map(function($speaker) use ($lang) {
                return [
                    'id' => $speaker->id,
                    'fullname' => $speaker->name . ' ' . $speaker->last_name,
                    'position' => ($lang === 'es') ? $speaker->position->name_es : $speaker->position->name_en,
                    'avatar' => $speaker->avatar ? env('APP_URL').'/storage/'.$speaker->avatar : null,
                    'description' => ($lang === 'es') ? $speaker->description_es : $speaker->description_en,
                    'social_links' => $speaker->social_links->map(function($speakerWraper) use ($lang) {
                        $social_network = $speakerWraper->social_network;
                        return [
                            'social_network_id' => $social_network->id,
                            'social_network' => $social_network->name,
                            'link' => $speakerWraper->link
                        ];
                    }),
                    'talks' => $speaker->talk_speaker->map(function($speakerWraper) use ($lang) {
                        $talk = $speakerWraper->talk;
                        return [
                            'id' => $talk->id,
                            'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                            'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A'),
                            'is_favorite' => Auth::guard('api')->user() ? ($talk->favorite ? 1 : 0): 0,
                            'is_notification' => Auth::guard('api')->user() ? ($talk->notification ? 1 : 0): 0,
                        ];
                    })
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $groupedSpeakers
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/speakers/{id}",
     *   summary="Get a speaker",
     *   description= "Show speaker details (Optional `token` to bring favorites and notifications information)",
     *   tags={"Speakers"},
     *   security={}, 
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
     *      description="Speaker ID",
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
     *     description="Speaker Not Found."
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
    public function speaker_details(LangRequest $request, $id): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $speaker = Speaker::with(['position','social_links.social_network', 'talk_speaker.talk' ])->find($id);

            if (!$speaker)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('api.speaker_not_found', [], $lang)
                ], 404);

            $formattedSpeaker = [
                'id' => $speaker->id,
                'fullname' => $speaker->name . ' ' . $speaker->last_name,
                'position' => ($lang === 'es') ? $speaker->position->name_es : $speaker->position->name_en,
                'avatar' => $speaker->avatar ? env('APP_URL').'/storage/'.$speaker->avatar : null,
                'description' => ($lang === 'es') ? $speaker->description_es : $speaker->description_en,
                'social_links' => $speaker->social_links->map(function($speakerWraper) use ($lang) {
                    $social_network = $speakerWraper->social_network;
                    return [
                        'social_network_id' => $social_network->id,
                        'social_network' => $social_network->name,
                        'link' => $speakerWraper->link
                    ];
                }),
                'talks' => $speaker->talk_speaker->map(function($speakerWraper) use ($lang) {
                    $talk = $speakerWraper->talk;
                    return [
                        'id' => $talk->id,
                        'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                        'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A'),
                        'is_favorite' => Auth::guard('api')->user() ? ($talk->favorite ? 1 : 0): 0,
                        'is_notification' => Auth::guard('api')->user() ? ($talk->notification ? 1 : 0): 0
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'data' => $formattedSpeaker
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/questions/talk/{id}",
     *   summary="Get all questions by talkId",
     *   description= "Show all questions by talkId (Only the `panelist` role can see it)",
     *   tags={"Questions"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Talk ID",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *          description="Unique Talk Identifier"
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="Show list of all questions",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *  @OA\Response(
     *     @OA\MediaType(mediaType="application/json"),
     *     response=404,
     *     description="Talk Not Found."
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
    public function allQuestions(LangRequest $request, $id): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            
            if (Auth::user()->getRoleNames()[0] !== 'Panelista') {
                return response()->json([
                    'success' => false,
                    'message' => 'invalid_rol',
                    'errors' =>  __('api.invalid_rol', [], $lang)
                ], 400);

            }

            $talk = Talk::find($id);

            if (!$talk)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('api.talk_not_found', [], $lang)
                ], 404);

            $questions = Question::with(['user'])->where('talk_id', $id)->get();

            $groupedQuestions = $questions->map(function($question) {
                $user = $question->user;

                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'user_id' => $question->user_id,
                    'full_name' => $user->name . ' ' . $user->last_name,
                    'avatar' => $user->avatar ? env('APP_URL').'/storage/'.$user->avatar : null
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $groupedQuestions
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/questions",
     *   summary="Create a question",
     *   description= "Create a question by user to the talk",
     *   tags={"Questions"},
     *   security={{"bearerAuth": {} }},
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"user_id","talk_id","question","lang"},
     *               @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  format="int64",
     *                  description="The user id"
     *               ),
     *               @OA\Property(
     *                  property="talk_id",
     *                  type="integer",
     *                  format= "int64",
     *                  description="The talk id"
     *              ),
     *              @OA\Property(
     *                  property="question",
     *                  type="string",
     *                  format= "text",
     *                  description="The question"
     *              ),
     *              @OA\Property(
     *                  property="lang",
     *                  type="string",
     *                  format= "text",
     *                  description="App language (es/en)"
     *              )
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="successful operation",
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
    public function question(QuestionRequest $request): JsonResponse
    {
        try {

            $question = Question::updateOrCreate(
                [    
                    'user_id' => $request->user_id,
                    'talk_id' => $request->talk_id
                ],
                [   'question' => $request->question ]
            );

            return response()->json([
                'success' => true,
                'data' => $question
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/questions/{id}",
     *   summary="Get a question",
     *   description= "Show question details by user and talk",
     *   tags={"Questions"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Talk ID",
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
     *      description="Show question details",
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
    public function question_details(LangRequest $request, $id): JsonResponse
    {
        try {

            return response()->json([
                'success' => true,
                'data' => Question::where([['user_id', Auth::user()->id],['talk_id', $id]])->first()
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/reviews/talk/{id}",
     *   summary="Get all reviews by talkId",
     *   description= "Show all reviews by talkId (Only the `panelist` role can see it)",
     *   tags={"Reviews"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Talk ID",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *          format="int64",
     *          description="Unique Talk Identifier"
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="Show list of all reviews",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *  @OA\Response(
     *     @OA\MediaType(mediaType="application/json"),
     *     response=404,
     *     description="Talk Not Found."
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
    public function allReviews(LangRequest $request, $id): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            
            if (Auth::user()->getRoleNames()[0] !== 'Panelista') {
                return response()->json([
                    'success' => false,
                    'message' => 'invalid_rol',
                    'errors' =>  __('api.invalid_rol', [], $lang)
                ], 400);

            }

            $talk = Talk::find($id);

            if (!$talk)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('api.talk_not_found', [], $lang)
                ], 404);

            $reviews = Review::with(['user'])->where('talk_id', $id)->get();

            $groupedReviews = $reviews->map(function($review) {
                $user = $review->user;

                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'user_id' => $review->user_id,
                    'full_name' => $user->name . ' ' . $user->last_name,
                    'avatar' => $user->avatar ? env('APP_URL').'/storage/'.$user->avatar : null
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $groupedReviews
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/reviews",
     *   summary="Create a review",
     *   description= "Create a review by user to the talk",
     *   tags={"Reviews"},
     *   security={{"bearerAuth": {} }},
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"user_id","talk_id","comment","rating","lang"},
     *               @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  format="int64",
     *                  description="The user id"
     *               ),
     *               @OA\Property(
     *                  property="talk_id",
     *                  type="integer",
     *                  format= "int64",
     *                  description="The talk id"
     *              ),
     *              @OA\Property(
     *                  property="comment",
     *                  type="string",
     *                  format= "text",
     *                  description="The comment"
     *              ),
     *              @OA\Property(
     *                  property="rating",
     *                  type="string",
     *                  format= "text",
     *                  description="The rating"
     *              ),
     *              @OA\Property(
     *                  property="lang",
     *                  type="string",
     *                  format= "text",
     *                  description="App language (es/en)"
     *              )
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="successful operation",
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
    public function review(ReviewRequest $request): JsonResponse
    {
        try {

            $review = Review::updateOrCreate(
                [    
                    'user_id' => $request->user_id,
                    'talk_id' => $request->talk_id
                ],
                [   
                    'comment' => $request->comment,
                    'rating' => $request->rating
                ]
            );

            $reviews = Review::where('talk_id', $request->talk_id)->get();
            $sum = 0;

            foreach($reviews as $review) {
                $sum = $sum + $review->rating;
            }

            $talk = Talk::find($request->talk_id);
            $talk->rating = $sum/(count($reviews));//average
            $talk->update();

            return response()->json([
                'success' => true,
                'data' => [
                    'review' => $review,
                    'rating' => $talk->rating
                ]
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/reviews/{id}",
     *   summary="Get a review",
     *   description= "Show review details by user and talk",
     *   tags={"Reviews"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Talk ID",
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
     *      description="Show reviews details",
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
    public function review_details(LangRequest $request, $id): JsonResponse
    {
        try {

            return response()->json([
                'success' => true,
                'data' => Review::where([['user_id', Auth::user()->id],['talk_id', $id]])->first()
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/favorites",
     *   summary="Get all favorites by userId",
     *   description= "Show all favorites by userId",
     *   tags={"Favorites"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Show list of all favprites",
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
    public function allFavorites(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $favorites = Favorite::with(['talk'])->where('user_id', Auth::user()->id)->get();

            $groupedFavorites = $favorites->map(function($favorite) use ($lang) {
                $talk = $favorite->talk;

                return [
                    'id' => $talk->id,
                    'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                    'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A'),
                    'image' => env('APP_URL') . '/storage/' . $talk->image,
                    'speakers' => $talk->speakers->map(function($speakerWrapper) use ($lang) {
                        $speaker = $speakerWrapper->speaker; // Accedemos al modelo 'speaker'
                        return [
                            'id' => $speaker->id,
                            'fullname' => $speaker->name . ' ' . $speaker->last_name,
                            'position' => ($lang === 'es') ? $speaker->position->name_es : $speaker->position->name_en,
                            'avatar' => $speaker->avatar ? env('APP_URL') . '/storage/' . $speaker->avatar : null
                        ];
                    })
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $groupedFavorites
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/favorites",
     *   summary="Create a favorite",
     *   description= "Add a favorite by user to the talk",
     *   tags={"Favorites"},
     *   security={{"bearerAuth": {} }},
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"talk_id","lang"},
     *               @OA\Property(
     *                  property="talk_id",
     *                  type="integer",
     *                  format= "int64",
     *                  description="The talk id"
     *              ),
     *              @OA\Property(
     *                  property="lang",
     *                  type="string",
     *                  format= "text",
     *                  description="App language (es/en)"
     *              )
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="successful operation",
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
    public function favorite(FavoriteRequest $request): JsonResponse
    {
        try {

            $lang = $request->lang; 

            $exists = 
                Favorite::where([
                    ['user_id', Auth::user()->id],
                    ['talk_id', $request->talk_id]
                ])->exists();
            
            if ($exists)
                Favorite::where([
                    ['user_id', Auth::user()->id],
                    ['talk_id', $request->talk_id]
                ])->delete();
            else
                Favorite::insert([    
                    'user_id' => Auth::user()->id,
                    'talk_id' => $request->talk_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            $talk = Talk::with(['favorite', 'notification'])->find($request->talk_id);
    
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $talk->id,
                    'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                    'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A'),
                    'is_favorite' => $talk->favorite ? 1 : 0,
                    'is_notification' => $talk->notification ? 1 : 0
                ]
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/translations",
     *   summary="Get translations links",
     *   description= "Show translations links",
     *   tags={"Translations"},
     *   security={{"bearerAuth": {} }},
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="Show translations links",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=500,
     *      description="an ""unexpected"" error"
     *   ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function translations(): JsonResponse
    {
        try {
            
            $translation = Translation::first();

            return response()->json([
                'success' => true,
                'data' => [
                    'link_es' => $translation->link_es,
                    'link_en' => $translation->link_en,
                    'image' => env('APP_URL').'/storage/' . $translation->image
                ]
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/maps",
     *   summary="Get sitemap",
     *   description= "Show sitemap",
     *   tags={"Maps"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Show sitemap",
     *    ),
     *  @OA\Response(
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
    public function maps(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $map = Map::select(['image','image_2','image_3'])->first();

            if ($lang === 'es') {
                $labels = [
                    'floor_1' => 'Piso 1',
                    'floor_2' => 'Piso 2',
                    'floor_3' => 'Piso 3'
                ];
            } else {
                $labels = [
                    'floor_1' => 'Floor 1',
                    'floor_2' => 'Floor 2',
                    'floor_3' => 'Floor 3'
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    $labels['floor_1'] => env('APP_URL').'/storage/'.$map->image,
                    $labels['floor_2'] => env('APP_URL').'/storage/'.$map->image_2,
                    $labels['floor_3'] => env('APP_URL').'/storage/'.$map->image_3
                ]
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/notifications",
     *   summary="Get all notifications by user",
     *   description= "Show notifications",
     *   tags={"Notifications"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Show sitemap",
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
    public function notifications(LangRequest $request): JsonResponse
    {
        try {
            
            $lang = $request->lang;
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
        
            if ($lang === 'es') {
                $labels = [
                    'today' => 'hoy',
                    'yesterday' => 'ayer',
                    'ancients' => 'antiguas',
                ];
            } else {
                $labels = [
                    'today' => 'today',
                    'yesterday' => 'yesterday',
                    'ancients' => 'ancients',
                ];
            }

            // Consultar notificaciones por fecha
            $todayNotifications = Notification::with(['notification_user'])->where('user_id', Auth::user()->id)->whereDate('date', $today)->get();
            $yesterdayNotifications = Notification::with(['notification_user'])->where('user_id', Auth::user()->id)->whereDate('date', $yesterday)->get();
            $ancientNotifications = Notification::with(['notification_user'])->where('user_id', Auth::user()->id)->whereDate('date', '<', $yesterday)->get();

            // Mapeo de notificaciones
            $notifications = [
                $labels['today'] => $this->mapNotifications($todayNotifications, $lang),
                $labels['yesterday'] => $this->mapNotifications($yesterdayNotifications, $lang),
                $labels['ancients'] => $this->mapNotifications($ancientNotifications, $lang),
            ];
            
            return response()->json([
                'success' => true,
                'data' => $notifications
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/notifications",
     *   summary="Create a notification",
     *   description= "Guardar talk para enviar notificación",
     *   tags={"Notifications"},
     *   security={{"bearerAuth": {} }},
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"talk_id","lang"},
     *               @OA\Property(
     *                  property="talk_id",
     *                  type="integer",
     *                  format= "int64",
     *                  description="The talk id"
     *              ),
     *              @OA\Property(
     *                  property="lang",
     *                  type="string",
     *                  format= "text",
     *                  description="App language (es/en)"
     *              )
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="successful operation",
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
    public function notification(FavoriteRequest $request): JsonResponse
    {
        try {

            $lang = $request->lang;

            $exists = 
                NotificationUser::where([
                    ['user_id', Auth::user()->id],
                    ['talk_id', $request->talk_id]
                ])->exists();
            
            if ($exists)
                NotificationUser::where([
                    ['user_id', Auth::user()->id],
                    ['talk_id', $request->talk_id]
                ])->delete();
            else
                NotificationUser::insert([    
                    'user_id' => Auth::user()->id,
                    'talk_id' => $request->talk_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            $talk = Talk::with(['favorite', 'notification'])->find($request->talk_id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $talk->id,
                    'title' => ($lang === 'es') ? $talk->title_es : $talk->title_en,
                   'hour' => Carbon::createFromFormat('H:i:s', $talk->hour)->format('h:i A'),
                    'is_favorite' => $talk->favorite ? 1 : 0,
                    'is_notification' => $talk->notification ? 1 : 0
                ]
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/lang",
     *   summary="Change lang",
     *   description= "Change the language of the logged in user",
     *   tags={"Lang"},
     *   security={{"bearerAuth": {} }},
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
     *      description="Show sitemap",
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
    public function lang(LangRequest $request): JsonResponse
    {
        try {
            if (Auth::guard('api')->user()){
                $user = Auth::guard('api')->user();
                $user->lang = $request->lang;
                $user->save();
            }

            return response()->json([
                'success' => true
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/tokens",
     *   summary="Add token",
     *   description= "Create or update token apps",
     *   tags={"Tokens"},
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"fcm_token"},
     *              @OA\Property(
     *                  property="fcm_token",
     *                  type="string",
     *                  format= "text",
     *                  description="Token ExpoHost"
     *              )
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="Show sitemap",
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
    public function tokens(TokenRequest $request): JsonResponse
    {
        try {

            Token::updateOrCreate(
                [ 'token' => $request->fcm_token ],
                [ 'token' => $request->fcm_token ]
            );

            return response()->json([
                'success' => true
            ], 200);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    // Helper para mapear las notificaciones
    function mapNotifications($notifications, $lang) {
        return $notifications->map(function($notification) use ($lang) {
            return [
                'id' => $notification->id,
                'notification_type_id' => $notification->notification_type_id,
                'talk_id' => $notification->notification_user ? $notification->notification_user->talk_id : null,
                'title' => ($lang === 'es') ? $notification->title_es : $notification->title_en,
                'description' => ($lang === 'es') ? $notification->description_es : $notification->description_en,
                'date' => Carbon::parse($notification->date)->format('H:i'),
            ];
        });
    }
}
