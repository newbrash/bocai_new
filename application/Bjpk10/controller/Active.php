<?php 
namespace app\bjpk10\controller;

use think\Controller;
use think\facade\Session;
use think\Db;
use think\facade\Request;
use app\bjpk10\model\Games_bjpk10_odds as Odds;
/*  功能函数
    ** 更新用户剩余金币，以数据库为准 refreshRemaining(
    ** 记录用户最新金币 table:user_user  refleshUser(
    ** 结算订单 table:games_bet_history recordeBetHistory($dice)
    
    ** 记录和值走势 table:bc_games_bjkp10_guanyahe_liangmian bc_games_bjkp10_guanyahe_haomafenbu recordeGuanYaHe($dice)
    ** 记录基本走势 table:games_bjpk10_basic_trend recordeBasicTrend($dice)
    ** 记录定胆位  table:games_bjpk10_dindanwei recordeDinDanWei($data);
    ** 记录开奖记录 table:games_bjpk10_dice_history recordeDiceHistory($dice);
    ** 
*/

class Active extends Controller
{


    //更新用户剩余金币，以数据库为准 公用
    public function refreshRemaining($order){
        $gold = Db::name('user_user')->where(['id'=>$order['id']])->value('gold');
        $remaining = $gold - $order['allGold'];
        Db::name('user_user')->where(['id'=>$order['id']])->update(['gold'=>$remaining]);
        return $remaining;
    }

    //记录用户最新金币 table:user_user 公用
    public function refleshUser($id,$remaining){
        Db::name('user_user')->where('id',$id)->update(['gold'=>$remaining]);
    }

    //结算订单 table:games_bet_history 公用
    public function recordeBetHistory($orderNumber,$dice,$win){
        $id = Db::name('games_bet_history')->where(['order_number'=>$orderNumber])->value('id');
        $status = 1;//开奖1
        if($win > 0){
            $status = 2;//中奖2
        }
        $data = [
            'open_code'=>$dice['opencode'],
            'win'=>$win,
            'open_time'=>$dice['opentime'],
            'status'=>$status,
        ];
        Db::name('games_bet_history')->where(['id'=>$id])->update($data);
    }



    //记录基本走势 table:games_bjpk10_basic_trend
    public function recordeBasicTrend($dice){
        $opencode = explode(',',$dice['opencode']);
        $issue =$dice['expect'];//期号
        $open_time = $dice['opentime'];
        $guanyahe = $opencode[0]+$opencode[1];
        $data = [
            "issue"=>$issue,
            "open_code"=>$dice['opencode'],
            "guanyahe"=>$guanyahe
        ];
        Db::name('games_bjpk10_basic_trend')->insert($data);
    }

    /**
     * 记录定胆位 table:games_bjpk10_dindanwei
     * 冠亚和：3-11小   12-19 大
     */
    public function recordeDinDanWei($dice){
        $opencode = explode(',',$dice['opencode']);
        $issue =$dice['expect'];//期号
        $open_time = $dice['opentime'];
        //一个10*10的大表
        $list = Db::name("games_bjpk10_dindanwei")->field('id,issue',true)->order('id desc')->find();
        if($list){
            for($i = 1;$i <= 10;$i++){
                $index = "ball_".$i;
                $list[$index] = json_decode($list[$index],true);
                for($j = 1;$j <= 10;$j++){
                    //i为第几球
                    if( $j == $opencode[$i-1]){
                        $list[$index][$j] = 0;
                    }else{
                        $list[$index][$j]++;
                    }
                }
            }
        }
        else{
            $list = [];
            for($i = 1;$i <= 10;$i++){
                $index = "ball_".$i;
                for($j = 1;$j <= 10;$j++){
                    //i为第几球
                    if( $j == $opencode[$i-1]){
                        $list[$index][$j] = 0;
                    }else{
                        $list[$index][$j] = 1;
                    }
                }
            }
        }
        //分别把每个号码表进行转换
        $data = [];
        foreach($list as $key=>$vo){
            $data[$key] = json_encode($list[$key]);
        }
        //添加开奖号码以及订单号
        $data['open_code'] = json_encode($opencode);
        $data['issue'] = $issue;

        Db::name('games_bjpk10_dindanwei')->Insert($data);
    }

    //记录冠军和table:bc_games_bjpk10_guanyahe_liangmian bc_games_bjpk10_guanyahe_haomafenbu 
    public function recordeGuanYaHe($dice){
        $opencode = explode(',',$dice['opencode']);
        $issue =$dice['expect'];//期号
        $open_time = $dice['opentime'];
       
        //记录冠亚和两面
        $guanyahe = $opencode[0] + $opencode[1];
        $liangmian = Db::name("games_bjpk10_guanyahe_liangmian")->order("id desc")->find();
        if($liangmian){
            //上一条记录的和大小单双出现的次数
            $recordLM = [
                "heda"=>intval($liangmian['heda']),
                "hexiao"=>intval($liangmian['hexiao']),
                "hedan"=>intval($liangmian['hedan']),
                "heshuang"=>intval($liangmian['heshuang']),
            ];
            if($guanyahe>=12){
                $recordLM['heda'] = 'da';
                $recordLM['hexiao']++;
            }
            else{
                $recordLM['heda']++;
                $recordLM['hexiao'] = 'xiao';
            }

            if($guanyahe%2){
                $recordLM['hedan'] = 'dan';
                $recordLM['heshuang']++;
            }
            else{
                $recordLM['heshuang'] = "shuang";
                $recordLM['hedan']++;
            }
        }
        else{
            $recordLM = [
                "heda"=>1,
                "hexiao"=>1,
                "hedan"=>1,
                "heshuang"=>1,
            ];
            if($guanyahe>=12){
                $recordLM['heda'] = 'da';
            }
            else{
                $recordLM['hexiao'] = 'xiao';
            }

            if($guanyahe%2){
                $recordLM['hedan'] = 'dan';
            }
            else{
                $recordLM['heshuang'] = "shuang";
            }
        }
        $liangmian = [
            "issue"=>$issue,
            "guanyahe"=>$guanyahe,
            "heda"=>$recordLM['heda'],
            "hexiao"=>$recordLM['hexiao'],
            "hedan"=>$recordLM['hedan'],
            "heshuang"=>$recordLM['heshuang'],
        ];

        $lastHaoma = Db::name("games_bjpk10_guanyahe_haomafenbu")->order("id desc")->find();
        if($lastHaoma){
            $recordHM = [
                "sum_3"=>$lastHaoma["sum_3"],
                "sum_4"=>$lastHaoma["sum_4"],
                "sum_5"=>$lastHaoma["sum_5"],
                "sum_6"=>$lastHaoma["sum_6"],
                "sum_7"=>$lastHaoma["sum_7"],
                "sum_8"=>$lastHaoma["sum_8"],
                "sum_9"=>$lastHaoma["sum_9"],
                "sum_10"=>$lastHaoma["sum_10"],
                "sum_11"=>$lastHaoma["sum_11"],
                "sum_12"=>$lastHaoma["sum_12"],
                "sum_13"=>$lastHaoma["sum_13"],
                "sum_14"=>$lastHaoma["sum_14"],
                "sum_15"=>$lastHaoma["sum_15"],
                "sum_16"=>$lastHaoma["sum_16"],
                "sum_17"=>$lastHaoma["sum_17"],
                "sum_18"=>$lastHaoma["sum_18"],
                "sum_19"=>$lastHaoma["sum_9"],
            ];
            //拼接字段
            $index = "sum_".$guanyahe;
            foreach($recordHM as $key => $vo){
                if($key==$index){
                    $recordHM[$key] = 0;
                }
                else{
                    $recordHM[$key]++;
                }
            }
        }
        else{
            $recordHM = [
                "sum_3"=>0,
                "sum_4"=>0,
                "sum_5"=>0,
                "sum_6"=>0,
                "sum_7"=>0,
                "sum_8"=>0,
                "sum_9"=>0,
                "sum_10"=>0,
                "sum_11"=>0,
                "sum_12"=>0,
                "sum_13"=>0,
                "sum_14"=>0,
                "sum_15"=>0,
                "sum_16"=>0,
                "sum_17"=>0,
                "sum_18"=>0,
                "sum_19"=>0,
            ];
            //拼接字段
            $index = "sum_".$guanyahe;
            foreach($recordHM as $key => $vo){
                if($key==$index){
                    $recordHM[$key] = 0;
                }
                else{
                    $recordHM[$key]++;
                }
            }
        }
        $haomafenbu = [
            "issue"=>$issue,
            "guanyahe"=>$guanyahe,
            "sum_3"=>$recordHM["sum_3"],
            "sum_4"=>$recordHM["sum_4"],
            "sum_5"=>$recordHM["sum_5"],
            "sum_6"=>$recordHM["sum_6"],
            "sum_7"=>$recordHM["sum_7"],
            "sum_8"=>$recordHM["sum_8"],
            "sum_9"=>$recordHM["sum_9"],
            "sum_10"=>$recordHM["sum_10"],
            "sum_11"=>$recordHM["sum_11"],
            "sum_12"=>$recordHM["sum_12"],
            "sum_13"=>$recordHM["sum_13"],
            "sum_14"=>$recordHM["sum_14"],
            "sum_15"=>$recordHM["sum_15"],
            "sum_16"=>$recordHM["sum_16"],
            "sum_17"=>$recordHM["sum_17"],
            "sum_18"=>$recordHM["sum_18"],
            "sum_19"=>$recordHM["sum_9"],
        ];
        Db::name("games_bjpk10_guanyahe_liangmian")->Insert($liangmian);
        Db::name("games_bjpk10_guanyahe_haomafenbu")->Insert($haomafenbu);
    }
    /**
     * 记录开奖结果 table:games_bjpk10_dice_history
     * 冠亚和：3-11小   12-19 大
     */
    public function recordeDiceHistory($dice){
        $opencodeStr = $dice['opencode'];
        $opencode = explode(',',$dice['opencode']);
        $issue =$dice['expect'];//期号
        $open_time = $dice['opentime'];//开奖时间
        $guanyahe = $opencode[0]+$opencode[1];
        $daxiao = $guanyahe>=12?"da":"xiao";
        $danshuang = $guanyahe%2?"dan":"shuang";
        $data = [
            "issue"=>$issue,
            "open_code"=>$opencodeStr,
            "open_time"=>$dice['opentime'],
            "guanyahe"=>$guanyahe,
            "daxiao"=>$daxiao,
            "danshuang"=>$danshuang,
        ];
        Db::name('games_bjpk10_dice_history')->insert($data);
    }

}
 ?>