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
namespace app\GameServer1\controller;

use Workerman\Worker as WorkerServer;
use think\worker\Server;
use Workerman\lib\Timer;
use app\Server\controller\Deal;


use app\GameServer1\controller\Request;

/*
* worker onworkerstart:创建时钟函数检测游戏开启状态
*        onmessage:接受前端穿过来的数据并且传给active.php处理
*        onclose:关闭连接卸掉对应的链接与时间标志
*        onconnect:初始化链接与时间标志并且告知active.php处理新的链接
*/

/**
 * Worker 命令行服务类
 */
class Server1 extends Server
{
    protected $Original = null;
    protected $userCons = array();
    protected $heart_interval = null; // 定时器
    protected $heart_time = 30; //心跳间隔
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

    //worker服务器启动时触发的函数
    public function onWorkerStart()
    {
        try {
            defined("DS") || define('DS', DIRECTORY_SEPARATOR);
            defined('__ROOT__') || define('__ROOT__', __DIR__.DS.'..'.DS.'..'.DS.'..'.DS);
            // 定时检测心跳
            $this->heart_interval = Timer::add($this->heart_time, function () {
                // 更新用户的心跳时间
                if (!empty($this->userCons)) {
                    $now_time = time();
                    foreach ($this->userCons as $key => $vo) {
                        if ($vo['time'] + ($this->heart_time*3) < $now_time) {
                            // 更新用户的链接资源标识符
                            Dbop::updateUserGameConId($vo['uid'], 0);
                            // 超过三次没响应心跳的关闭连接
                            $vo['con']->close();
                            unset($this->userCons[$key]);
                        } else {
                            // 向用户发送心跳
                            $this->userCons[$key]['con']->send(json_encode([
                                'type'=>'heart',
                                'data'=>'ping',
                            ]));
                        }
                    }
                } else {
                    echo "heart:no user online\n";
                }
            });
    
            $this->Original = new Original();
            $this->Original->start();
        } catch (\Exception $e) {
            echo "onWorkerStart error:".$e->getMessage()." in file:".$e->getFile()." at line:".$e->getLine()."\n";
        }
    }

    

    /*
    * 初始化链接及心跳时间
    */
    public function onConnect($connection)
    {
        echo Deal::iconv("“游客".$connection->id."”连接服务器成功！\n");
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
        try {
            $data = json_decode($data, true);
            echo "-----array.data-----\n";
            dump(Deal::iconv($data));
            switch ($data['type']) {
                case "handle":
                    // 握手处理
                    $this->handle($connection, $data);
                    break;
                case "heart":
                    // 接受到心跳
                    if (isset($this->userCons[$connection->id]['nickname']) && $this->userCons[$connection->id]['nickname']) {
                        echo Deal::iconv("用户“".$this->userCons[$connection->id]['nickname']."”在线！\n");
                    } else {
                        echo Deal::iconv("“游客".$connection->id."”在线！\n");
                    }
                    break;
                case "settlement":
                    // 处理结算结果
                    Request::settlement($connection, $data, $this->userCons);
                    break;
                case "openResult":
                    // 向所有用户推送开奖结果
                    Request::openResult($connection, $data, $this->userCons);
                    break;
                default:
                    // 处理游戏的获取信息的请求和下注请求
                    if (!Request::request($connection, $data)) {
                        $this->Original->message($connection, $data);
                    }
                    break;
            }
            if (isset($this->userCons[$connection->id])) {
                // 更新用户活动时间
                $this->userCons[$connection->id]['time'] = time();
            }
        } catch (\Exception $e) {
            echo Deal::iconv($e->getMessage().' in file:'.$e->getFile()." at line:".$e->getLine()."\n");
        }
    }


    /**
     * 握手处理
     */
    public function handle($connection, $data)
    {
        $info = [
            'con'=>$connection,
            'uid'=>$data['send_id'],
            'nickname'=>$data['nickname'],
            'time'=>time(),
        ];
        // dump($info);
        $this->userCons[$connection->id] = $info;
        $result = $connection->send(json_encode([
            'type'=>'handle',
            'connectionId'=>$data['send_id'] ? $connection->id : null,
        ]));
        if ($data['send_id']) {
            Dbop::updateUserGameConId($data['send_id'], $connection->id);
        }
    }

    public function onclose($connection)
    {
        try {
            echo Deal::iconv(isset($this->userCons[$connection->id]['nickname'])
            ?'用户“'.$this->userCons[$connection->id]['nickname']."”已离开！\n"
            :"“游客".$connection->id."”已离开！\n");
            //只卸载用户连接信息
            if (isset($this->userCons[$connection->id])) {
                Dbop::updateUserGameConId($this->userCons[$connection->id]['uid'], 0);
                unset($this->userCons[$connection->id]);
            }
            $this->Original->close($connection);
        } catch (\Exception $e) {
            echo "onClose error:".$e->getMessage()." in file:".$e->getFile()." at line:".$e->getLine()."\n";
        }
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
        Timer::del($this->heart_interval);
        WorkerServer::stopAll();
    }
}
