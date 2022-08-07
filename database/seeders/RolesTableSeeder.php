<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Administrator',
                'code' => 'admin'
            ],
            [
                'id' => 2,
                'name' => 'Operator',
                'code' => 'operator'
            ]
        ];

        foreach ($roles as $role){
            Role::updateOrCreate(['code' => $role['code']], $role);
        }

    }
}
