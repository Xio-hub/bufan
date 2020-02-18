<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use App\Models\Panorama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PanoramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = Auth::guard('merchant')->user();
        $merchant::with(['panoramas' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        $panoramas = $merchant->panoramas;
        foreach($panoramas as $k => $panorama){
            $panorama->cover = Storage::url($panorama->cover);
        }
        return view('merchants.panoramas.index')->with('panoramas', $panoramas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchant = Auth::guard('merchant')->user();
        $styles = $merchant->panorama_styles;
        $materials = $merchant->materials;
        return view('merchants.panoramas.create')->with([
            'styles' => $styles,
            'materials' => $materials
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
        $style = $request->input('style', '');
        $material = $request->input('material', '');
        $panorama = $request->input('panorama', '');

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

        if($panorama == ''){
            $error = 1;
            $message = '请上传全景图';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            Panorama::create([
                'merchant_id' => $merchant->id,
                'style_id' => $style,
                'material_id' => $material,
                'source_url' => $panorama,
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
            $panorama = Panorama::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete', $panorama)){
                $panorama->delete();

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
        $path = $request->file('file')->store("images/panoramas");
        return $path;
    }
}
