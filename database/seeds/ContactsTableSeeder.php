<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContactsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'ContactID' => 1,
            'ContactFirstname' => 'Thodoris',
            'ContactLastname' => 'Zagorakis',
            'ContactAddress' => 'Miaouli 8',
            'ContactPostCode' => '192 35',
            'ContactCity' => 'Athens',
        ]);

        DB::table('contacts')->insert([
            'ContactID' => 2,
            'ContactFirstname' => 'Antonia',
            'ContactLastname' => 'Laratzaki',
            'ContactAddress' => 'Ekavis 4',
            'ContactPostCode' => '189 77',
            'ContactCity' => 'Athens',
        ]);
    }
}