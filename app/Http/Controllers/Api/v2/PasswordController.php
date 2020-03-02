<?php

namespace App\Http\Controllers\Api\v2;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        try{
            $password = $request->input('password','') ?? '';
            
            $rules = [
                'password' => 'required|min:6|max:32',
            ];

            $messages = [
                'password.required' => '请输入密码',
                'password.min' => '请输入至少:min位密码',
                'password.max' => '请输入至多:max位密码'
            ];
      
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $message = $errors->first();

                $error = 1;
                return response()->json(compact('error','message'));
            }
            
            $user = $request->user();
            $user->password = bcrypt($request->password);
            $user->save();
            $status = true;
        }catch(Exception $e){
            Log::error($e);
            $status = false;
        }

        return response()->json(compact('status'));
    }
}
