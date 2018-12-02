<?php
namespace app\MyCommon\controller;

use think\facade\Config;
use app\Server\controller\Deal;

abstract class Game
{
    public $parent = null;

    public function __construct()
    {
    }

    // 开启游戏（设置定时器，获取开奖号码）
    abstract public function begin();

    // 关闭服务器时触发
    abstract public function close();


    // 获取信息
    abstract public function dataProcer($param);


    /**
     * 发送数据
     */
    public function send($data)
    {
        try{
            if(!isset($data['uid']) || !isset($data['con_id'])){
                throw new \Exception("not exist index \"uid\" or \"con_id\"");
            }else{
                if (!isset($data['type']) || $data['type'] != 'settlement') {
                    // throw new \Exception("type将会被添加或者修改为`settlement`");
                    echo Deal::iconv("type为系统内置字段，将会被添加或者修改为`settlement`\n");
                    $data['type'] = 'settlement';
                }
                $this->parent->send($data);
            }
        }catch(\Exception $e){
            echo "send error:".$e->getMessage()." in file:".$e->getFile()." at line:".$e->getLine()."\n";
        }
    }

    public function openReult($data)
    {
        if (!isset($data['type']) || $data['type'] != 'openResult') {
            // throw new \Exception("type将会被添加或者修改为`openResult`");
            echo Deal::iconv("type为系统内置字段，将会被添加或者修改为`openResult`\n");
            $data['type'] = 'openResult';
        }
        $this->parent->send($data);
    }
}
