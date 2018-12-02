<?php
namespace app\Cqssc\controller;

use Workerman\lib\Timer;
use app\MyCommon\controller\Game;
// use think\facade\Config;
use app\MyCommon\controller\Gameapi;
use app\Server\controller\Deal;
use app\Server\controller\Redis;
use app\MyCommon\controller\Reptile;

// use app\Cqssc\controller;

class Cqssc extends Game
{
    /**
     * 当天晚上 22:00:00
     */
    protected $night = null;
    /**
     * 当天早上 10:00:00
     */
    protected $morning = null;
    /**
     * 最后一次开奖期数
     */
    protected $last_expect = null;
    /**
     * 定时器句柄
     */
    protected $timer_interval = null;
    /**
     * 定时器的时间间隔
     */
    protected $timer_int = 10 * 60;
    /**
     * 定时器的回调函数的参数
     */
    protected $timer_argv = array();
    /**
     * true：表示一直执行，false：表示执行一次
     */
    protected $timer_persistent = true;

    /**
     * 最后一次开奖的信息
     */
    protected $last_open = null;

    protected $begin = true;


    public function begin()
    {
        if ($this->timer_interval) {
            echo "cqssc(".date('Y-m-d H:i:s')."): initing Timer...\n";
            Timer::del($this->timer_interval);
            $this->timer_interval = null;
        }
        $res = $this->isReady();
        if ($res) {
            // $this->timer_int = $res['expire'];
            // $this->last_expect = $this->last_open['expect'];
            if ($res['next']) {
                echo Deal::iconv("cqssc(".date("Y-m-d H:i:s")."): 开奖结果：".implode(',', $this->last_open['opencode'])."; 期号：".$this->last_open['expect']."; 开奖时间：".$this->last_open['opentime']."\ncqssc(".date("Y-m-d H:i:s")."): 开奖时间间隔：".$this->timer_int."秒，下次开奖时间为".$res['next']."秒后!\n");
                sleep($res['next']);
                echo "cqssc(".date("Y-m-d H:i:s")."): open timer at ".date("Y-m-d H:i:s")."\n";
                $this->timer_interval = Timer::add($this->timer_int, array($this, 'settlement'), $this->timer_argv, $this->timer_persistent);
            }
            $this->settlement();
        } else {
            echo Deal::iconv('cqssc('.date("Y-m-d H:i:s").'): 重庆时时彩：无法获取开奖时间间隔！\n');
        }
    }

    public function isReady()
    {
        echo "cqssc(".date('Y-m-d H:i:s')."): preparing for the game...\n";
        echo "cqssc(".date('Y-m-d H:i:s')."): geting opencode...\n";
        // 获取开奖历史
        $opencode = self::getOpenCode(true);
        if ($opencode) {
            echo "cqssc(".date('Y-m-d H:i:s')."): initing time setting...\n";
            $this->night = strtotime(date("Y-m-d")." 22:00:00");
            $this->morning = strtotime(date('Y-m-d')." 10:00:00");

            echo "cqssc(".date('Y-m-d H:i:s')."): calculating time interval...\n";
            if (time() >= $this->night) {
                $this->timer_int = 5 * 60;
            }

            echo "cqssc(".date('Y-m-d H:i:s')."): Calculate the next prize opening time...\n";
            $passtime = time() - $opencode['opentimestamp'];
            if ($passtime >= ($this->timer_int)) {
                $nextTime = 0;
            } else {
                $nextTime = $this->timer_int - $passtime;
                if ($nextTime < 0) {
                    $nextTime = ($nextTime % $time) + $time;
                }
            }
            echo "cqssc(".date('Y-m-d H:i:s')."): init setting...\n";
            $this->last_expect = $opencode['expect'];
            $this->last_open = $opencode;
            $opencode['timer_int'] = $this->timer_int;
            echo "cqssc(".date('Y-m-d H:i:s')."): saving open result to redis...\n";
            Redis::set(['cqssc_last_open'=>json_encode($opencode)]);
            return [
                // 'expire'=>$time,
                'next'=>$nextTime,
                // 'last_times'=>$opencode,
            ];
        } else {
            return false;
        }
    }

    // 结算
    public function settlement()
    {
        echo "cqssc(".date("Y-m-d H:i:s")."): Now is time to calculate....\n";
        echo "cqssc(".date("Y-m-d H:i:s")."): getting opencode....\n";
        // 获取开奖结果
        $opencode = $this->getOpenCode();
         
        echo "cqssc(".date("Y-m-d H:i:s")."): saving open result to db....\n";
        // 保存开奖结果
        Dbop::saveOpenResult($opencode);
        echo "cqssc(".date("Y-m-d H:i:s")."): checking time interval....\n";
        if (time() > $this->night) {
            // 晚上十点之后，没两次开奖时间间隔变成5分钟
            $this->timer_int = 5 * 60;
            // 清除定时器
            Timer::del($this->timer_interval);
            $this->timer_interval = null;
        }
        // 更新redis的开奖信息
        echo "cqssc(".date("Y-m-d H:i:s")."): update redis the opened information....\n";
        $opencode['timer_int'] = $this->timer_int;
        Redis::set(['cqssc_last_open'=>json_encode($opencode)]);
        // 获取下注信息
        echo "cqssc(".date("Y-m-d H:i:s")."): getting users's bets information....\n";
        $betsInfo = Dbop::getBetsInfo($opencode['expect']);
        echo "cqssc(".date("Y-m-d H:i:s")."): settlementing....\n";
        // 计算结果
        $result = Calculate::settlement($opencode['opencode'], $betsInfo);
        echo "cqssc(".date("Y-m-d H:i:s")."): pushing opencode to users....\n";
        // 所有客户端推送开奖结果
        $this->openReult([
            'issue'=>($this->last_expect + 1),
            'countdown'=>$this->begin ? [
                'shijiancuo'=>($this->last_open['opentimestamp']+$this->timer_int),
                'zifuchuan'=>date("Y-m-d H:i:s", ($this->last_open['opentimestamp']+$this->timer_int))
            ] : null,
            'recentInfo'=>Dbop::recentInfo(),
            'result'=>$result,
        ]);
        if($this->begin){
            $this->begin = false;
        }
        // 服务器端展示开奖信息
        $passtime = time() - $opencode['opentimestamp'];
        echo "cqssc(".date("Y-m-d H:i:s")."): has pass $passtime s\n";
        echo Deal::iconv("cqssc(".date('Y-m-d H:i:s')."): 开奖结果：".implode(',', $opencode['opencode'])."; 期号：".$opencode['expect']."; 开奖时间：".$opencode['opentime']."\n");
        if ($passtime >= $this->timer_int) {
            echo Deal::iconv("cqssc(".date("Y-m-d H:i:s")."): 开奖时间间隔：".$this->timer_int."秒，进入下一次开奖...!\n");
            // 结算
            $this->settlement();
        } else {
            echo "cqssc(".date("Y-m-d H:i:s")."): calculating the next prize open time...\n";
            $next = $this->timer_int - $passtime;
            if ($next < 0) {
                $next = ($next % $this->timer_int) + $this->timer_int;
            }
            echo Deal::iconv("cqssc(".date("Y-m-d H:i:s")."): 开奖时间间隔：".$this->timer_int."秒，下次开奖时间为".$next."秒后!\n");
            if (!$this->timer_interval) {
                // 启动定时器
                if ($next) {
                    sleep($next);
                }
                echo "cqssc(".date("Y-m-d H:i:s")."): open timer at ".date('Y-m-d H:i:s')."!\n";
                $this->timer_interval = Timer::add($this->timer_int, array($this, 'settlement'), $this->timer_argv, $this->timer_persistent);
                $this->settlement();
            }
        }
    }
 

    /**
     * 关闭时执行的方法
     */
    public function close()
    {
        Timer::del($this->timer_interval);
    }
    // 获取信息
    public function dataProcer($param)
    {
        dump($param);
        switch ($param['type']) {
            case "deskInfo":
                return $this->getOdds($param);
                break;
            case "dingDanWei":
            case "daxiaodanshuang":
                return $this->getTrendChart($param);
                break;
            case "create":
                return $this->bets($param);
                break;
            case "betHistory":
                return $this->betHistory($param);
                break;
            default:
                return [
                    'type'=>'error',
                    'errmsg'=>'无法找到对应的处理函数！'
                ];
        }
    }


    public function betHistory($data)
    {
        return Dbop::betHistory($data);
    }
    /**
     * 获取走势图
     */
    public function getTrendChart($data)
    {
        $result = Dbop::trendChart($data['weishu'], $data['size']);
        return [
            'type'=>$data['weishu'],
            'trendInfo'=>$result,
        ];
    }
    /**
     * 获取所有玩法和相应的赔率并且格式化返回
     */
    public function getOdds($data)
    {
        $last_open = json_decode(Redis::get('cqssc_last_open'), true);
        if (!$last_open) {
            return [
                'code'=>'游戏还没有开启',
            ];
        }
        // dump($last_open);
        $nextTime = $last_open['opentimestamp'] + $this->timer_int;
        if ($nextTime < time()) {
            $beginTime = strtotime(date('Y-m-d')." 10:00:00");
            $timeToOpen = $beginTime - time();
        }
        // 获取最新版本号
        $path = __ROOT__.'public'.DS.'game-version.json';
        $version = json_decode(file_get_contents($path), true);
        if ($data['version'] != $version[$data['game']]) {
            // 获取赔率信息
            $info =  Dbop::getOdds($data);
            $info['version']=$version[$data['game']];
            return [
                'type'=>'gameOdds',
                'deskInfo'=>$info,
                'interval'=>$last_open['timer_int'],
                'issue'=>($last_open['expect'] + 1),
                'countdown'=>!isset($timeToOpen) || !$timeToOpen ? [
                    'shijiancuo'=>$nextTime,
                    'zifuchuan'=>date("Y-m-d H:i:s", $nextTime)
                ] : null,
                'recentInfo'=>Dbop::recentInfo(),
                'wait_time'=>isset($timeToOpen)&&$timeToOpen ? $timeToOpen : null,
            ];
        } else {
            return [
                'type'=>'gameOdds',
                'version'=>$version[$data['game']],
                'interval'=>$last_open['timer_int'],
                'issue'=>($last_open['expect'] + 1),
                'countdown'=>!isset($timeToOpen) || !$timeToOpen ? [
                    'shijiancuo'=>$nextTime,
                    'zifuchuan'=>date("Y-m-d H:i:s", $nextTime)
                ] : null,
                'recentInfo'=>Dbop::recentInfo(),
                'wait_time'=>isset($timeToOpen)&&$timeToOpen ? $timeToOpen : null,
            ];
        }
    }

    // 下注
    public function bets($param)
    {
        // 获取最后一期信息
        $last_open = json_decode(Redis::get('cqssc_last_open'), true);
        if (!$last_open) {
            return [
                'code'=>'游戏还没有开启'
            ];
        } elseif ($param['issue'] != ($last_open['expect']+1)) {
            return [
                'code'=>'期号发生了变更',
                'issue'=>($last_open['expect']+1)
            ];
        }
        $data = Format::format($param);
        if (!$data) {
            return [
                'create'=>false,
                'errmsg'=>'创建订单失败',
                'issue'=> ($last_open['expect']+1)
            ];
        }
        $result = Dbop::saveBets($data);
        $result['issue'] = ($last_open['expect']+1);
        return $result;
    }

   
    /**
     * 获取开奖结果
     */
    public function getOpenCode($flag = false)
    {
        if (!$flag) {
            echo "cqssc(".date("Y-m-d H:i:s")."): checking the game whether is begin....\n";
            if ((time()-$this->last_open['opentimestamp']) > (2 * $this->timer_int) &&  time() < $this->morning) {
                echo "cqssc(".date("Y-m-d H:i:s")."): there is ".($this->morning - time())."s to begin the game....\n";
                sleep($this->morning - time());
            }
        }
        // $opencode = Gameapi::gameData_1('cqssc', 1);
        $opencode = Reptile::cqssc();
        if ($opencode) {
            if ($opencode['expect'] > $this->last_expect) {
                echo "cqssc(".date("Y-m-d H:i:s")."): get opencode (ok)\n";
                $this->last_expect = $opencode['expect'];
                $this->last_open = $opencode;
            } else {
                if (!$flag) {
                    echo Deal::iconv("cqssc(".date('Y-m-d H:i:s')."): 获奖结果为：（期号：".$opencode['expect']." 号码：".implode(',', $opencode['opencode'])." 开奖时间：".$opencode['opentime']."）\n");
                    echo "cqssc(".date("Y-m-d H:i:s")."): trying to get the opencode again...\n";
                    sleep(5);
                    $opencode = $this->getOpenCode();
                }
            }
        } else {
            echo Deal::iconv("cqssc(".date('Y-m-d H:i:s')."): 获取结果为：NULL\n");
            echo "cqssc(".date("Y-m-d H:i:s")."): trying to get the opencode again...\n";
            sleep(5);
            $opencode = $this->getOpenCode();
        }
        return $opencode;
    }
}
