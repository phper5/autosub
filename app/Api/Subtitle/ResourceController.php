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
            $filename='vtt';
        }else{
            $tmp = explode('.',$filename);
            $filename = $tmp[0];
        }
        $filename = $filename.'-'.$resource->language.'.vtt';
        return response($resource->subtitle)->header('Content-Disposition','attachment;filename="'.$filename.'"');
    }
    public function getOneByType(Request $request,$type,$id) {
        $resource = Resource::find($id);
        $filename = $resource->filename;
        if (!$filename){
            $filename=$type;
        }else{
            $tmp = explode('.',$filename);
            $filename = $tmp[0];
        }
        $filename = $filename.'-'.$resource->language.'.'.$type;
        $sub = trim($resource->subtitle);
        $sub = trim($resource->subtitle,'WEBVTT');
        $sub = trim($resource->subtitle);
        $str = [];
        foreach (explode("\n",$str) as $line) {
            if (strstr($line,'-->') && (substr_count($line,':')==4 || substr_count($line,':')==2)){
                $line = str_replace('.',',',$line);
            }
            $str[] = $line;
        }
        $str = implode("\n",$str);

        return response($str)->header('Content-Disposition','attachment;filename="'.$filename.'"');
    }

}