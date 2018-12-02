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
namespace app\Sangong\controller;
use think\Db;
use app\Sangong\controller\Index;
use app\Sangong\controller\Abnormal;
use Workerman\Worker as WorkerServer;
use think\worker\Server;
use workerman\lib\Timer;

/**
 * Worker 命令行服务类
 */
class Worker extends Server
{
        protected $worker;
        protected $app;
        protected $i = 0;
        protected $player=array();
        protected $time = 10;//心跳时间间隔
        /*
           $beginTime : 发牌时间     
        */
        protected $beginTime = 0;//开局时间

        protected $dealTime = 20;//每一局时间长度

        protected $account = 8;//结算时间
        protected $Abnormal;

        protected $lastInfo = "" ; //最新一局游戏的信息
        protected $dealDown = 0; //押注倒计时
        
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
        * 三公的socket接口
        * 一 ：enter()入口  返回结果 0:没有资格进入房间 否则:牌桌详情
        * 二 ：play() 玩家下注 返回由Index.php处理函数的结果
        * 三 ：
        */
        echo "-----onmessage-----json.data-----\n";
        file_put_contents("./player.json", $data);
        echo $data."\n";
        $data = json_decode($data,true);
        var_dump($data);
        echo "-----array.data-----\n";
        echo "\n";
        switch($data['type']){
            //加入房间 code2
            case "enterRoom":
            $result['roomInfo'] = $this->Abnormal->enterRoom();
            $result['code'] = 2;
            break;
            //牌桌初始化工作 
            case "enterDesk":
            echo $connection->id."  clickDesk ".$data['desk'];
            // if($this->beginTime + $this->dealTime - time()<=5){ //结算期间新加入的用户接收不到信息
            //     $result = [
            //         "code"=> 999
            //     ];
            //     $result = $this->Abnormal->enterDesk($data); //code:0金币或者积分不足  1可以进入房间
            // }
            // else{
            //     $result = $this->Abnormal->enterDesk($data); //code:0金币或者积分不足  1可以进入房间
            //     if($result['code']==1){
            //         $this->player['enterDesk'][$connection->id] = 1; 
            //     }
            // }
            $lastInfo = $this->lastInfo;
            file_put_contents("./player.json", json_encode($lastInfo));
            $result = $this->Abnormal->enterDesk($data); //code:0金币或者积分不足  1可以进入房间
            $result["account"] = (time() - $this->beginTime) >= $this->account ? 0 : $lastInfo;//倒计时
            $result['accountDown'] = $this->account - (time() - $this->beginTime);//结算倒计时
            //结算结束  开牌倒计时 = 最新的倒计时 其它情况=14
            $result["countDown"] = $result['accountDown']>=0?$this->dealDown:$this->dealDown + $result['accountDown']-1;
            $this->player['enterDesk'][$connection->id] = 1;
            //在结算期间进入房间
            break;
            //倒计时
            case "play":
            echo "-----player-----".$connection->id."-----has-----played-----\n";
            $this->player['data'][$connection->id] = $data;
            $result = [
                "code"=>6 //返回一个押注成功的信号
            ];
            // echo "Client->".$connection->id." play the Game in room: ".$data['room'];
            break;
            //玩家进入牌桌请求倒计时
            // case "countDown":
            // $lastInfo = json_encode($this->lastInfo);
            // $result = [
            //     "countDown" => $this->beginTime + $this->dealTime-1-time(),
            //     "account" => (time() - $this->beginTime) >= $this->account ? 0 : $lastInfo,
            //     "code"=>7
            // ];
            // break; 
            case "leaveDesk":
            unset($this->player['enterDesk'][$connection->id]);
            $result = [
                "code"=>8
            ];
            break; 
            default:
            $result = '{"baga":"are you kidding me"}';
            break;
        }
        $result = json_encode($result);
        file_put_contents("./player.json", $result);
        $connection->send($result);
    }

//让结算完毕得还在线的金币最高的玩家当庄家
 public function nextBanker(){
    foreach($this->player['connection'] as $conId=>$vo){
        if($this->player['data'][$conId]){
            $online[$conId] = Db::name('user_user')->field('id,gold')->where(['id'=>$this->player['data'][$conId]['id']])->find();
        }
        
    }
    $online = array_values($online);
    $online = array_unique($online);
    $bankerid = $online[0]['id'];
    //冒泡求最大值
    for($i=0;$i<count($online)-1;$i++){
        if($online[$i]['gold']>$online[$i+1]['gold']){
            $online[$i+1] = $online[$i];
        }
    }
    $bankerid = end($online)['id'];
    Db::name('games_sg_banker')
    ->insert([
        'banker_id'=>$bankerid,
        'time'=>time()
    ]);
 } 


 public function addBanker(){
    // $this->beginTime = time()+$this->interval; //后端结算游戏与前端结算游戏时间差需要游戏测试才能确定
    $banker = Db::name('user_user')->alias('u')->join('games_sg_banker g','g.banker_id = u.id')->field('u.id,u.head,u.nickname,u.gold')->order('g.time desc')->find();
    
    //返回给没有押注的玩家需要庄家信息
    $this->lastInfo['banker'] = $banker;
    return $banker;
 }

/*
    初始化链接跟链接时间
*/
public function onConnect($connection)
{    
    echo "-----onconnect-----".$connection->id."\n";
    $this->player['connection'][$connection->id] = $connection;
    $this->player['time'][$connection->id] = time();
}                                       

//worker服务器启动时触发的函数
 public function onWorkerStart(){
        $this->player['data'] = []; //用户的结算数组
        $this->player['time'] = []; //用户的心跳数组
        $this->player['connection'] = [];   //用户的链接对象信息
        $this->player['enterDesk'] = [];
        $this->beginTime = time();  //每一局游戏的发牌时间
        $this->Abnormal = new Abnormal(); //预定把函数分离出去的
    
    // 定时检测心跳
    $this->worker->timer_id = Timer::add($this->time, function()
    {   
        $time = time();
        if(!empty($this->player['time'])){
            foreach($this->player['time'] as $key => $vo){
                if(($this->player['time'][$key] + $this->time*3) < $time){
                    // $this->player['connection'][$key]->close();
                }            
            }
            foreach($this->player['connection'] as $k => $vo){
                // echo $this->player['time'][$k].":";
                if(isset($this->player['connection'][$k])){
                    // $vo->send('online');
                    echo $k."-----".$vo->id."-----\n";
                }
            }
        }
        else{
            echo "heart:no player online\n";
        }
    });


    /**
    * 控制牌局时间
    *    游戏从服务器启动就一直发牌，发回去的倒计时+结算时间+1s=总的发牌间隔
    */
    $this->worker->interval = Timer::add($this->dealTime,function(){
            //重置开局时间
            $this->beginTime = time();
            //押注倒计时 = 发牌时间 + 每局时长 - 结算时间
            $this->dealDown = $this->dealTime - $this->account-1;
              $sangong = new Index();
             //没有玩家押注直接给所有玩家发牌
             if(count($this->player['data'])<=0){
                $deal = $sangong->returnDeal();
                $this->lastInfo['deal'] = $deal;

                if(count($this->player['connection']) > 0){
                    foreach($this->player['connection'] as $k => $con){
                        if(isset($this->player['enterDesk'][$con->id])){
                            self::timeSend($con,$deal);
                        }
                    }
                }
             }
             // 有玩家押注
             else{
                    /*
                       有玩家押注时的数据结构是$this->player['data'] = [
                            'data'=>[
                                $connection->id=>['']//对应的押注的用户的返回信息
                            ]
                            'deal'=>[]//独立出来个没有押注的玩家的牌组
                       ]
                    */
                     $result = $sangong->begin($this->player['data']);//押注玩家组
                     file_put_contents("./player.json", json_encode($result,true));
                     $this->lastInfo['deal'] = $result['deal']; //围观玩家
                     
                     //检测还在线的玩家，让金币最高的那个玩家当庄家
                     // self::nextBanker();
                     //要在产生新的庄家后面，把庄家分别添加到每一个要返回的客户端界面
                     $banker = self::addBanker();
                     //把结果返回给还在线的玩家
                     echo "-----have player play return-----\n";
                     foreach($this->player['connection'] as $k => $con){
                        //没有参与游戏的玩家
                        if(!isset($this->player['data'][$k])){
                            echo "-----player no bet*return-----\n";
                            // echo $k;
                            self::timeSend($con,$this->lastInfo);
                        }
                        else{
                        //参与游戏的玩家
                             if($this->player['data'][$k]){
                                 echo "-----player bet*return-----\n";
                                 $data = $result['data'][$k];
                                 $data['banker'] = $banker;
                                 self::timeSend($con,$data);
                                 unset($this->player['data'][$k]);
                                 echo "hadn't send player data---->".count($this->player['data'])."\n";
                             }
                        }
                     } 
                  //牌发完了，卸掉牌组以及押注的玩家信息
                  $this->player['data'] = [];
                }

    });
 }

//给所有发送回去的信息添加倒计时
public function timeSend($con,$deal){
    // echo $deal;
    $data = [];

    $deal['countDown'] = $this->dealDown;
    //一次返回所有信息
    $deal = json_encode($deal);
    $con->send($deal);
    
    $deal=json_decode($deal,true);
    $i = 4;
    foreach($deal['deal'] as $player=>$card){
        $i--;
        $data[$i]['code'] = 3;
        $data[$i]['player'] = $player;
        $data[$i]['card'] = $card;
        // echo "connectionid : ".$con->id."-card : ".$i."\n";
        // $send = json_encode($data);
        // $con->send($send);
    }


    // //每一秒发一次牌
    // Timer::add(1,function()use($con,$data,$deal){
    //     $send = json_encode($data[3]);
    //     $con->send($send);

    //     Timer::add(1,function()use($con,$data,$deal){
    //         $send = json_encode($data[2]);
    //         $con->send($send);

    //         Timer::add(1,function()use($con,$data,$deal){
    //             $send = json_encode($data[1]);
    //             $con->send($send);

    //             Timer::add(1,function()use($con,$data,$deal){
    //                 $send = json_encode($data[0]);
    //                 $con->send($send);
    //                 /*
    //                     开局信号
    //                 */
    //                 Timer::add(1,function()use($con,$data,$deal){
    //                     $userInfo['code'] = 5;
    //                     $userInfo['countDown'] = $this->beginTime + $this->dealTime - time()-1;
    //                     //非押注玩家
    //                     if($deal['code'] == 4){
    //                         $userInfo['result'] = 0;
    //                     }
    //                     else{
    //                         //押注玩家
    //                         $userInfo['result'] = $deal['result'];
    //                     }
    //                     $send = json_encode($userInfo);
    //                     $con->send($send);
    //                 },array(),false);
    //             },array(),false);
    //         },array(),false);
    //     },array(),false);
    // },array(),false);
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
