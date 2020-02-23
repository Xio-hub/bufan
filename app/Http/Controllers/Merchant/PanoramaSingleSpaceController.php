<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Panorama;
use App\Models\PanoramaSingleSpace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PanoramaSingleSpaceController extends Controller
{
    public function index(PanoramaSingleSpace $panorama_single_space)
    {
        $merchant = Auth::guard('merchant')->user();
        $single_spaces = $panorama_single_space
            ->select('panorama_single_spaces.source_url',
                'panorama_styles.name as style','materials.name as material','panorama_single_spaces.created_at')
            ->leftJoin('panorama_styles','panorama_single_spaces.style_id', '=', 'panorama_styles.id')
            ->leftJoin('materials','panorama_single_spaces.material_id', '=', 'materials.id')
            ->orderBy('panorama_single_spaces.created_at','desc')
            ->where(['panorama_single_spaces.merchant_id'=>$merchant->id])
            ->get();

        foreach($single_spaces as $k => $single_space){
            $single_space->source_url = Storage::url($single_space->source_url);
        }
        return view('merchants.panoramas.single_spaces.index')->with('single_spaces', $single_spaces);
    }

    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        $merchant->with(['panorama_styles', 'spaces', 'materials'])->get();
        $materials = $merchant->materials;
        $styles = $merchant->styles;
        $spaces = $merchant->spaces;

        return view('merchants.panoramas.single_spaces.create')->with([
            'styles' => $styles,
            'spaces' => $spaces,
            'materials' => $materials
        ]);
    }

    public function store(Request $request)
    {
        $style = $request->input('style', '') ?? '';
        $material = $request->input('material', '') ?? '';
        $picture = $request->input('picture', '') ?? '';

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

        if($picture == ''){
            $error = 1;
            $message = '请上传图片';
            return response()->json(compact('error','message'));
        }

        $count = PanoramaSingleSpace::where(['style_id' => $style, 'material_id' => $material])->count();
        if($count > 0){
            $error = 1;
            $message = '数据已存在，无法添加';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            PanoramaSingleSpace::create([
                'merchant_id' => $merchant->id,
                'style_id' => $style,
                'material_id' => $material,
                'source_url' => $picture,
            ]);
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

    public function edit(Request $request)
    {
        $id = $request->id;
        $single_space = PanoramaSingleSpace::findOrFail($id);
        $merchant = Auth::guard('merchant')->user();
        $styles = $merchant->panorama_styles;
        $materials = $merchant->materials;
        $spaces = $merchant->spaces;
        return view('merchants.panoramas.single_spaces.edit');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $style = $request->input('style', '') ?? '';
        $material = $request->input('material', '') ?? '';
        $space = $request->input('space', '') ?? '';
        $picture = $request->input('picture', '') ?? '';

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

        if($space == ''){
            $error = 1;
            $message = '请选择空间';
            return response()->json(compact('error','message'));
        }

        if($picture == ''){
            $error = 1;
            $message = '请上传图片';
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
            $single_space->space_id = $space;
            $single_space->material_id = $material;
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
        $path = $request->file('file')->store("images/panoramas/single_spaces");
        return $path;
    }
}
