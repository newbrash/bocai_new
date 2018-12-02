<?php
namespace app\Monitor\controller;

use think\facade\Config;
use think\Db;
use app\MyCommon\controller\Base;

/**
 * 抢红包
 */
class GrabRedEnvelope
{
    protected $Config = null;
    public function start()
    {
        // 获取配置信息
        $this->Config = Config::pull('worker');
        // 创建一个socket
        
        // 实例化redis对象
        $redis = new \Redis();
        // 链接redis服务器
        $redis->connect($this->Config['redis']['host'], $this->Config['redis']['port']) or die("redis connect failed!");
        //
        $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1) or die("set time out failed!");
        echo "grabred-server listening....\n";
        while (true) {
            $info = $redis->rpop('grab_red_envelope_list');
            if ($info) {
                $info = json_decode($info, true);
                $data = $this->dealGrabRed($info, $redis);
                $this->send($data);
            }
        }
        $redis->close();
    }


    public function dealGrabRed($data, $redis)
    {
        try {
            // redis索引
            $index = json_encode(['red_id'=>(int)$data['red_id'],'mid'=>(int)$data['msg_id']]);
            $redinfo = $redis->get($index);
            if ($redinfo) {
                // 解析json字符串
                $redinfo = json_decode($redinfo, true);
                dump($redinfo);
                // 红包可接受人数
                $redinfo['n'] = intval($redinfo['n']);
                $redinfo['gold'] = intval($redinfo['gold']);
                $redInfo['send_time'] = intval($redinfo['send_time']);
                if ($redinfo['n']) {
                    if (in_array($data['user_id'], $redinfo['user'])) {
                        // 用户已领取过
                        return [
                            'type'=>'responseChatRoomRedbag',
                            'status'=>false,
                            'msg'=>'你已领取！',
                            'code'=>303,
                            'msg_index'=>$data['msg_index'],
                            'con_id'=>$data['con_id'],
                            'uid'=>$data['user_id'],
                            'mid'=>$data['msg_id'],
                            'rid'=>$data['red_id'],
                        ];
                    } else {
                        // 可领取人数减一
                        $redinfo['n']--;
                        // 添加可已接受用户id
                        $redinfo['user'][] = $data['user_id'];
                        if ($redinfo['n']>0) {
                            // 随机生成领取红包金额
                            $gold = rand(1, intval($redinfo['gold'])-intval($redinfo['n'])+1);
                            $status = 0;

                            $redinfo['gold'] -= $gold;
                            // 重置红包过期时间
                            $expired = $data['EXPIRE_TIME'] -(time()-$redinfo['send_time']);
                            // return $expired;
                            // 更新redis中红包信息
                            $redis->setex($index, $expired, json_encode($redinfo));
                        } else {
                            // 剩余最后一人的金币
                            $gold = $redinfo['gold'];
                            $status = 1;
                            $redis->del($index);
                        }
                       
                        // 更新用户金币信息
                        $userInfo = DB::name('user_user')->where('id', $data['user_id'])->field('id, gold, username,head,nickname,phonenumber')->find();
                        $userInfo['gold'] += $gold;
                        // return $userInfo;
                        DB::name('user_user')->update($userInfo);
                        // 更新红包信息
                        $redbag = DB::name("user_red")->field('detail,recived_num,send_id,remark')->where('id', $data['red_id'])->find();
                        // return $redbag;
                        // 红包领取详情
                        if ($redbag['detail']) {
                            $redbag['detail'] = json_decode($redbag['detail'], true);
                        } else {
                            $redbag['detail'] = [];
                        }
                        $redbag['detail'][$data['user_id']] = [
                            'head'=>$userInfo['head'],
                            'nickname'=>$userInfo['nickname'],
                            'time'=>time(),
                            'gold'=>$gold,
                        ];
                        // 红包消息的内容
                        if ($status) {
                            $msgContent = 'false:[-'.$redbag['send_id'].'-';
                        } else {
                            $msgContent = '[-'.$redbag['send_id'].'-';
                        }
                        foreach ($redbag['detail'] as $key => $vo) {
                            $msgContent .= 'o-'.$key.'-';
                        }
                        $msgContent .= '](@redbag'.$data['red_id'].'redbag@)'.$redbag['remark'];

                        // 红包信息
                        $updateData['detail'] = json_encode($redbag['detail']);
                        $updateData['recived_num'] = $redbag['recived_num']+1;
                        $updateData['status'] = $status;
                        // $redbag['id'] = $data['red_id'];
                        // return $redbag;
                        // 更新红包信息
                        DB::name('user_red')->where('id', $data['red_id'])->update($updateData);
                        // 更新红包消息内容
                        $redMsg = [
                            'id'=>$data['msg_id'],
                            'content'=>$msgContent
                        ];
                        DB::name('chat_room')->update($redMsg);

                        // 金币记录详情
                        $detail = [
                            '领红包前'=>$userInfo['gold'] - $gold,
                            '红包金额'=>$gold,
                            '领红包后'=>$userInfo['gold']
                        ];
                        // 保存金币记录
                        Base::goldHistory($userInfo['username']?$userInfo['username']:$userInfo['phonenumber'], '领红包', $detail);
                    }
                } else {
                    return [
                        'type'=>'responseChatRoomRedbag',
                        'status'=>false,
                        'msg'=>'红包已被抢完，下次出手要快点哦！',
                        'code'=>202,
                        'redStatus'=>1,
                        'msg_index'=>$data['msg_index'],
                        'con_id'=>$data['con_id'],
                        'uid'=>$data['user_id'],
                        'mid'=>$data['msg_id'],
                        'rid'=>$data['red_id'],
                    ];
                }
            } else {
                $status = DB::name("user_red")->where('id', $data['red_id'])->value('status');
                if ($status == 1) {
                    $errMsg = '红包已被抢完，下次出手要快点哦！';
                } else {
                    $errMsg = '红包已过期，下次早点哦！';
                }
                return [
                    'type'=>'responseChatRoomRedbag',
                    'status'=>false,
                    'msg'=>$errMsg,
                    'code'=>101,
                    'redStatus'=>$status,
                    'msg_index'=>$data['msg_index'],
                    'con_id'=>$data['con_id'],
                    'uid'=>$data['user_id'],
                    'mid'=>$data['msg_id'],
                    'rid'=>$data['red_id'],
                ];
            }
            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollback();
            echo "errMsg:".$e->getMessage()."\n";
            return [
                'type'=>'responseChatRoomRedbag',
                'status'=>false,
                'code'=>505,
                'msg'=>'领取失败，请检查网络是否正常!',
                'msg_index'=>$data['msg_index'],
                'con_id'=>$data['con_id'],
                'uid'=>$data['user_id'],
                'mid'=>$data['msg_id'],
                'rid'=>$data['red_id'],
            ];
        }
        return [
            'type'=>'responseChatRoomRedbag',
            'status'=>true,
            'msg'=>'领取成功',
            'gold'=>$userInfo['gold'],
            'content'=>$msgContent,
            'code'=>0,
            'msg_index'=>$data['msg_index'],
            'con_id'=>$data['con_id'],
            'uid'=>$data['user_id'],
            'mid'=>$data['msg_id'],
            'rid'=>$data['red_id'],
        ];
    }

    public function send($data)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            throw new Exception("redis creates socket failed!");
        } else {
            // 链接服务器
            $conn = socket_connect($socket, $this->Config['redis']['shost'], $this->Config['port']);
            if ($conn) {
                // dump($data);
                $data = "#@#redis-data-request#@#" . json_encode($data);
                // dump($data);
                if (socket_send($socket, $data, strlen($data), MSG_DONTROUTE)) {
                    echo "send successful!\n";
                } else {
                    throw new Exception("send failed!");
                }
            } else {
                throw new Exception("redis socket connects workerman failed!");
            }
            socket_close($socket);
        }
    }
}
