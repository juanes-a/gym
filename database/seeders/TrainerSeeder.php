<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trainers')->insert([
            [
                'name' => 'John Doe',
                'occupation' => 'Personal Trainer',
                'experience' => 5,
                'email' => 'johndoe@trainer.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'), // Se encripta la contraseña
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Alice Smith',
                'occupation' => 'Yoga Instructor',
                'experience' => 8,
                'email' => 'alicesmith@trainer.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
