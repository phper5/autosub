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
            'language'=>$this->language,
            'lan_txt' => Lan::getLanTxt($this->language),
            'created_at'=>$this->created_at->timestamp,
            'url' => $this->getUrl(null,null,$auto_orient,false,['download_as'=>$this->filename])
        ];
        if (isset($options['flac'])&&$options['flac']) {
            $flac_id = 0;
            if (isset($this->flac)){
                $flac_id = $this->flac;
            }elseif (isset($this->ogg)){
                $flac_id = $this->ogg;
            }elseif (isset($this->mp3)){
                $flac_id = $this->mp3;
            }elseif (isset($this->wav)){
                $flac_id = $this->wav;
            }
            if ($flac_id) {
                $flac = Resource::find($flac_id);
                $data['flac'] = $flac->toResponse();
            }
        }
        if (isset($options['preview'])&&$options['preview']) {

            if (isset($this->mp4)){
                if ($mp4 = Resource::find($this->mp4))
                {
                    $data['mp4'] = $mp4->toResponse();
                }
            }
            if (isset($this->ogg)){
                if ($mp4 = Resource::find($this->ogg))
                {
                    $data['ogg'] = $mp4->toResponse();
                }
            }
            if (isset($this->mp3)){
                if ($mp4 = Resource::find($this->mp3))
                {
                    $data['mp3'] = $mp4->toResponse();
                }
            }
            if (isset($this->wav)){
                if ($mp4 = Resource::find($this->wav))
                {
                    $data['wav'] = $mp4->toResponse();
                }
            }
        }
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
