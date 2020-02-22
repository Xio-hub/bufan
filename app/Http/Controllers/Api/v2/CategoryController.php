<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Category;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function list(Request $request,Category $category)
    {
        $merchant_id = $request->user()->id;
        
        $merchant = Merchant::find($merchant_id);
        $category_ids = json_decode($merchant->base->category_ids,true);

        $data = $category->getUserCategories($category_ids,$merchant->id);

        return response()->json($data);
    }
}
