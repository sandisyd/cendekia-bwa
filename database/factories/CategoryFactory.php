<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $name = $this->faker->unique()->randomElement([
                'Fiksi',
                'Non-Fiksi',
                'Biografi',
                'Sejarah',
                'Teknologi',
                'Sains',
                'Fantasi',
                'Ilmu Pengetahuan',
                'Anak-Anak',
                'Pengembangan Diri',
                'Misteri'
            ]),
            'slug' => str()->lower(str()->slug($name) . str()->random(4)),
        ];
    }
}
