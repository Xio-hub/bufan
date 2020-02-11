<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\CourseConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CourseConfigController extends Controller
{
    public function editBackground()
    {
        $config = CourseConfig::first();
        $background = $config->background;
        $background = $background ? Storage::url($background) : '';
        return view('admins.courses.configs.background')->with('background', $background);
    }

    public function editIntroduction()
    {
        $config = CourseConfig::first();
        $introduction = $config->introduction;
        return view('admins.courses.configs.introduction')->with('introduction', $introduction);
    }

    public function updateIntroduction(Request $request)
    {
        $config = CourseConfig::first();
        $introduction = $request->input('introduction');
        $config->introduction = $introduction;
        try{
            $config->save();
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

    public function updateBackground(Request $request)
    {
        $config = CourseConfig::first();
        $background = $request->input('background','') ?? '';
        $config->background = $background;

        try{
            $config->save();
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
