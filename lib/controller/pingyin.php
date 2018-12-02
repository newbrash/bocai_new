<?php
/**
 +------------------------------------------------------
 *    PHP 汉字转拼音
 +------------------------------------------------------
 *    使用方法:
 *      $py = new PinYin();
 *		echo $py->getpy("糗事百科",true);
 +------------------------------------------------------
 */
class Pinyin
{
    public $pinyin = array(); // 汉字拼音对照数组
    public $quanpin = true; // 设置为全拼还是首字母
 
    /**
     * 构造函数
     */
    public function __construct()
    {
        define('DS', DIRECTORY_SEPARATOR);
        $this->pinyin = json_decode(file_get_contents(__DIR__.DS.'..'.DS.'res'.DS.'pingyin.json'));
    }
 
    /**
     * 汉字转拼音函数
     *
     * @param string $s			汉字字符串
     * @param bool $quanpin		是否全拼
     * @param bool $daxie		首字母是否大写
     * @return string
     */
    public function getpy($s, $quanpin = true, $daxie = false)
    {
        $s = preg_replace("/\s/is", "_", $s);
        $s = preg_replace("/(|\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\{|\}|\[|\]|\||\\|\:|\;|\"|\'|\<|\,|\>|\.|\?|\/)/is", "", $s);
        $i = 0;
        $py = '';
        // 加入这一句，自动识别UTF-8
        if (strlen("拼音") > 4) {
            $s = iconv('UTF-8', 'GBK', $s);
        }
        if ($quanpin) {
            // 全拼
            for ($i = 0; $i < strlen($s); $i++) {
                if (ord($s[$i]) > 128) {
                    $char = $this->asi2py(ord($s[$i]) + ord($s[$i + 1]) * 256);
                    $py.=$char;
                    $i++;
                } else {
                    $py.=$s[$i];
                }
            }
        } else {
            // 首字母
            for ($i = 0; $i < strlen($s); $i++) {
                if (ord($s[$i]) > 128) {
                    $char = $this->asi2py(ord($s[$i]) + ord($s[$i + 1]) * 256);
                    $py	.=$char[0];
                    $i++;
                } else {
                    $py	.=$s[$i];
                }
            }
        }
        // 判断是否输出小写字符
        return ($daxie == true ? $py : strtolower($py));
    }
 
    public function asi2py($a)
    {
        $py = $this->pinyin;
        foreach ($py as $p) {
            if (array_search($a, $p) === false) {
            } else {
                return key($py);
            }
            next($py);
        }
    }
}
