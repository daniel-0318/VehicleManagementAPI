<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'lastname' => fake()->lastname,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'identificationType' => fake()->randomElement(['CC', 'CE', 'RC']),
            'identificationNumber' => fake()->unique()->numerify('##########'),
            'gender' => fake()->randomElement(['male', 'female', null]),
            'geoAddress' => fake()->randomElement(["3.896139, -76.288718","3.899950, -76.301979"]),
            'phone' => fake()->phoneNumber,
            'photoIdFront' => fake()->imageUrl(640, 480, 'people'),
            'photoIdBack' => fake()->imageUrl(640, 480, 'people'),
            'photoProfile' => fake()->imageUrl(640, 480, 'people'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
