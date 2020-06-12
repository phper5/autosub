<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $incrementing = false;

    const STATUS_INIT = 0;
    const STATUS_QUEUE = 10;
    const STATUS_PROCESS = 20;
    const STATUS_FINISH = 30;
    const STATUS_ERROR = -10;

    public function toResponse($config=[])
    {
        $data = [
            'status'=>$this->status,
            'progress'=>$this->progress,
            'task_id' => $this->id,
            'service' => $this->service,
            'target_file' => [],
            'source_file' => [],
        ];
        $options = [];
        if (isset($config['preview_width']) && $config['preview_width'])
        {
            $options['preview']=1;
            $options['preview_width'] = $config['preview_width'];
        }
        $args = json_decode($this->args,true);
        if ($this->sub1)
        {

            if ($this->sub1 && $resource = Resource::find($this->sub1))
            {
                $data['sub1'] = $resource->toResponse($options);
                $data['sub1']['lan_txt'] = Lan::getLanTxt($args['language']);
            }
        }
        if ( $args['is_need_trans'] && $this->sub2)
        {

            if ($this->sub2 && $resource = Resource::find($this->sub2))
            {
                $data['sub2'] = $resource->toResponse($options);
                $data['sub2']['lan_txt'] = Lan::getLanTxt($args['is_need_trans']);
            }
            if ($args['is_need_merge'] && $this->sub3)
            {

                if ($this->sub3 && $resource = Resource::find($this->sub3))
                {
                    $data['sub3'] = $resource->toResponse($options);
                    $data['sub3']['lan_txt'] = '合并字幕';
                }
            }
        }

        if ($this->mp3)
        {

            if ($this->mp3 && $resource = Resource::find($this->mp3))
            {
                $data['mp3'] = $resource->toResponse($options);
            }
        }
        if ((isset($config['sourceDetail']) && $config['sourceDetail']) || $this->target_file) {
            if ($resource = Resource::find($this->source_file))
            {

                $data['source_file'] = [$resource->toResponse($options)];
            }
        }

        $data['args'] = json_decode($this->args);

        return $data;
    }
}
