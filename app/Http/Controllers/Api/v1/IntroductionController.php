<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntroductionController extends Controller
{
    public function categories()
    {
        $data = [
            [
                'id' => '1',
                'name' => '品牌介绍'
            ],
            [
                'id' => '2',
                'name' => '企业文化'
            ],
            [
                'id' => '3',
                'name' => '发展历程'
            ],
            [
                'id' => '4',
                'name' => '硬件实力'
            ],
            [
                'id' => '5',
                'name' => '员工风采'
            ],
            [
                'id' => '6',
                'name' => '实际案例'
            ],
        ];

        return response()->json($data);
    }

    public function detail()
    {
        $data = [
            'id' => 1,
            'name' => '',
            'content' => 'rich text editor content'
        ];

        return response()->json($data);
    }
}
