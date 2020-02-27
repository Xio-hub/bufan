<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function detail(Request $request)
    {
        $id = $request->id;
        $user = $request->user();
        $article = Article::select('merchant_id','title','content')->where(['id' => $id])->first();
        if($article && $user->can('view',$article)){
            unset($article->merchant_id);
        }else{
            $article = null;
        }
        return response()->json($article);
    }
}
