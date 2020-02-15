<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        
        $total = User::all()->count();
        $model = User::query()
                    ->select(['id', 'name', 'email'])
                    ->offset($start)
                    ->limit($length);

        return DataTables::eloquent($model)->setTotalRecords($total)->toJson();
    }
}
