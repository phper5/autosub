<?php
namespace App;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Sts\Sts;
use OSS\OssClient;

class Oss
{
    public function getBucket()
    {
        $bucket =  config('oss.buckets')['coder5-shenzhen'];
        $bucket['bucket_name'] = 'coder5-shenzhen';
        return $bucket;
    }
    public function buildCallbackUrl($params=[]) {
        $body = 'bucket=${bucket}&object=${object}&etag=${etag}&size=${size}&mime_type=${mimeType}&image_height=${imageInfo.height}&image_width=${imageInfo.width}&image_format=${imageInfo.format}';
        foreach ($params as $key => $val)
        {
            $body.='&x_'.$key.'='.$val;
        }
        $url = [
            'callbackUrl'=>config('oss.callback_url'),
            'callbackBody'=>$body,
            'callbackBodyType'=>'application/x-www-form-urlencoded'
        ];

        return $url;
        //return .'&transmission_id='.$transmission_id;
    }
    public function getUoloadSts() {
        //构建阿里云client时需要设置AccessKey ID和AccessKey Secret
        $bucket = $this->getBucket();
        AlibabaCloud::accessKeyClient(config('oss.access_key'),config('oss.secret_key'))->regionId($bucket['region_id'])->asDefaultClient();
        /**
         * @var $upload Result
         */
        $upload = Sts::v20150401()
            ->assumeRole()
            //指定角色ARN
            ->withRoleArn('acs:ram::1143353861681511:role/ossupload')
            //RoleSessionName即临时身份的会话名称，用于区分不同的临时身份
            ->withRoleSessionName('client_name')
            //设置Policy以进一步限制角色的权限
            //以下权限策略表示拥有所有OSS的只读权限
//            ->withPolicy('{
//             "Statement":[
//                {
//                     "Action":
//                 [
//                     "oss:Get*",
//                     "oss:List*"
//                     ],
//                      "Effect": "Allow",
//                      "Resource": "*"
//                }
//                   ],
//          "Version": "1"
//        }')
            ->connectTimeout(60)
            ->timeout(3600)
            ->request();
        $data = $upload->toArray();
        return ($data['Credentials']);
    }

    public function getKeys()
    {
        return [
            'access_id'=>config('oss.access_key'),
            'access_secret'=>config('oss.secret_key')
        ];
    }
    public function getSignedObjectUrl($bucket_name, $object, $resize_width = 0,$time=null,$usedCDN=false,$auto_orient=1,$options=[])
    {
        $auth = $this->getKeys();
        $bucket = $this->getBucket();
        $ossClient = new OssClient($auth['access_id'], $auth['access_secret'],$bucket['endpoint']);
        $ossClient->setUseSSL(true);
        //$options = null;
        if ($resize_width)
        {
            if ($auto_orient)
            {
                $style = 'image/resize,m_lfit,w_'.$resize_width."/auto-orient,1";
//                if ($resize_width == 160 || $resize_width == 1080) {
//                    $style='style/'.$resize_width.'p';
//                }
            }
            else{
                $style = 'image/resize,m_lfit,w_'.$resize_width."/auto-orient,0";
            }

            $options[OssClient::OSS_PROCESS] =  $style;//image/resize,m_lfit,w_$resize_width  //x-oss-process=style/160p
        }else{
            if ($auto_orient) {
                $style = 'image/auto-orient,1';
            }
        }
        if (isset($options['download_as']))
        {
            $options[OssClient::OSS_CONTENT_DISPOSTION] =  'attachment; filename="'.$options['download_as'].'"';
            unset($options['download_as']);
        }
        if (!$time) {
            $time = 3600;
        }
        $signedUrl = $ossClient->signUrl($bucket_name, $object, $time, OssClient::OSS_HTTP_GET, $options);;//echo $signedUrl."\n";

        if( !$usedCDN){
            return $signedUrl;
        }
//        $uri = parse_url($signedUrl);
//        // print_r($uri);
//        $object = $uri['path'];
//        $auth_args = self::getAliyunCDNAuthHash($object,$bucket->getCDNAuthKey(),$time);
//        $signedUrl = "https://{$bucket->getCdnDomain()}{$object}?auth_key={$auth_args}";//echo $signedUrl;exit;
//        // $signedUrl = "https://{$bucket->getCdnDomain()}{$object}?auth_key={$auth_args}&".$uri['query']??'';echo $signedUrl;exit;
//        if ($resize_width)
//        {
//            if ($auto_orient)
//            {
//                if ($resize_width == 'jpg')
//                {
//                    $signedUrl.='&x-oss-process=image/format,jpg';
//                }elseif ($resize_width == 160 || $resize_width == 1080)
//                {
//                    $signedUrl.='&x-oss-process=style/'.$resize_width.'p';
//                }
//                else{
//                    $signedUrl.='&x-oss-process=image/resize,m_lfit,w_'.$resize_width.'/auto-orient,1';
//                }
//            }else{
//                if ($resize_width == 'jpg')
//                {
//                    $signedUrl.='&x-oss-process=image/format,jpg';
//                }
//                else{
//                    $signedUrl.='&x-oss-process=image/resize,m_lfit,w_'.$resize_width.'/auto-orient,0';
//                }
//            }
//
//        }
//        return $signedUrl;
    }
}
