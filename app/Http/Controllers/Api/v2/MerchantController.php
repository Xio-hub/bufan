<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MerchantBase;
use Yajra\DataTables\Facades\DataTables;

class MerchantController extends Controller
{
    public function list(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        
        $total = Merchant::all()->count();
        $model = MerchantBase::query()->offset($start)->limit($length)->select(['merchant_id', 'name']);

        return DataTables::eloquent($model)->setTotalRecords($total)->toJson();
    }
}
