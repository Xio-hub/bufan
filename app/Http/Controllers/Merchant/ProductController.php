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
        $products = $merchant->products;
        foreach($products as $k => $product){
            $product->cover = Storage::url($product->cover);
            
            if($product->type == 'image'){
                $product->type = '图片';
            }elseif($product->type == 'video'){
                $product->type = '视频';
            }elseif($product->type == 'pdf'){
                $product->type = 'PDF';
            }
        }
        return view('merchants.products.index')->with('products',$products);
    }

    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        $articles = $merchant->articles;
        return view('merchants.products.create')->with('articles', $articles);
    }

    public function store(Request $request)
    {
        $name = $request->input('name','');
        $detail_type = $request->input('detail_type','');
        $image_datail = $request->input('image_detail','');
        $video_datail = $request->input('video_detail','');
        $pdf_datail = $request->input('pdf_detail','');
        $hotspot = $request->input('hotspot','') ?? '';

        if($name == ''){
            $error = 1;
            $message = '请输入产品名称';
            return response()->json(compact('error','message'));
        }

        $cover = '';
        if ($request->hasFile('cover')) {
            $cover =  $request->cover->store('images/products/cover');
        }

        $background_music = '';
        if ($request->hasFile('background_music')) {
            $background_music =  $request->background_music->store('audios/products/backgrounds');
        }

        $detail = '';
        if($detail_type == 'image'){
            $detail = $image_datail;
        }else if($detail_type == 'video'){
            $detail = $video_datail;
        }else if($detail_type == 'pdf'){
            $detail = $pdf_datail;
        }else{
            $error = 1;
            $message = '类型参数错误';
            return response()->json(compact('error','message'));
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
                'background_music' => $background_music,
                'hotspot' => $hotspot,
            ]);

            $detail_data = [];
            foreach($detail as $i => $v){
                $now = Carbon::now()->toDateTimeString();
                $detail_data[$i]['merchant_id'] = $merchant->id;
                $detail_data[$i]['product_id'] = $product->id;
                $detail_data[$i]['source_type'] = $detail_type;
                $detail_data[$i]['source_url'] = $v;
                $detail_data[$i]['priority'] = 0;
                $detail_data[$i]['hotspot'] = 0;
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

    public function edit(Request $request, Product $product)
    {
        $id = $request->id;

        $merchant = Auth::guard('merchant')->user();
        $product = Product::findOrFail($id);
        $articles = $merchant->articles;
        $image_resources = ProductResource::where(['product_id'=> $id,'source_type' => 'image'])->orderBy('priority','asc')->get();
        $video_resources = ProductResource::where(['product_id'=> $id,'source_type' => 'video'])->orderBy('priority','asc')->get();
        $pdf_resources = ProductResource::where(['product_id'=> $id,'source_type' => 'pdf'])->orderBy('priority','asc')->get();
        if($merchant->can('edit', $product)){
            return view('merchants.products.edit')->with([
                'product' => $product,
                'articles' => $articles,
                'image_resources' => $image_resources,
                'video_resources' => $video_resources,
                'pdf_resources' => $pdf_resources
            ]);
        }else{
            abort(404);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        
        try{
            $product = Product::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();

            if($merchant->can('update', $product)){

                if ($request->has('name')) {
                    $name = $request->input('name','');
                    if($name == ''){
                        $error = 1;
                        $message = '请输入名称';
                        return response()->json(compact('error','message'));
                    }
                    $product->name = $name;
                }

                if ($request->has('detail_type')) {
                    $product->type = $request->input('detail_type','');
                }

                if ($request->has('hotspot')) {
                    $product->hotspot = $request->input('hotspot','');
                }

                if ($request->has('priority')) {
                    $product->priority = $request->input('priority',0);
                }

                if ($request->hasFile('cover')) {
                    $product->cover =  $request->top_logo->store('images/products/cover');
                }
        
                if ($request->hasFile('background_music')) {
                    $product->background_music =  $request->background_music->store('audios/background_musics');
                }

                $product->save();
                $error = 0;
                $message = 'success';
            }else{
                $error = 1;
                $message = 'UnAuthorized';
            }
        }catch(Exception $e){
            $error = 1;
            $message = '修改失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        try{
            $product = Product::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete', $product)){
                DB::beginTransaction();
                $product->delete();
                $product->resources()->delete();
                DB::commit();
                $error = 0;
                $message = 'success';
            }else{
                $error = 1;
                $message = 'UnAuthorized';
            }
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '删除失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function storeImage(Request $request)
    {
        $path = $request->file('file')->store("images/products/resources");
        return $path;
    }

    public function storeVideo(Request $request)
    {
        $path = $request->file('file')->store("videos/products/resources");
        return $path;
    }

    public function storePDF(Request $request)
    {
        $path = $request->file('file')->store("pdfs/products/resources");
        return $path;
    }
}
