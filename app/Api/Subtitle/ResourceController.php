<?php


namespace App\Api\Subtitle;


use App\Resource;
use Illuminate\Http\Request;

class ResourceController
{
    public function getOne(Request $request,$id) {
        $resource = Resource::find($id);
        $filename = $resource->filename;
        if (!$filename){
            $filename='srt';
        }else{
            $tmp = explode('.',$filename);
            $filename = $tmp[0];
        }
        $filename = $filename.'-'.$resource->language.'.srt';
        return response($resource->subtitle)->header('Content-Disposition','attachment;filename="'.$filename.'"');
    }
}
