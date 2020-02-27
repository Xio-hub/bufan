<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\SpaceResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Space $space)
    {
        $merchant = Auth::guard('merchant')->user();
        $spaces = $space
            ->select('spaces.id','spaces.name','spaces.cover','spaces.priority','spaces.type','spaces.created_at','space_categories.name as category_name')
            ->leftJoin('space_categories','spaces.category_id','=','space_categories.id')
            ->orderBy('spaces.created_at','desc')
            ->where(['spaces.merchant_id'=>$merchant->id])
            ->get();


        foreach($spaces as $k => $space){
            $space->cover = Storage::url($space->cover);

            if($space->type == 'image'){
                $space->type = '图片';
            }elseif($space->type == 'video'){
                $space->type = '视频';
            }elseif($space->type == 'pdf'){
                $space->type = 'PDF';
            }
        }
        return view('merchants.spaces.index')->with('spaces',$spaces);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        $categories = $merchant->spaceCategories;
        $articles = $merchant->articles;
        return view('merchants.spaces.create')->with([
            'categories'=> $categories,
            'articles' => $articles
        ]);
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
        $pdf_datail = $request->input('pdf_detail','');
        $hotspot = $request->input('hotspot','');

        if($name == ''){
            $error = 1;
            $message = '请输入名称';
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
        }else if($detail_type == 'pdf'){
            $detail = $pdf_datail;
        }else{
            $error = 1;
            $message = '类型参数错误';
            return response()->json(compact('error','message'));
        }

        if(empty($detail)){
            $error = 1;
            $message = '请上传空间资料';
            return response()->json(compact('error','message'));
        }

        try{
            DB::beginTransaction();
            $merchant = Auth::guard('merchant')->user();

            $space = Space::create([
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
                $detail_data[$i]['space_id'] = $space->id;
                $detail_data[$i]['source_type'] = $detail_type;
                $detail_data[$i]['source_url'] = $v;
                $detail_data[$i]['created_at'] = $now;
                $detail_data[$i]['updated_at'] = $now;
            }
            SpaceResource::insert($detail_data);
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
        $articles = $merchant->articles;
        $space = Space::findOrFail($id);
        $image_resources = SpaceResource::where(['space_id'=> $id,'source_type' => 'image'])->orderBy('priority','asc')->get();
        $video_resources = SpaceResource::where(['space_id'=> $id,'source_type' => 'video'])->orderBy('priority','asc')->get();
        $pdf_resources = SpaceResource::where(['space_id'=> $id,'source_type' => 'pdf'])->orderBy('priority','asc')->get();
        if($merchant->can('edit', $space)){
            return view('merchants.spaces.edit')->with([
                'categories' => $categories,
                'articles' => $articles,
                'space' => $space,
                'image_resources' => $image_resources,
                'video_resources' => $video_resources,
                'pdf_resources' => $pdf_resources
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
    public function update(Request $request, $id)
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
            $space = Space::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('update', $space)){
                DB::beginTransaction();
                
                $space->name = $name;
                $space->hotspot = $hotspot;
                $space->type = $detail_type;
                
                if($cover != ''){
                    $space->cover = $cover;
                }

                if($background_music != ''){
                    $space->background_music = $background_music;
                }

                $space->save();

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
            $space = Space::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete',$space)){
                DB::beginTransaction();
                $space->resources()->delete();
                $space->delete();
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
        $path = $request->file('file')->store("images/spaces/details");
        return $path;
    }

    public function storeVideo(Request $request)
    {
        $path = $request->file('file')->store("videos/spaces");
        return $path;
    }

    public function storePDF(Request $request)
    {
        $path = $request->file('file')->store("pdfs/products/resources");
        return $path;
    }
}
