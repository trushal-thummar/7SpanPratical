<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Add Default Roles
        $this->call(RolesTableSeeder::class);

        //Add Default Users
        $this->call(UsersTableSeeder::class);

        //Add Default Roles To Users
        $this->call(RoleUsersTableSeeder::class);

        //Add Default Hobbies
        $this->call(HobbiesTableSeeder::class);
    }
}
