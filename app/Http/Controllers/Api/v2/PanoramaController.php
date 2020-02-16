<?php

namespace App\Http\Controllers\Api\v2;

use App\Org\Page;
use App\Models\Material;
use App\Models\Panorama;
use App\Models\VerticalView;
use Illuminate\Http\Request;
use App\Models\PanoramaStyle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PanoramaController extends Controller
{
    public function getMaterials(Request $request,Material $material)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 20) ?? 20;
        $merchant_id = $request->user()->id;

        $total = $material->where(['merchant_id' => $merchant_id])->count();
        if($total > 0){
            $data = $material->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
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

    public function getStyles(Request $request, PanoramaStyle $panorama_style)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 20) ?? 20;
        $merchant_id = $request->user()->id;

        $total = $panorama_style->where(['merchant_id' => $merchant_id])->count();

        if($total > 0){
            $data = $panorama_style->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
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

    public function detail(Request $request,Panorama $panorama)
    {
        $style_id = $request->input('style_id');
        $material_id = $request->input('material_id');

        if(is_null($style_id) or is_null($material_id) or !is_positive_integer($style_id) or !is_positive_integer($material_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $panorama->select('id', 'source_url as url')->where(['style_id'=>$style_id,'material_id'=>$material_id])->first();

        if(!is_null($data)){
            $data->url = $data->url ? Storage::url($data->url) : '';
        }

        return response()->json($data);
    }

    public function getVerticalView(Request $request, VerticalView $vertical_view)
    {
        $style_id = $request->input('style_id');

        if(is_null($style_id) or !is_positive_integer($style_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $vertical_view->select('id', 'source_url as url')->where(['style_id'=>$style_id])->first();

        if(!is_null($data)){
            $data->url = $data->url ? Storage::url($data->url) : '';
        }

        return response()->json($data);
    }
}
