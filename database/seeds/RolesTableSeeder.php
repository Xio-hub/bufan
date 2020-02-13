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
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => '2020-01-27 12:36:52',
                'updated_at' => '2020-01-27 12:36:52',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2020-01-27 12:36:58',
                'updated_at' => '2020-01-27 12:36:58',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'merchant',
                'guard_name' => 'web',
                'created_at' => '2020-01-27 12:37:14',
                'updated_at' => '2020-01-27 12:37:14',
            ),
        ));
        
        
    }
}