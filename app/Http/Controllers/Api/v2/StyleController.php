<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StyleController extends Controller
{
    public function categories()
    {
        $data = [
            [
                'id' => '1',
                'name' => '意式风格',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '2',
                'name' => '中式风格',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '3',
                'name' => '欧式风格',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '4',
                'name' => '日式风格',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '5',
                'name' => '美式风格',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '6',
                'name' => '韩式风格',
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
                'name' => '意式风格01',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '2',
                'name' => '意式风格02',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '3',
                'name' => '意式风格03',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '4',
                'name' => '意式风格04',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '5',
                'name' => '意式风格05',
                'cover' => 'http://www.image1.com'
            ],
            [
                'id' => '6',
                'name' => '意式风格06',
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
}
