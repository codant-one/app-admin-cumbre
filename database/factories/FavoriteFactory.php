<?php

namespace Database\Factories;

use Str;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;
    protected static $talkIdCounter = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $talkId = self::$talkIdCounter;
        self::$talkIdCounter++;

        return [
            'user_id' => 3,
            'talk_id' => $talkId,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}
