<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'ahmdb625@gmail.com')->first();

        if ($user) {
            $user->role = 'admin';
            $user->save();
        }
    }
}
