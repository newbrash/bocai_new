<?php
namespace app\MyCommon\controller;

class Reptile
{
    public static function cqssc()
    {
        $numbers = [
            '201808200329021430' => 0,
            '201808200329022908' => 1,
            '201808200329023852' => 2,
            '201808200329024582' => 3,
            '201808200329025833' => 4,
            '201808200329026188' => 5,
            '201808200329027351' => 6,
            '201808200329028495' => 7,
            '201808200329029838' => 8,
            '2018082003290210496' => 9,
        ];
        $url = 'https://www.cjcp.com.cn/kaijiang/cqssc/';
        try{
            $info = self::httpRequest($url, 30);
            $info = mb_convert_encoding($info, 'utf-8', 'GB2312');
            $preg = '/<div class="info_list">[\s\S]*?<dl>([\s\S]*?)<\/dl>[\s\S]*?<\/div>/';
    
            $flag = preg_match_all($preg, $info, $res);
            if ($flag) {
                $flag = preg_match_all('/\d+|(^：\d)[\s\S]*?(?=<)/', $res[1][0], $res);
                if ($flag) {
                    $res = $res[0];
                    $time = $res[6].'-'.$res[7].'-'.$res[8].' '.$res[9].':'.$res[10].':'.$res[11];
                    $_open = [
                        'expect'=>$res[0],
                        'opencode'=>[
                            'wan'   =>  $numbers[$res[1]],
                            'qian'  =>  $numbers[$res[2]],
                            'bai'   =>  $numbers[$res[3]],
                            'shi'   =>  $numbers[$res[4]],
                            'ge'    =>  $numbers[$res[5]],
                        ],
                        'opentime'=>$time,
                        'opentimestamp'=>strtotime($time)
                    ];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }catch(\Exception $e){
            echo "cqssc api error:".$e->getMessage()." in file:".$e->getFile()." at line:".$e->getLine()."\ntring again...\n";
            $_open = self::cqssc();
        }
        return $_open;
    }
    /**
     * web请求数据
     * @param url 请求路径
     * @param data 请求参数
     * @param method 请求方式
     * @param time_out 请求超时时间
     * @param callback 回调方法
     */
    public static function httpRequest($url, $time_out = 5, $data='', $method='GET', $callback='')
    {
        if (!$url || $time_out <= 0) {
            return false;
        }
        $ch = curl_init();
        if (strtoupper($method)=='POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif ($data) {
            $url .= '?'.http_bulid_query($data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, (int)$time_out);
        curl_setopt($ch, CURLOPT_URL, (string)$url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_ENABLE_NPN, false);
        curl_setopt($ch, CURLOPT_SSL_ENABLE_ALPN, false);

        $info = curl_exec($ch);
        if ($callback) {
            $callback($info, $ch);
        }
        if ($info === false) {
            throw new \Exception('curl_errmsg:'.curl_errno($ch).":".curl_error($ch));
        }
        curl_close($ch);
        return $info;
    }
}
