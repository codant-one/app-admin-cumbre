<?php

namespace Database\Factories;

use Str;
use App\Models\NotificationUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class NotificationUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NotificationUser::class;
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
