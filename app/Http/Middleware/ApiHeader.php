<?php
/**
 * Created by PhpStorm.
 * User: white
 * Date: 12/11/18
 * Time: 2:29 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class ApiHeader
{
    public function handle($request, Closure $next)
    {
        if ($this->isApi($request))
        {
            if ($request->getMethod() == 'OPTIONS')
            {
                $response = new Response();
            }
            else{
                $response = $next($request);
            }
            foreach (config('wx-apiheader.headers',['Access-Control-Allow-Origin'=>'*',
                'Access-Control-Allow-Methods'=>'GET, POST, PATCH, PUT, OPTIONS,DELETE',
                'Access-Control-Allow-Headers'=>'Request-Time,Authorization,X-Hash,Brand,App,App-Version,Cli-Os,Cli-Os-Version,Content-Type']) as $k =>$v)
            {
                $response->header($k, $v);
            }
        }else{
            $response = $next($request);
        }

        return $response;
    }
    public function isApi($request)
    {
        $uri = $request->getPathInfo();
        $uri = trim($uri,'/');

        if (substr($uri,0,4) == 'api/')
        {
            return true;
        }

    }
}
