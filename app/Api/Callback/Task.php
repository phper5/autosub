<?php


namespace App\Api\Callback;


use App\Api\Response;
use App\Oss;
use App\Resource;
use Illuminate\Http\Request;


class Task
{
    public function finished(Request $request)
    {
        $task_id = $request->input('task_id','');
        $progress = $request->input('progress',0);
        $content = $request->input('content','');
        $task = \App\Task::find($task_id);
        $result = $request->input('result',[]);
        if ($source = Resource::find($task->source_file)){
            $source->subtitle = $content;
        }
        if ($progress){
            $task->progress = $progress;
        }
        if ($content) {
            if ($source = Resource::find($task->source_file)){
                $source->subtitle = $content;
                $source->status = \App\Task::STATUS_FINISH;
                $source->save();
            }
            $task->progress = 100;
            $task->status = \App\Task::STATUS_FINISH;
        }
        $task->save();
    }
    public function getOne(Request $request)
    {
        $test_task_id = $request->input('task_id','');
        if ($test_task_id) {
            $task=\App\Task::find($test_task_id);
        }
        else{
            $task = \App\Task::where('status',\App\Task::STATUS_PRCS) ->orderBy('created_at', 'ASC')->first();
        }
        if ($task)
        {
            if ($test_task_id || \App\Task::where('id', $task->id)
                ->where('status', \App\Task::STATUS_PRCS)
                ->update(['status' => \App\Task::STATUS_ZM])) {
                $data ['task'] =$task->toResponse(['sourceDetail'=>true,'args'=>true,'flac'=>true]);
                $data ['task']['update_url'] = config('app.url').'/api/callback/task/finished';
                $params = [
                    'user_id'=>$task->user_id,
                    'task_id'=>$task->id,
                    'action'=>'task'
                ];
                $data['oss']=(new Oss())->buildCallbackUrl($params);
                return (new Response())->setData([$data])->setHeaders(['Cache-Control'=>'no-cache'])->Json();
            }
        }
        return (new Response())->setData([])->setHeaders(['Cache-Control'=>'no-cache'])->Json();
    }

    public function putOne(Request $request,$id)
    {
        if ($task = \App\Task::find($id))
        {
            $status = $request->get('status');
            $progress = $request->get('progress');
            \App\Task::where('id', $task->id)
                ->where('status', '!=',\App\Task::STATUS_FINISH)
                ->update(['progress' => $progress,'status'=>$status]
                );
        }
        return (new Response())->setData([])->Json();
    }
}
