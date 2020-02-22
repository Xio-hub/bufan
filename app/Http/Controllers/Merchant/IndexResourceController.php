<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use Illuminate\Http\Request;
use App\Models\IndexResource;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IndexResourceController extends Controller
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
        $index_id = $request->input('index_id', '') ?? '';
        $upload_path = '';

        if($resource_type == 'video'){
            $count = IndexResource::where(['index_id' => $index_id, 'source_type' => 'video'])->count();
            if($count == 1){
                $error = 1;
                $message = '只能上传一个视频';
                return response()->json(compact('error','message'));
            }
        }else
        {
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error','message'));     
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            $priority = 0;

            $upload_path = 'videos/index/resources';
            $path = $request->file('file')->store($upload_path);
            $resource = IndexResource::create([
                'merchant_id' => $merchant->id,
                'index_id' => $index_id,
                'content' => $path,
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
        $resource_type = $request->input('resource_type', '') ?? '';
        $text_content = $request->input('text_content', '') ?? '';
        try{
            $path = '';
            if($resource_type == 'video'){
                $path = $request->file('file')->store("images/products/resources");
                $resource = IndexResource::find($id);
                Storage::delete($resource->content);
                $resource->content = $path;
                $resource->save();
            }elseif($resource_type == 'text'){
                $resource = IndexResource::find($id);
                $resource->content = $text_content;
                $resource->save();
            }else{
                $error = 1;
                $message = '参数错误';
                return response()->json(compact('error','message'));     
            }
            
            $error = 0;
        }catch(Exception $e)
        {
            Log::error($e);
            $error = 1;
        }
        
        $result = [
            'error' => $error,
            'path' => $path ? Storage::url($path) : ''
        ];

        return response()->json($result);
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
            $resource = IndexResource::find($id);
            if($merchant->can('delete',$resource)){
                $source_url = $resource->source_url;
                $result = $resource->delete();
    
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
