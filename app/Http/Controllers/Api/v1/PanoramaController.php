<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanoramaController extends Controller
{
    public function getMaterials()
    {
        $data = [
            [
                'id' => '1',
                'name' => '木纹01',
                'cover' => 'http://imageurl.com',
            ],
            [
                'id' => '2',
                'name' => '木纹02',
                'cover' => 'http://imageurl.com',
            ],
            [
                'id' => '3',
                'name' => '木纹03',
                'cover' => 'http://imageurl.com',
            ],
        ];

        $meta = [
            'total' => '3',
            'next' => null,
            'previous' => null
        ];

        $result = compact('data','meta');

        return response()->json($result);
    }

    public function getStyles()
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
            'url' => 'http://imageurl.com',
        ];

        return response()->json($data);
    }

    public function getVerticalView()
    {
        $data = [
            'id' => '1',
            'url' => 'http://imageurl.com',
        ];

        return response()->json($data);
    }

    public function getTargetView()
    {
        $data = [
            'id' => '1',
            'url' => 'http://imageurl.com',
        ];

        return response()->json($data);
    }
}
