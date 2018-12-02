<?php
namespace app\Cqssc\controller;

use think\Db;

class Dbop
{
    /**
     * 保存开奖信息
     */
    public static function saveOpenResult($result)
    {
        $opencode = $result['opencode'];
        $result['opencode'] = implode(',', $result['opencode']);
        $id = DB::name("cqssc_result")->insertGetId($result);
        try {
            // $opencode = explode(',', $result['opencode']);
            $keys = [
                'wan_'.$opencode['wan'],
                'qian_'.$opencode['qian'],
                'bai_'.$opencode['bai'],
                'shi_'.$opencode['shi'],
                'ge_'.$opencode['ge'],
                'wan_'.self::isMaxKey($opencode['wan']),
                'qian_'.self::isMaxKey($opencode['qian']),
                'bai_'.self::isMaxKey($opencode['bai']),
                'shi_'.self::isMaxKey($opencode['shi']),
                'ge_'.self::isMaxKey($opencode['ge']),
                'wan_'.self::isDoubleKey($opencode['wan']),
                'qian_'.self::isDoubleKey($opencode['qian']),
                'bai_'.self::isDoubleKey($opencode['bai']),
                'shi_'.self::isDoubleKey($opencode['shi']),
                'ge_'.self::isDoubleKey($opencode['ge']),
            ];
            $trend = DB::name("cqssc_trend")->order('id desc')->find();
            
            if ($trend) {
                unset($trend['id']);
                unset($trend['open_code']);
                unset($trend['expect']);
                foreach ($trend as $key => $vo) {
                    if (in_array($key, $keys)) {
                        $trend[$key] = 0;
                    } else {
                        $trend[$key]++;
                    }
                }
            } else {
                foreach ($opencode as $key => $vo) {
                    $index = $key."_";
                    for ($i=0; $i<10; $i++) {
                        if ($i == $vo) {
                            $trend[$index.$i] = 0;
                        } else {
                            $trend[$index.$i] = 1;
                        }
                    }
                    $k1 = self::isMaxKey($vo);
                    if ($k1 == 'da') {
                        $trend[$index.'da'] = 0;
                        $trend[$index.'xiao'] = 1;
                    } else {
                        $trend[$index."da"] = 1;
                        $trend[$index."xiao"] = 0;
                    }
                    $k1 = self::isDoubleKey($vo);
                    if ($k1 == 'dan') {
                        $trend[$index.'dan'] = 0;
                        $trend[$index.'shuang'] = 1;
                    } else {
                        $trend[$index.'dan'] = 1;
                        $trend[$index.'shuang'] = 0;
                    }
                }
            }
            $trend['open_code'] = $result['opencode'];
            $trend['expect'] = $result['expect'];
            // dump($trend);
            DB::name('cqssc_trend')->insert($trend);
        } catch (\Exception $e) {
            echo "save result error:".$e->getMessage()." in file:".$e->getFile()." at line:".$e->getLine()."\n";
        }
        return $id;
    }

    /**
     * 判断大小
     */
    public static function isMaxKey($code)
    {
        if ($code > 4) {
            return 'da';
        } else {
            return 'xiao';
        }
    }
    /**
     * 判断单双
     */
    public static function isDoubleKey($code)
    {
        if ($code % 2) {
            return 'dan';
        } else {
            return 'shuang';
        }
    }
    /**
     * 获取下注信息
     */
    public static function getBetsInfo($expect)
    {
        $list = Db::name('cqssc_nbet')->where(['status'=>0,'expect'=>$expect])->select();
        return $list;
    }

    /**
     * 获取赔率信息
     */
    public static function getOdds($data)
    {
        $list = DB::name('cqssc_odds')->select();
        $odds =[
                'wuxin'=> [  // 五星
                    'zhixuan'=>[  // 直选
                        'fushi'=> $list[0]['odds'], // 复式
                        'danshi'=> $list[1]['odds'], // 单式
                        'zuhe'=> $list[2]['odds']."~".($list[2]['odds']/(pow($list[3]['odds'], 4))), // 组合
                    ],
                    'wuxinzuxuan'=>[ // 组选
                        'zuxuan120'=> $list[4]['odds'], // 组选120
                        'zuxuan60'=> $list[5]['odds'], // 组选60
                        'zuxuan30'=> $list[6]['odds'], // 组选30
                        'zuxuan20'=> $list[7]['odds'], // 组选20
                        'zuxuan10'=> $list[8]['odds'], // 组选10
                        'zuxuan5'=> $list[9]['odds'] // 组选5
                    ],
                ],
                'daxiaodanshuang'=>[ //单双大小
                    'zonghe'=>[ // 总和
                        'zonghe'=> $list[10]['odds']
                    ],
                    'dingwei'=>[ // 定位
                        'wan'=> $list[11]['odds'], // 万位
                        'qian'=> $list[12]['odds'], // 千位
                        'bai'=> $list[13]['odds'], // 百位
                        'shi'=> $list[14]['odds'], // 十位
                        'ge'=> $list[15]['odds'] // 个位
                    ],
                    'chuangguan'=>[  // 串关
                        'chuangguan'=> $list[16]['odds']
                    ],
                ],
                'dindanwei'=>[ // 定位胆
                    'dindanwei'=>[
                        'dindanwei'=>$list[17]['odds']
                    ]
                ]
            ];
        // 获取规则提示
        $rules = json_decode(file_get_contents(__DIR__.DS.'rules.json'), true);
        return [
            'odds'=>$odds,
            'rules'=>$rules,
        ];
    }

    /**
     * 获取最近开奖信息
     */
    public static function recentInfo($num = 20)
    {
        $list = DB::name('cqssc_result')->order('id desc')->limit($num)->select();
        foreach ($list as $key => $vo) {
            $list[$key]['opencode'] = explode(",", $vo['opencode']);
            $list[$key]['sum'] = array_sum($list[$key]['opencode']);
            $list[$key]['maxOrMin'] = Calculate::isMax($list[$key]['sum'], 22);
            $list[$key]['doubleOrFloat'] = Calculate::isDouble($list[$key]['sum']);
        }
        return $list;
    }


    /**
     * 获取趋势图信息
     */
    public static function trendChart($index = '万位', $num = 20)
    {
        $trend_list = DB::name('cqssc_trend')->order('id desc')->field($_fields[$index])->limit($num)->select();

        return Calculate::trendChart($index, $trend_list);
    }


    /**
     * 保存用户的下注信息
     */
    public static function saveBets($data)
    {
        $user_gold = DB::name('user_user')->where('id', $data['bet_info'][0]['user_id'])->value('gold');
        if ($user_gold > $data['allGold']) {
            Db::startTrans();
            try {
                Db::name('cqssc_nbet')->insertAll($data['bet_info']);
                Db::name('user_user')->where('id', $data['bet_info'][0]['user_id'])->setDec('gold', $data['allGold']);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                return [
                    'create'=>false,
                    'remaining'=>$user_gold,
                    'errmsg'=>'创建订单失败'
                ];
            }
            return [
                'create'=>true,
                'remaining'=>($user_gold - $data['allGold'])
            ];
        } else {
            return [
                'create'=>false,
                'remaining'=>$user_gold,
                'errmsg'=>'金币不足'
            ];
        }
    }

    public static function updateBets($data){
        Db::startTrans();
        try{
            Db::name('cqssc_nbet')->update($data);
            if($data['win']){
                Db::name('user_user')->where('id', $data['user_id'])->setInc('gold', ($data['win']+$data['return_point']));
            }elseif($data['return_point']){
                Db::name()->where('id', $data['user_id'])->setInc('gold', $data['return_point']);
            }
            $userInfo = Db::name('user_user')->where('id', $data['user_id'])->field('gold,username,phonenumber')->find();
            Db::commit();
        }catch(\Exception $e){
            Db::rollback();
            return false;
        }
        return $userInfo;
    }

    public static function saveAllGoldHistory($history){
        Db::name('gold_history')->insertAll($history);
    }


    public static function betHistory($data){
        $listRows = 30;
        if(!isset($data['page'])){
            $data['page'] = 0;
        }
        $firstRow = $listRows * $data['page'];
        $list = Db::name('cqssc_nbet')->where('user_id', $data['user_id'])
        ->field("avatar,key,gameName,create_time,gold,expect as issue,first_type,second_type,third_type,bet_info as number,odds,open_code,open_time,order_number,return_point,status,user_id,win")
        ->order('create_time desc')->select();
        return Format::formatBetHistory($list);
    }   
}
