<?php


namespace App\Api;



use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QrcodeController  extends Api
{
    public function get(Request $request)
    {

        $key = $request->input('key');
        $expire_second = $request->input('expire_second');
        if (!$expire_second)
        {
            $expire_second = 15*24 * 3600;
        }
        if ($account = $request->input('account'))
        {
            $app = app('wechat.official_account.'.$account);
        }
        else{
            $app = app('wechat.official_account');
        }
        $result = $app->qrcode->temporary($key,  $expire_second);
        return $result;
        $ticket = $result['ticket'];
        $url = $app->qrcode->url($ticket);
        return [
            'data'=>['url'=>$url],
            'status'=>1
        ];
    }


}
