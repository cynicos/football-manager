<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin',
                'role_id' => 1,
                'email' => '9davita9@gmail.com',
                'password' => bcrypt('grandmaster')
            ],
            [
                'name' => 'Operator',
                'role_id' => 2,
                'email' => 'cynicos4@gmail.com',
                'password' => bcrypt('secret')
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }

    }
}
