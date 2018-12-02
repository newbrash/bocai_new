<?php
namespace app\GameServer2\controller;

class RegisterGame
{
    /**
     * 注册的游戏名称
     */
    public static $games = [];

    /**
     * 注册的游戏的类
     */
    public static $gameClass = [];

    /**
     *
     */
    public function __construct()
    {
        self::$games = [];
        self::$gameClass = [];
    }

    /**
     * 注册所有游戏
     * @param array $games [['name'=>'game1','class'=>'class1','namespace'=>'namespace1'],...]
     */
    public static function registerGames($games)
    {
        foreach ($games as $name => $info) {
            self::register($info['namespace'], $info['class'], $name, true);
        }
    }
    // 注册单个游戏
    public static function register($namespace, $class_name, $game_name = null, $replace = false)
    {
        if (!$game_name) {
            $game_name = $class_name;
        }
        if (isset(self::$gameClass[$game_name])) {
            if ($replace) {
                self::$gameClass[$game_name] = "\\".rtrim($namespace, '\\')."\\".$class_name;
            } else {
                throw new \Exception("该游戏已注册，如要替换，将第4个参数设置为true!");
                return false;
            }
        } else {
            self::$games[] = $game_name;
            self::$gameClass[$game_name] = "\\".rtrim($namespace, '\\')."\\".$class_name;
        }
    }

    /**
     * 启动所有游戏
     */
    public static function beginGames($parent)
    {
        // dump("==============gamebegin=================");
        // dump($parent);
        $worker = [];
        foreach (self::$gameClass as $game => $class) {
            $worker[$game] = new $class;
            $worker[$game]->parent = $parent;
            $worker[$game]->begin();
        }
        return $worker;
    }
    /**
     * 删除所有游戏
     */
    public static function delete()
    {
        self::$games = [];
        self::$gameClass = [];
    }
}
