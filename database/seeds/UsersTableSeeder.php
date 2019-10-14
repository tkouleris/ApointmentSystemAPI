<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'UsrFirstname' => 'admin',
            'UsrLastname' => 'admin',
            'UsrEmail' => 'admin@as.com',
            'UsrRoleID' => 1,
            'UsrPassword' => bcrypt('secret')
        ]);
    }
}