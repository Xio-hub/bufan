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
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'email' => '653816325@qq.com',
                'password' => '$2y$10$1cyIl9E4Y0N5XWZJreUQcOPoXAa0zzlHyl8mjL5fB9n1n6/3Jv50C',
                'remember_token' => '71zUzk08veWSLNzm0Qt04eTEQY0NGaqP831JjzEBPK436mMJAssxxYgkQkPU',
                'created_at' => '2020-01-18 15:27:27',
                'updated_at' => '2020-01-31 03:30:02',
            ),
        ));
        
        
    }
}