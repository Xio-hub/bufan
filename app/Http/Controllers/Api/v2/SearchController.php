<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Space;
use App\Models\Style;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function search(Request $request,Product $product, Space $space, Style $style)
    {
        $keyword = $request->input('keyword', '') ?? '';
        $merchant_id = $request->input('merchant_id');
        if(is_null($merchant_id) or !is_positive_integer($merchant_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        if($keyword == ''){
            return [];
        }

        $product_result = $product->select('id', 'name', 'cover')
                                ->where([['merchant_id','=',$merchant_id],['name', 'like' , "%{$keyword}%"]])
                                ->get()
                                ->toArray();
        $this->handleCover($product_result);

        $space_result = $space->select('id', 'name', 'cover')
                                ->where([['merchant_id','=',$merchant_id],['name', 'like' , "%{$keyword}%"]])
                                ->get()
                                ->toArray();
        $this->handleCover($space_result);

        $style_result = $style->select('id', 'name', 'cover')
                                ->where([['merchant_id','=',$merchant_id],['name', 'like' , "%{$keyword}%"]])
                                ->get()
                                ->toArray();
        $this->handleCover($style_result);
                                
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

    private function handleCover(&$data)
    {
        foreach($data as $k => $v){
            foreach($data as $k => $v){
                $data[$k]['cover'] = $v['cover'] ? Storage::url($v['cover']) : '';
            }
        }
    }
}
