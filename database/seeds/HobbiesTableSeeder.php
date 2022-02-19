<?php

use Illuminate\Database\Seeder;

class HobbiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        //Delete All Current Records
        \DB::table('hobbies')->delete();
        
        //Save Hobbies Records
        \DB::table('hobbies')->insert(array( 
            array (
                'id' => 1,
                'title' => 'Listning Music',
                'created_at' => now()
            ), 
            array (
                'id' => 2,
                'title' => 'Playing Cricket',
                'created_at' => now()
            ), 
            array (
                'id' => 3,
                'title' => 'Drawing',
                'created_at' => now()
            ), 
            array (
                'id' => 4,
                'title' => 'Painting',
                'created_at' => now()
            ), 
            array (
                'id' => 5,
                'title' => 'Traveling',
                'created_at' => now()
            ), 
            array (
                'id' => 6,
                'title' => 'Reading Books',
                'created_at' => now()
            ), 
            array (
                'id' => 7,
                'title' => 'Writing',
                'created_at' => now()
            ),
        ));       
    }
}