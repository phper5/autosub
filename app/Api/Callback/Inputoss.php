<?php


namespace App\Api\Callback;


use App\Api\Response;
use App\Oss;
use App\Resource;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

class Inputoss
{
    private function task(Request $request)
    {
        $bucket = $request->input('bucket');
        $object = $request->input('object');
        $size = $request->input('size');
        $mime_type = $request->input('mime_type');
        $image_height = $request->input('image_height');
        $image_width = $request->input('image_width');
        $user_id = $request->input('x_user_id');
        $resource = new Resource();
        $resource->id = Uuid::uuid();
        $resource->bucket = $bucket;
        $resource->object = $object;
        $resource->filename = $request->input('x_filename');;
        $resource->type = (explode('/',$mime_type))[0];
        $resource->attrs = json_encode([
            'image_width'=>$image_width,
            'image_height'=>$image_height,
        ]);
        $resource->user_id = $user_id;
        $resource->size = $size;
        $resource->save();
        $task_id = $request->input('x_task_id');
        $task = \App\Task::find($task_id);
        $task->target_file = json_encode([$resource->id]);
        $task->status = \App\Task::STATUS_FINISH;
        $task->save();
        return (new Response())->setData(['task_id'=>$task->id])->setHeaders(['Cache-Control'=>'no-cache'])->Json();

    }
    private function upload(Request $request)
    {
        $bucket = $request->input('bucket');
        $object = $request->input('object');
        $size = $request->input('size');
        $mime_type = $request->input('mime_type');
        $image_height = $request->input('image_height');
        $image_width = $request->input('image_width');
        $is_inpainting = $request->input('x_is_inpainting',0);
        $orientation = 1;
        //*****
        $test = [];
        try{
            $url = (new Oss())->getSignedObjectUrl($bucket,$object,null,3600,false,false,['x-oss-process'=>'image/info']);
            $test['url'] = $url;
            $client = new \GuzzleHttp\Client();
            $res = $client->request('get',$url,['timeout=>2','headers' => [
                'Accept'     => 'application/json',
            ]]);
            $res = $res->getBody();
            $data = json_decode($res->getContents(),true);
            if (isset($data['ImageHeight']['value'])) {
                $orientation = $data['Orientation']['value']??1;
                if ($orientation>=5 && $orientation<=8)
                {
                    $image_height = $data['ImageWidth']['value'];
                    $image_width = $data['ImageHeight']['value'];
                }
                else{
                    $image_height = $data['ImageHeight']['value'];
                    $image_width = $data['ImageWidth']['value'];
                }

            }
            $test['data'] = $data;
            $test['h'] =$image_height;

        }catch (\Exception $e){

        }

        //print(bucket.sign_url('GET', object, 3600,None,{'x-oss-process':'image/info'}))

        $user_id = $request->input('x_user_id');
        $screen_width = $request->input('x_screen_width',0);
        $preview_width = $request->input('x_preview_width',0);
        $resource = new Resource();
        $resource->id = Uuid::uuid();
        $resource->bucket = $bucket;
        $resource->object = $object;
        $resource->filename = $request->input('x_filename');;
        $resource->type = (explode('/',$mime_type))[0];
        $resource->attrs = json_encode([
            'image_width'=>$image_width,
            'image_height'=>$image_height,
            'orientation'=>$orientation
        ]);
        $resource->user_id = $user_id;
        $resource->size = $size;
        $resource->save();
        $options = [];
        if ($is_inpainting) {
            $options['preview']=1;
            $options['preview_width']=$preview_width;
        }
        $data = $resource->toResponse($options);
        $data['test'] = $test;
        return (new Response())->setData($data)->Json();
    }
    public function post(Request $request)
    {

        $action = $request->input('x_action','upload');
        if ($action == 'task')
        {
            return $this->task($request);
        }
        else{
            return $this->upload($request);
        }

    }
}
