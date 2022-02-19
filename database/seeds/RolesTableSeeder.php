<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        //Delete All Current Records
        \DB::table('roles')->delete();
        
        //Save Roles Records
        \DB::table('roles')->insert(array(
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'created_at' => now()
            )
        ));
    }
}