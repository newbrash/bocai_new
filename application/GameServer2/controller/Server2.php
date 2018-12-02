<?php
namespace app\GameServer2\controller;

use Workerman\Worker as MyWebServer; //需要实例化的worker对象
use think\worker\Server; // 需要继承的父类
use Workerman\Lib\Timer; // 定时器

use think\facade\Config; // 配置助手类

// use app\GameServer2\controller\RegisterGame; // 游戏管理类

class Server2 extends Server
{
    /**
     * 发送数据的socket句柄
     */
    protected $socket = null;
    /**
     * 所有游戏的实例化对象池
     */
    protected $worker = [];




    /**
     * 架构函数
     * @access public
     * @param  string $host 监听地址
     * @param  int    $port 监听端口
     * @param  array  $context 参数
     */
    public function __construct($host = null, $port = null, $context = [])
    {
        $this->worker = new MyWebServer();
        // 设置回调
        foreach ($this->event as $event) {
            if (method_exists($this, $event)) {
                $this->worker->$event = [$this, $event];
            }
        }
        defined("GAME_STATUS_START") or define("GAME_STATUS_START", 1);
        defined("GAME_STATUS_OVER") or define("GAME_STATUS_OVER", 0);
    }
    
    /**
     * onWorkerStart 启动事件回调
     * @access public
     * @param  \Workerman\Worker    $worker
     * @return void
     */
    public function onWorkerStart($worker)
    {
        try {
            $config = Config::pull('worker');
            // 实例化redis对象
            $redis = new \Redis();
            // 链接redis服务器
            $redis->connect($config['redis']['host'], $config['redis']['port']) or die("redis connect failed!");
            // $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1) or die("set time out failed!");
            $redis->set("GAME_STATUS", GAME_STATUS_START);

            // 创建socket客户端，用于将开奖结果推送给用户
            $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if (!$this->socket) {
                throw new Exception("redis creates socket failed!");
            // die("redis creates socket failed!");
            } else {
                // 链接服务器
                $conn = socket_connect($this->socket, $config['redis']['shost'], $config['gameport']);
                if (!$conn) {
                    throw new Exception("redis socket connects workerman failed!");
                    // die("redis socket connects workerman failed!");
                }
            }
            // 注册游戏
            RegisterGame::registerGames($config['games']);
            // 游戏实例化列表
            $this->worker = RegisterGame::beginGames($this);
        } catch (\Exception $e) {
            echo "error imformatino:".$e->getMessage()." in file:".$e->getFile()." at line:".$e->getLine()."\n";
        }
    }

    /**
     * 发送数据
     */
    public function send($data)
    {
        try {
            // $this->parent->send($data);
            $data = "#@#redis-data-request#@#" . json_encode($data);
            if (socket_send($this->socket, $data, strlen($data), MSG_DONTROUTE)) {
                echo "send successful!\n";
            } else {
                throw new Exception("send failed!");
            }
        } catch (\Exception $e) {
            echo "error imformation:".$e->getMessage()." in file:".$e->getFile()." at line:".$e->getLine();
        }
    }

    /**
     * 启动
     * @access public
     * @return void
     */
    public function start()
    {
        MyWebServer::runAll();
    }

    /**
     * 停止
     * @access public
     * @return void
     */
    public function stop()
    {
        if ($this->worker && !empty($this->worker)) {
            foreach ($this->worker as $key => $vo) {
                $vo->close();
            }
        }
        $config = Config::pull('worker');
        // 实例化redis对象
        $redis = new \Redis();
        // 链接redis服务器
        $redis->connect($config['redis']['host'], $config['redis']['port']) or die("redis connect failed!");
        // $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1) or die("set time out failed!");
        // $redis->set("GAME_STATUS", GAME_STATUS_OVER);
        $redis->del("GAME_STATUS");
        socket_close($this->socket);
        RegisterGame::delete();
        MyWebServer::stopAll();
    }
}
