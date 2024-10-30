<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user= User::create([
            'profil_user'=>'UsersProfiles/WhatsApp Image 2024-07-20 à 10.51.52_ddc6fb0b.jpg',
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'num_user'=>'59278869',
            'email_verified_at' => now(), 
            'password' => Hash::make('admin'),
        ]);

        $user->assignRole('admin');
    }
}
