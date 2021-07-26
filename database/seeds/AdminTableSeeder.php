<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@mailinator.com',
            'password' => '$2y$10$oCoRTm/bWOHKMZLN0hrgJOji51dIyG8C3/844SUxSVBxDs1pMXJKy',
            'is_super' =>1
        ]);
    }
}
