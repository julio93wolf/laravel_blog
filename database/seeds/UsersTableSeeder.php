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
        factory(Blog\User::class,29)->create();
        
        Blog\User::create([
        	'name' => 'Julio Valle',
        	'email' => 'juliovr_93@hotmail.com',
        	'password' => bcrypt('taskforce141')
        ]);
        
    }
}
