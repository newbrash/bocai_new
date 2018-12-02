<?php
namespace app\Cqssc\controller;

class Calodds
{
    protected static $_odds = 0;
    public static function odds($data)
    {
        self::$_odds = 0;
        switch ($data['type']) {
            case "wuxin":
                self::wuXing($data);
                break;
            case "daxiaodanshuang":
                self::daxiaodanshuang($data);
                break;
            case "dindanwei":
                self::dindanwei($data);
                break;
        }
        return self::$_odds;
    }


    /**
     * 五星
     */
    public static function wuXing($data)
    {
        switch ($data['leiXin']) {
            case "zhixuan":
                self::zhiXuan($data);
                break;
            case "wuxinzuxuan":
                self::zuXuan($data);
                break;
        }
    }

    /**
     * 大小单双
     */
    public static function daxiaodanshuang($data)
    {
        switch ($data['leiXin']) {
            case "zonghe":
                self::zonghe($data);
                break;
            case "dingwei":
                self::dingwei($data);
                break;
            case "chuangguan":
                self::chuanguan($data);
                break;
        }
    }


    /**
     * 直选
     */
    public static function zhiXuan($data)
    {
        switch ($data['name']) {
            case "fushi":
                self::fuShi($data);
                break;
            case "danshi":
                self::danShi($data);
                break;
            case "zuhe":
                self::zuHe($data);
                break;
        }
    }

    /**
     * 组选
     */
    public static function zuXuan($data)
    {
        switch ($data['name']) {
            case "zuxuan120":
                self::zuxuan120($data);
                break;
            case "zuxuan60":
                self::zuxuan60($data);
                break;
            case "zuxuan30":
                self::zuxuan30($data);
                break;
            case "zuxuan20":
                self::zuxuan20($data);
                break;
            case "zuxuan10":
                self::zuxuan10($data);
                break;
            case "zuxuan5":
                self::zuxuan5($data);
                break;
        }
    }


    /**
     * 定位胆
     */
    public static function dindanwei($data)
    {
        self::$_odds = $data['odds'];
    }

    /**
     * 总和
     */
    public static function zonghe($data)
    {
        self::$_odds = $data['odds'];
    }

    /**
     * 大小单双之定位
     */
    public static function dingwei($data)
    {
        self::$_odds = $data['odds'];
    }
    /**
     * 串关
     */
    public static function chuanguan($data)
    {
        $n = 0;
        foreach ($data['number'] as $key => $vo) {
            if(!empty($vo)){
                $n++;
            }
        }
        if($n){
            self::$_odds = pow($data['odds'], $n);
        }else{
            self::$_odds = $data['odds'];
        }
    }

    
    public static function fuShi($data)
    {
        self::$_odds = $data['odds'];
    }
    public static function danShi($data)
    {
        self::$_odds = $data['odds'];
    }
    public static function zuHe($data)
    {
        $n = self::stars($code, $data['number']);
        if ($n) {
            $odds = explode('~', $data['odds']);
            $b = pow((intval($odds[0]) / intval($odds[1])), 1/5);
            $_odds = 0;
            switch ($n) {
                case 5:
                    $_odds += intval($odds[0]);
                    // no break
                case 4:
                    $_odds += intval($odds[1]) * pow($b, 3);
                    // no break
                case 3:
                    $_odds += intval($odds[1]) * pow($b, 2);
                    // no break
                case 2:
                    $_odds += intval($odds[1]) * pow($b, 1);
                    // no break
                case 1:
                    $_odds += intval($odds[1]);
                    break;
                default:
            }
            self::$_odds = $_odds;
        } else {
            self::$_odds = $data['odds'];
        }
    }

    // 判断几星组合
    public static function stars($code, $data)
    {
        $n = 0;
        if (in_array($code['ge'], $data[0])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['shi'], $data[1])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['bai'], $data[2])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['qian'], $data[3])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['wan'], $data[4])) {
            $n++;
        }
        return $n;
    }

    public static function zuxuan120($data)
    {
        self::$_odds = $data['odds'];
    }

    public static function zuxuan60($data)
    {
        self::$_odds = $data['odds'];
    }

    public static function zuxuan30($data)
    {
        self::$_odds = $data['odds'];
    }

    public static function zuxuan20($data)
    {
        self::$_odds = $data['odds'];
    }

    public static function zuxuan10($data)
    {
        self::$_odds = $data['odds'];
    }

    public static function zuxuan5($data)
    {
        self::$_odds = $data['odds'];
    }
}
