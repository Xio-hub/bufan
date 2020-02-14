<?php

namespace App\Http\Controllers\Api\v2;

use App\Org\Page;
use App\Models\Style;
use Illuminate\Http\Request;
use App\Models\StyleCategory;
use App\Http\Controllers\Controller;
use App\Models\StyleResource;

class StyleController extends Controller
{
    public function categories(Request $request, StyleCategory $style_category)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 8) ?? 8;
        $merchant_id = $request->input('merchant_id');
        if(is_null($merchant_id) or !is_positive_integer($merchant_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $style_category->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();
        
        $total = $style_category->where(['merchant_id' => $merchant_id])
                        ->count();

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function list(Request $request, Style $style)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 8) ?? 8;
        $style_id = $request->input('filter_id', 0) ?? 0;
        if($style_id == 0){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $style->select('id','name','cover')
                        ->where(['space_id' => $style_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();
        
        $total = $style->where(['space_id' => $style_id])
                        ->count();

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function detail(Request $request, Style $style, StyleResource $style_resource)
    {
        $id = $request->id;

        $data = $style->select('id','name')
                        ->where(['id' => $id])
                        ->first();

        if($data){
            $data = $data->toArray();
            $resources = $style_resource->select('source_type as type','source_url')
                            ->where(['product_id' => $id])    
                            ->orderBy('priority', 'asc')
                            ->get()
                            ->toArray();
            $data['content'] = $resources;              
        }else{
            $data = null;
        }

        return response()->json($data);
    }
}
