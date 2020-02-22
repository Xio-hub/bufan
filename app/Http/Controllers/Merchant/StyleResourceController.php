<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use Illuminate\Http\Request;
use App\Models\StyleResource;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StyleResourceController extends Controller
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
        $style_id = $request->input('style_id', '') ?? '';
        $upload_path = '';
        if($resource_type == 'image'){
            $upload_path = 'images/styles/resources';
            $count = StyleResource::where(['style_id' => $style_id, 'source_type' => 'image'])->count();
            if($count == 30){
                $error = 1;
                $message = '最多只能上传30张图片';
                return response()->json(compact('error','message'));
            }
        }else if($resource_type == 'video'){
            $upload_path = 'videos/styles/resources';
            $count = StyleResource::where(['style_id' => $style_id, 'source_type' => 'video'])->count();
            if($count == 1){
                $error = 1;
                $message = '只能上传一个视频';
                return response()->json(compact('error','message'));
            }
        }else if($resource_type == 'pdf'){
            $upload_path = 'pdfs/styles/resources';
            $count = StyleResource::where(['style_id' => $style_id, 'source_type' => 'pdf'])->count();
            if($count == 1){
                $error = 1;
                $message = '只能上传一个pdf';
                return response()->json(compact('error','message'));
            }
        }else{
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            $priority = 0;
            $path = $request->file('file')->store($upload_path);
            $resource = StyleResource::create([
                'merchant_id' => $merchant->id,
                'style_id' => $style_id,
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
            $path = $request->file('file')->store("images/styles/resources");
            $resource = StyleResource::find($id);
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
            $resource = StyleResource::find($id);
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
