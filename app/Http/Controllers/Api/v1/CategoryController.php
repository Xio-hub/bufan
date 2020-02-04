<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function list(Request $request)
    {
        $data = [
            [
                'id' => '1',
                'name' => '新品鉴赏'
            ],
            [
                'id' => '2',
                'name' => '风格感觉'
            ],
            [
                'id' => '3',
                'name' => '功能空间'
            ],
            [
                'id' => '4',
                'name' => '全景体验'
            ],
            [
                'id' => '5',
                'name' => '学无止境'
            ],
            [
                'id' => '6',
                'name' => '企业风采'
            ],
        ];
        return response()->json($data);
    }
}
