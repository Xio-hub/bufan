<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use App\Models\Introduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IntroductionController extends Controller
{
    public function index()
    {
        $merchant = Auth::guard('merchant')->user();
        $introductions = $merchant->introductions;
        return view('merchants.introductions.index')->with('introductions', $introductions);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $merchant = Auth::guard('merchant')->user();
        $introduction = Introduction::where(['id'=>$id,'merchant_id'=>$merchant->id])->firstOrFail();
        return view('merchants.introductions.edit')->with('introduction',$introduction);
    }

    public function update(Request $request)
    {
        try{
            $merchant = Auth::guard('merchant')->user();
            $id = $request->id;
            $content = $request->input('content');
            $priority = $request->input('priority');
            $status = $request->input('status');

            $introduction = Introduction::where(['id'=>$id])->firstOrFail();
            if(!$merchant->can('update',$introduction)){
                $error = 1;
                $message = 'UnAuthorized';
                return response()->json(compact('error','message'));
            }
            
            if($content){
                $introduction->content = $content;
            }

            if($priority){
                $introduction->priority = $priority;
            }

            if($status !== null){
                $introduction->status = $status;
            }
            $introduction->save();
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            $error = 1;
            $message = '修改失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function storeImage(Request $request){
        $path = $request->file('file')->store("images/introductions");
        
        if($path){
            $error = 0;
            $path = Storage::url($path);
        }else{
            $error = 1;
        }

        return response()->json(compact('error','path'));
    }
}
