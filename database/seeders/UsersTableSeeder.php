<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'super_admin@gmail.com',
            'password' => bcrypt(value:'123456'),
        ]);

        $user->addRole('super_admin');

    }//end of run

}//end of seeder
