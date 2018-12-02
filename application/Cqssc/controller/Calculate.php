<?php
namespace app\Cqssc\controller;

class Calculate
{
    protected static $result = [];
    protected static $gold_history = [];

    public static function settlement($code, $data)
    {
        self::$result = [];
        foreach ($data as $key => $vo) {
            $vo['bet_info'] = json_decode($vo['bet_info'], true);
            switch ($vo['first_type']) {
                case "wuxing":
                    self::fiveStars($code, $vo);
                    break;
                case "daxiaodanshuang":
                    self::maxMinDoubleFloat($code, $vo);
                    break;
                case "dingweidan":
                    self::dingWeiDan($code, $vo);
                    break;
            }
        }
        file_put_contents(__DIR__.'/gold_history.json', json_encode(self::$gold_history));
        file_put_contents(__DIR__.'/gold_history_1.json', json_encode(array_values(self::$gold_history)));
        Dbop::saveAllGoldHistory(array_values(self::$gold_history));
        file_put_contents(__DIR__.'/user.json', json_encode(self::$result));
        return self::$result;
    }

    /**
     * 五星
     */
    public static function fiveStars($code, $data)
    {
        switch ($data['second_type']) {
            case "zhixuan":
                self::fiveStarsD($code, $data);
                break;
            case "zuxuan":
                self::fiveStarsG($code, $data);
                break;
        }
    }

    /**
     * 五星直选
     */
    public static function fiveStarsD($code, $data)
    {
        switch ($data['third_type']) {
            case "fushi":
                self::fiveStarsDF($code, $data);
                break;
            case "danshi":
                self::fiveStarsDD($code, $data);
                break;
            case "zuhe":
                self::fiveStarsDZ($code, $data);
                break;
        }
    }

    /**
     * 计算五星直选复式是否中奖
     */
    public static function fiveStarsDF($code, $data)
    {
        $_status = true;
        foreach ($data['bet_info'] as $k => $v) {
            if (!in_array($code[$k], $v)) {
                $_status = false;
                break;
            }
        }
        if ($_status) {
            self::update($data['id'], $data['user_id'], ($data['one_gold'] * $data['odds']), 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }

    /**
     * 计算五星直选单式是否中奖
     */
    public static function fiveStarsDD($code, $data)
    {
        $code = implode('', $code);
        $gold = 0;
        foreach ($data['bet_info'] as $key => $vo) {
            if ($code == $vo) {
                $gold += $data['one_gold'] * $data['odds'];
            }
        }
        if ($gold) {
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }


    /**
     * 计算五星直选组合中奖情况
     */
    public static function fiveStarsDZ($code, $data)
    {
        $n = self::stars($code, $data['bet_info']);
        if ($n) {
            // $odds = explode('~', $data['odds']);
            // $b = pow((intval($odds[0]) / intval($odds[1])), 1/5);
            $num = $data['num'];
            // $_odds = 0;
            switch ($n) {
                case 5:
                    $num = $num * (1 / count($data['bet_info']['wan']));
                    // $_odds += intval($odds[0]);
                    // no break
                case 4:
                    $num = $num * (1 / count($data['bet_info']['qian']));
                    // $_odds += intval($odds[1]) * pow($b, 3);
                    // no break
                case 3:
                    $num = $num * (1 / count($data['bet_info']['bai']));
                    // $_odds += intval($odds[1]) * pow($b, 2);
                    // no break
                case 2:
                    $num = $num * (1 / count($data['bet_info']['shi']));
                    // $_odds += intval($odds[1]) * pow($b, 1);
                    // no break
                case 1:
                    $num = $num * (1 / count($data['bet_info']['ge']));
                    // $_odds += intval($odds[1]);
                    break;
                default:
            }
            // $gold = $_odds * $data['one_gold'] * $num;
            $gold = $data['odds'] * $data['one_gold'] * $num;
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }
    // 判断
    public static function stars($code, $data)
    {
        $n = 0;
        if (in_array($code['ge'], $data['ge'])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['shi'], $data['shi'])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['bai'], $data['bai'])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['qian'], $data['qian'])) {
            $n++;
        } else {
            return $n;
        }
        if (in_array($code['wan'], $data['wan'])) {
            $n++;
        }
        return $n;
    }

    /**
     * 五星组选
     */
    public static function fiveStarsG($code, $data)
    {
        switch ($data['third_type']) {
            case "120":
                self::zuXuan120($code, $data);
                break;
            case "60":
                self::zuXuan60($code, $data);
                break;
            case "30":
                self::zuXuan30($code, $data);
                break;
            case "20":
                self::zuXuan20($code, $data);
                break;
            case "10":
                self::zuXuan10($code, $data);
                break;
            case "5":
                self::zuXuan5($code, $data);
                break;
        }
    }

    /**
     * 组选120
     */
    public static function zuXuan120($code, $data)
    {
        foreach ($code as $one) {
            $key = array_search($one, $data['bet_info']);
            if ($key === false) {
                self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                return false;
            } else {
                unset($data['bet'][$key]);
            }
        }
        $gold = $data['one_gold'] * $data['odds'];
        self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
    }

    /**
     * 组选60
     */
    public static function zuXuan60($code, $data)
    {
        $count = array_count_values($code);
        if (count($count) == 4 && max($count) == 2) {
            foreach ($count as $k => $v) {
                if (!$v == 2) {
                    if (!in_array($k, $data['bet_info']['2code'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                } else {
                    if (!in_array($k, $data['bet_info']['danhao'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                }
            }
            $gold = $data['one_gold'] * $data['odds'];
            self::update($data['id'], $data['user_info'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }

    /**
     * 组选30
     */
    public static function zuXuan30($code, $data)
    {
        $count = array_count_values($code);
        if (max($count) == 2 && count($count) == 3) {
            foreach ($count as $key => $vo) {
                if ($vo == 2) {
                    if (!in_array($key, $data['bet_info']['2code'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                } else {
                    if (!in_array($key, $data['bet_info']['danhao'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                }
            }
            $gold = $data['one_gold'] * $data['odds'];
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }

    /**
     * 组选20
     */
    public static function zuXuan20($code, $data)
    {
        $count = array_count_values($code);
        if (max($count) == 3 && count($count) == 3) {
            foreach ($count as $key => $vo) {
                if ($vo == 3) {
                    if (!in_array($key, $data['bet_info']['3code'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                } else {
                    if (!in_array($key, $data['bet_info']['danhao'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                }
            }
            $gold = $data['one_gold'] * $data['odds'];
            self::update($data['id'], $data['user_id'], 0, $gold, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }
    /**
     * 组选10
     */
    public static function zuXuan10($code, $data)
    {
        $count = array_count_values($code);
        if (max($count) == 3 && count($count) == 2) {
            foreach ($count as $key => $vo) {
                if ($vo == 3) {
                    if (!in_array($key, $data['bet_info']['3code'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                } else {
                    if (!in_array($key, $data['bet_info']['2code'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                }
            }
            $gold = $data['one_gold'] * $data['odds'];
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }
    public static function zuXuan5($code, $data)
    {
        $count = array_count_values($code);
        if (max($count) == 4) {
            foreach ($count as $key => $vo) {
                if ($vo == 4) {
                    if (!in_array($key, $data['bet_info']['4code'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                } else {
                    if (!in_array($key, $data['bet_info']['danhao'])) {
                        self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                        return false;
                    }
                }
            }
            $gold = $data['one_gold'] * $data['odds'];
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }
    /**
     * 计算大小单双
     */
    public static function maxMinDoubleFloat($code, $data)
    {
        switch ($data['second_type']) {
            case "zonghe":
                self::zongHe($code, $data);
                break;
            case "dingwei":
                self::dingWei($code, $data);
                break;
            case "chuanguan":
                self::chuanGuan($code, $data);
                break;
        }
    }

    /**
     * 计算总和是否中奖
     */
    public static function zongHe($code, $data)
    {
        $gold = 0;
        $sum = array_sum($code);
        $a = self::isMax($sum, 22);
        $b = self::isDouble($sum);
        if (in_array($a, $data['bet_info'])) {
            $gold += $data['one_gold'] * $data['odds'];
        }
        if (in_array($b, $data['bet_info'])) {
            $gold += $data['one_info'] * $data['odds'];
        }
        if ($gold) {
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }

    /**
     * 定位计算
     */
    public static function dingWei($code, $data)
    {
        $gold = 0;
        $a = self::isMax($code[$data['third_type']], 4);
        $b = self::isDouble($code[$data['third_type']]);
        if (in_array($a, $data['bet_info'])) {
            $gold += $data['one_gold'] * $data['odds'];
        }
        if (in_array($b, $data['bet_info'])) {
            $gold += $data['one_gold'] * $data['odds'];
        }
        if ($gold) {
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }

    /**
     * 计算串关是否中奖，中奖金额
     */
    public static function chuanGuan($code, $data)
    {
        $_odds = 0;
        $_betN = 1;
        foreach ($data['bet_info'] as $key => $vo) {
            if (!empty($vo)) {
                $a = self::isMax($code[$key], 4);
                $b = self::isDouble($code[$key]);
                if (in_array($a, $vo) || in_array($b, $vo)) {
                    $_odds++;
                    if (in_array($a, $vo) && in_array($b, $vo)) {
                        $_betN *= 2;
                    } else {
                        $_betN *= 1;
                    }
                } else {
                    self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
                    return false;
                }
            }
        }
        if ($_odds) {
            // $gold = $_betN * $data['one_gold'] * pow($data['odds'], $_odds);
            $gold = $_betN * $data['one_gold'] * $data['odds'];
            self::update($data['id'], $data['user_id'], $gold, 0, 1, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }
    // 判断号码的大小
    public static function isMax($code, $minLimit)
    {
        if ($code > $minLimit) {
            return '大';
        } else {
            return '小';
        }
    }
    // 判断号码的单双
    public static function isDouble($code)
    {
        if ($code % 2) {
            return '单';
        } else {
            return '双';
        }
    }
    /**
     * 定位胆
     */
    public static function dingWeiDan($code, $data)
    {
        $_betN = 0;
        foreach ($data['bet_info'] as $key => $vo) {
            if (in_array($code[$key], $vo)) {
                $_betN++;
            }
        }
        if ($_betN) {
            $gold = $_betN * $data['odds'] * $data['one_gold'];
            self::update($data['id'], $data['user_id'], $gold, 0, 2, $code);
        } else {
            self::update($data['id'], $data['user_id'], 0, 0, 1, $code);
        }
    }


    /**
     * 更行注单信息
     */
    public static function update($id, $uid, $win, $return_point, $status, $code)
    {
        $updateInfo = [
            'id'=>$id,
            'user_id'=>$uid,
            'win'=>$win,
            'return_point'=>$return_point,
            'status'=>$status,
            'open_code'=>implode(',', $code),
            'open_time'=>time(),
        ];
        self::$result[$uid]['win'] += $updateInfo['win'];
        self::$result[$uid]['return_point'] += $updateInfo['return_point'];

        $info = Dbop::updateBets($updateInfo);
        if ($info !== false) {
            self::$result[$uid]['gold'] = $info['gold'];
            if ($win) {
                self::$gold_history[$uid] = [
                    'username'=>$info['username'] || $info['phonenumber'],
                    'operation'=>'投注结算',
                    'detail'=>json_encode([
                        '结算前'    => (self::$result[$uid]['gold'] - self::$result[$uid]['win'] - self::$result[$uid]['return_point']),
                        '计算金额'  => self::$result[$uid]['win'],
                        '返点金额'  => self::$result[$uid]['return_point'],
                        '结算后'    => self::$result[$uid]['gold'],
                    ]),
                    'time'=>time(),
                ];
            }
        }
    }


    /**
     * 统计趋势图的数据
     */
    public static function trendChart($index, $list){
        
        $_fields = [
            '万位'=>[
                'id',
                'open_code',
                'expect',
                'wan_0',
                'wan_1',
                'wan_2',
                'wan_3',
                'wan_4',
                'wan_5',
                'wan_6',
                'wan_7',
                'wan_8',
                'wan_9'
            ],
            '千位'=>[
                'id',
                'open_code',
                'expect',
                'qian_0',
                'qian_1',
                'qian_2',
                'qian_3',
                'qian_4',
                'qian_5',
                'qian_6',
                'qian_7',
                'qian_8',
                'qian_9'
            ],
            '百位'=>[
                'id',
                'open_code',
                'expect',
                'bai_0',
                'bai_1',
                'bai_2',
                'bai_3',
                'bai_4',
                'bai_5',
                'bai_6',
                'bai_7',
                'bai_8',
                'bai_9'
            ],
            '十位'=>[
                'id',
                'open_code',
                'expect',
                'shi_0',
                'shi_1',
                'shi_2',
                'shi_3',
                'shi_4',
                'shi_5',
                'shi_6',
                'shi_7',
                'shi_8',
                'shi_9'
            ],
            '个位'=>[
                'id',
                'open_code',
                'expect',
                'ge_0',
                'ge_1',
                'ge_2',
                'ge_3',
                'ge_4',
                'ge_5',
                'ge_6',
                'ge_7',
                'ge_8',
                'ge_9'
            ],
            '大小单双'=>[
                'id',
                'open_code',
                'expect',
                'ge_da',
                'ge_xiao',
                'ge_dan',
                'ge_shuang',
                'shi_da',
                'shi_xiao',
                'shi_dan',
                'shi_shuang',
                'bai_da',
                'bai_xiao',
                'bai_dan',
                'bai_shuang',
                'qian_da',
                'qian_xiao',
                'qian_dan',
                'qian_shuang',
                'wan_da',
                'wan_xiao',
                'wan_dan',
                'wan_shuang'
            ]
        ];
        $maxOut = [];
        $stemp = [];
        $maxLose = [];
        $averageLose = [];
        $averageNum = [];
        $times = [];
        foreach ($_fields[$index] as $key => $vo) {
            if ($vo != 'id' && $vo != 'open_code' && $vo != 'expect') {
                $maxOut[$vo] = 0;
                $stemp[$vo] = 0;

                $maxLose[$vo] = 0;
                $averageLose[$vo] = 0;
                $averageNum[$vo] = 1;
                $times[$vo] = 0;
            }
        }
        foreach ($list as $key => $vo) {
            foreach ($vo as $k => $v) {
                if ($k != 'id' && $k != 'open_code' && $k != 'expect') {
                    if (!$v) {
                        $stemp[$k]++;
                        if ($stemp[$k] > $maxOut[$k]) {
                            $maxOut[$k] = $stemp[$k];
                        }
                        $times[$k]++;
                    } else {
                        if ($v > $maxLose[$k]) {
                            $maxLose[$k] = $v;
                        } else {
                            $averageNum[$k]++;
                        }
                        $averageLose[$k]++;
                        $stemp[$k] = 0;
                    }
                    if ($index != '大小单双') {
                        $i = explode("_", $k);
                        $list[$key][$i[1]] = $v;
                        unset($list[$key][$k]);
                    }
                }
            }
            $list[$key]['open_code'] = explode(',', $vo['open_code']);
        }
        foreach ($averageLose as $key => $vo) {
            $averageLose[$key] = round($vo / $averageNum[$key]);
        }
        return [
            'trend'=>$list,
            'statistics'=>[
                'times'=>$times,
                'averageLose'=>$averageLose,
                'maxLose'=>$maxLose,
                'maxOut'=>$maxOut,
            ]
        ];
    }
}
