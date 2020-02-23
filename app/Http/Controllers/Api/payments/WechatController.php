<?php

namespace App\Http\Controllers\Api\payments;

use Ramsey\Uuid\Uuid;
use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = config('payment.wechat');
    }
    
    public function createCourseOrder(Request $request)
    {
        $order = [
            'out_trade_no' => time(),
            'body' => 'subject-测试',
            'total_fee' => '1',
        ];
        $wechat = Pay::wechat($this->config);
        
        return $wechat->wap($order);
    }

    public function notify()
    {
        $pay = Pay::wechat($this->config);

        try{
            $data = $pay->verify(); //验签

            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $pay->success();
    }
}
