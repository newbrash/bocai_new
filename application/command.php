<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
//game-server1,game-server2 grabred-server overdue-server
return [
    'app\test\controller\command',
    'app\GameServer2\controller\serverCommand',
    'app\GameServer1\controller\ServerCommand',
    'app\Monitor\controller\OverdueMonitorCommand',
    'app\Monitor\controller\GrabRedEnvelopeCommand',
    'app\Server\MyWorker',
    'app\GameWorker\controller\GameWorkerCommand',
];

