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
                'status' => true,
            ]
        );

        // User 1
        User::updateOrCreate(
            ['email' => 'user1@example.com'],
            [
                'name' => 'محمد علي',
                'password' => Hash::make('User@1234'),
                'role' => 'user',
                'phone' => '98765432',
                'profile_photo' => null,
                'bio' => 'صاحب نشاط تجريبي 1',
                'is_verified' => true,
                'status' => true,
            ]
        );

        // User 2
        User::updateOrCreate(
            ['email' => 'user2@example.com'],
            [
                'name' => 'أحمد يوسف',
                'password' => Hash::make('User@1234'),
                'role' => 'user',
                'phone' => '99887766',
                'profile_photo' => null,
                'bio' => 'صاحب نشاط تجريبي 2',
                'is_verified' => true,
                'status' => true,
            ]
        );

        // User 3
        User::updateOrCreate(
            ['email' => 'user3@example.com'],
            [
                'name' => 'خالد محمود',
                'password' => Hash::make('User@1234'),
                'role' => 'user',
                'phone' => '66554433',
                'profile_photo' => null,
                'bio' => 'صاحب نشاط تجريبي 3',
                'is_verified' => true,
                'status' => true,
            ]
        );
    }


}
