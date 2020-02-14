<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Introduction;

class IntroductionController extends Controller
{
    public function categories(Request $request,Introduction $instruduction)
    {

        $merchant_id = $request->input('merchant_id');
        if(is_null($merchant_id) or !is_positive_integer($merchant_id)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        $data = $instruduction->select('id', 'title as name')
                            ->where(['merchant_id', $merchant_id])
                            ->get()
                            ->toArray();

        return response()->json($data);
    }

    public function detail(Request $request,Introduction $instruduction)
    {
        $id = $request->id;
        $data = $instruduction->select('id', 'title as name', 'content')
                        ->where(['id' => $id])
                        ->first();

        return response()->json($data);
    }
}
