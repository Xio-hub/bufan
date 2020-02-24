<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IndexResource;
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
        $data->top_logo = Storage::url($data->top_logo);
        $data->sitebar_logo = Storage::url($data->sitebar_logo);
        $data->slogan = Storage::url($data->slogan);
        return response()->json($data);
    }

    public function index(Request $request)
    {
        $merchant_id = $request->user()->id;
        $data = MerchantIndex::getIndexContent($merchant_id);
        $data = MerchantIndex::select('id','cover','music1','music2','music3','type')->where(['merchant_id'=>$merchant_id])->first();
        if(!empty($data)){
            $data = $data->toArray();
            $data['cover'] = $data['cover'] ? Storage::url($data['cover']) : '';
            $data['music1'] = $data['music1'] ? Storage::url($data['music1']) : '';
            $data['music2'] = $data['music2'] ? Storage::url($data['music2']) : '';
            $data['music3'] = $data['music3'] ? Storage::url($data['music3']) : '';
            $index_resource = IndexResource::select('content')->where(['index_id'=> $data['id'], 'source_type' => $data['type']])->first();
            if($index_resource){
                $data['content'] = $index_resource->content;
            }else{
                $data['content'] = '';
            }
        }
  
        return response()->json($data);
    }
}
