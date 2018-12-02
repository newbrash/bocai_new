<?php
namespace app\GameServer1\controller;

use think\facade\Config;
use app\MyCommon\controller\Game;

class Request
{
    public static function request($connection, $data)
    {
        $config = Config::pull('worker');
        if (!isset($config['games'][$data['game']])) {
            return false;
        }
        $class = '\\'.$config['games'][$data['game']]['namespace'].'\\'.$config['games'][$data['game']]['class'];
        $result = self::dataProcer(new $class, $data);
        $connection->send(json_encode($result));
        return true;
    }

    public static function dataProcer(Game $game, $data)
    {
        return $game->dataProcer($data);
    }

    /**
     * 向下注客户推送结算消息
     */
    public static function settlement($connection, $data, $userCons)
    {
        echo "push result to user\n";
        if (!isset($data['con_id']) || !isset($data['uid'])) {
            if ($data['con_id'] && isset($userCons[$data['con_id']]['uid']) && $userCons[$data['con_id']]['uid'] == $data['uid']) {
                $userCons[$data['con_id']]['con']->send($data);
            }
        }
    }

    /**
     * 向所有用户推送
     */
    public static function openResult($connection, $data, $userCons)
    {
        $msg = [
            'issue'=>$data['issue'],
            'countdown'=>$data['countdown'],
            'recentInfo'=>$data['recentInfo'],
        ];
        $open_result = $data['result'];
        echo "push open result to everybody!\n";
        foreach ($userCons as $key => $vo) {
            if (isset($vo['con']) && $vo['con']) {
                if(isset($vo['uid']) && isset($open_result[$vo['uid']])){
                    $msg['remaining'] = $open_result[$vo['uid']['gold']];
                }
                $vo['con']->send(json_encode($msg));
            }
        }
    }
}
