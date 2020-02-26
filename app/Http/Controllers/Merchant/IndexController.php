<?php

namespace App\Http\Controllers\Merchant;

use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Models\IndexResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryAlias;

class IndexController extends Controller
{
    public function edit(Category $category)
    {
        $merchant = Auth::guard('merchant')->user();

        $index_data = $merchant->index;
        $category_ids = json_decode($merchant->base->category_ids,true);

        $categories = $category->getUserCategories($category_ids, $merchant->id);
        $text_resource = IndexResource::where(['merchant_id'=> $merchant->id,'source_type' => 'text'])->first();
        $video_resources = IndexResource::where(['merchant_id'=> $merchant->id,'source_type' => 'video'])->first();

        return view('merchants.index.edit')->with([
            'data' => $index_data,
            'categories' => $categories,
            'text_resource' => $text_resource,
            'video_resource' => $video_resources
        ]);
    }

    public function update(Request $request)
    {
        $alias = $request->input('alias', []) ?? [];
        $website = $request->input('website', '') ?? '';
        $show_type = $request->input('show_type', []) ?? [];
        if(empty($alias)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error','message')); 
        }

        try{
            DB::beginTransaction();
            $merchant = Auth::guard('merchant')->user();
            $merchant_index = $merchant->index;

            //cover
            if ($request->hasFile('cover')) {
                $this->validate($request, ['cover'=>'image']);
                $cover =  $request->cover->store('images/index');
                $cover_type = 'image';
                $merchant_index->cover = $cover;
                $merchant_index->cover_type = $cover_type;
            }

            if ($request->hasFile('music1')) {
                $music1 =  $request->music1->store('audios/index');
                $merchant_index->music1 = $music1;
            }

            if ($request->hasFile('music2')) {
                $music2 =  $request->music1->store('audios/index');
                $merchant_index->music2 = $music2;
            }

            if ($request->hasFile('music3')) {
                $music3 =  $request->music1->store('audios/index');
                $merchant_index->music3 = $music3;
            }

            $merchant_index->type = $show_type;
            $merchant_index->website = $website;
            $merchant_index->save();

            //category
            $category_ids = json_decode($merchant->base->category_ids,true);
            foreach($category_ids as $i => $v){
                CategoryAlias::updateOrCreate(['merchant_id'=> $merchant->id,'category_id'=> $v],['alias'=> $alias[$i]]);
            }

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
