<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function editBackground()
    {
        $course = Course::select('background')->first();
        $background = Storage::url($course->background);
        return view('admins.courses.background')->with('background', $background);
    }

    public function editInfo()
    {
        $course = Course::first();
        return view('admins.courses.info')->with('course', $course);
    }

    public function editTeacherInfo()
    {
        $course = Course::first();
        return view('admins.courses.teacher_info')->with('course', $course);
    }

    public function editPrice()
    {
        $course = Course::first();
        return view('admins.courses.price')->with('course', $course);
    }

    public function update(Request $request)
    {

        $info = $request->input('info');
        $teacher_info = $request->input('teacher_info');
        $price = $request->input('price');
        $background = $request->input('background');

        if(!$info && !$teacher_info && !$price && !$background){
            $error = 1;
            $message = '参数不能为空';
            return response()->json(compact('error', 'message'));
        }

        try{
            $course = Course::first();
            if($background){
                $course->background = $background;
            }
            if($info){
                $course->info = $info;
            }
            if($teacher_info){
                $course->teacher_info = $teacher_info;
            }
            if($price){
                $course->price = number_format($price,2,".","");;
            }
            $course->save();
            $error = 0;
            $message = 'success';
        }catch(Exception $e){
            $error = 1;
            $message = '更新失败';
            Log::error($e);
        }finally{
            return response()->json(compact('error', 'message'));
        }
    }

    public function storeBackground(Request $request)
    {
        $path = $request->file('file')->store("images/courses/background");
        return $path;
    }
}
