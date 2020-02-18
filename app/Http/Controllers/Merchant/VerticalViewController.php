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
        $merchant::with(['vertical_views' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        $vertical_views = $merchant->vertical_views;
        foreach($vertical_views as $k => $vertical_view){
            $vertical_view->source_url = Storage::url($vertical_view->source_url);
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
        $styles = $merchant->panorama_styles;
        $materials = $merchant->materials;
        return view('merchants.vertical_views.create')->with([
            'styles' => $styles,
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
        $vertical_view = $request->input('vertical_view', '');

        if($style == ''){
            $error = 1;
            $message = '请选择风格';
            return response()->json(compact('error','message'));
        }

        if($vertical_view == ''){
            $error = 1;
            $message = '请上传俯视图图';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            VerticalView::create([
                'merchant_id' => $merchant->id,
                'style_id' => $style,
                'source_url' => $vertical_view,
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
