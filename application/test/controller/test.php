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
namespace app\test\controller;

use app\test\controller\testworker as MyWebServer;
use think\worker\Server;
use Workerman\Lib\Timer;

/**
 * Worker 命令行服务类
 */
class test extends Server
{
    protected $time_interval; // 心跳间隔
    protected $timer_handle; // 定时器句柄


    protected $n = 0;
    /**
     * 架构函数
     * @access public
     * @param  string $host 监听地址
     * @param  int    $port 监听端口
     * @param  array  $context 参数
     */
    public function __construct($host = null, $port = null, $context = [])
    {
        // // 初始化心跳间隔为30秒
        $this->time_interval = 1;
        // // 初始化定时器句柄
        $this->timer_handle = null;
        $this->worker = new MyWebServer();
        // 设置回调
        foreach ($this->event as $event) {
            if (method_exists($this, $event)) {
                $this->worker->$event = [$this, $event];
            }
        }
    }
    
    /**
     * onWorkerStart 启动事件回调
     * @access public
     * @param  \Workerman\Worker    $worker
     * @return void
     */
    public function onWorkerStart($worker)
    {
        $this->timer_handle = Timer::add($this->time_interval, function () {
            dump('DDDDD'.$this->n);
            $this->n++;
        });
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
        // 关闭定时器
        Timer::del($this->timer_handle);
        MyWebServer::stopAll();
    }
}
