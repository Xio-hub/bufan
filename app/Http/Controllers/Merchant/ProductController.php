<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $merchant = Auth::guard('merchant')->user();
        $merchant::with(['products' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        $products = $merchant->products;
        foreach($products as $k => $product){
            $product->cover = Storage::url($product->cover);
        }
        return view('merchants.products.index')->with('products',$products);
    }

    public function create()
    {
        return view('merchants.products.create');
    }

    public function store(Request $request)
    {
        $name = $request->input('name','');
        $detail_type = $request->input('detail_type','');
        $cover = $request->input('cover','');
        $image_datail = $request->input('image_detail','');
        $video_datail = $request->input('video_detail','');

        if($name == ''){
            $error = 1;
            $message = '请输入产品名称';
            return response()->json(compact('error','message'));
        }

        if(!in_array($detail_type,['image','video'])){
            $error = 1;
            $message = '产品详细类型错误';
            return response()->json(compact('error','message'));
        }

        if($cover == ''){
            $error = 1;
            $message = '请上传封面图片';
            return response()->json(compact('error','message'));
        }

        $detail = '';
        if($detail_type == 'image'){
            $detail = $image_datail;
        }else if($detail_type == 'videp'){
            $detail = $video_datail;
        }

        if(empty($detail)){
            $error = 1;
            $message = '请上传产品资料';
            return response()->json(compact('error','message'));
        }

        try{
            DB::beginTransaction();
            $merchant = Auth::guard('merchant')->user();
            $product = Product::create([
                'merchant_id' => $merchant->id,
                'name' => $name,
                'cover' => $cover,
                'type' => $detail_type,
            ]);

            $detail_data = [];
            foreach($detail as $i => $v){
                $now = Carbon::now()->toDateTimeString();
                $detail_data[$i]['merchant_id'] = $merchant->id;
                $detail_data[$i]['product_id'] = $product->id;
                $detail_data[$i]['source_type'] = $detail_type;
                $detail_data[$i]['source_url'] = $v;
                $detail_data[$i]['created_at'] = $now;
                $detail_data[$i]['updated_at'] = $now;
            }
            ProductResource::insert($detail_data);
            DB::commit();
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '添加商品失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function edit()
    {
        // return view('merchants.products.edit');
    }

    public function update(Request $request)
    {

    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        try{
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->delete();
            $product->resources()->delete();
            DB::commit();

            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '删除失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }


    public function storeCover(Request $request)
    {
        $path = $request->file('file')->store("images/products/cover");
        return $path;
    }


    public function storeImage(Request $request)
    {
        $path = $request->file('file')->store("images/products/detail");
        return $path;
    }

    public function storeVideo(Request $request)
    {
        $path = $request->file('file')->store("videos/products");
        return $path;
    }
}
