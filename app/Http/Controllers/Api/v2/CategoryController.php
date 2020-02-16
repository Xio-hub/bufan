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
        $merchant_id = $request->user()->id;
        
        $merchant = Merchant::find($merchant_id);
        $category_ids = $merchant->base->category_ids;
        $data = $category->select('id','name')->whereIn('id',json_decode($category_ids, true))->get()->toArray();

        return response()->json($data);
    }
}
