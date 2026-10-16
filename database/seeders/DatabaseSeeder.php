<?php

namespace Database\Seeders;

use App\Contexts\Identity\Infrastructure\Persistence\Eloquent\UserEloquentModel;
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
        // UserEloquentModel::factory(10)->create();

        UserEloquentModel::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
