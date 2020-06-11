<?php


namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

use Illuminate\Support\Facades\App;

class Template
{
    protected $except = [
        //
    ];

    public function handle(Request $request, Closure $next, $guard = null)
    {
        $uri = $request->url();
        $tmp = parse_url($uri);

        if (isset($tmp['host']) && ($tmp['host'] == 'mypic.life' || $tmp['host'] == '2d.com')) {
            $path = resource_path('views/mypic.life/');
            $view = app('view')->getFinder();
            // 重新定义视图目录
            $view->prependLocation($path);
        }
        if (isset($tmp['host']) && ($tmp['host'] == 'diandi.org' || $tmp['host'] == 'www.diandi.org')) {
            //$path = resource_path('views/diandi.org/');
            $path = resource_path('views/default/');
            $view = app('view')->getFinder();
            // 重新定义视图目录
            $view->prependLocation($path);
        }
        else{
            $path = resource_path('views/default/');
            $view = app('view')->getFinder();
            // 重新定义视图目录
            $view->prependLocation($path);
        }

        return $next($request);
    }
}
