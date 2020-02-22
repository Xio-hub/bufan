<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use Illuminate\Http\Request;
use App\Models\PanoramaStyle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PanoramaStyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = Auth::guard('merchant')->user();
        $merchant::with(['panorama_styles' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        $styles = $merchant->panorama_styles;
        foreach($styles as $k => $style){
            $style->cover = Storage::url($style->cover);
        }
        return view('merchants.panoramas.styles.index')->with('styles', $styles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchants.panoramas.styles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name', '');
        $cover = $request->input('cover', '');

        if($name == ''){
            $error = 1;
            $message = '请输入名称';
            return response()->json(compact('error','message'));
        }

        if($cover == ''){
            $error = 1;
            $message = '请上传封面';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            PanoramaStyle::create([
                'merchant_id' => $merchant->id,
                'name' => $name,
                'cover' => $cover,
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
        $merchant = Auth::guard('merchant')->user();
        $style = PanoramaStyle::findOrFail($id);
        if($merchant->can('edit',$style)){
            return view('merchants.panoramas.styles.edit')->with('style',$style);
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
        $name = $request->input('name', '');
        if($name == ''){
            $error = 1;
            $message = '请输入风格名称';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            $style = PanoramaStyle::findOrFail($id);
            if($merchant->can('update',$style)){
                if ($request->hasFile('cover')) {
                    $cover =  $request->cover->store('images/spaces/categories/cover');
                    $style->cover = $cover;
                }
                $style->name = $name;
                $style->save();

                $error = 0;
                $message = 'success';
            }else{
                $error = 1;
                $message = 'UnAuthorized';
            }
        }
        catch(Exception $e){
            Log::error($e);
            $error = 1;
            $message = '修改失败，请稍后再试或者联系管理员';
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
            $panorama_style = PanoramaStyle::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete', $panorama_style)){
                DB::beginTransaction();
                $panorama_style->panoramas->delete();
                $panorama_style->delete();
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
        $path = $request->file('file')->store("images/panoramas/styles/covers");
        return $path;
    }
}
