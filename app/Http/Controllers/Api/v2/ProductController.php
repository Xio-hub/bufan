<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\ProductResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function list(Request $request, Product $product)
    {
        $merchant_id = $request->user()->id;
        $data = $product->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
                        ->orderBy('priority', 'asc')
                        ->get()
                        ->toArray();

        foreach($data as $k => $v){
            $data[$k]['cover'] = $v['cover'] ? Storage::url($v['cover']) : '';
        }
        
        return response()->json($data);
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $user = $request->user();
        $product = Product::select('id','merchant_id','name','type')
                        ->where(['id' => $id])
                        ->first();

        if($product && $user->can('view',$product)){
            $data = $product->toArray();
            
            $resources = ProductResource::select('source_type as type','source_url','hotspot')
                            ->where(['product_id' => $id,'source_type' => $data['type']])    
                            ->orderBy('priority', 'asc')
                            ->get()
                            ->toArray();

            foreach($resources as $k => $v){
                $resources[$k]['source_url'] = $v['source_url'] ? Storage::url($v['source_url']) : '';
            }
            
            $data['content'] = $resources;
            unset($data['merchant_id']);        
        }else{
            $data = null;
        }

        return response()->json($data);
    }
}
