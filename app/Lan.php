<?php


namespace App;


class Lan
{
    public static function getLanTxt($lan){
        $settings = config('lan.site');
        return $settings[$lan]??$lan;
    }
}
