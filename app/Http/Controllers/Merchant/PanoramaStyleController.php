<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PanoramaStyle;
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
    public function destroy($id)
    {
        //
    }

    public function storeCover(Request $request)
    {
        $path = $request->file('file')->store("images/panoramas/styles/covers");
        return $path;
    }
}
