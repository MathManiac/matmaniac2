<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $henrik = \App\User::create([
            'name'     => 'Henrik',
            'email'    => 'hh@nyborg-gym.dk',
            'password' => bcrypt('1234')
        ]);

        $niels = \App\User::create([
            'name'     => 'Niels',
            'email'    => 'nfa@sdu.dk',
            'password' => bcrypt('1234')
        ]);
    }
}
