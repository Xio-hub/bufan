<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use App\Models\Style;
use Illuminate\Http\Request;
use App\Models\StyleResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = Auth::guard('merchant')->user();

        $merchant::with(['styles' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        $styles = $merchant->styles;
        foreach($styles as $k => $style){
            $style->cover = Storage::url($style->cover);
        }
        return view('merchants.styles.index')->with('styles',$styles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        $categories = $merchant->styleCategories;
        return view('merchants.styles.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category_id = $request->input('category','0');
        $name = $request->input('name','');
        $detail_type = $request->input('detail_type','');
        $cover = $request->input('cover','');
        $image_datail = $request->input('image_detail','');
        $video_datail = $request->input('video_detail','');

        if($name == ''){
            $error = 1;
            $message = '请输入名称';
            return response()->json(compact('error','message'));
        }

        if(!in_array($detail_type,['image','video'])){
            $error = 1;
            $message = '空间详细类型错误';
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
        }else if($detail_type == 'video'){
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

            $space = Style::create([
                'merchant_id' => $merchant->id,
                'category_id' => $category_id,
                'name' => $name,
                'cover' => $cover,
                'type' => $detail_type,
            ]);

            $detail_data = [];
            foreach($detail as $i => $v){
                $now = Carbon::now()->toDateTimeString();
                $detail_data[$i]['merchant_id'] = $merchant->id;
                $detail_data[$i]['style_id'] = $space->id;
                $detail_data[$i]['source_type'] = $detail_type;
                $detail_data[$i]['source_url'] = $v;
                $detail_data[$i]['created_at'] = $now;
                $detail_data[$i]['updated_at'] = $now;
            }
            StyleResource::insert($detail_data);
            DB::commit();
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '添加空间失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        try{
            $style = Style::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete',$style)){
                DB::beginTransaction();
                $style->resources()->delete();
                $style->delete();
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

    public function storeCover(Request $request)
    {
        $path = $request->file('file')->store("images/styles/covers");
        return $path;
    }

    public function storeImage(Request $request)
    {
        $path = $request->file('file')->store("images/styles/details");
        return $path;
    }

    public function storeVideo(Request $request)
    {
        $path = $request->file('file')->store("videos/styles");
        return $path;
    }
}
