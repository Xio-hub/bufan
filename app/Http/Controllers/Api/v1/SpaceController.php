<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpaceController extends Controller
{
    public function getCategories()
    {
        $data = [
            [
                'id' => '1',
                'name' => '厨房',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '2',
                'name' => '客厅',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '3',
                'name' => '书房',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '4',
                'name' => '浴室',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '5',
                'name' => '阳台',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '6',
                'name' => '儿童房',
                'cover' => 'http://www.image1.com'
            ],
        ];

        $meta = [
            'total' => '6',
            'next' => null,
            'previous' => null
        ];

        $result = compact('data','meta');

        return response()->json($result);
    }

    public function list()
    {
        $data = [
            [
                'id' => '1',
                'name' => '厨房01',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '2',
                'name' => '厨房02',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '3',
                'name' => '厨房03',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '4',
                'name' => '厨房04',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '5',
                'name' => '厨房05',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '6',
                'name' => '厨房06',
                'cover' => 'http://www.image1.com'
            ],
        ];

        $meta = [
            'total' => '6',
            'next' => null,
            'previous' => null
        ];

        $result = compact('data','meta');

        return response()->json($result);
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

    public function search()
    {
        $data = [
            [
                'id' => '1',
                'name' => '厨房',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '2',
                'name' => '客厅',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '3',
                'name' => '书房',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '4',
                'name' => '浴室',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '5',
                'name' => '阳台',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '6',
                'name' => '儿童房',
                'cover' => 'http://www.image1.com'
            ],
        ];

        $meta = [
            'total' => '6',
            'next' => null,
            'previous' => null
        ];

        $result = compact('data','meta');

        return response()->json($result);
    }
}
