<?php
namespace app\Admin\controller;

use think\Controller;
use think\Db;
use think\facade\Config;
use think\facade\Session;
use app\MyCommon\controller\Base;

/**
 *
 */
class Common extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $result = Base::check();
        // 如何发生错误则将错误信息输出
        if ($result['code']) {
            Base::echo_error($result['msg']);
        }
        // 判断是否登陆
        if (!Session::has('admin')) {
            $this->redirect('Admin/Login/login');
        }
        // 获取logo
        $logo = Db::name('system_info')->field('logo_src')->find();
        $this->assign([
            'web_title'=>'管理员后台',
            'logo'=>$logo['logo_src'],
        ]);
    }

    /**
     * 设置redis里的系统配置
     */
    public function setRedis($system_info)
    {
        try {
            $redisConfig = Config::get('worker.redis');
            $redis = new \Redis();
            $redis->connect($redisConfig['host'], $redisConfig['port']);
            if ($redis->set('system_info', json_encode($system_info))) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            echo json_encode([
                'code'=>-2,
                'msg'=>'redis服务器链接失败！'
            ]);
            exit;
        }
    }
    /**
     * 更新保存在redis里的系统配置
     */
    public function updateRedis($updateData)
    {
        try {
            if (is_array($updateData) && !empty($updateData)) {
                $redisConfig = Config::get('worker.redis');
                $redis = new \Redis();
                $redis->connect($redisConfig['host'], $redisConfig['port']);
                $system_info = json_decode($redis->get('system_info'), true);
                $updateFlag = false;
                foreach ($updateData as $key => $vo) {
                    if (isset($system_info[$key]) && $system_info[$key] != $vo) {
                        if (!$updateFlag) {
                            $updateFlag = true;
                        }
                        $system_info[$key] = $vo;
                    } elseif (!isset($system_info[$key])) {
                        throw new \Exception("not found index:".$key);
                        return false;
                    }
                }
                if ($updateFlag) {
                    $redis->set('system_info', json_encode($system_info));
                }
                return true;
            }
        } catch (\Exception $e) {
            echo json_encode([
                'code'=>-2,
                'msg'=>'redis服务器链接失败！'
            ]);
            exit;
        }
    }
    
    public function getRedis($index = null)
    {
        try {
            $redisConfig = Config::get('worker.redis');
            $redis = new \Redis();
            $redis->connect($redisConfig['host'], $redisConfig['port']);
            $system_info = json_decode($redis->get('system_info'), true);
            if ($index) {
                if (isset($system_info[$index])) {
                    return $system_info[$index];
                } else {
                    return null;
                }
            } else {
                return $system_info;
            }
        } catch (\Exception $e) {
            echo json_encode([
                'code'=>-2,
                'msg'=>'redis服务器链接失败！'
            ]);
            exit;
        }
    }
}
