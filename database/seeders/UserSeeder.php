<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Fatah At Thariq',
            'username' => 'fatah4561',
            'email' => 'fatah@gmail.com',
            'bio' => "My name is fatah a web developer",
            'password' => Hash::make('fatah123'),
            'profile_pic' => "uploads/user/pictures/profile-2.png",
        ]);
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'john132',
            'email' => 'john@gmail.com',
            'bio' => 'My name is john doe a photographer',
            'password' => Hash::make('john123'),
            'profile_pic' => "uploads/user/pictures/profile-1.png",
        ]);
        $user = User::create([
            'name' => 'Siri',
            'username' => 'siri132',
            'email' => 'siri@gmail.com',
            'bio' => 'My name is siri an AI',
            'password' => Hash::make('siri123'),
            'profile_pic' => "uploads/user/pictures/profile-3.png",
        ]);
        $user = User::create([
            'name' => 'April',
            'username' => 'april132',
            'email' => 'april@gmail.com',
            'bio' => 'Aku adalah april sebuah bulan',
            'password' => Hash::make('april123'),
            'profile_pic' => "uploads/user/pictures/profile-4.png",
        ]);
        $user = User::create([
            'name' => 'Ucok',
            'username' => 'ucok132',
            'email' => 'ucok@gmail.com',
            'bio' => 'Urang teh ucok gan',
            'password' => Hash::make('ucok123'),
            'profile_pic' => "uploads/user/pictures/profile-6.png",
        ]);
    }
}
