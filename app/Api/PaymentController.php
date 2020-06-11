<?php


namespace App\Api;


use Illuminate\Http\Request;
use Yansongda\LaravelPay\Facades\Pay;

class PaymentController
{
    public function getOne(Request $request,$id) {
        $order = [
            'out_trade_no' => time(),
            'total_amount' => '1.00',
            'subject' => $id.'---:'.config('app.name'),
        ];

        $result =  Pay::alipay()->scan($order);
        $result->qr_code;
        //        String agent = request.getHeader("User-Agent").toLowerCase();
        //        System.out.println("响应头的类型："+agent);
        //        if (agent.indexOf("micromessenger") > 0) {
        //            System.out.println("微信支付");
        //        } else if (agent.indexOf("alipayclient") > 0) {
        //            System.out.println("阿里支付");
        return $result->qr_code;
        return redirect($result->qr_code);
    }
}
