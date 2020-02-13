<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\ProductResource;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function list(Request $request, Product $product)
    {
        $merchant_id = $request->input('merchant_id', 0) ?? 0;
        if($merchant_id == 0){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $product->select('id','name','cover')
                        ->where(['merchant_id' => $merchant_id])
                        ->orderBy('priority', 'asc')
                        ->get()
                        ->toArray();
        
        return response()->json($data);
    }

    public function detail(Request $request,Product $product,ProductResource $product_resource)
    {
        $id = $request->id;

        $product = $product->select('id','name')
                        ->where(['id' => $id])
                        ->first();

        if($product){
            $data = $product->toArray();
            $resources = $product_resource->select('source_type as type','source_url')
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
