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
        $adminEmail = 'ahmdb625@gmail.com';

        
        $user = User::where('email', $adminEmail)->first();

        
        if ($user) {
            $user->role = 'admin';
            $user->save();
        }
    }
}
