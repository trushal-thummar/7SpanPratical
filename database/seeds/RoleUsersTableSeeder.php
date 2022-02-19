<?php

use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        //Delete All Current Records
        \DB::table('role_users')->delete();
        
        //Save Role Users Records
        \DB::table('role_users')->insert(array(
            array (
                'id' => 1,
                'role_id' => 1,
                'user_id' => 1,
                'created_at' => now()
            )
        ));        
    }
}