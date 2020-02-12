<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseOutline;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CourseOutlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outlines = CourseOutline::select('id','title','priority','created_at')->get()->all();
        return view('admins.courses.outlines.index')->with('outlines', $outlines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.courses.outlines.create');
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

        if(!$title){
            $error = 1;
            $message = '请输入标题';
            return response()->json(compact('error', 'message'));
        }

        if(!$content){
            $error = 1;
            $message = '请输入内容';
            return response()->json(compact('error', 'message'));
        }

        try{
            CourseOutline::create([
                'course_id' => Course::first()->id,
                'title' => $title,
                'content' => $content,
            ]);
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            $error = 1;
            $message = '创建失败，请稍后重试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error', 'message'));
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
    public function edit(Request $request)
    {
        $id = $request->id;
        $outline = CourseOutline::findOrFail($id);
        return view('admins.courses.outlines.edit')->with('outline', $outline);
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
        $id = $request->id;
        $title = $request->input('title');
        $content = $request->input('content');

        if(!$title){
            $error = 1;
            $message = '请输入标题';
            return response()->json(compact('error', 'message'));
        }

        if(!$content){
            $error = 1;
            $message = '请输入内容';
            return response()->json(compact('error', 'message'));
        }

        try{
            $outline = CourseOutline::findOrFail($id);
            $outline->title = $title;
            $outline->content = $content;
            $outline->save();
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            $error = 1;
            $message = '更新失败，请稍后重试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error', 'message'));
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
            $outline = CourseOutline::where(['id' => $id])->find();
            $outline->delete();
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            $error = 1;
            $message = '更新失败，请稍后重试或联系管理员';
            Log::error($e);
        }finally{
            return response()->json(compact('error', 'message'));
        }
    }
}
