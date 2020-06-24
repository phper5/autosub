<?php


namespace App\Api;


use Illuminate\Http\Request;

class Resource extends Api
{
    public function getOne(Request $request,$id) {
        $resource = \App\Resource::find($id);
        $options = ['preview'=>$request->input('preview',0)];
        return (new Response())->setData($resource->toResponse($options))->Json();
    }
}
