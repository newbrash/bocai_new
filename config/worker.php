<?php
return [
    'count' => 2,
    'host' => '0.0.0.0',
    'port' => 8080,
    'gameport' => 2525,
    'redis' => array(
        'host'=>'127.0.0.1',
        'port'=>6379,
        'shost'=>'127.0.0.1',
    ),
    // 'context_option'=> array(
    //     'ssl'=>array(
    //         // 使用绝对路径
    //         'local_cert' => "H:/phpstudy/Apache/conf/key/server.crt", // 也可以是crt文件
    //         'local_pk' => "H:/phpstudy/Apache/conf/key/server.key",
    //         'verify_peer' => false,
    //     ),
    // ),
    // 'ssl'=>true,
    'games'=> array(
        // array(
        //     'name'=>'Gd11x5',
        //     'class'=>'Gd11x5',
        //     'namespace'=>'app\Gd11x5\controller'
        // ),
        'cjssc'=>array(
            // 'name'=>'Cqssc',
            'class'=>'Cqssc',
            'namespace'=>'app\Cqssc\controller'
        ),
    ),
];
