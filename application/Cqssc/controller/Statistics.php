<?php
namespace app\Cqssc\controller;

class Statistics
{
    /**
     * 计算五星组选120的注数
     */
    public static function zuXuan120($data){
        return self::C(count($data), 5);
    }

    /**
     * 计算五星组选60的注数
     */
    public static function zuXuan60($data)
    {
        // 计算二重号的个数
        $code_2_num = count($data['2code']);
        // 计算单号的个数
        $float_num = count($data['danhao']);
        if ($code_2_num && $float_num >= 3) {
            // 计算二重号和单号相同的个数
            $n = count(array_intersect($data['2code'], $data['danhao']));
            // 计算总注数
            $total = $code_2_num * self::C($float_num, 3);
            if ($n) {
                // 计算一组（二重号和单号相同）的注数
                $one = self::C($float_num - 1, 2);
                // 总注数 - 二重号和单号相同产生的注数
                $total = $total - $n * $one;
            }
            return $total;
        } else {
            return false;
        }
    }


    /**
     * 计算五星组选30的注数
     */
    public static function zuXuan30($data)
    {
        $code_2_num = count($data['2code']);
        $float_num = count($data['danhao']);
        if ($code_2_num >= 2 && $float_num) {
            $total = $float_num * self::C($code_2_num, 2);
            $n = count(array_intersect($data['2code'], $data['danhao']));
            $one = self::C($code_2_num-1, 1);
            $total -= $n * $one;
            return $total;
        } else {
            return false;
        }
    }

    /**
     * 计算五星组选20的注数
     */
    public static function zuXuan20($data){
        $code_3_num = count($data['3code']);
        $float_num = count($data['danhao']);
        if($code_3_num && $float_num >= 2){
            $total = $code_3_num * self::C($float_num, 2);
            $n = count(array_intersect($data['3code'], $data['danhao']));
            $one = self::C($float_num-1, 1);
            $total -= $n * $one;
            return $total;
        }else{
            return false;
        }
    }


    /**
     * 计算五星组选10的注数
     */
    public static function zuXuan10($data){
        $code_2_num = count($data['2code']);
        $code_3_num = count($data['3code']);
        $n = count(array_intersect($data['2code'], $data['3code']));
        $total = $code_2_num * $code_3_num - $n;
        return $total;
    }

    /**
     * 计算五星组选5的注数
     */
    public static function zuXuan5($data){
        $code_4_num = count($data['4code']);
        $float_num = count($data['danhao']);
        $n = count(array_intersect($data['4code'], $data['danhao']));
        $total = $code_4_num * $float_num - $n;
        return $total;
    }

    /**
     * 组合排序算法
     * @param number $a 总个数
     * @param number $b 每组的个数
     * @return number $z 在a个单位中选b个为一组，一共有z种组法
     */
    public static function C($a, $b)
    {
        $y = 1;
        $x = 1;
        for (;$a > $b; $a--) {
            $y *= $a;
            $x *= ($a - $b);
        }
        $z = $y/$x;
        return $z;
    }
}
