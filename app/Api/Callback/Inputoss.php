<?php


namespace App\Api\Callback;


use App\Api\Response;
use App\Oss;
use App\Resource;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

class Inputoss
{
    private function proc(Request $request)
    {
        $step = $request->input('x_step','mp3');
        $bucket = $request->input('bucket');
        $object = $request->input('object');
        $size = $request->input('size');
        $mime_type = $request->input('mime_type');
        $user_id = $request->input('x_user_id');
        $resource = new Resource();
        $resource->id = Uuid::uuid();
        $resource->bucket = $bucket;
        $resource->object = $object;
        $resource->filename = $request->input('x_filename');;
        $resource->type = (explode('/',$mime_type))[0];
        $resource->user_id = $user_id;
        $resource->size = $size;
        $resource->user_file = 0;
        $resource->save();
        $task_id = $request->input('x_task_id');
        $task = \App\Task::find($task_id);
        if ($source = Resource::find($task->source_file))
        {
            if ( $step){
                $source->$step = $resource->id;
            }
            if ( in_array($step,['flac','mp3','aac','ogg','wav']) &&  ($task->status == \App\Task::STATUS_PROCESS)){
                $task->status = \App\Task::STATUS_PRCS;
                $source->status = \App\Task::STATUS_PRCS;
            }
            $source->save();
        }
        $task->save();
        return (new Response())->setData(['resource_id'=>$resource->id])->setHeaders(['Cache-Control'=>'no-cache'])->Json();
    }
    private function task(Request $request)
    {
        $step = $request->input('x_step','mp3');
        $bucket = $request->input('bucket');
        $object = $request->input('object');
        $size = $request->input('size');
        $mime_type = $request->input('mime_type');
        $user_id = $request->input('x_user_id');
        $resource = new Resource();
        $resource->id = Uuid::uuid();
        $resource->bucket = $bucket;
        $resource->object = $object;
        $resource->filename = $request->input('x_filename');;
        $resource->type = (explode('/',$mime_type))[0];
        $resource->user_id = $user_id;
        $resource->size = $size;
        $resource->save();
//
        $task_id = $request->input('x_task_id');
        $task = \App\Task::find($task_id);
//        $task->target_file = json_encode([$resource->id]);
//        $task->status = \App\Task::STATUS_FINISH;
//        $task->save();
        if ( $step){
            $task->$step = $resource->id;
        }
        if ( in_array($step,['flac','mp3','aac','ogg','wav']) && $task->status == \App\Task::STATUS_QUEUE){
            $task->status = \App\Task::STATUS_PRCS;
        }else{
            $finished = 1;
            $args = json_decode($task->args,true);
            if (!$task->sub1)
                $finished = 0;
            if ($args['is_need_trans']&&!$task->sub2) {
                $finished = 0;
            }
            if ($args['is_need_trans'] && $args['is_need_merge']&&!$task->sub3) {
                $finished = 0;
            }
            if ($finished)
            {
                $task->status = \App\Task::STATUS_FINISH;
            }
        }

        $task->save();
        return (new Response())->setData(['resource_id'=>$resource->id])->setHeaders(['Cache-Control'=>'no-cache'])->Json();

    }
    private function upload(Request $request)
    {
        $bucket = $request->input('bucket');
        $object = $request->input('object');
        $size = $request->input('size');
        $mime_type = $request->input('mime_type');


        //*****
        $test = [];


        $user_id = $request->input('x_user_id');


        $resource = new Resource();
        $resource->id = Uuid::uuid();
        $resource->bucket = $bucket;
        $resource->object = $object;
        $resource->filename = $request->input('x_filename');;
        $resource->type = (explode('/',$mime_type))[0];
        $resource->user_id = $user_id;
        $resource->size = $size;
        $resource->save();
        $options = [];

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
        if ($action == 'proc')
        {
            return $this->proc($request);
        }
        else{
            return $this->upload($request);
        }

    }
}
