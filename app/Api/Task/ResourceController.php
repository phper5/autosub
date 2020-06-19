<?php


namespace App\Api\Task;


use App\Api\Response;
use App\Resource;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

class ResourceController
{
    public function post(Request $request)
    {
        $user = $request->user('api');
        $uid = $user->getAuthIdentifier();
        $resource_id = $request->input('resource_id');
        $language = $request->input('language');
        $resource = Resource::find($resource_id);
        if ($resource){
            $resource->status = \App\Task::STATUS_QUEUE;
            $resource->language = $language;
            $resource->progress=0;
            $resource->save();

        }
        //写入task

        $task = new \App\Task();
        $task->user_id = $uid;
        $task->id = Uuid::uuid();
        $task->service ='audio2txt';
        $task->status =\App\Task::STATUS_QUEUE;
        $task->progress =0;
        $task->args =json_encode(['language'=>$language]);
        $task->source_file = $resource_id;
        $task->save();
        return (new Response())->setData($task->toResponse())->setHeaders(['Cache-Control'=>'no-cache'])->Json();
    }
}
