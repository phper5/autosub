<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public $incrementing = false;


    public  function toResponse($options=[])
    {
        $auto_orient = true;
        $usedCdn = false;
        $data = [
            'resource_id'=>$this->id,
            'type'=>$this->type,
            'filename'=>$this->filename,
            'size'=>$this->size,
            'bucket'=>$this->bucket,
            'object'=>$this->object,
            'is_payed'=>$this->is_payed,
            'created_at'=>$this->created_at->timestamp,
            'url' => $this->getUrl(null,null,$auto_orient,false,['download_as'=>$this->filename])
        ];
        $max_width = null;

//        if ($this->type == 'image')
//        {
//            $json = json_decode($this->attrs,true);
//            $data['image_height'] = $json['image_height']??0;
//            $data['image_width'] = $json['image_width']??0;
//            if ($this->is_payed)
//            {
//                $data['image_original_url'] = $this->getUrl(null,3600,$auto_orient,$usedCdn);
//            }
//        }
        return $data;
    }
    public function getUrl($width=null,$time=null,$auto_orient=1,$usedCdn=false,$options=[])
    {


        if ($this->type =='image')
        {
            $url = (new Oss())->getSignedObjectUrl($this->bucket,$this->object,$width,$time,$usedCdn,$auto_orient,$options);
        }elseif ($this->type =='audio')
        {
            $url = (new Oss())->getSignedObjectUrl($this->bucket,$this->object,null,$time,$usedCdn,$auto_orient);
        }
        elseif ($this->type == 'video') {
            $url =  (new Oss())->getSignedObjectUrl($this->bucket,$this->object,null,$time,$usedCdn,$auto_orient);
        }
        else{
            $url = (new Oss())->getSignedObjectUrl($this->bucket,$this->object,null,$time,$usedCdn,$auto_orient);
        }
        return $url;
    }
}
