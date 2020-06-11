<?php


namespace App;


use Illuminate\Http\Request;

class CDN
{
    public static function getUrl($uri)
    {
        /**
         * @var $request Request
         */
        $request = app()->request;
        $scheme = $request->getScheme();
        return $scheme.config('cdn.static').$uri;

    }
}
