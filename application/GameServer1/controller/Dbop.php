<?php
namespace app\GameServer1\controller;

use think\Db;

class Dbop
{
    /**
     * 更新用户的游戏的链接资源标识符
     */
    static public function updateUserGameConId($uid, $con_id){
        DB::name('user_user')->where('id',$uid)->update(['game_con_id'=>$con_id]);
    }
}
