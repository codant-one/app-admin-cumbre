<?php

namespace Database\Factories;

use Str;
use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class SponsorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sponsor::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $folder = 'model'.rand(1,3);

        return [
            'category_id' => rand(1, 4),
            'logo' => 'sponsors/' . $this->faker->file(public_path('images/sponsors/'.$folder), storage_path('app/public/sponsors'), false),
            'link' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}
