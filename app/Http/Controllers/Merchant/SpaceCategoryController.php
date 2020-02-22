<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use Illuminate\Http\Request;
use App\Models\SpaceCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SpaceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = Auth::guard('merchant')->user();
        $merchant::with(['spaceCategories' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        $categories = $merchant->spaceCategories;
        foreach($categories as $k => $category){
            $category->cover = Storage::url($category->cover);
        }
        return view('merchants.space_categories.index')->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchants.space_categories.create');
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
            $message = '请输入目录名称';
            return response()->json(compact('error','message'));
        }

        if($cover == ''){
            $error = 1;
            $message = '请上传封面';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            $space_category = SpaceCategory::create([
                'merchant_id' => $merchant->id,
                'name' => $name,
                'cover' => $cover,
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
        $merchant = Auth::guard('merchant')->user();
        $space_category = SpaceCategory::findOrFail($id);
        if($merchant->can('edit',$space_category)){
            return view('merchants.space_categories.edit')->with('category',$space_category);
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
            $message = '请输入目录名称';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            $space_category = SpaceCategory::findOrFail($id);
            if($merchant->can('update',$space_category)){
                if ($request->hasFile('cover')) {
                    $cover =  $request->cover->store('images/spaces/categories/cover');
                    $space_category->cover = $cover;
                }
                $space_category->name = $name;
                $space_category->save();

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
            $category = SpaceCategory::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete',$category)){
                DB::beginTransaction();
                
                $category->resources()->delete();
                $category->spaces()->delete();
                $category->delete();
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
            $message = '';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function storeCover(Request $request)
    {
        $merchant = Auth::guard('merchant')->user();
        $merchant_id = $merchant->id;
        $path = $request->file('file')->store("images/spaces/categories/covers");
        return $path;
    }
}
