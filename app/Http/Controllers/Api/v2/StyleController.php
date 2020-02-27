<?php

namespace App\Http\Controllers\Api\v2;

use App\Org\Page;
use App\Models\Style;
use Illuminate\Http\Request;
use App\Models\StyleCategory;
use App\Models\StyleResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StyleController extends Controller
{
    public function categories(Request $request, StyleCategory $style_category)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 8) ?? 8;
        $merchant_id = $request->user()->id;

        $total = $style_category->where(['merchant_id' => $merchant_id])->count();

        if($total > 0){
            $data = $style_category->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();

            foreach($data as $k => $v)
            {
                $data[$k]['cover'] = $v['cover'] ? Storage::url($v['cover']) : '';
            }
        }else{
            $data = [];
        }
    

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function list(Request $request, Style $style)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 8) ?? 8;
        $category_id = $request->input('filter_id', 0) ?? 0;
        if($category_id == 0){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $total = $style->where(['category_id' => $category_id])->count();
        if($total > 0){
            $data = $style->select('id','name','cover')
                        ->where(['category_id' => $category_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();
            foreach($data as $k => $v){
                $data[$k]['cover'] = $v['cover'] ? Storage::url($v['cover']) : '';
            }
        }else{
            $data = [];
        }

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $user = $request->user();
        $style = Style::select('id','merchant_id','name','type','hotspot')
                        ->where(['id' => $id])
                        ->first();

        if($style && $user->can('view',$style)){
            $data = $style->toArray();
            unset($data['merchant_id']);
            $resources = StyleResource::select('source_type as type','source_url')
                            ->where(['style_id' => $id, 'source_type' => $data['type']])    
                            ->orderBy('priority', 'asc')
                            ->get()
                            ->toArray();

            foreach($resources as $k => $v){
                $resources[$k]['source_url'] = $v['source_url'] ? Storage::url($v['source_url']) : '';
            }
            
            $data['content'] = $resources;              
        }else{
            $data = null;
        }

        return response()->json($data);
    }
}
