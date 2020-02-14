<?php

namespace App\Http\Controllers\Api\v2;

use App\Org\Page;
use App\Models\Space;
use Illuminate\Http\Request;
use App\Models\SpaceCategory;
use App\Http\Controllers\Controller;
use App\Models\SpaceResource;

class SpaceController extends Controller
{
    public function getCategories(Request $request, SpaceCategory $space_category)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 8) ?? 8;
        $merchant_id = $request->input('merchant_id');
        if(is_null($merchant_id) or !is_positive_integer($merchant_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $space_category->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();
        
        $total = $space_category->where(['merchant_id' => $merchant_id])
                        ->count();

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function list(Request $request, Space $space)
    {

        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 8) ?? 8;
        $space_id = $request->input('filter_id', 0) ?? 0;
        if($space_id == 0){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $space->select('id','name','cover')
                        ->where(['space_id' => $space_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();
        
        $total = $space->where(['space_id' => $space_id])
                        ->count();

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function detail(Request $request,Space $space, SpaceResource $space_resource)
    {
        $id = $request->id;

        $data = $space->select('id','name')
                        ->where(['id' => $id])
                        ->first();

        if($data){
            $data = $data->toArray();
            $resources = $space_resource->select('source_type as type','source_url')
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
