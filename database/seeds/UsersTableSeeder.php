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
        //
        DB::table('users')->insert([
            'name' => 'eveames',
            'email' => 'eveames.chem@gmail.com',
            'password' => bcrypt('take_action!'),
            'auth_type' => 'admin'
        ]);

        DB::table('users')->insert([
            'name' => 'student',
            'email' => 'student@example.com',
            'password' => bcrypt('stuff'),
            'auth_type' => 'student'
        ]);

        DB::table('users')->insert([
            'name' => 'teacher',
            'email' => 'teacher@example.com',
            'password' => bcrypt('stuff'),
            'auth_type' => 'teacher'
        ]);
    }
}
