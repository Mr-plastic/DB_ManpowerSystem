<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visited') -> insert([
            [
                'id' => 1,
                '造訪次數' => 121,
            ],
            ]);
        DB::table('users') -> insert([
        [
            'id' => 1,
            'username' => 'admin',
            'password' => Hash::make('1234'),
            'Authority' => 'super user',
        ],
        [
            'id' => 2,
            'username' => 'ryan',
            'password' => Hash::make('1234'),
            'Authority' => 'general user',
        ]
        ]);
    }
}
