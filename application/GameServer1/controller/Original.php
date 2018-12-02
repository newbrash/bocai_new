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

use app\GameWorker\controller\Active;
use app\GameWorker\controller\Gd11x5;

class Original
{
    protected $active;
    protected $Gd11x5;



    //worker服务器启动时触发的函数
    public function start()
    {
        $this->active = new Active();//接口游戏处理类
        $this->Gd11x5 =  new Gd11x5();

        $this->Gd11x5->gameStatus();//开启广东十一选五游戏检测 游戏流程与其它数字彩票一致，区别:里面采用了redis缓存记录信息
        $this->active->gameStatus();//接口游戏开启检测->包含游戏:六合彩，江苏快三
    }



    /*
     * onMessage 事件回调
     * @access public
     * @param  \Workerman\Connection\TcpConnection    $connection
     * @param  mixed                                  $data
     * @return vpopmail_del_domain(domain)
     */
    public function message($connection, $data)
    {
        switch ($data['game']) {
            case 'gd':
                $this->Gd11x5->enter($connection, $data);//广东十一选五
            break;
            default://六合彩,江苏快三
                $this->active->enter($connection, $data);//统一规格游戏
                break;
        }
    }
    
    public function close($connection)
    {
        /**
         * 只卸载用户连接信息
         * 最好弄成内部函数删除protected变量的形式吧
         *  */
        if (isset($this->active->connection["six"][$connection->id])) {
            unset($this->active->connection["six"][$connection->id]);
        } elseif (isset($this->active->connection["jsks"][$connection->id])) {
            unset($this->active->connection["jsks"][$connection->id]);
        } elseif (isset($this->active->connection["bjpk10"][$connection->id])) {
            unset($this->active->connection["bjpk10"][$connection->id]);
        } elseif (isset($this->BjPK10->connection[$connection->id])) {
            unset($this->BjPK10->connection[$connection->id]);
        } elseif (isset($this->Cqssc->connection[$connection->id])) {
            unset($this->Cqssc->connection[$connection->id]);
        } elseif (isset($this->Gd11x5->connection[$connection->id])) {
            unset($this->Gd11x5->connection[$connection->id]);
        }

        // 三公设置的是enterDesk保存链接信息
        elseif (isset($this->SanGong->connection[$connection->id])) {
            $data = [
                    "type"=>"loseConnection",
                ];
            $this->SanGong->enter($connection, $data);
        }
        echo $connection->id."  has been closed\n";
    }
}
