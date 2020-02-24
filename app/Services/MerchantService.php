<?php

namespace App\Services;

use App\Models\Merchant;
use Illuminate\Support\Carbon;

class MerchantService
{
    public function validateCreateMerchantForm(&$request)
    {
        $username = $request->input('username','') ?? '';
        $email = $request->input('email','') ?? '';
        $password = $request->input('password', '') ?? '';
        $merchant_name = $request->input('merchant_name','') ?? '';
        $categories = $request->input('categories') ?? '';
        $permissions = $request->input('permissions') ?? '';
        $expired_at = $request->input('expired_at') ?? '';

        if($username == ''){
            $message = '请输入用户名';
            return ['error'=>1,'message'=>$message];
        }
        if(strlen($username)>60){
            $message = '用户名过长';
            return ['error'=>1,'message'=>$message];
        }
        if(strlen($username)<6){
            $message = '用户名至少包含10个字符';
            return ['error'=>1,'message'=>$message];
        }
        if($this->checkUsernameExist($username)){
            $message = '用户名已被使用。';
            return ['error'=>1,'message'=>$message];
        }
        if($email == ''){
            $message = '请输入电子邮件';
            return ['error'=>1,'message'=>$message];
        }
        if(!is_email($email)){
            $message = '邮箱格式错误';
            return ['error'=>1,'message'=>$message];
        }
        if($this->checkEmailExist($email)){
            $message = '该邮箱已被使用';
            return ['error'=>1,'message'=>$message];
        }
        if($password == ''){
            $message = '请输入密码';
            return ['error'=>1,'message'=>$message];
        }
        if($merchant_name == ''){
            $message = '请输入商家名称';
            return ['error'=>1,'message'=>$message];
        }
        if(empty($categories)){
            $message = '请选择栏目';
            return ['error'=>1,'message'=>$message];
        }
        if(empty($permissions)){
            $message = '请选择权限';
            return ['error'=>1,'message'=>$message];
        }
        if(empty($expired_at)){
            $message = '请选择到期时间';
            return ['error'=>1,'message'=>$message];
        }
        if(Carbon::parse($expired_at)->toDateTimeString() < Carbon::now()->toDateTimeString()){
            $message = '到期时间不能早于当前日期';
            return ['error'=>1,'message'=>$message];
        }

        return ['error'=>0,'message'=>''];

    }

    private function checkUsernameExist($username){
        $count = Merchant::where(['username' => $username])->count();
        return $count > 0 ? true : false;
    }

    private function checkEmailExist($email){
        $count = Merchant::where(['email' => $email])->count();
        return $count > 0 ? true : false;
    }
}