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
    public function index(Style $style)
    {
        $merchant = Auth::guard('merchant')->user();

        $styles = $style
            ->select('styles.id','styles.name','styles.cover','styles.priority','styles.created_at','style_categories.name as category_name')
            ->leftJoin('style_categories','styles.category_id','=','style_categories.id')
            ->orderBy('styles.created_at','desc')
            ->where(['styles.merchant_id'=>$merchant->id])
            ->get();
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
        $image_datail = $request->input('image_detail','');
        $video_datail = $request->input('video_detail','');
        $hotspot = $request->input('hotspot','');

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

        $cover = '';
        if ($request->hasFile('cover')) {
            $cover =  $request->cover->store('images/spaces/cover');
        }else{
            $error = 1;
            $message = '请上传封面图片';
            return response()->json(compact('error','message'));
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
        }

        if(empty($detail)){
            $error = 1;
            $message = '请上传空间资料';
            return response()->json(compact('error','message'));
        }

        try{
            DB::beginTransaction();
            $merchant = Auth::guard('merchant')->user();

            $style = Style::create([
                'merchant_id' => $merchant->id,
                'category_id' => $category_id,
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
                $detail_data[$i]['style_id'] = $style->id;
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
    public function edit(Request $request)
    {
        $id = $request->id;

        $merchant = Auth::guard('merchant')->user();
        $categories = $merchant->spaceCategories;
        $style = Style::findOrFail($id);
        $image_resources = StyleResource::where(['style_id'=> $id,'source_type' => 'image'])->orderBy('priority','asc')->get();
        $video_resources = StyleResource::where(['style_id'=> $id,'source_type' => 'video'])->orderBy('priority','asc')->get();
        if($merchant->can('edit', $style)){
            return view('merchants.styles.edit')->with([
                'categories' => $categories,
                'style' => $style,
                'image_resources' => $image_resources,
                'video_resources' => $video_resources,
            ]);
        }else{
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $name = $request->input('name','');
        $detail_type = $request->input('detail_type','');
        $hotspot = $request->input('hotspot','');

        if($name == ''){
            $error = 1;
            $message = '请输入风格名称';
            return response()->json(compact('error','message'));
        }

        $cover = '';
        if ($request->hasFile('cover')) {
            $cover =  $request->cover->store('images/styles/cover');
        }

        $background_music = '';
        if ($request->hasFile('background_music')) {
            $background_music =  $request->background_music->store('audios/background_musics');
        }

        try{
            $style = Style::findOrFail($id);

            DB::beginTransaction();
            $merchant = Auth::guard('merchant')->user();

            $style->name = $name;
            $style->hotspot = $hotspot;
            $style->type = $detail_type;
            
            if($cover != ''){
                $style->cover = $cover;
            }

            if($background_music != ''){
                $style->background_music = $background_music;
            }

            $style->save();

            DB::commit();
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '修改失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
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
