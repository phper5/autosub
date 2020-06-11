<?php


namespace App\Api\Callback;


use App\Resource;

class ResourceController
{
    public function payment($id){
        if ($reource = Resource::find($id))
        {
            $reource->is_payed= 1;
            $reource->save();
            return [
                'success'=>1
            ];
        }
        return [
            'notfound'
        ];
    }
}
