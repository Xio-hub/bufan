<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function list()
    {
        $data = [
            [
                'id' => 1,
                'name' => '新品1',
                'cover' => 'http://www.imageurl.com'
            ],
            [
                'id' => 2,
                'name' => '新品2',
                'cover' => 'http://www.imageurl.com'
            ],
            [
                'id' => 3,
                'name' => '新品3',
                'cover' => 'http://www.imageurl.com'
            ],
            [
                'id' => 4,
                'name' => '新品4',
                'cover' => 'http://www.imageurl.com'
            ],
            [
                'id' => 5,
                'name' => '新品5',
                'cover' => 'http://www.imageurl.com'
            ],
            [
                'id' => 6,
                'name' => '新品6',
                'cover' => 'http://www.imageurl.com'
            ],
        ];
        
        return response()->json($data);
    }

    public function detail()
    {
        $data = [
            'id' => '1',
            'name' => '',
            'content' => array(
                [
                    'type' => 'image',
                    'source_url' => 'http://www.image1.com'
                ],
                [
                    'type' => 'image',
                    'source_url' => 'http://www.image2.com'
                ],
                [
                    'type' => 'image',
                    'source_url' => 'http://www.image3.com'
                ],
                [
                    'type' => 'image',
                    'source_url' => 'http://www.image4.com'
                ],
            ),
        ];

        return response()->json($data);
    }
}
