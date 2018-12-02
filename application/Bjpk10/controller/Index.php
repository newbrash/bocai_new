<?php
namespace app\Bjpk10\controller;

use app\Server\controller\Deal;
use app\Bjpk10\controller\Active;
use app\MyCommon\controller\Gameapi;
use think\Controller;
use think\Db;
//获取游戏开奖号码接口z
/*
 ** 最近游戏开出的色子记录 recentInfo();--改表名字
 ** 生成订单     createOrder();--小改
 ** 取消订单     destroyOrder();--公用
 ** 获取历史记录  gameHistory();--大改
 ** 桌面信息      deskInfo();--公用
 ** 近期开奖信息  recentOpen()--改表名字
 ** 下注历史  betHistory();--公用
 ** 创建订单时检测是否有足够的金币 createCheck($allGold, $id)--公用

自用
 **
 */

class Index extends Controller
// class Index

{
    protected $function;
    protected $dice; //开奖详细
    protected $opencode; //开奖号码
    public function __construct()
    {
        $this->active = new Active();
    }

    //测试
    public function makeTest()
    {
        // 随机100期测试效果
        $time = time();
        $expect = 2018118;

        for ($i = 0; $i <= 100; $i++) {
            $opencode = [
                1, 2, 3, 4, 5, 5, 6, 7, 8, 9, 10,
            ];
            shuffle($opencode);
            $time--;

            $opencode = implode(',', $opencode);

            $data = [
                'expect' => $expect--,
                'opencode' => $opencode,
                'opentime' => date("Y-m-d H:i:s", $time),
            ];
            $dice = explode(",", $this->dice['data']['data'][0]['opencode']);

            // 记录和值走势 table:games_jsks_sum_trend
            $this->active->recordeSumTrend($data);
            // 记录基本走向 table:games_jsks_basic_trend
            $this->active->recordeBasicTrend($data);
            //记录开奖结果 table:games_jsks_dice_history
            $this->active->recordeDiceHistory($data);
        }
    }

    //直接获取游戏结果
    public function diceResult()
    {
        // 采集数据
        echo Deal::iconv("北京pk10采集数据\n");
        try{
            $dice = new Gameapi();
            $this->dice = $dice->getGameData('bjpks');
            
            $data = $this->dice['data']['data'][0];
            $opencode = explode(",", $this->dice['data']['data'][0]['opencode']);
            $this->opencode = $opencode;
            $dice = $opencode;
            echo Deal::iconv("北京pk10数据采集完毕\n");
        }
        catch(\Exception $e){
            echo Deal::iconv("北京pk10数据采集失败,此处为人造数据\n");
            // 测试
            $opencode = [
                1,2,3,4,5,6,7,8,9,10
            ];
            shuffle($opencode);

            $dice = $opencode;
            $opencode = implode(',',$opencode);
            $expect = 2018118;
            $data = [
                'expect' => $expect--,
                'opencode' => $opencode,
                'opentime' => date("Y-m-d H:i:s",time()),
            ];
            $this->dice['data']['data'][0] = $data;
            // 测试
        }


        //记录冠军和 table:games_jsks_sum_trend
        $this->active->recordeGuanYaHe($data);
        echo Deal::iconv("记录北京pk10冠亚和\n");
        // 记录基本走向 table:games_jsks_basic_trend
        $this->active->recordeBasicTrend($data);
        echo Deal::iconv("记录北京pk10基本走势\n");
        //记录定位胆 table:games_jsks_basic_trend
        $this->active->recordeDinDanWei($data);
        echo Deal::iconv("记录北京pk10定胆位\n");
        //记录开奖结果 table:games_jsks_dice_history
        $this->active->recordeDiceHistory($data);
        echo Deal::iconv("记录北京pk10色子历史\n");

        //北京pk10数据结构太简单没有这一项
        // $gameResult = [
        // ];
        // echo "return GameResult--\n";
        // return $gameResult;
    }

    // 游戏结算    //bet就是workman传过来的数据
    public function begin($playerData=[], $diceResult=[])
    {
        $odds = file_get_contents(dirname(dirname(__FILE__)) . "./odds.json");
        $odds = json_decode($odds, true);
        $odds = $odds['odds'];
        foreach ($playerData as $conId => $player) {

            $playerWin = 0; //单个玩家赢的金币
            //求出每一注订单的下注结果
            foreach ($player as $orderNumber => $order) {

                //更新用户剩余金币，以数据库为准
                $playerData[$conId]['remaining'] = $this->active->refreshRemaining($order);

                $win = 0;
                //求出每一个结果
                $type = $order['type'];
                $leiXin = $order['leiXin'];
                $name = $order['name'];
                $smallName = $order['smallName'];
                $number = $order['number'];
                $gold = $order['gold'];
                //按类型结算订单
                switch ($type) {
                    /**
                         * 前一
                         * "tips":"从01-10中任选1个号码组成一注。",
                         * "rule":"所选号与开奖号第一位相同，即为中奖。",
                         * "case":"选号：05，开奖号：05*********。"
                         */
                    case "qianyi":
                        if (in_array($this->opencode[0], $number)) {
                            $win = $gold * $odds[$type][$leiXin][$name];
                        }

                    break;

                    /**
                         * 前二
                         * "tips":"从冠军、亚军中各选1个不同的号码组成一注。",
                         * "rule":"所选号与开奖号前两位号码相同，且顺序一致，即为中奖。",
                         * "case":"按序选号：0508，开奖号：0508********。"
                         */
                    case "qianer":
                        if (in_array($this->opencode[0], $number["guanjun"])&&in_array($this->opencode[1], $number["yajun"])) {
                            $win = $gold * $odds[$type][$leiXin][$name];
                        }
                    break;

                    //前三
                    case "qiansan":
                    if (in_array($this->opencode[0], $number["guanjun"])&&in_array($this->opencode[1], $number["yajun"])&&in_array($this->opencode[2], $number["jijun"])) {
                        $win = $gold * $odds[$type][$leiXin][$name];
                    }
                    break;

                    //定胆位
                    case "dindanwei":
                    switch($smallName){
                        case "guanjun":
                            if (in_array($this->opencode[0], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;
                        case "yajun":
                            if (in_array($this->opencode[1], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;
                        case "jijun":
                            if (in_array($this->opencode[2], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;      
                        case "di4min":
                            if (in_array($this->opencode[3], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;
                        case "di5min":
                            if (in_array($this->opencode[4], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;
                        case "di6min":
                            if (in_array($this->opencode[5], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break; 
                        case "di7min":
                            if (in_array($this->opencode[6], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;
                        case "di8min":
                            if (in_array($this->opencode[7], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;
                        case "di9min":
                            if (in_array($this->opencode[8], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;
                        case "di10min":
                            if (in_array($this->opencode[9], $number)) {
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                        break;                                                                                                                   
                    }

                    //冠亚和
                    case "guanyahe":
                    $guanyahe = $this->opencode[0]+$this->opencode[1];
                    if (in_array($this->opencode[0], $number)) {
                        $index = "sum_".$guanyahe;
                        $win = $gold * $odds[$type][$leiXin][$name][$index];
                    }
                    break;

                    //龙虎
                    case "longhu":
                        switch($name){
                            case "guanjun":
                            if($this->opencode[0]>$this->opencode[9]){
                                $result = "long";
                            }
                            else{
                                $result = "hu";
                            }
                            if(in_array($result,$number)){
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                            break;

                            case "yajun":
                            if($this->opencode[1]>$this->opencode[8]){
                                $result = "long";
                            }
                            else{
                                $result = "hu";
                            }
                            if(in_array($result,$number)){
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }                          
                            break;
                            case "jijun":
                            if($this->opencode[2]>$this->opencode[7]){
                                $result = "long";
                            }
                            else{
                                $result = "hu";
                            }
                            if(in_array($result,$number)){
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }                          
                            break;
                            case "di4min":
                            if($this->opencode[3]>$this->opencode[6]){
                                $result = "long";
                            }
                            else{
                                $result = "hu";
                            }
                            if(in_array($result,$number)){
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                            break;
                            case "di5min":
                            if($this->opencode[4]>$this->opencode[5]){
                                $result = "long";
                            }
                            else{
                                $result = "hu";
                            }
                            if(in_array($result,$number)){
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                            break;                        
                        }
                    break;

                    //五行
                    case "wuxin":
                       switch($name){
                           case "guanjun":
                            if(in_array($this->opencode[0],$number)){
                                $win = $gold * $odds[$type][$leiXin][$name];
                            }
                           break;
                           case "yajun":
                           if(in_array($this->opencode[1],$number)){
                            $win = $gold * $odds[$type][$leiXin][$name];
                            }
                           break;
                           case "jijun":
                           if(in_array($this->opencode[2],$number)){
                            $win = $gold * $odds[$type][$leiXin][$name];
                            }
                           break;
                       } 
                    break;

                    //大小单双
                    case "daxiaodanshuang":
                    switch($leiXin){
                        case "daxiao":
                            switch($name){
                                case "guanjun":
                                    if($this->opencode[0]>=6){
                                        $result = "da";
                                    }
                                    else{
                                        $result = "xiao";
                                    }
                                    if(in_array($result,$number)){
                                        $win = $gold * $odds[$type][$leiXin][$name];
                                    }
                                break;

                                case "yajun":
                                    if($this->opencode[1]>=6){
                                        $result = "da";
                                    }
                                    else{
                                        $result = "xiao";
                                    }
                                    if(in_array($result,$number)){
                                        $win = $gold * $odds[$type][$leiXin][$name];
                                    }
                                break;

                                case "jijun":
                                    if($this->opencode[2]>=6){
                                        $result = "da";
                                    }
                                    else{
                                        $result = "xiao";
                                    }
                                    if(in_array($result,$number)){
                                        $win = $gold * $odds[$type][$leiXin][$name];
                                    }                                
                                break;
                            }
                        break;

                        case "danshuang":
                            switch($name){
                                case "guanjun":
                                    if($this->opencode[0]%2){
                                        $result = "dan";
                                    }
                                    else{
                                        $result = "shuang";
                                    }
                                    if(in_array($result,$number)){
                                        $win = $gold * $odds[$type][$leiXin][$name];
                                    }
                                break;

                                case "yajun":
                                    if($this->opencode[1]%2){
                                        $result = "dan";
                                    }
                                    else{
                                        $result = "shuang";
                                    }
                                    if(in_array($result,$number)){
                                        $win = $gold * $odds[$type][$leiXin][$name];
                                    }
                                break;

                                case "jijun":
                                    if($this->opencode[2]%2){
                                        $result = "dan";
                                    }
                                    else{
                                        $result = "shuang";
                                    }
                                    if(in_array($result,$number)){
                                        $win = $gold * $odds[$type][$leiXin][$name];
                                    }                                
                                break;

                                }
                            break;

                            case "guanyahe":
                                $guanyahe = $this->opencode[0] + $this->opencode[1];
                                $result = [];
                                $result[] = $guanyahe >= 13?"da":"xiao";
                                $result[] = $guanyahe%2?"dan":"shuang";
                                foreach($result as $vo){
                                    if(in_array($vo,$number)){
                                        $win += $gold * $odds[$type][$leiXin][$name][$vo];//多了一维定位赔率
                                    }
                                }
                            break;
                    }   
                    break;
                }
                $dice = $this->dice['data']['data'][0];
                //结算订单 table:games_bet_history:update
                $this->active->recordeBetHistory($orderNumber, $dice, $win);
                $playerWin += $win;
                $userId = $playerData[$conId][$orderNumber]['id'];
            }
            //清空数组只返回剩余金币
            $remaining = $playerData[$conId]['remaining'] + $playerWin;

            //更新用户金币数据： table:user_user : update
            $this->active->refleshUser($userId, $remaining);
            //清空数组
            $playerData[$conId] = [];
            //保留remaining
            $playerData[$conId]['remaining'] = $remaining;
        }
        return $playerData;
    }

    /*
     **请求个人的购奖记录
     */
    public function betHistory($yema,$user_id)
    {
        $betHistory = Db::name('games_bet_history')->where(['user_id'=>$user_id])->field('id', true)->order('id desc')->limit($yema*15, 15)->select();
        return $betHistory;
    }

    //最近游戏记录 table::'games_jsks_dice_history'
    public function recentInfo()
    {
        $data = Db::name('games_bjpk10_dice_history')->field('id', true)->order('id desc')->limit(19)->select();
        foreach($data as $key=>$vo){
            $data[$key]['open_code'] = explode(',',$data[$key]['open_code']);
        }
        return $data;
    }
    /*
     *localhost/bcweb/Bjpk10/index/gameHistory?type=dingDanWei&size=30&yeshu=01
     *获取开奖结果以及历史走势并保存在worker.php的 $this->gameHistory 中;
     */
    public function gameHistory($type="",$size="",$yeshu="")
    {
        //基本走势
        //定胆位
        //冠军和
        $findDinDan = [
            "30"=>Db::name("games_bjpk10_dindanwei")->field("id,open_code",true)->order('id desc')->limit(0,30)->select(),
            "50"=>Db::name("games_bjpk10_dindanwei")->field("id,open_code",true)->order('id desc')->limit(0,50)->select(),
            "100"=>Db::name("games_bjpk10_dindanwei")->field("id,open_code",true)->order('id desc')->limit(0,100)->select(),
        ];
        $reverse = [];
        $issue = [];
        foreach($findDinDan as $key=>$vo){
            foreach($vo as $key2 =>$vo2){
                    foreach($vo2 as $key3=>$vo3){
                        if($key3 !="issue"){//期号不需要倒转
                        //解码同时进行倒转
                             $reverse[$key][$key3][$key2] = json_decode($vo3,true);
                        }
                        else{
                            $issue[$key][] = $vo3;
                        }
                    }
            }
        }
        //平均遗漏，最大遗漏找的是历史所有数据
        $findAll = Db::name("games_bjpk10_dindanwei")->field('id,issue,open_code',true)->select();
        $reverseAll = [];
        $newReverseAll = [];
        foreach($findAll as $key=>$vo){
            foreach($vo as $key2 =>$vo2){
                //解码同时进行倒转
                $index = explode("_",$key2)[1];
                if($index<=9){
                    $index= "0".$index;
                }else{
                    $index = (string)$index;
                }
                $reverseAll[$index][$key] = json_decode($vo2,true);
                //装成10*All的数组形式
                foreach($reverseAll[$index][$key] as $key3=>$vo3){
                    $newReverseAll[$index][$key3][$key] = $vo3;
                }   
            }
        }
        $zuidayilou = [];//最大遗漏
        $pinjunyilou = [];//平均遗漏
        foreach($newReverseAll as $key=>$vo){
            foreach($vo as $key2=>$vo2){
                $zuidayilou[$key][$key2] = max($newReverseAll[$key][$key2]);
                //寻找该个数字出现的次数
                $count = array_count_values($newReverseAll[$key][$key2]);
                $cishu = isset($count[0])?$count[0]:0;
                //获取平均遗漏
                $pinjunyilou[$key][$key2] = floor(count($newReverseAll[$key][$key2])/($cishu+1));
            }
        }
        //3*10页的数据  往每一页分析数据里添加最大遗漏与平均遗漏组成总的分析表
        $dinDanWei =  [
            "30"=>[
                "01"=>[
                    "issue"=>$issue['30'],
                    "table"=>$reverse['30']['ball_1'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_1']),
                ],
                "02"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_2'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_2']),
                ],
                "03"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_3'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_3']),
                ],
                "04"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_4'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_4']),
                ],
                "05"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_5'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_5']),
                ],
                "06"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_6'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_6']),
                ],
                "07"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_7'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_7']),
                ],
                "08"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_8'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_8']),
                ],
                "09"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_9'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_9']),
                ],
                "10"=>[
                    "issue"=>$issue['30'],                    
                    "table"=>$reverse['30']['ball_10'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['30']['ball_10']),
                ],
            ],
            "50"=>[
                "01"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_1'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_1']),
                ],
                "02"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_2'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_2']),
                ],
                "03"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_3'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_3']),
                ],
                "04"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_4'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_4']),
                ],
                "05"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_5'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_5']),
                ],
                "06"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_6'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_6']),
                ],
                "07"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_7'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_7']),
                ],
                "08"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_8'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_8']),
                ],
                "09"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_9'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_9']),
                ],
                "10"=>[
                    "issue"=>$issue['50'],
                    "table"=>$reverse['50']['ball_10'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['50']['ball_10']),
                ],
            ],
            "100"=>[
                "01"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_1'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_1']),
                ],
                "02"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_2'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_2']),
                ],
                "03"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_3'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_3']),
                ],
                "04"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_4'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_4']),
                ],
                "05"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_5'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_5']),
                ],
                "06"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_6'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_6']),
                ],
                "07"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_7'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_7']),
                ],
                "08"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_8'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_8']),
                ],
                "09"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_9'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_9']),
                ],
                "10"=>[
                    "issue"=>$issue['100'],
                    "table"=>$reverse['100']['ball_10'],
                    "analyse"=>self::dingDanWeiAnalyse($reverse['100']['ball_10']),
                ],
            ],
        ];
        //把最大遗漏与平均遗漏装到分析表去
        foreach( $dinDanWei as $key=>$vo){
            foreach($vo as $keyI=>$voI){
                $dinDanWei[$key][$keyI]['analyse']['zuidayilou'] = $zuidayilou[$keyI];
                $dinDanWei[$key][$keyI]['analyse']['pinjunyilou'] = $pinjunyilou[$keyI];
            }
        }

        //基本走势
        $basic = [
            "30"=>Db::name("games_bjpk10_basic_trend")->order('id desc')->field("id",true)->limit(30)->select(),
            "50"=>Db::name("games_bjpk10_basic_trend")->order('id desc')->field("id",true)->limit(50)->select(),
            "100"=>Db::name("games_bjpk10_basic_trend")->order('id desc')->field("id",true)->limit(100)->select(),
        ];
        foreach($basic as $key=>$vo){
            foreach($vo as $key2=>$vo2){
                $basic[$key][$key2]['open_code'] = explode(",",$vo2['open_code']);
            }
        }
        //冠亚和两面  ---------------分析还没做
        $liangMian = [
            "30"=>[
                "table"=>Db::name("games_bjpk10_guanyahe_liangmian")->order('id desc')->field("id",true)->limit(30)->select(),
                "analyse"=>self::liangMianAnalyse(30),
            ],
            "50"=>[
                "table"=>Db::name("games_bjpk10_guanyahe_liangmian")->order('id desc')->field("id",true)->limit(50)->select(),
                "analyse"=>self::liangMianAnalyse(50),
            ],
            "100"=>[
                "table"=>Db::name("games_bjpk10_guanyahe_liangmian")->order('id desc')->field("id",true)->limit(100)->select(),
                "analyse"=>self::liangMianAnalyse(100),
            ],
        ];
        //冠亚和号码分布
        $haomafenbu = [
            "30"=>[
                "table"=>Db::name("games_bjpk10_guanyahe_haomafenbu")->order('id desc')->field("id",true)->limit(30)->select(),
                "analyse"=>self::haoMaFenBuAnalyse(30),
            ],
            "50"=>[
                "table"=>Db::name("games_bjpk10_guanyahe_haomafenbu")->order('id desc')->field("id",true)->limit(50)->select(),
                "analyse"=>self::haoMaFenBuAnalyse(50),
            ],
            "100"=>[
                "table"=>Db::name("games_bjpk10_guanyahe_haomafenbu")->order('id desc')->field("id",true)->limit(100)->select(),
                "analyse"=>self::haoMaFenBuAnalyse(100),
            ],
        ];
        $result = [
            "dingDanWei" =>$dinDanWei,
            "basicPk10"=>$basic,
            "guanYaHe"=>[
                "30"=>[
                    $liangMian["30"],
                    $haomafenbu["30"],
                ],
                "50"=>[
                    $liangMian["50"],
                    $haomafenbu["50"],
                ],
                "100"=>[
                    $liangMian["100"],
                    $haomafenbu["100"],
                ],
            ],
        ];
        if($type!=""){
            if($yeshu!=""){
                echo json_encode($result[$type][$size][$yeshu]);exit;//定胆位
            }
            echo json_encode($result[$type][$size]);exit;
        }
        // echo json_encode($result);exit;
        return $result;
    }
    /**
     * 定胆位分析
     * 分析十个数字在本次查询中的数据
     * "chuxiancishu":出现次数//本次
     * "zuidaliangchu":最大连出//本次
     * "pingjunyilou":平均遗漏//历史
     * "zuidayilou":最大遗漏//历史
     */
    public function dingDanWeiAnalyse($array){
        $reverse = [];
        foreach($array as $key=>$vo){
            if($key!="issue"){
                foreach($vo as $keyI => $voI){
                    $reverse[$keyI][$key] = $voI;
                }
            }
        }
        //出现次数
        $cishu = [
            "1"=> count(array_keys($reverse['1'],"0")),
            "2"=> count(array_keys($reverse['2'],"0")),
            "3"=> count(array_keys($reverse['3'],"0")),
            "4"=> count(array_keys($reverse['4'],"0")),
            "5"=> count(array_keys($reverse['5'],"0")),
            "6"=> count(array_keys($reverse['6'],"0")),
            "7"=> count(array_keys($reverse['7'],"0")),
            "8"=> count(array_keys($reverse['8'],"0")),
            "9"=> count(array_keys($reverse['9'],"0")),
            "10"=> count(array_keys($reverse['10'],"0")),
        ];
        //最大连出
        $dalianOut = [
            '1'=>[0],
            '2'=>[0],
            '3'=>[0],
            '4'=>[0],
            '5'=>[0],
            '6'=>[0],
            '7'=>[0],
            '8'=>[0],
            '9'=>[0],
            '10'=>[0],
        ];

        foreach($reverse as $key=>$vo){
            //相同则增加一个和值连出数并且比上一个大1
            foreach($vo as $keyI => $voI){
                if($voI==0){
                    $dalianOut[$key][count($dalianOut[$key])] = $dalianOut[$key][count($dalianOut[$key])-1]+1;
                }
                else{
                    $dalianOut[$key][count($dalianOut[$key])] = 0;
                }
            }
        }
        //取最大数
        foreach($dalianOut as $key=>$vo){
            $dalianOut[$key] = max($dalianOut[$key]);
        }
        $result = [];
        for($i=1;$i<=10;$i++){
            $result['zuidaliangchu'][$i] = $dalianOut[$i];
            $result["chuxiancishu"][$i] = $cishu[$i]; 
        }
        return $result;
    }

    /**
     * 冠亚和两面分析
     * @acount大小
     */
    public function liangMianAnalyse($acount){
        /**
         * 出现次数，最大连出使用的是当前的查询的期数来分析
         * 平均遗漏，最大遗漏使用的是历史总的期数作为分析
         */
        $data = Db::name("games_bjpk10_guanyahe_liangmian")->order('id desc')->field("heda,hexiao,hedan,heshuang")->limit($acount)->select();
        $all = Db::name("games_bjpk10_guanyahe_liangmian")->field("heda,hexiao,hedan,heshuang")->select();

        //历史总的期数
        $acountAll = count($all);
        //倒转当前期数
        foreach($data as $key=>$vo){
            foreach($vo as $vokey=>$vovo){
                $new[$vokey][$key]=(int)$vovo;
            }
        }
        //倒转所有期数
        foreach($all as $key=>$vo){
            foreach($vo as $vokey=>$vovo){
                $newAll[$vokey][$key]=(int)$vovo;
            }
        }
        
        //当前期数的和|大小单双出现的次数
        $heda = array_count_values($new['heda'])['0'];
        $hexiao = array_count_values($new['hexiao'])['0'];
        $hedan = array_count_values($new['hedan'])['0'];
        $heshuang = array_count_values($new['heshuang'])['0'];
        //历史总的和|大小单双出现的次数
        $hedaAll = array_count_values($newAll['heda'])['0'];
        $hexiaoAll = array_count_values($newAll['hexiao'])['0'];
        $hedanAll = array_count_values($newAll['hedan'])['0'];
        $heshuangAll = array_count_values($newAll['heshuang'])['0'];
        $result = [
            "times"=>[
                "heda"=>$heda,
                "hexiao"=>$hexiao,
                "hedan"=>$hedan,
                "heshuang"=>$heshuang,
            ],//出现的次数

            "pinjunyilou"=>[
                "heda"=>floor($acountAll/($hedaAll)+1),
                "hexiao"=>floor($acountAll/($hexiaoAll)+1),
                "hedan"=>floor($acountAll/($hedanAll)+1),
                "heshuang"=>floor($acountAll/($heshuangAll)+1),
            ],//平均遗漏

            "zuidayilou"=>[
                "heda"=>max($newAll['hexiao']),
                "hexiao"=>max($newAll['heda']),
                "hedan"=>max($newAll['heshuang']),
                "heshuang"=>max($newAll['hedan']),
            ],//最大遗漏

            "zuidalianchu"=>[
                "heda"=>[0],
                "hexiao"=>[0],
                "hedan"=>[0],
                "heshuang"=>[0],
            ]//最大连出 初始化为连出数组最终结果为数组里的最大值
        ];
        foreach($newAll as $key=>$vo){
            foreach($vo as $vokey=>$vovo){
                if($vovo == 0){
                    $result['zuidalianchu'][$key][] = $result['zuidalianchu'][$key][count($result['zuidalianchu'][$key])-1]+1;
                }
                else{
                    $result['zuidalianchu'][$key][] = 0;
                }
            }
            $result['zuidalianchu'][$key] = max($result['zuidalianchu'][$key]);
        }
        return $result;
    }

    /**
     * 冠亚和号码分布分析
     * @acount大小
     */
    public function haomaFenBuAnalyse($acount){
        /**
         * 出现次数，最大连出使用的是当前的查询的期数来分析
         * 平均遗漏，最大遗漏使用的是历史总的期数作为分析
         */
        $data = Db::name("games_bjpk10_guanyahe_haomafenbu")->order('id desc')->field("id,issue,guanyahe",true)->limit($acount)->select();
        $all = Db::name("games_bjpk10_guanyahe_haomafenbu")->field("id,issue,guanyahe",true)->select();

        //历史总的期数
        $acountAll = count($all);

        //倒转当前期数
        foreach($data as $key=>$vo){
            foreach($vo as $vokey=>$vovo){
                $new[$vokey][$key]=(int)$vovo;
            }
        }

        //倒转所有期数
        foreach($all as $key=>$vo){
            foreach($vo as $vokey=>$vovo){
                $newAll[$vokey][$key]=(int)$vovo;
            }
        }        
        $result = [
            "times"=>[],
            "pinjunyilou"=>[],
            "zuidayilou"=>[],
            "zuidalianchu"=>[]
        ];

        //所有期数每个值出现的次数
        foreach($newAll as $key => $vo){
            $timesAll[$key] = array_count_values($newAll[$key])['0'];
        }

        foreach($new as $key=>$vo){
            $result["times"][$key] = isset(array_count_values($new[$key])['0'])?array_count_values($new[$key])['0']:0;
            $result["pinjunyilou"][$key] = floor($acountAll/($timesAll[$key]+1));
            $result["zuidayilou"][$key] = max($newAll[$key]);
            //此处为连出的数组，最大连出为连出里的最大值
            $zuidalianchu[$key][0]=0;
        }
        foreach($new as $key=>$vo){
            foreach($vo as $vokey=>$vovo){
                if($vovo==0){
                    $zuidalianchu[$key][]=$zuidalianchu[$key][count($zuidalianchu[$key])-1]+1;
                }
                else{
                    $zuidalianchu[$key][]=0;
                }
            }
        } 
        foreach($zuidalianchu as $key=>$vo){
            $result['zuidalianchu'][$key]=max($zuidalianchu[$key]);
        }
        return $result;
    }
    /**
     * 生成下注订单
     * @$order： 前端传来的订单信息
     * @createTime:订单创建时间
     * $orderNumber:订单号
     * $fileOdds:赔率表
     *
     */
    public function createOrder($order, $createTime, $orderNumber, $fileOdds)
    {
        $type = $order['type']; //大分类
        $leiXin = $order["leiXin"]; //类型
        $name = $order["name"];
        $smallName = $order['smallName'];
        $number = $order["number"]; //押注号码的数组
        /**
         * 构造赔率
         */
        $fileOdds = $fileOdds['odds'];
        $odds = [];
        switch($type){
            case "guanyahe":
            foreach($number as $key=>$vo){
                $index = "sum_".$vo;
                $odds[] = $fileOdds[$type][$leiXin][$name][$index];
            }
            break;

            case "daxiaodanshuang":
            foreach($number as $key=>$vo){
                $odds[] = $fileOdds[$type][$leiXin][$name][$vo];
            }
            break;
            default:
                $odds[] = $fileOdds[$type][$leiXin][$name];
            break;
        }
        $odds = implode(',',$odds);

        $numberStr;
        switch($type){
            case "qianyi":
                $numberStr = implode(',',$number);
            break;
            case "qianer":
                $numberStr = implode(',',$number['guanjun'])."|".implode(',',$number['yajun']);
            break;
            case "qiansan":
                $numberStr = implode(',',$number['guanjun'])."|".implode(',',$number['yajun'])."|".implode(',',$number['jijun']);
            break;
            default:
            $numberStr = implode(',',$number);
            break;
        }
        $data = [
            'user_id' => $order['id'], //用户id
            'issue' => $order['issue'], //押注期号
            'gold' => $order['zhuShu'] . "注  " . $order['gold'] . "金币", //押注金额 注数+金额
            'order_number' => $orderNumber, //押注单号
            'name' => $type."_".$name, //押注名称
            'return_point' => 0, //返点
            'create_time' => $createTime,
            'number' => $numberStr, //押注数据
            'odds' => $odds, //押注赔率
            "avatar" => $order['avatar'], //头像
            "key" => $order['key'], //关键字
            "gameName" => $order['gameName'], //游戏名字
        ];

        $bet = Db::name('games_bet_history')->insert($data);
        if ($bet) {
            $result = [
                'create' => true,
            ];
        } else {
            $result = [
                'create' => false,
            ];

        }
        echo "------------create success--------------\n";
        return $result;
    }

    /**
     * 检测金币状态
     */
    public function createCheck($allGold, $id)
    {
        $findGold = Db::name("user_user")->where(['id' => $id])->value('gold');
        if ($findGold >= $allGold) {
            //金币足够扣除，返回剩余金币
            $result = [
                "status" => true,
                "remaining" => $findGold - $allGold,
            ];
        } else {
            //金币不够，不扣除返回剩下金币
            $result = [
                "status" => false,
                "remaining" => $findGold,
            ];
        }
        return $result;
    }

    /**
     * 江苏快三近期开奖记录
     * ajax 请求近期开奖
     */
    public function recentOpen($yema)
    {
        $recentOpen = Db::name('games_bjpk10_dice_history')->field('issue,open_time,open_code')->limit($yema*15,15)->order('id desc')->select();
        foreach($recentOpen as $key => $vo){
            $recentOpen[$key]['open_code'] = explode(',',$recentOpen[$key]['open_code']);
        }
        return $recentOpen;
    }
    //撤销订单
    public function destroyOrder($orderNumber)
    {
        $data = Db::name('games_bet_history')->where(['order_number' => $orderNumber])->field('id,user_id,status,gold')->find();

        //订单还没有被结算可以撤销
        if ($data && $data['status'] == 0) {
            try {
                $Dgold = substr($data['gold'], strpos($data['gold'], ' ') + 1); //把金币数分割出来
                $gold = str_replace("金币", '', $Dgold); //分割金币数
            } catch (\Exception $e) {
                throw $e;
            }

            //更改订单状态为3已撤销
            Db::name('games_bet_history')->where(['id' => $data['id']])->update(['status' => 3]);
            $result = [
                'cancel' => true,
                'cancelGold' => $gold,
            ]; //撤销成功
            echo "---destroy success---\n";
        } else {
            $result = ['cancel' => false]; //订单 已经删除或者已经结算
            echo "---destroy faile---\n";
        }
        return $result;
    }

    //返回桌面信息 table::
    public function deskInfo()
    {
        $data = file_get_contents(dirname(dirname(__FILE__)) . "/send.json");
        return json_decode($data, true);
    }

    //数据结构
    public function dataType()
    {

        $playerData = [
            '2' => [
                '0' => [
                    "id" => 11, //用户的id
                    'type' => "qianyi",
                    'leiXin' => "qianyi", //前一 - 前一
                    "name"=>"qianyi",
                    "number" => ['01', '02','04','05','07','08','09','10'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '1' => [
                    "id" => 11, //用户的id
                    'type' => "qianer",
                    'leiXin' => "qianer", //前一 - 前一
                    "name"=>"qianerfushi",
                    "number" => ['guanjun'=>['01', '02','04','05','07','08','09','10'], "yajun"=>['01', '02','04','05','07','08','09','10']],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '2' => [
                    "id" => 11, //用户的id
                    'type' => "qianer",
                    'leiXin' => "qianer", //前一 - 前一
                    "name"=>"qianerdanshi",
                    "number" => ['guanjun'=>['01', '02','04','05','07','08','09','10'], "yajun"=>['01', '02','04','05','07','08','09','10']],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '3' => [
                    "id" => 11, //用户的id
                    'type' => "qiansan",
                    'leiXin' => "qiansan", //前一 - 前一
                    "name"=>"qiansanfushi",
                    "number" => [
                                "guanjun"=>['01', '02','04','05','07','08','09','10'],
                                "yajun"=>['01', '02','04','05','07','08','09','10'],
                                'jijun'=>['01', '02','04','05','07','08','09','10']
                            ],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '4' => [
                    "id" => 11, //用户的id
                    'type' => "qiansan",
                    'leiXin' => "qiansan", //前一 - 前一
                    "name"=>"qiansandanshi",
                    "number" => [
                        "guanjun"=>['01'],
                        "yajun"=>['02'],
                        'jijun'=>['03']
                    ],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '5' => [
                    "id" => 11, //用户的id
                    'type' => "dindanwei",
                    'leiXin' => "dindanwei", //前一 - 前一
                    "name"=>"dindanwei",
                    "number" => ['01', '02','04','05','07','08','09','10'],
                    "smallName"=>"guanjun",//亚军季军
                    //smallName所有字段 guanjun yajun jijun di4min di5min di6min di7min di8min di9min di10min
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '6' => [
                    "id" => 11, //用户的id
                    'type' => "dindanwei",
                    'leiXin' => "dindanwei", //前一 - 前一
                    "name"=>"1~5",
                    "number" => ['01', '02','04','05','07','08','09','10'],
                    "smallName"=>"guanjun",
                    //smallName所有字段 guanjun yajun jijun di4min di5min di6min 
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '7' => [
                    "id" => 11, //用户的id
                    'type' => "dindanwei",
                    'leiXin' => "dindanwei", //前一 - 前一
                    "name"=>"6~10",
                    "number" => ['01', '02','04','05','07','08','09','10'],
                    "smallName"=>"di6min",//亚军季军
                    //smallName所有字段 di6min di7min di8min di9min di10min
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '8' => [
                    "id" => 11, //用户的id
                    'type' => "guanyahe",
                    'leiXin' => "guanyahe", //前一 - 前一
                    "name"=>"hezhi",
                    "number" => ["3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19"],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '9' => [
                    "id" => 11, //用户的id
                    'type' => "longhu",
                    'leiXin' => "longhu", //前一 - 前一
                    "name"=>"guanjun",
                    "number" => ['long', 'hu'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '10' => [
                    "id" => 11, //用户的id
                    'type' => "longhu",
                    'leiXin' => "longhu", //前一 - 前一
                    "name"=>"yajun",
                    "number" => ['long', 'hu'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '12' => [
                    "id" => 11, //用户的id
                    'type' => "longhu",
                    'leiXin' => "longhu", //前一 - 前一
                    "name"=>"jijun",
                    "number" => ['long', 'hu'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '13' => [
                    "id" => 11, //用户的id
                    'type' => "longhu",
                    'leiXin' => "longhu", //前一 - 前一
                    "name"=>"disimin",
                    "number" => ['long', 'hu'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '14' => [
                    "id" => 11, //用户的id
                    'type' => "longhu",
                    'leiXin' => "longhu", //前一 - 前一
                    "name"=>"diwumin",
                    "number" => ['long', 'hu'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '15' => [
                    "id" => 11, //用户的id
                    'type' => "wuxin",
                    'leiXin' => "wuxin", //前一 - 前一
                    "name"=>"guanjun",
                    "number" => ['01', '02','04','05','07','08','09','10'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '16' => [
                    "id" => 11, //用户的id
                    'type' => "wuxin",
                    'leiXin' => "wuxin", //前一 - 前一
                    "name"=>"yajun",
                    "number" => ['01', '02','04','05','07','08','09','10'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '17' => [
                    "id" => 11, //用户的id
                    'type' => "wuxin",
                    'leiXin' => "wuxin", //前一 - 前一
                    "name"=>"jijun",
                    "number" => ['01', '02','04','05','07','08','09','10'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '18' => [
                    "id" => 11, //用户的id
                    'type' => "daxiaodanshuang",
                    'leiXin' => "daxiao", //前一 - 前一
                    "name"=>"daxiao~guanjun",
                    "number" => ['da', 'xiao'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '19' => [
                    "id" => 11, //用户的id
                    'type' => "daxiaodanshuang",
                    'leiXin' => "danshuang", //前一 - 前一
                    "name"=>"danshuang~yajun",
                    "number" => ['dan', 'shuang'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '20' => [
                    "id" => 11, //用户的id
                    'type' => "daxiaodanshuang",
                    'leiXin' => "daxiao", //前一 - 前一
                    "name"=>"daxiao~jijun",
                    "number" => ['da', 'xiao'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
                '21' => [
                    "id" => 11, //用户的id
                    'type' => "daxiaodanshuang",
                    'leiXin' => "guanyahe", //前一 - 前一
                    "name"=>"daxiaodanshuang",
                    "number" => ['dan', 'shuang'],
                    "smallName"=>"",
                    "gold" => 10,
                    "allGold" => 50, //下注总金额
                    "total" => 5, //总注数
                    "remaining" => 1000, //剩余金币user_user表查询
                ],
            ],
        ];

        // $data = [];
        $result = [];
        $i = -10;
        do {
            $diceResult = self::diceResult();
            $result[] = self::begin($playerData, $diceResult);

            $i++;
        } while ($i);
        dump($result);
    }

}
