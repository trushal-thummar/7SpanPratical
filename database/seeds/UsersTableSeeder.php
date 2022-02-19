<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        //Delete All Current Records
        \DB::table('users')->delete();
        
        //Save Role Users Records
        \DB::table('users')->insert(array (
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => \Hash::make(12345678),
                'created_at' => now(),
            )
        ));
    }
}