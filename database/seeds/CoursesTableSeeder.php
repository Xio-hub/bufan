<?php

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('courses')->delete();
        
        \DB::table('courses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '默认课程',
                'background' => '',
                'info' => '<p>课程简介<br></p>',
                'teacher_info' => '<p>讲师介绍<br></p>',
                'price' => '0.18',
                'created_at' => '2020-02-12 21:01:00',
                'updated_at' => '2020-02-21 14:13:58',
            ),
        ));
        
        
    }
}