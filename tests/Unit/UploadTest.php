<?php

namespace Tests\Unit;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Result\Result;
use AlibabaCloud\Ecs\Ecs;
use AlibabaCloud\OssAdmin\OssAdmin;
use AlibabaCloud\Ram\Ram;
use AlibabaCloud\Sts\Sts;
use App\Oss;
use App\Resource;
use OSS\Core\OssException;
use OSS\OssClient;
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $sts = (new Oss())->getUoloadSts();

        $accessKeyId = $sts['AccessKeyId'];
        $accessKeySecret = $sts['AccessKeySecret'];//SecurityToken //Expiration
        $bucket = "coder5-ai";
        $object = "abc";
        $endpoint = "oss-cn-hongkong.aliyuncs.com";
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint,false,$sts['SecurityToken']);
            $content = "hello";
            $result = $ossClient->putObject($bucket, $object, $content);
            //$result = $ossClient->deleteObject($bucket, 'abc');
        } catch (OssException $e) {
            print $e->getMessage();
        }


    }

    public function testA()
    {
        $url = '';
        $client = new \GuzzleHttp\Client();
        $res = $client->request('get',$url,['timeout=>2','headers' => [
            'Accept'     => 'application/json',
        ]]);
        $res = $res->getBody();
        $data = json_decode($res->getContents(),true);
print_r($data);
        echo $data['ImageHeight']['value'];
        $data['ImageWidth'];

        $url = (new Oss())->getSignedObjectUrl('coder5-ai','20200412/repair/6f16999f-57e5-4edd-9c1c-0bad1659b2ad..jpg',null,3600,false,false,['x-oss-process'=>'image/info']);
        $url = (new Oss())->getSignedObjectUrl('coder5-ai','20200412/repair/6f16999f-57e5-4edd-9c1c-0bad1659b2ad..jpg',null,3600,false,false);
        print_r($url);
    }


}
