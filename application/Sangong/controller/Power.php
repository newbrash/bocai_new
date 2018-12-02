<?php 
namespace app\Sangong\controller;
use think\Controller;
/**开挂总则

    /**特殊牌型  每发一张牌就卸掉一张牌
     * 三公:  [10,11,12, 23,24,25, 36,37,38, 49,50,51 ];
     * 对子:  [0,13,26,39]  +rand(1,3)一次 rand(count(array))一次
     * 三条:  [0,13,26,39]  +rand(1,2)两次
     * 同花顺: [0,2,3,4,5,6, 13,15,16,17,18, 26,27,28,29, 39,40,41,42,43] if(in_array([0 13 26 39]))[a,a+11,a+12] else [a,a+1,a+2]
     * 零点:[[0,8],[1,7],[2,6],[3,5],[13,21],[14,20],[15,19],[16,18],[26,34],[27,33],[28,32]]
     * 赢输和:先产生庄家的牌,庄家的牌是被限制在 3-2p7之间 
     * 
     * 赢: 庄家p值： 0p:先给闲家发一个p剩下两张牌随意  1p:先给闲家发两个p,剩下随意
     *     2p：先给闲家发两个p之后找一个比庄家个位数大的牌
     * 输: 庄家p值： 0p 给闲家发零点,再发一个较小的牌 1p,2p:随机3张牌 一个p也不发给闲家
     * 和: 庄家p值： 0p 给闲家发零点,再发一个大小一样的牌 1p:先给庄家发一张p,再随意发一张非p,用size+10或者size减去非p值的牌
     * 最后从总牌组里提取最后一张牌   2p:先发两张p  再发一张大小一致的牌
     */

     /**
      * 闲家开挂使用上述方式开挂
      * 庄家开挂使用上述输与赢即可
      * 注意事项:上述的牌型可以进行扩充与调整以达到发牌多样性以及优化发牌速度
      */
// class Power extends Controller{
    class Power{
    //平台玩家发牌

    public $deck = array();//总的牌组
    public $p = array();   // 公牌
    public $notP = array();//非公牌
    public function __construct(){
        for($i=1;$i<=13;$i++){
            $this->deck[$i] = ['color'=>'red','size'=>$i];//红心
            $this->deck[$i+13] = ['color'=>'spade','size' =>$i];//黑桃
            $this->deck[$i+26] = ['color' =>'diamond','size'=>$i];//方砖
            $this->deck[$i+39] = ['color'=>'wintersweet','size' =>$i];//梅花
        }
        //整合数组 令数组从零开始
        $this->p = [
            11,12,13,
            24,25,26,
            37,38,39,
            50,51,52,
        ];
        $this->notP = [
            1,2,3,4,5,6,7,8,9,10,
            14,15,16,17,18,19,20,21,22,23,
            27,28,29,30,31,32,33,34,35,36,
            40,41,42,43,44,45,46,47,48,49,
        ];
    }
    // public function bocaiDeal($power,$goldPool){
    public function bocaiDeal(){
        // $power = json_decode($power,true);
        
        // $goldPool = [
        //         "player1" => [
        //             "toDeal" => 0,
        //             "sanGong" => 0,
        //             "win" => 100,
        //             "peace" => 0,
        //             "lose" => 10,
        //         ],
        //         "player2" => [
        //             "toDeal" => 0,
        //             "sanGong" => 0,
        //             "win" => 10,
        //             "peace" => 0,
        //             "lose" => 100,
    
        //         ],
        //         "player3" => [
        //             "toDeal" => 0,
        //             "sanGong" => 0,
        //             "win" => 0,
        //             "peace" => 0,
        //             "lose" => 0,
        //         ],
        // ];//金币池

        $power = [
            "player"=>"banker",
        ];

        $power = [
            "player"=>"player",
            "bet"=>[
                '0'=> ["player" =>"player2","status" =>"toDeal"],
                '1'=> ["player" =>"player1","status" =>"win"],
                '2'=> ["player" =>"player23","status" =>"sanGong"],
            ],
            "gold "=>10,
        ];

        $card = array();
        //平台玩家是庄家
        if($power["player"] == "banker"){
            
            //根据金币池里的金币数量开牌，目前只根据输赢两个池开牌，默认其它金币池全收，只开输赢
            $card = self::bankerPower($goldPool);
        }
        else{//平台玩家是闲家
            $card = self::playerPower($power);
        }
        return $card;
    }

    /**   第一版完成
     * 1：庄家1个p，两个非p的随机牌
     *    闲家赢：2个非对子非同花p，一个2到9的随机牌
     *    闲家输：3个非对子非同花非顺子并且非p的随机牌
     * 2：上面设定决定闲家不开三公，不开和牌
     *    闲家开非 对子 顺子 同花顺 三条 同花
     */

    public function bankerPower($goldPool){

         $countDeck = count($this->deck);//总牌组长度;
         $countP = count($this->p);//公牌组长度;
         $countNotP = count($this->notP);//非公牌长度;
         $banker = [];
         $player1 = [];
         $player2 = [];
         $player3 = [];

        /**
         * 产生庄家的牌：1个p，两个非p的随机牌
         */
        //生成公牌
         $bankerPSub = rand(0,$countP-1);
         $bankerP = $this->p[$bankerPSub];
         
         //卸掉已开的公牌,并且重新整理牌组
         unset($this->p[$bankerPSub]);
         $this->p = array_values($this->p);

         //生成非公牌
         $bankerNotP1Sub = rand(0,$countNotP-1);
         $bankerNotP1 = $this->notP[$bankerNotP1Sub];
         //卸掉已开的非公牌,并且重新整理牌组
         unset($this->notP[$bankerNotP1Sub]);
         $this->notP = array_values($this->notP);

         $countNotP = count($this->notP);
         //生成非公牌2
         $bankerNotP2Sub = rand(0,$countNotP-1);
         $bankerNotP2 = $this->notP[$bankerNotP2Sub];
         //卸掉已开的非公牌,并且重新整理牌组
         unset($this->notP[$bankerNotP2Sub]);
         $this->notP = array_values($this->notP);

         $banker = [
                $this->deck[$bankerP],
                $this->deck[$bankerNotP1],
                $this->deck[$bankerNotP2],
          ]; 


         //根据规则产生对应闲家的牌
         foreach($goldPool as $player => $pool){
            
            $PK = $pool['win'] - $pool['lose'];
            //吃掉金币池比较大的那一个
            switch($PK){   

               //    $$player: 对应 $player1 $player2 $player3
               case $PK >= 0:
                   $$player = self::playerLose();
               break;

               case $PK < 0:
                   $$player = self::playerWin();
               break;

               default:
               break;
            }
         }
         $card = [
             "banker" => $banker,
             "player1" => $player1,
             "player2" => $player2,
             "player3" => $player3,
         ];
         return $card;
    }
    
    /**  
     * 1:三公,对牌
     * 2：庄家1个p，两个非p的随机牌
     *    闲家和：1个p，一个随机牌，庄家点数-随机牌的值 
     *    闲家赢：2个非对子非同花p，一个2到9的随机牌
     *    闲家输：3个非对子非同花非顺子并且非p的随机牌
     * 3：上面设定决定闲家不开三公，不开和牌
     *    闲家开非 对子 顺子 同花顺 三条 同花,非公牌组合里找出对子 顺子 同花顺 三条 同花
     */
    public function playerPower($power){
        
    }
    /**
     * 闲家赢：2个非对子非同花p，一个2到9的随机牌
     */
    public function playerWin(){
        $countP = count($this->p);//公牌组长度;
        $countNotP = count($this->notP);//非公牌长度;
        $flag = 0;//规则标志
        do{
            $playerP1Sub = rand(0,$countP-1);
            $playerP2Sub = rand(0,$countP-1);

            $playerP1 = $this->p[$playerP1Sub];
            $playerP2 = $this->p[$playerP2Sub];

            $playerP1Deck = $this->deck[$playerP1];
            $playerP2Deck = $this->deck[$playerP2];

            
            //同一张牌，对子，同花不通过
            if( ($playerP1Deck == $playerP2Deck) || ($playerP1Deck['size'] == $playerP2Deck['size']) || ($playerP1Deck['color'] == $playerP2Deck['color'])){
                $flag = 1;
            }
            else{
                $flag = 0;
            }
        }while($flag);

        unset($this->p[$playerP1Sub]);
        unset($this->p[$playerP2Sub]);
        $this->p = array_values($this->p);
  
        //2-9的牌
        $flag = 0;
        do{
            $playerNotPSub = rand(0,$countNotP-1); 
            $playerNotP = $this->notP[$playerNotPSub];
            $playerNotPDeck = $this->deck[$playerNotP];
            if($playerNotPDeck['size']>9&&$playerNotPDeck['size']<2){
                $flag = 1;
            }
            else{
                $flag = 0;
            }
        }while($flag);

        unset($this->notP[$playerNotPSub]);
        $this->notP = array_values($this->notP);

        $playerCard = [
            $playerP1Deck,$playerP2Deck,$playerNotPDeck,
        ];
        return $playerCard;
    }

    // 闲家输：3张非对子非同花非顺子并且非p的牌
    public function playerLose(){
        $card = [];
        $countNotP = count($this->notP);
        do{
            $playerNotP1Sub = rand(0,$countNotP-1); //2
            $playerNotP2Sub = rand(0,$countNotP-1); //2
            $playerNotP3Sub = rand(0,$countNotP-1); //2
            
            $playerNotP1 = $this->notP[$playerNotP1Sub];
            $playerNotP2 = $this->notP[$playerNotP2Sub];
            $playerNotP3 = $this->notP[$playerNotP3Sub];

            $card[] = $this->deck[$playerNotP1];
            $card[] = $this->deck[$playerNotP2];
            $card[] = $this->deck[$playerNotP3];
 
            $straight = self::straight($card); //顺子
            $flush = self::flush($card); //同花
            $pair = self::pair($card); //对子
            

            if($straight||$flush||$pair){//9
                $flag = 1;
                $card = [];
            }
            else{
                $flag = 0;
            }
        }while($flag);
        unset($this->notP[$playerNotP1Sub]);
        unset($this->notP[$playerNotP2Sub]);
        unset($this->notP[$playerNotP3Sub]);

        $this->notP = array_values($this->notP);
        return $card;
    }

    //计算顺子
    public function straight($card){
        $flag = 0;
        // 把数组的大小取出来
        $array = [
            '0'=>$card[0]['size'],
            '1'=>$card[1]['size'],
            '2'=>$card[2]['size']
        ];
        // 升序排列数组
        sort($array);
        //最大值比最小值大2或者A Q K牌型
        if(($array[2]-$array[0]==2)||($array[0]==1&&$array[1]==12&&$array[2]==13)){
            $flag = 1;
        }
        return $flag;
    }
    
    //计算对子
    public function pair($card){
        $flag = 0;
        // 把数组的大小取出来
        $array = [
            '0'=>$card[0]['size'],
            '1'=>$card[1]['size'],
            '2'=>$card[2]['size']
        ]; 
        if($array[0]==$array[1]||$array[0]==$array[2]||$array[1]==$array[2]){
            $flag = 1;
        } 
        return $flag;
    }

    //计算同花  flush  pair straight three
    public function flush($card){
        $flag = 0;
        if(($card[0]['color'] == $card[1]['color']&&$card[1]['color'] == $card[2]['color'])){
            $flag = 1;
        }
        return $flag;

    }

    //各种牌型数组
    public function cardType(){
        /**
         * 特征
         * 顺子
         *  
         */        
        $p = [
            10,11,12,
            23,24,25, 
            36,37,38, 
            49,50,51,
        ];
        echo $p[0];

        $notP = [
            0,1,2,3,4,5,6,7,8,9,
            13,14,15,16,17,18,19,20,21,22,
            26,27,28,29,30,31,32,33,34,35,
            39,40,41,42,43,44,45,46,47,48,
        ];
    }


/**
 * 情景假设
 * 情景1: 庄家:0p7   闲家1 : 三公 闲家2: 赢    闲家3:三公
 * 情景2: 庄家:1p7   闲家1 : 三公 闲家2: 输    闲家3:三公
 * 情景3: 庄家:2p7   闲家1 : 三公 闲家2: 赢    闲家3:和局
 * 情景4: 庄家:0p7   闲家1 : 三公 闲家2: 对牌  闲家3:三公
 * 情景5: 庄家:1p7   闲家1 : 赢   闲家2: 和局  闲家3:三公
 * 情景6: 庄家:2p7   闲家1 : 和 闲家2: 和  闲家3:和
 */
}



    /**特殊牌型  每发一张牌就卸掉一张牌
     * 三公:  [10,11,12, 23,24,25, 36,37,38, 49,50,51];
     * 对子:  [0,13,26,39]  +rand(1,3)一次 rand(count(array))一次
     * 三条:  [0,13,26,39]  +rand(1,2)两次
     * 同花顺: [0,2,3,4,5,6, 13,15,16,17,18, 26,27,28,29, 39,40,41,42,43] if(in_array([0 13 26 39]))[a,a+11,a+12] else [a,a+1,a+2]
     * 零点:[[0,8],[1,7],[2,6],[3,5],[13,21],[14,20],[15,19],[16,18],[26,34],[27,33],[28,32]]
     * 赢输和:先产生庄家的牌,庄家的牌是被限制在 3-2p7之间 
     * 
     * 赢: 庄家p值： 0p:先给闲家发一个p剩下两张牌随意  1p:先给闲家发两个p,剩下随意
     *     2p：先给闲家发两个p之后找一个比庄家个位数大的牌
     * 输: 庄家p值： 0p 给闲家发零点,再发一个较小的牌 1p,2p:随机3张牌 一个p也不发给闲家
     * 和: 庄家p值： 0p 给闲家发零点,再发一个大小一样的牌 1p:先给庄家发一张p,再随意发一张非p,用size+10或者size减去非p值的牌
     * 最后从总牌组里提取最后一张牌   2p:先发两张p  再发一张大小一致的牌
     */
file_put_contents(dirname(__FILE__)."./power.json",'');
for($i=0;$i<=1000;$i++){
    $bocaiPower = new Power;
    $banker = $bocaiPower->bocaiDeal();
    $temp = json_encode($banker);
    file_put_contents(dirname(__FILE__)."./power.json",$temp.",\n",FILE_APPEND);
}
