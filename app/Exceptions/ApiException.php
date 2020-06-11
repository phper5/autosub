<?php


namespace App\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    const ERROR_TEST = [
        'code'=>110,
        'msg'=>'msg',
        'httpCode'=>400,
        'headers'=>[]
    ];
    const INVAILD_ACCESS = [
        'code'=>100,
        'msg'=>'invaild access',
        'httpCode'=>430,
        'headers'=>[]
    ];
    const NOT_FOUND = [
        'code'=>101,
        'msg'=>'not found',
        'httpCode'=>404,
        'headers'=>[]
    ];
    const INVAILD_TOKEN = [
        'code'=>102,
        'msg'=>'invaild token',
        'httpCode'=>410,
        'headers'=>[]
    ];
    const INVAILD_PARAM = [
        'code'=>103,
        'msg'=>'invaild param',
        'httpCode'=>400,
        'headers'=>[]
    ];
    const INVAILD_AUTH = [
        'code'=>104,
        'msg'=>'用户名或密码错误',
        'httpCode'=>400,
        'headers'=>[]
    ];

    public function __construct($error, $msg='',$previous=null)
    {
        $msg = $msg?:$error['msg'];
        parent::__construct($error['httpCode'], $msg, $previous, $error['headers'], $error['code']);
    }
}
