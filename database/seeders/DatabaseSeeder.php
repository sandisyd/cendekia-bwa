<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Budi Utomo',
            'username' => 'buditomo',
            'email' => 'budi@cendekia.test'
        ]);

        $this->call([
            CategorySeeder::class,
            PublisherSeeder::class,
        ]);
    }
}
