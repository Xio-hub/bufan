<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '商家管理',
                'guard_name' => 'admin',
                'created_at' => '2020-01-27 12:38:36',
                'updated_at' => '2020-01-27 12:38:36',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '课程管理',
                'guard_name' => 'admin',
                'created_at' => '2020-01-27 12:38:45',
                'updated_at' => '2020-01-27 12:38:45',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '订单管理',
                'guard_name' => 'admin',
                'created_at' => '2020-01-27 12:38:54',
                'updated_at' => '2020-01-27 12:38:54',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '新品管理',
                'guard_name' => 'merchant',
                'created_at' => '2020-01-27 12:39:11',
                'updated_at' => '2020-01-27 12:39:11',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '风格管理',
                'guard_name' => 'merchant',
                'created_at' => '2020-01-27 12:39:18',
                'updated_at' => '2020-01-27 12:39:18',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '空间管理',
                'guard_name' => 'merchant',
                'created_at' => '2020-01-27 12:39:24',
                'updated_at' => '2020-01-27 12:39:24',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '全景管理',
                'guard_name' => 'merchant',
                'created_at' => '2020-01-27 12:39:38',
                'updated_at' => '2020-01-27 12:39:38',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => '风采管理',
                'guard_name' => 'merchant',
                'created_at' => '2020-01-27 12:39:50',
                'updated_at' => '2020-01-27 12:39:50',
            ),
        ));
        
        
    }
}