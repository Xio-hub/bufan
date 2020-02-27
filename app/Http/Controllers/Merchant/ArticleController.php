<?php

namespace App\Http\Controllers\Merchant;

use Exception;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('merchants.articles.index');
    }

    public function getList(Request $request)
    {
        $start = $request->input('start', 0) ?? 0;
        $length = $request->input('length', 25) ?? 25; 
        
        $total = Article::all()->count();
        $models = Article::query()->orderBy('created_at','desc')
                    ->offset($start)->limit($length);
                    
        return DataTables::eloquent($models)->setTotalRecords($total)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchants.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        if(empty($title) or empty($content)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error','message'));
        }

        try{
            $merchant = Auth::guard('merchant')->user();
            Article::create([
                'merchant_id' => $merchant->id,
                'title' => $title,
                'content' => $content
            ]);
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            $error = 1;
            $message = '创建文章失败，请稍后重试';
            Log::error($e->getMessage());
        }

        return response()->json(compact('error','message'));
        
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
        $article = Article::findOrFail($id);
        if($merchant->can('edit', $article)){
            return view('merchants.articles.edit')->with('article', $article);
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
        $title = $request->input('title');
        $content = $request->input('content');

        if(empty($title) or empty($content)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error','message'));
        }

        try{
            $article = Article::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('update', $article)){
                $article->title = $title;
                $article->content = $content;
                $article->save();
                $error = 0;
                $message = 'success';
            }else{
                $error = 1;
                $message = 'UnAuthorized';
            }
        }catch(Exception $e){
            $error = 1;
            $message = '修改失败，请稍后重试';
            Log::error($e->getMessage());
        }

        return response()->json(compact('error','message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $article = Article::findOrFail($id);
            $merchant = Auth::guard('merchant')->user();
            if($merchant->can('delete', $article)){
                $article->delete();
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
}
