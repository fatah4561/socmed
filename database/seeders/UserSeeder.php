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
        ]);
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'john132',
            'email' => 'john@gmail.com',
            'bio' => 'My name is john doe a photographer',
            'password' => Hash::make('john123'),
        ]);
    }
}
