<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Demouser',
             'email' => 'test@example.com',
             'api_token'=>'227D1F7CQ0o7LutSfia4xYlC3btJ8Qy1nmmb5PkKLNeytvg6OL2zwuVQ6IIn',
         ]);
    }
}
