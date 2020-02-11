<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '') ?? '';

        if($keyword == ''){
            return [];
        }

        $data = [
            'product' => [
                'title' => '新品鉴赏',
                'data' =>[
                    [
                        'id' => 1,
                        'name' => '新品1',  
                        'cover' => 'http://imageurl.com'
                    ],
                    [
                        'id' => 2,
                        'name' => '新品2',  
                        'cover' => 'http://imageurl.com'
                    ],
                ]
            ],
            'space' => [
                'title' => '功能空间',
                'data' =>[
                    [
                        'id' => 1,
                        'name' => '空间1',  
                        'cover' => 'http://imageurl.com'
                    ],
                    [
                        'id' => 2,
                        'name' => '空间2',  
                        'cover' => 'http://imageurl.com'
                    ],
                ]
            ],
            'style' => [
                'title' => '风格鉴赏',
                'data' =>[
                    [
                        'id' => 1,
                        'name' => '风格1',  
                        'cover' => 'http://imageurl.com'
                    ],
                    [
                        'id' => 2,
                        'name' => '风格2',  
                        'cover' => 'http://imageurl.com'
                    ],
                ]
            ]
        ];

        return response()->json($data);
    }
}
