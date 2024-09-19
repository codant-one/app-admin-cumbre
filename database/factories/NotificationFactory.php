<?php

namespace Database\Factories;

use Str;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Generar una fecha aleatoria: hoy, ayer o antes de ayer
        $randomDate = $this->faker->randomElement([
            now(),
            now()->subDay(1),
            now()->subDay(2)
        ]);

        $notification_type_id = rand(1, 2);

        return [
            'user_id' => 3,
            'notification_type_id' => $notification_type_id,
            'notification_user_id' => $notification_type_id === 1 ? 1 : null,
            'is_read' => rand(0, 1),
            'title_es' => $this->faker->text,
            'title_en' => $this->faker->text,
            'description_es' => $this->faker->text,
            'description_en' => $this->faker->text,
            'date' => $randomDate,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}
