<?php

use Illuminate\Database\Seeder;

class FormelsamlingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 5)->create()->each(function($category){
            $category->subjects()->save(factory(App\Subject::class)->make());
            $category->subjects()->save(factory(App\Subject::class)->make());
        });

        foreach(\App\Subject::all() as $subject)
        {
            for ($i=0; $i < 3; $i++)
            {
                $subject->columns()->save(factory(App\SubjectColumn::class)->make([
                    'order' => $i
                ]));
            }
        }
    }
}
