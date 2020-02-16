<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Introduction;

class IntroductionController extends Controller
{
    public function categories(Request $request,Introduction $instruduction)
    {

        $merchant_id = $request->user()->id;

        $data = $instruduction->select('id', 'title as name')
                            ->where(['merchant_id' => $merchant_id])
                            ->orderBy('priority','asc')
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
