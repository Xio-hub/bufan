<?php

namespace App\Http\Controllers\Api\v2;

use Exception;
use Illuminate\Http\Request;
use App\Models\MerchantApplication;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function createApplication(Request $request)
    {   
        $company_name = $request->input('company_name','') ?? '';
        $mobile = $request->input('mobile','') ?? '';
        $address = $request->input('address','') ?? '';
        $introduction = $request->input('introduction','') ?? '';

        if(empty($company_name) or empty($mobile) or empty($address) or empty($introduction)){
            $error = 1;
            $message = '参数错误';
            return response()->json(compact('error', 'message'));
        }

        if(mb_strlen($introduction) > 200){
            $error = 1;
            $message = '企业简介过长';
            return response()->json(compact('error', 'message'));
        }

        if(!is_mobile($mobile)){
            $error = 1;
            $message = '手机格式错误';
            return response()->json(compact('error', 'message'));
        }

        try{
            MerchantApplication::create([
                'company_name' => $company_name,
                'mobile' => $mobile,
                'address' => $address,
                'introduction' => $introduction
            ]);
            $status = true;
            $message = 'success';
        }catch(Exception $e){
            $status = false;
            Log::error($e);
            $message = '申请失败，请稍后重试或联系工作人员';
        }

        return response()->json(compact('status','message'));
    }
}
