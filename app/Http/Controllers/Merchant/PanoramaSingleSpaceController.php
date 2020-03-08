<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use App\Models\Style;
use App\Models\Panorama;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\PanoramaSingleSpace;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PanoramaSingleSpaceResource;
use App\Models\StyleCategory;

class PanoramaSingleSpaceController extends Controller
{
    public function index(PanoramaSingleSpace $panorama_single_space)
    {
        $merchant = Auth::guard('merchant')->user();
        $single_spaces = $panorama_single_space
            ->select('style_categories.name as style_category','styles.name as style','materials.name as material','panorama_single_spaces.id','panorama_single_spaces.source_type','panorama_single_spaces.created_at')
            ->leftJoin('styles','panorama_single_spaces.style_id', '=', 'styles.id')
            ->leftJoin('materials','panorama_single_spaces.material_id', '=', 'materials.id')
            ->leftJoin('style_categories','styles.category_id','style_categories.id')
            ->where(['panorama_single_spaces.merchant_id'=>$merchant->id])
            ->get();

        foreach($single_spaces as $k => $single_space){
            if($single_space->source_type == 'image'){
                $single_space->source_type = '图片';
            }elseif($single_space->source_type == 'video'){
                $single_space->source_type = '视频';
            }elseif($single_space->source_type == 'pdf'){
                $single_space->source_type = 'PDF';
            }
        }
        return view('merchants.panoramas.single_spaces.index')->with('single_spaces', $single_spaces);
    }

    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        $materials = $merchant->materials;
        $categories = $merchant->styleCategories;

        return view('merchants.panoramas.single_spaces.create')->with([
            'materials' => $materials,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $style = $request->input('style', '') ?? '';
        $material = $request->input('material', '') ?? '';
        $detail_type = $request->input('detail_type','');
        $image_datail = $request->input('image_detail','');
        $video_datail = $request->input('video_detail','');
        $pdf_datail = $request->input('pdf_detail','');

        if($style == ''){
            $error = 1;
            $message = '请选择风格';
            return response()->json(compact('error','message'));
        }

        if($material == ''){
            $error = 1;
            $message = '请选择材质';
            return response()->json(compact('error','message'));
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

        $count = PanoramaSingleSpace::where(['style_id' => $style, 'material_id' => $material])->count();
        if($count > 0){
            $error = 1;
            $message = '数据已存在，无法添加';
            return response()->json(compact('error','message'));
        }

        try{
            DB::beginTransaction();
            $merchant = Auth::guard('merchant')->user();
            $single_space = PanoramaSingleSpace::create([
                'merchant_id' => $merchant->id,
                'style_id' => $style,
                'material_id' => $material,
                'source_type' => $detail_type,
            ]);

            $detail_data = [];
            foreach($detail as $i => $v){
                $now = Carbon::now()->toDateTimeString();
                $detail_data[$i]['merchant_id'] = $merchant->id;
                $detail_data[$i]['single_space_id'] = $single_space->id;
                $detail_data[$i]['source_type'] = $detail_type;
                $detail_data[$i]['source_url'] = $v;
                $detail_data[$i]['priority'] = 0;
                $detail_data[$i]['hotspot'] = 0;
                $detail_data[$i]['created_at'] = $now;
                $detail_data[$i]['updated_at'] = $now;
            }
            PanoramaSingleSpaceResource::insert($detail_data);

            DB::commit();
            $error = 0;
            $message = 'success';
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error($e);
            $error = 1;
            $message = '添加失败，请稍后再试或者联系管理员';
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $single_space = PanoramaSingleSpace::findOrFail($id);

        $merchant = Auth::guard('merchant')->user();
        $articles = $merchant->articles;
        $materials = $merchant->materials;
        $categories = $merchant->styleCategories;

        $image_resources = PanoramaSingleSpaceResource::where(['single_space_id'=> $id,'source_type' => 'image'])->orderBy('priority','asc')->get();
        $video_resources = PanoramaSingleSpaceResource::where(['single_space_id'=> $id,'source_type' => 'video'])->orderBy('priority','asc')->get();
        $pdf_resources = PanoramaSingleSpaceResource::where(['single_space_id'=> $id,'source_type' => 'pdf'])->orderBy('priority','asc')->get();

        $single_space_style_category = StyleCategory::select('style_categories.id','style_categories.name')
                                            ->leftJoin('styles','style_categories.id','=','styles.category_id')
                                            ->where(['styles.id' => $single_space->style_id])
                                            ->first();

        $styles = Style::select('id','name')->where(['category_id' => $single_space_style_category->id])->get();

        return view('merchants.panoramas.single_spaces.edit')->with([
            'articles' => $articles,
            'single_space' => $single_space,
            'materials' => $materials,
            'categories' => $categories,
            'single_space_style_category' => $single_space_style_category,
            'styles' => $styles,
            'image_resources' => $image_resources,
            'video_resources' => $video_resources,
            'pdf_resources' => $pdf_resources
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $style = $request->input('style', '') ?? '';
        $material = $request->input('material', '') ?? '';
        $type = $request->input('detail_type', '') ?? '';

        if($style == ''){
            $error = 1;
            $message = '请选择风格';
            return response()->json(compact('error','message'));
        }

        if($material == ''){
            $error = 1;
            $message = '请选择材质';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            $single_space = PanoramaSingleSpace::where(['id'=>$id])->firstOrFail();
            if(!$merchant->can('update',$single_space)){
                $error = 1;
                $message = 'UnAuthorized';
                return response()->json(compact('error','message'));
            }
            
            
            $single_space->style_id = $style;
            $single_space->material_id = $material;
            $single_space->source_type = $type;
            $single_space->save();
            $error = 0;
            $message = 'success';
        }
        catch(Exception $e){
            Log::error($e);
            $error = 0;
            $message = '添加失败，请稍后再试或者联系管理员';
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        try{
            $single_space = PanoramaSingleSpace::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete', $single_space)){
                $single_space->delete();

                $error = 0;
                $message = 'success';
            }else{
                $error = 1;
                $message = 'UnAuthorized';
            }
        }catch(Exception $e){
            $error = 1;
            $message = '删除失败，请稍后再试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function storeImage(Request $request)
    {
        $path = $request->file('file')->store("images/single_spaces/resources");
        return $path;
    }

    public function storeVideo(Request $request)
    {
        $path = $request->file('file')->store("videos/single_spaces/resources");
        return $path;
    }

    public function storePDF(Request $request)
    {
        $path = $request->file('file')->store("pdfs/single_spaces/resources");
        return $path;
    }
}
