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
        $config = CourseConfig::where(['config_name'=>'background'])->firstOrFail();
        $background = $config->value;
        $background = $background ? Storage::url($background) : '';
        return view('admins.courses.background')->with('background', $background);
    }

    public function updateBackground(Request $request)
    {
        $config = CourseConfig::where(['config_name'=>'background'])->first();
        $background = $request->input('background','') ?? '';
        $config->value = $background;

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
