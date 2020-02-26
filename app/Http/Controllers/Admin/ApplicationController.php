<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\MerchantApplication;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('admins.applications.index');
    }

    public function getList(Request $request)
    {
        $start = $request->input('start', 0) ?? 0;
        $length = $request->input('length', 25) ?? 25; 
        
        $total = MerchantApplication::all()->count();
        $models = MerchantApplication::query()->orderBy('created_at','desc')
                    ->offset($start)->limit($length);
                    
        return DataTables::eloquent($models)->setTotalRecords($total)->toJson();
    }
}
