<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // تأكد أن لديك موديل User
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'i.m.s.1995@hotmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Mustafa@2023@'),
                'role' => 'admin',
                'phone' => '12345678',
                'profile_photo' => null,
                'bio' => 'مدير النظام',
                'is_verified' => true,
                'is_trusted' => true,
                'status' => true,
            ]
        );

        
    }


}
