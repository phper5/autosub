<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $incrementing = false;

    const STATUS_INIT = 0;
    const STATUS_QUEUE = 10;
    const STATUS_PROCESS = 20;
    const STATUS_PRCS = 22;
    const STATUS_ZM = 24;
    const STATUS_FINISH = 30;
    const STATUS_ERROR = -10;

    public function toResponse($config=[])
    {
        $data = [
            'status'=>$this->status,
            'progress'=>$this->progress,
            'task_id' => $this->id,
            'service' => $this->service,
        ];
        if ($this->status == self::STATUS_ZM){
            $data['progress'] = 10 + $data['progress']*0.9;
        }
        if ($data['progress']>100){
            $data['progress'] = 100;
        }
        if ($this->args){
            $args = json_decode($this->args,true);
        }else{
            $args=[];
        }
        if ((isset($config['sourceDetail']) && $config['sourceDetail']) || $this->status == self::STATUS_FINISH) {
            if ($resource = Resource::find($this->source_file))
            {

                $data['source_file'] = [$resource->toResponse([])];
            }
        }


        $data['args'] = $args;

        return $data;
    }
}
