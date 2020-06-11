<?php

namespace App\Http\Middleware;

use App\Api\Api;
use App\Http\Controllers\Api\ApiController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\Response;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        DB::connection()->enableQueryLog();
        //开始的处理
        $startTime = intval(microtime(true) * 1000);

        $response = $next($request);


        if ($this->isApi($request))
        {

            //结束的处理
            $endTime = intval(microtime(true) * 1000);
            if ($response instanceof  RedirectResponse) {
                return $response; //to check!
            }


            $run_time = $endTime - $startTime;
            $response->header('X-RUNTIME', $run_time);
            $data = ['run_time' => $run_time];
            //user-agent
            //Authorization
            $header_fields = [
                'authorization',
                'user-agent',
                'request-time',
                'app-name',
                'app-version',
                'cli-os',
                'cli-os-version',
                'set-cookie'
            ];
            $request_header = [];
            foreach ($request->headers->all() as $key => $val) {
                if (in_array(strtolower($key), $header_fields)) {
                    $request_header[$key] = is_array($val) ? $val[0] : $val;
                }
            }
            $data['request'] = [
                'uri' => $request->getUri(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'header' => $request_header,
                'params' => $request->all(),
             //   'params2' => file_get_contents('php://input')
            ];

            $data['response'] = [
                'header'=>$response->headers,
                'body' => $response->getContent(),
            ];
            if (1||config('app.debug'))
            {
                $data['sql'] = DB::getQueryLog();
            }
            Log::channel('request')->info('request', $data);
            DB::flushQueryLog();
        }

        return $response;
    }
    private function isApi(Request $request)
    {
        try{
            //特殊處理

             $path = trim($request->getPathInfo(),'/');
            if (substr($path,0,4)=='api/')
            {
                return true;
            }
            return false;
            //print_r(DB::getQueryLog());
            $route = $request->getRouteResolver();
            if (!$route) {
                return false;
            }
            /**
             * @var \Illuminate\Routing\Route::class
             */
            $controller = $route()->getController();
            if ($controller instanceof  Api)
            {
                return true;
            }

        }
        catch (\Exception $e){
            Log::channel('execption')->info('isApi', [$e]);
        }
        catch (\Throwable $e)
        {
            Log::channel('execption')->info('isApi', [$e]);
        }
        return false;

    }
}
