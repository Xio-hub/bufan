<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InitController extends Controller
{
    public function init(Request $request)
    {
        $merchant_id = $request->input('merchant_id');
        $data = [
            'top_logo' => 'http:/imageurl.com',
            'sitebar_logo' => 'http://imageurl.com',
            'slogan' => '布凡家居设计'
        ];
        return response()->json($data);
    }

    public function getIndexBackground()
    {
        $data = [
            'url' => 'http://imageurl.com',
        ];
        return response()->json($data);
    }
}
