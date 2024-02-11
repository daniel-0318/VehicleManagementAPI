<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plate' => $this->faker->regexify('[A-Z]{3}-[0-9]{3}'),
            'model_year' => $this->faker->year,
            'configuration' => $this->faker->randomElement(['CA', '2', '3', '4', '2S2', '2S3', '2S3', '3S3']),
            'body_type' => $this->faker->randomElement(['Furgón', 'Volco', 'Tanque', 'Estacas', 'Porta Contenedor']),
            'image_path' => $this->faker->imageUrl(640, 480, 'transport'),
            'user_id' => User::factory(),
        ];
    }
}
