<?php


namespace App\Api\Resources;


use App\Api\Response;
use App\Exceptions\ApiException;
use App\Oss;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Auth
{
    public function get(Request $request)
    {
        $params = $request->input('params',[]);
        $user = $request->user();
//        throw new HttpException(400, 'dfdfd');
        $data = (new Oss())->getUoloadSts();
        $bucket = (new Oss())->getBucket();
        $data['bucket'] = $bucket['bucket_name'];
        $data['endpoint'] = $bucket['endpoint'];
        $data['path'] = 'tmp/'.date('Ymd').'/';
        $params['user_id'] = $user->id;
        $data['callback'] =  (new Oss())->buildCallbackUrl($params);
        return (new Response())->setData($data)->Json();
    }
}
