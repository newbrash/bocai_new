<?php
namespace app\Sangong\controller;

use think\Db;
use app\MyCommon\controller\Game;

class Sangong extends Game
{
    // 获取信息
    public function getInfos($param)
    {
        switch ($param['request_type']) {
            case "getOdds":
                return $this->getOdds();
                break;
        }
    }

    // 下注
    public function bets($param)
    {
    }

    // 结算
    public function settlement($param)
    {
    }

    /**
     * 获取所有玩法和相应的赔率并且格式化返回
     */
    public function getOdds()
    {
        // $list = DB::name('gd11x5_odds')->select();
        // foreach ($list as $key => $vo) {
            
        // }
    }
}
