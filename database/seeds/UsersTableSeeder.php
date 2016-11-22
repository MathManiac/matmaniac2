<?php

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
        $henrik = \App\User::create([
            'name' => 'Henrik',
            'email' => 'hh@nyborg-gym.dk',
            'password' => bcrypt('1234')
        ]);
    }
}
