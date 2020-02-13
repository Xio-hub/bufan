<?php

namespace App\Http\Controllers\Api\v1;

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
        $model = Merchant::query()->offset($start)->limit($length)->select(['id', 'username']);

        return DataTables::eloquent($model)->setTotalRecords($total)->toJson();
    }
}
