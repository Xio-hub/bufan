<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Category;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function list(Request $request,Category $category)
    {
        $merchant_id = $request->input('merchant_id', 0) ?? 0;
        if($merchant_id == 0){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $merchant = Merchant::find($merchant_id);
        if(!$merchant){
            $error = 1;
            $message = '商家不存在';
            return response()->json(compact('error', 'message'));
        }

        $category_ids = $merchant->base->category_ids;
        $data = $category->select('id','name')->whereIn('id',json_decode($category_ids, true))->get()->toArray();

        return response()->json($data);
    }
}
