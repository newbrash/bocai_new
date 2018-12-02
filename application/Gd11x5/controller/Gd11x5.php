<?php
namespace app\Gd11x5\controller;

use think\Db;
use app\MyCommon\controller\Game;
use Workerman\Lib\Timer;
use app\MyCommon\controller\Mytimer;
use app\MyCommon\controller\Gameapi;
use app\Server\controller\Deal;

class Gd11x5 extends Game
{
    /**
     * 定时器句柄
     */
    protected $timer_int = null;

    /**
     * 定时器的执行时间间隔
     */
    protected $time_interval = 1;

    /**
     * 定时器回调函数的参数
     */
    protected $timer_argv = array();

    /**
     * true：持久化，false：执行一次
     */
    protected $timer_persistent = true;

    public function begin()
    {
        echo "Gd11x5 is begining...\n";
        $result = $this->isReady();
        $this->time_interval = $result['normal'];
        echo Deal::iconv("开奖时间间隔为：".$this->time_interval."s\n");
        if ($result['sleep']) {
            echo Deal::iconv("离下一次开奖还有".$result['sleep']."s\n");
            sleep($result['sleep']);
        }
        $this->settlement();
        $this->timer_int = Timer::add($this->time_interval, array($this, 'settlement'), $this->timer_argv, $this->timer_persistent);
    }


    /**
     * 检查当前时间是否为开奖时间，如果是则返回开奖时间间隔，如果不是，则睡眠，等待下一次开奖时间，然后开启游戏结算统计
     */
    public function isReady()
    {
        echo "checking...\n";
        $info = Gameapi::getGameData('gd11x5', 5);
        $a[] = $info['data'][0]['opentimestamp'] - $info['data'][1]['opentimestamp'];
        $a[] = $info['data'][1]['opentimestamp'] - $info['data'][2]['opentimestamp'];
        $a[] = $info['data'][2]['opentimestamp'] - $info['data'][3]['opentimestamp'];
        $a[] = $info['data'][3]['opentimestamp'] - $info['data'][4]['opentimestamp'];
        // 统计数组中所有值出现的次数
        $a = array_count_values($a);
        arsort($a); //键值对降序排序（asort按键值对升序排序，krsort按键值降序排序）
        reset($a); //将数组的内部指针指向第一个单元
        $time_interval = key($a); //获取当前指针的键值（开奖时间间隔）
        // 计算离下一次开奖时间的时间差
        $next_time_interval = $time_interval - (time() - $info['data'][0]['opentimestamp']);
        if ($next_time_interval < 0) {
            $next_time_interval = ($time_interval + $next_time_interval) % $time_interval;
        } elseif ($next_time_interval > 0) {
            $next_time_interval = ($time_interval - $next_time_interval) % $time_interval;
        }
        return [
            'normal'=>$time_interval,
            'sleep'=>$next_time_interval
        ];
    }


    public function close()
    {
        Timer::del($this->timer_int);
    }



    /**
     * 获取信息请求处理
     * @param arr $param
     */
    public function getInfos($param)
    {
        // 判断请求类型
        switch ($param['request_type']) {
            case "getOdds":
                // 获取赔率
                return $this->getOdds();
                break;
            default:
                return [
                    'type'=>'error',
                    'errmsg'=>'请求类型错误。。。'
                ];
        }
    }


    /**
     * 下注信息处理
     */
    public function bets($param)
    {
        dump($param);
    }

    /**
     * 计算方法入口
     */
    public function settlement()
    {
        echo "Gd11x5:Now is time to open result! The time is ".date('Y-m-d H:i:s')."\n";

        $this->send(['type'=>'settlement','msg'=>'测试数据']);
    }

    /**
     * 获取所有玩法和相应的赔率并且格式化返回
     */
    public function getOdds()
    {
        $list = DB::name('gd11x5_odds')->select();
        $res = [];
        foreach ($list as $key => $vo) {
            $vo['options'] = $this->product($vo);
            $res[$vo['play_type']][$vo['type']][] = $vo;
        }
        return [
            'type'=>'gameOdds',
            'odds'=>$res
        ];
    }

    public function product($data)
    {
        switch ($data['play_type']) {
            case "三码":
                switch ($data['type']) {
                    case "前三直选":
                        switch ($data['option_name']) {
                            case "复式":
                                break;
                            case "单式":
                                break;
                        }
                        break;
                    case "前三组选":
                        switch ($data['option_name']) {
                            case "复式":
                                break;
                            case "单式":
                                break;
                        }
                        break;
                }
                break;
            case "二码":
                switch ($data['type']) {
                    case "前二直选":
                        switch ($data['option_name']) {
                            case "复式":
                                break;
                            case "单式":
                                break;
                        }
                        break;
                    case "前二组选":
                        switch ($data['option_name']) {
                            case "复式":
                                break;
                            case "单式":
                                break;
                        }
                        break;
                }
                break;
            case "不定胆":
                switch ($data['type']) {
                    case "不定胆":
                        switch ($data['option_name']) {
                            case "前三位":
                                break;
                        }
                        break;
                }
                break;
            case "定位胆":
                switch ($data['type']) {
                    case "定位胆":
                        switch ($data['option_name']) {
                            case "定位胆":
                                break;
                        }
                        break;
                }
                break;
            case "任选":
                switch($data['type']){
                    case "任选复式":
                        switch($data['option_name']){
                            case "一中一":
                                break;
                            case "二中二":
                                break;
                            case "":
                                break;
                        }
                        break;
                    case "任选单式":
                        break;
                }
                break;
        }
    }
}
