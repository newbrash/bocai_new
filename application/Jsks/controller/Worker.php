<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace app\Jsks\controller;
use think\Db;
use app\Jsks\controller\Index;
use Workerman\Worker as WorkerServer;
use think\worker\Server;
use workerman\lib\Timer;


/**
 * Worker 命令行服务类
 */
class Worker extends Server
{
        protected $time = 5;//定时结算游戏  

        protected $player=array();

        protected $heartTime = 10;//心跳时间间隔

        protected $dealTime = 60;//江苏快三60s一局

        protected $recentInfo = [] ; //最新五局游戏的色子

        protected $beginTime = 0; //每局游戏的开始时间

        protected $deskInfo = []; //牌桌信息

        protected $Index;//Index类对象

        protected $gameStatus = 0;//游戏开启状态

        protected $diceResult = [];//最近一局色子的所有结果的结算

        protected $gameHistory = [];//走势图以及开奖记录

        protected $orderPrefix = [];//订单号前缀

        protected $orderSuffix = 0;//订单号后缀
    /**
     * 架构函数
     * @access public
     * @param  string $host 监听地址
     * @param  int    $port 监听端口
     * @param  array  $context 参数
     */
    public function __construct($host, $port, $context = [])
    {
        $this->worker = new WorkerServer('websocket://' . $host . ':' . $port, $context);
        // 设置回调
        foreach ($this->event as $event) {
            if (method_exists($this, $event)) {
                $this->worker->$event = [$this, $event];
            }
        }
    }

    /**
     * 设置参数
     * @access public
     * @param  array    $option 参数
     * @return void
     */
    public function option(array $option)
    {
        // 设置参数
        if (!empty($option)) {
            foreach ($option as $key => $val) {
                $this->worker->$key = $val;
            }
        }
    }


public function onclose($connection){
    unset($this->player['connection'][$connection->id]);
    unset($this->player['time'][$connection->id]);

    echo $connection->id."  has been closed\n";
}


    /*
     * onMessage 事件回调
     * @access public
     * @param  \Workerman\Connection\TcpConnection    $connection
     * @param  mixed                                  $data
     * @return vpopmail_del_domain(domain)
     */
    public function onMessage($connection, $data)
    {
        /**
        *enterRoom
        */
        echo "-----onmessage-----json.data-----\n";
        file_put_contents("./player.json", $data);
        // echo $data."\n";
        $data = json_decode($data,true);
        // var_dump($data);
        echo "-----array.data-----\n";
        echo "\n";
        switch($data['type']){

            //心跳
            case "ping":
            $this->player['time'][$connection->id] = time();
            // $connection->send('{"code":"pong"}');
            break;

            //下注订单
            case "create" :
            //期号发生了变更
            if($data['bet']['issue']!=($this->gameHistory[0]['issue']+1)){
                $result = [
                    "code"=>"0",
                    "issue"=>$this->gameHistory[0]['issue']+1
                ];
                $connection->send(json_encode($result));
            }
            else{
                $orderNumber = ($this->gameHistory[0]['issue']+1).$this->orderPrefix[$data['bet']['type']].$this->orderSuffix;//生成订单号
                $this->orderSuffix++;
                $this->player['data'][$connection->id][$orderNumber] = $data['bet'];
                
                $this->Index->createOrder($data['bet'],$issue,$orderNumber);//生成订单
            }
            break;

            //撤销订单
            case "destroy":
            $this->Index->destroyOrder($data['order']);
            unset($this->player['data'][$connection->id][$order]);
            break;
            /*
            *dimention-first:走势图type = 'sum||basic'||开奖记录type = 'dice'  
            *dimention-second:size 记录条数
            */
            case "history" :
            $connection->send(json_encode(($this->gameHistory[$data['type']]['size'])));
            default:
            $result = '{"baga":"are you kidding me"}';
            break;
        }
    }


    public function onConnect($connection)
    {    
        echo "-----onconnect-----".$connection->id."\n";
        $this->player['connection'][$connection->id] = $connection;
        $this->player['time'][$connection->id] = time();
       
        //返回桌面信息   最近五局色子信息

        $data = [
            'gameStatus' =>$this->gameStatus,//游戏开启状态
            'recentInfo' =>$this->recentInfo,//最近五局游戏信息
            'deskInfo' =>$this->deskInfo, //牌桌信息
            // 'gameHistory'=>$this->gameHistory,//通过onmessage请求
            'countDown' => $this->dealTime - ($this->beginTime - time()) //开局倒计时
        ];
        $connection->send(json_encode($data));
    }                                       

//worker服务器启动时触发的函数
 public function onWorkerStart(){
    $this->Index = new Index();
    $this->player['issue'] = [];//订单书面信息
    $this->player['data'] = []; //押注玩家的信息
    $this->player['time'] = []; //用户的心跳数组
    $this->player['connection'] = [];   //用户的链接对象信息
    /*色子信息+牌桌信息=牌桌     游戏历史记录 = 走势图+开奖记录
    ** 新进入房间用户直接返回deskInfo+recentInfo+gameStatus+gameHistory+(倒计时 = beginTime+$this->dealTime-time())
    */
    $this->gameHistory = $this->Index->gameHistory();  //游戏历史记录
    file_put_contents('./player.json', "gameHistory------\n".json_encode($this->gameHistory)."\n",FILE_APPEND);

    $this->deskInfo = $this->Index->deskInfo();        //牌桌信息
    $this->recentInfo = $this->Index->recentInfo();    //最近五局色子信息
    $this->beginTime = time();              //游戏的开局时间
    $this->gameStatus = 0;     //游戏开启状态
    $this->orderSuffix = 1000;
    $this->orderPrefix = [ //订单号前缀
        "sum" =>'001', 
        "size"=>'002',
        "threeDiffrent"=>'003',
        "threeConAll"=>'004',
        "threeSameAll"=>'005',
        "threeSameSg"=>'006',
        "twoSameDb"=>'007',
        "twoSameSg"=>'008',
        "twoDiffrent"=>'009'
    ];
    // 定时检测心跳
    $this->worker->timer_id = Timer::add($this->time, function()
    {   
        $time = time();
        //更新用户的心跳时间
        if(!empty($this->player['time'])){
            foreach($this->player['time'] as $key => $vo){
                if(($this->player['time'][$key] + $this->time*3) < $time){
                    $this->player['connection'][$key]->close();
                }
                else{
                    $this->player['connection'][$key]->send('{"code":"pong"}');
                }   

            }
            //输出还在线的用户
            foreach($this->player['connection'] as $k => $vo){
                if(isset($this->player['connection'][$k])){
                    // $vo->send('online');
                    echo $k."-----is online\n";
                }
            }
        }
        else{
            echo "heart:no player online\n";
        }
    });
    //游戏开始，一分钟一局 同时把开启标志置1
    // if(self::gameBegin()){
        // $this->gameStatus = 1;

        $jsks_timer = Timer::add($this->dealTime, function()
        { 

            //更新开局时间，用于新加入用户倒计时计算
            $this->beginTime = time();

            //更新走势图，开奖结果，
            $this->gameHistory = $this->Index->gameHistory();
            
            // file_put_contents('./player.json', "gameHistory------\n".json_encode($this->gameHistory)."\n",FILE_APPEND);
            //更新最近五局游戏结果 色子图片
            $this->recentInfo = $this->Index->recentInfo();
            
            // file_put_contents('./player.json', "recentInfo------\n".json_encode($this->recentInfo)."\n",FILE_APPEND);
            //假如牌桌赔率变化频繁，此处应该更新牌桌信息
            // $this->deskInfo = $this->Index->deskInfo();

            //返回结果
            if(count($this->player['data']) > 0){
                //获取色子的计算结果
                $this->diceResult = $this->Index->diceResult();

                file_put_contents('./player.json', "diceResult------\n".json_encode($this->diceResult)."\n",FILE_APPEND);
                //获取游戏结果
                $result = $this->Index->begin($this->player['data'],$this->diceResult);

                file_put_contents('./player.json', "result------\n".json_encode($result)."\n",FILE_APPEND);
            }

            foreach($this->player['connection'] as $conId => $connection){
                //有玩家下注结果返回
                if(count($this->player['data']) > 0){

                    if(isset($this->player['data'][$conId])){
                        //押注玩家返回结算数据+最新游戏结果
                        $result[$conId]['diceImg'] = $this->recentInfo;//附加最近五局色子的图片
                        $connection->send(json_encode($result[$conId]));
                    }
                    //非押注玩家返回最新的游戏结果
                    else{
                        $connection->send(json_encode($this->recentInfo));
                    }

                }
                // 没有玩家押注直接返回最新的游戏结果
                else{
                    $connection->send(json_encode($this->recentInfo));
                }
            }

            //删除用户的押注表单信息 与玩家押注数据
            $this->player['data'] = [];
            $this->player['issue'] = [];
        });

        // 当天游戏结束去掉定时器并且把开启标志置零
        // if(self::gameOver()){
        //     $this->gamestatus = 0;
        //     Timer::del($game_timer);
        // }
    // }


}


    //判断游戏是否开始
    public function gameBegin(){

    }
    //判断游戏是否结束
    public function gameOver(){

    }
    /*
     * 启动
     * @access public
     * @return void
     */
    public function start()
    {
        WorkerServer::runAll();
    }

    /**
     * 停止
     * @access public
     * @return void
     */
    public function stop()
    {
        WorkerServer::stopAll();
    }
}
