<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MerchantBase;
use App\Models\MerchantIndex;
use Illuminate\Support\Facades\Storage;

class InitController extends Controller
{
    public function init(Request $request)
    {
        $merchant_id = $request->user()->id;
        $data = MerchantBase::select('top_logo','sitebar_logo','slogan')
                            ->where(['merchant_id'=>$merchant_id])
                            ->first();
                            
        return response()->json($data);
    }

    public function index(Request $request)
    {
        $merchant_id = $request->user()->id;   
        $data = MerchantIndex::select('cover','content')
                            ->where(['merchant_id'=>$merchant_id])
                            ->first()
                            ->toArray();
        if($data['cover'] != ''){
            $data['cover'] = Storage::url($data['cover']);
        }
        return response()->json($data);
    }
}
