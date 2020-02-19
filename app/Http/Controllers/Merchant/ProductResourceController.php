<?php

namespace App\Http\Controllers\Merchant;

use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Models\ProductResource;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductResourceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resource_type = $request->input('resource_type', '') ?? '';
        $product_id = $request->input('product_id', '') ?? '';
        $upload_path = '';
        if(!in_array($resource_type,['image','video']) or $product_id == ''){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error','message'));
        }

        if($resource_type == 'image'){
            $upload_path = 'images/products/resources';
            $count = ProductResource::where(['product_id' => $product_id, 'source_type' => 'image'])->count();
            if($count == 30){
                $error = 1;
                $message = '最多只能上传30张图片';
                return response()->json(compact('error','message'));
            }
        }else{
            $upload_path = 'videos/products/resources';
            $count = ProductResource::where(['product_id' => $product_id, 'source_type' => 'video'])->count();
            if($count == 1){
                $error = 1;
                $message = '只能上传一个视频';
                return response()->json(compact('error','message'));
            }
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            $priority = 0;
            $path = $request->file('file')->store($upload_path);
            $resource = ProductResource::create([
                'merchant_id' => $merchant->id,
                'product_id' => $product_id,
                'source_url' => $path,
                'source_type' => $resource_type,
            ]);
            $id = $resource->id;

            $error = 0;
            $message = 'success';
            $data = [
                'id' => $id,
                'source_url' => Storage::url($path),
                'priority' => $priority
            ];
        }catch(Exception $e){
            Log::error($e);
            $error = 1;
            $message = '添加失败';
            $data = [];
        }
        return response()->json(compact('error','message','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $path = $request->file('file')->store("images/products/resources");
            $resource = ProductResource::find($id);
            Storage::delete($resource->source_url);
            $resource->source_url = $path;
            $resource->save();
            
            $error = 0;
        }catch(Exception $e)
        {
            Log::error($e);
            $error = 1;
        }
        
        $result = [
            'error' => $error,
            'path' => Storage::url($path)
        ];

        return response()->json($resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $merchant = Auth::guard('merchant')->user();
            $resource = ProductResource::find($id);
            if($merchant->can('delete',$resource)){
                $source_url = $resource->source_url;
                $result = $resource->delete();
                Storage::delete($source_url);
    
                $error = 0;
                $message = 'success';
            }else{
                $error = 1;
                $message = 'UnAuthorized';
            }
        }catch(Exception $e){
            Log::error($e);
            $error = 1;
            $message = '删除失败';
        }finally{
            return response()->json(compact('error','message'));
        }
    }
}
