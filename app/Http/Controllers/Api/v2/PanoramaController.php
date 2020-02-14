<?php

namespace App\Http\Controllers\Api\v2;

use App\Org\Page;
use App\Models\Material;
use App\Models\Panorama;
use Illuminate\Http\Request;
use App\Models\PanoramaStyle;
use App\Http\Controllers\Controller;
use App\Models\VerticalView;

class PanoramaController extends Controller
{
    public function getMaterials(Request $request,Material $material)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 20) ?? 20;
        $merchant_id = $request->input('merchant_id');
        if(is_null($merchant_id) or !is_positive_integer($merchant_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $material->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();
        
        $total = $material->where(['merchant_id' => $merchant_id])->count();

        $page = new Page($total, $limit);
        return response()->json(['data' => $data, 'meta' => ['total_count' => $total, 'next' => $page->getNext(), 'previous' => $page->getPrev()]]);
    }

    public function getStyles(Request $request, PanoramaStyle $panorama_style)
    {
        $offset = $request->input('offset',0) ?? 0;
        $limit = $request->input('limit', 20) ?? 20;
        $merchant_id = $request->input('merchant_id');
        if(is_null($merchant_id) or !is_positive_integer($merchant_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $panorama_style->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
                        ->orderBy('priority', 'asc')
                        ->offset($offset)
                        ->limit($limit)
                        ->get()
                        ->toArray();
        
        $total = $panorama_style->where(['merchant_id' => $merchant_id])->count();

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

        return response()->json($data);
    }
}
