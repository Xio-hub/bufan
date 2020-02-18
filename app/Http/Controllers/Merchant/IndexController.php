<?php

namespace App\Http\Controllers\Merchant;

use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function edit()
    {
        $merchant = Auth::guard('merchant')->user();

        $index_data = $merchant->index;

        return view('merchants.index.edit')->with('data',$index_data);
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $merchant = Auth::guard('merchant')->user();
            $merchant_index = $merchant->index;

            $cover = '';
            $cover_type = '';
            if ($request->hasFile('cover')) {
                $this->validate($request, ['cover'=>'image']);
                $cover =  $request->cover->store('images/index');
                $cover_type = 'image';
            }

            $merchant_index->cover = $cover;
            $merchant_index->cover_type = $cover_type;
            $merchant_index->content = $request->content;
            $merchant_index->save();
            DB::commit();

            $error = 0;
            $message = '修改成功';
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '修改失败，请联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }


}
