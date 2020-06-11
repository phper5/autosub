<?php
/**
 * zh-CHS2en	en2zh-CHS
zh-CHS2ja	ja2zh-CHS
zh-CHS2ko	ko2zh-CHS
zh-CHS2fr	fr2zh-CHS
 */

$file ="/home/white/b.srt";
$output = substr($file,0,-4)."_cn.srt";
echo $output;
$type=2;
$tr_type="AUTO";
$tr_type="en2zh-CHS";
$url = "http://fanyi.youdao.com/translate?&doctype=json&type=".$tr_type."&i=";
$str = file_get_contents($file);
//print_r($str);
$sentences = preg_split("/\n(\s)*\s/", $str);

$txt = [];
function get_data($url){

    $headers = ['Accept:image/webp,*/*','User-Agent:Mozilla/5.0 (X11; Linux x86_64; rv:74.0) Gecko/20100101 Firefox/74.0','Host:fanyi.youdao.com'];

      //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
//    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //执行命令
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
//    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
    return $data;
  }
foreach($sentences as $sentence)
{
    $line = explode("\n",$sentence);
    if (count($line)!=3 || is_numeric($line[2])) {
        $txt[]=$sentence;
        continue;
    }

    sleep(1);
    $trans_url = $url.rawurlencode($line[2]);
    echo $trans_url."\n";
    echo $line[2]."\n";

    $result = get_data($trans_url);//file_get_contents(($trans_url));
    $result = json_decode($result,true);
    $word = $result['translateResult'][0][0]['tgt'];
    echo $word."\n\n\n";
    if ($type == 2)
    {
        $txt[]=implode("\n",[$line[0],$line[1],$line[2],$word]);
    }else{
        $txt[]=implode("\n",[$line[0],$line[1],$word]);
    }

}
print_r($txt);
$myfile = fopen($output, "w");

fwrite($myfile, implode("\n\n",$txt));
fclose($myfile);




    //print_r($result);



