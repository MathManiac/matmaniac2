<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clearTables();
        $this->call(UsersTableSeeder::class);
        $this->call(ExercisesSeeder::class);
        $this->call(FormelsamlingSeeder::class);
    }

    public function clearTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tables = [
            'users',
            'sub_exercise_types',
            'exercise_types',
            'subject_columns',
            'subjects',
            'categories'
        ];
        foreach($tables as $table)
            DB::table($table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
