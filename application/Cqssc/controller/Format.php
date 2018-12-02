<?php
namespace app\Cqssc\controller;

class Format
{
    protected static $result = [];
    protected static $gold = 0;
    // protected static $gameInfo = [];
    protected static $expect = null;
    public static function format($data)
    {
        self::$result = [];
        self::$expect = $data['issue'];
        foreach ($data['order'] as $key => $vo) {
            self::$gold += $vo['allGold'];
            switch ($vo['type']) {
                case "wuxin":
                    self::wuXing($vo);
                    break;
                case "daxiaodanshuang":
                    self::daxiaodanshuang($vo);
                    break;
                case "dindanwei":
                    self::dindanwei($vo);
                    break;
            }
        }
        file_put_contents(__DIR__.'/user_bet.json', json_encode([
            'allGold' => self::$gold,
            'bet_info' => self::$result
        ]));
        return [
            'allGold' => self::$gold,
            'bet_info' => self::$result,
        ];
    }


    /**
     * 五星
     */
    public static function wuXing($data)
    {
        switch ($data['leiXin']) {
            case "zhixuan":
                self::zhiXuan($data);
                break;
            case "wuxinzuxuan":
                self::zuXuan($data);
                break;
        }
    }

    /**
     * 大小单双
     */
    public static function daxiaodanshuang($data)
    {
        switch ($data['leiXin']) {
            case "zonghe":
                self::zonghe($data);
                break;
            case "dingwei":
                self::dingwei($data);
                break;
            case "chuangguan":
                self::chuanguan($data);
                break;
        }
    }


    /**
     * 直选
     */
    public static function zhiXuan($data)
    {
        switch ($data['name']) {
            case "fushi":
                self::fuShi($data);
                break;
            case "danshi":
                self::danShi($data);
                break;
            case "zuhe":
                self::zuHe($data);
                break;
        }
    }

    /**
     * 组选
     */
    public static function zuXuan($data)
    {
        switch ($data['name']) {
            case "zuxuan120":
                self::zuxuan120($data);
                break;
            case "zuxuan60":
                self::zuxuan60($data);
                break;
            case "zuxuan30":
                self::zuxuan30($data);
                break;
            case "zuxuan20":
                self::zuxuan20($data);
                break;
            case "zuxuan10":
                self::zuxuan10($data);
                break;
            case "zuxuan5":
                self::zuxuan5($data);
                break;
        }
    }


    /**
     * 定位胆
     */
    public static function dindanwei($data)
    {
        self::save($data, 'dingweidan', '', '', true);
    }

    /**
     * 总和
     */
    public static function zonghe($data)
    {
        foreach ($data['number'] as $key => $vo) {
            foreach($vo as $k => $v){
                $data['number'][$key][$k] =self::indexToWord($v);
            }
        }
        self::save($data, 'daxiaodanshuang', 'zonghe', '', false);
    }

    /**
     * 大小单双之定位
     */
    public static function dingwei($data)
    {
        foreach ($data['number'][0] as $k => $v) {
            $number[$k] = self::indexToWord($v);
        }
        $data['number'] = $number;
        self::save($data, 'daxiaodanshuang', 'dingwei', $data['name'], false);
    }
    /**
     * 串关
     */
    public static function chuanguan($data)
    {
        foreach ($data['number'] as $key => $vo) {
            foreach ($vo as $k => $v) {
                $data['number'][$key][$k] = self::indexToWord($v);
            }
        }
        self::save($data, 'daxiaodanshuang', 'chuanguan', '', true);
    }

    
    public static function fuShi($data)
    {
        self::save($data, 'wuxing', 'zhixuan', 'fushi', true);
    }
    public static function danShi($data)
    {
        self::save($data, 'wuxing', 'zhixuan', 'danshi', false);
    }
    public static function zuHe($data)
    {
        self::save($data, 'wuxing', 'zhixuan', 'zuhe', true);
    }

    public static function zuxuan120($data)
    {
        $data['number'] = $data['number'][0];
        self::save($data, 'wuxing', 'zuxuan', '120', false);
    }

    public static function zuxuan60($data)
    {
        self::save1($data, '60', '2code', 'danhao');
    }

    public static function zuxuan30($data)
    {
        self::save1($data, '30', '2code', 'danhao');
    }

    public static function zuxuan20($data)
    {
        self::save1($data, '20', '3code', 'danhao');
    }

    public static function zuxuan10($data)
    {
        self::save1($data, '10', '3code', '2code');
    }

    public static function zuxuan5($data)
    {
        self::save1($data, '5', '4code', 'danhao');
    }

    public static function save1($data, $type, $first_index, $second_index)
    {
        $info = [
            'user_id'=>$data['id'],
            'order_number'=>date('YmdHis').mt_rand(),
            'expect'=>self::$expect,
            'one_gold'=>$data['gold'],
            'gold'=>$data['zhuShu'].'注    '.$data['allGold'].'金币',
            'odds'=>Calodds::odds($data),
            'num'=>$data['zhuShu'],
            'first_type'=>'wuxing',
            'second_type'=>'zuxuan',
            'third_type'=>$type,
            'create_time'=>time(),
            'key'=>$data['key'],
            'gameName'=>$data['gameName'],
            'avatar'=>$data['avatar'],
        ];
        $bet[$first_index] = $data['number'][0];
        $bet[$second_index] = $data['number'][1];
        $info['bet_info'] = json_encode($bet);
        self::$result[] = $info;
    }

    public static function save($data, $first_type, $second_type, $third_type, $flag = true)
    {
        $info = [
            'user_id'=>$data['id'],
            'order_number'=>date('YmdHis').mt_rand(),
            'expect'=>self::$expect,
            'one_gold'=>$data['gold'],
            'gold'=>$data['zhuShu'].'注    '.$data['allGold'].'金币',
            'odds'=>Calodds::odds($data),
            'num'=>$data['zhuShu'],
            'first_type'=>$first_type,
            'second_type'=>$second_type,
            'third_type'=>$third_type,
            'create_time'=>time(),
            'key'=>$data['key'],
            'gameName'=>$data['gameName'],
            'avatar'=>$data['avatar'],
        ];
        if($flag){
            $info['bet_info'] = json_encode([
                'wan'=>$data['number'][0],
                'qian'=>$data['number'][1],
                'bai'=>$data['number'][2],
                'shi'=>$data['number'][3],
                'ge'=>$data['number'][4]
            ]);
        }else{
            $info['bet_info'] = json_encode($data['number']);
        }
        
        self::$result[] = $info;
    }

    public static function indexToWord($index)
    {
        $data = [
            'da' => '大',
            'xiao' => '小',
            'dan' => '单',
            'shuang' => '双'
        ];
        return $data[$index];
    }


    /**
     * 格式化用户投注记录
     */
    public static function formatBetHistory($list){
        foreach($list as $key => $vo){
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $vo['create_time']);
            $list[$key]['number'] = json_decode($vo['number'], true);
            $list[$key]['name'] = self::reduction($vo['first_type'], $vo['second_type'], $vo['third_type']);
            unset($list[$key]['first_type']);
            unset($list[$key]['second_type']);
            unset($list[$key]['third_type']);
        }
        return $list;
    }

    public static function reduction($first, $second, $third){
        if($first == 'wuxing'){
            $first = 'wuxin';
        }
        if($second == 'chuanguan'){
            $second = 'chuangguan';
        }
        if($first && $second && $third){
            return $first."_".$second."_".$third;
        }else if($first && $second){
            return $first."_".$second;
        }else{
            return $first;
        }
    }
}
