<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use App\Models\VerticalView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerticalViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = Auth::guard('merchant')->user();
        
        $merchant = Auth::guard('merchant')->user();
        $vertical_views = VerticalView::select('vertical_views.id','vertical_views.created_at','vertical_views.source_type','materials.name as material_name','style_categories.name as style_category','styles.name as style_name')
                            ->leftJoin('materials','vertical_views.material_id','=','materials.id')
                            ->leftJoin('styles','vertical_views.style_id','styles.id')
                            ->leftJoin('style_categories','styles.category_id','style_categories.id')
                            ->where(['vertical_views.merchant_id' => $merchant->id])
                            ->get();

        foreach($vertical_views as $k => $vertical_view){
            if($vertical_view->source_type == 'image'){
                $vertical_view->source_type = '鸟瞰图片';
            }else if($vertical_view->source_type == 'link'){
                $vertical_view->source_type = '鸟瞰链接';
            }
        }
        return view('merchants.vertical_views.index')->with('vertical_views', $vertical_views);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        $materials = $merchant->materials;
        $categories = $merchant->styleCategories;

        return view('merchants.vertical_views.create')->with([
            'materials' => $materials,
            'categories' => $categories,
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
        $style = $request->input('style', '') ?? '';
        $material = $request->input('material', '') ?? '';
        $vertical_view = $request->input('vertical_view', '') ?? '';
        $source_type = $request->input('source_type','') ?? '';
        $link = $request->input('link','') ?? '';

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

        if($vertical_view == '' && $link == ''){
            $error = 1;
            $message = '请上传鸟瞰图 或输入鸟瞰图链接';
            return response()->json(compact('error','message'));
        }

        $source_url = '';
        if($source_type == 'image'){
            $source_url = $vertical_view;
        }else if($source_type == 'link'){
            $source_url = $link;
        }else{
            $error = 1;
            $message = '请选择类型';
            return response()->json(compact('error','message'));
        }

        $count = VerticalView::where(['style_id' => $style, 'material_id' => $material])->count();
        if($count > 0){
            $error = 1;
            $message = '数据已存在，无法添加';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            VerticalView::create([
                'merchant_id' => $merchant->id,
                'style_id' => $style,
                'material_id' => $material,
                'source_url' => $source_url,
                'source_type' => $source_type
            ]);
            $error = 0;
            $message = 'success';
        }
        catch(Exception $e){
            Log::error($e);
            $error = 1;
            $message = '添加失败，请稍后再试或者联系管理员';
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
            $vertical_view = VerticalView::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete', $vertical_view)){
                $vertical_view->delete();

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
        $path = $request->file('file')->store("images/vertical_views");
        return $path;
    }
}
