<?php

namespace Database\Factories;

use App\Models\ProfileMahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfileMahasiswa>
 */
class ProfileMahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ProfileMahasiswa::class;

    public function definition(): array
    {
        return [
            'nim' => fake() -> unique() -> numerify('K35########'),
            'kontak' => fake()->phoneNumber()
        ];
    }
}
