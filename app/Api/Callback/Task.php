<?php


namespace App\Api\Callback;


use App\Api\Response;
use App\Oss;
use Illuminate\Http\Request;


class Task
{
    public function finished(Request $request)
    {
        $task_id = $request->input('task_id','');
        $task = \App\Task::find($task_id);
        $result = $request->input('result',[]);
        if (is_array($result)) {
            foreach ($result as $key =>$val) {
                $task->$key = $val;
            }
        }
        $status = \App\Task::STATUS_FINISH;
        $args = json_decode($task->args,true);
        if (!$task->sub1)
            $status = \App\Task::STATUS_PROCESS;
        if ($args['is_need_trans']&&!$task->sub2) {
            $status = \App\Task::STATUS_PROCESS;
        }
        if ($args['is_need_merge']&&!$task->sub3) {
            $status = \App\Task::STATUS_PROCESS;
        }
        $task->status = $status;
        $task->save();
    }
    public function getOne(Request $request)
    {
        $test_task_id = $request->input('task_id','');
        if ($test_task_id) {
            $task=\App\Task::find($test_task_id);
        }
        else{
            $task = \App\Task::where('status',\App\Task::STATUS_QUEUE) ->orderBy('created_at', 'ASC')->first();
        }
        if ($task)
        {
            if ($test_task_id || \App\Task::where('id', $task->id)
                ->where('status', \App\Task::STATUS_QUEUE)
                ->update(['status' => \App\Task::STATUS_PROCESS])) {
                $data ['task'] =$task->toResponse(['sourceDetail'=>true,'args'=>true]);
                $data ['task']['finished_url'] = config('app.url').'/api/callback/task/finished';
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
