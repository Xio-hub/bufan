<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Space;
use App\Models\Style;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request,Product $product, Space $space, Style $style)
    {
        $keyword = $request->input('keyword', '') ?? '';

        if($keyword == ''){
            return [];
        }

        $product_result = $product->select('id', 'name', 'cover')
                                ->where(['name', 'like' , "%{$keyword}%"])
                                ->get()
                                ->toArray();

        $space_result = $space->select('id', 'name', 'cover')
                                ->where(['name', 'like' , "%{$keyword}%"])
                                ->get()
                                ->toArray();

        $style_result = $style->select('id', 'name', 'cover')
                                ->where(['name', 'like' , "%{$keyword}%"])
                                ->get()
                                ->toArray();
                                
        $data = [
            'product' => [
                'title' => '新品鉴赏',
                'data' => $product_result,
            ],
            'space' => [
                'title' => '功能空间',
                'data' => $space_result
            ],
            'style' => [
                'title' => '风格鉴赏',
                'data' => $style_result
            ]
        ];

        return response()->json($data);
    }
}
