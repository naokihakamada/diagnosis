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
            'name' => '管理人',
            'email' => '_admin_@ecm-training.com',
            'password' => bcrypt('ecm-training-oomura'),
            ]);
    }
}
