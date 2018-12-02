<?php
namespace app\Admin\controller;

use app\Admin\controller;
use think\Db;

/**
 *
 */
class Luntan extends Common
{
    // 论坛设置
    public function index()
    {
        // 获取分区列表
        $lists = DB::name('forum_zone')->select();
        $this->assign([
            'title'=>'论坛设置',
            'back_url'=>url('Admin/Index/index'),
            'lists'=>$lists,
        ]);
        return $this->fetch();
    }

    // 发帖设置
    public function fatie()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            if ($param['id']) {
                if ($this->updateRedis($param)) {
                    if (DB::name('system_info')->update($param)) {
                        $result = [
                            'code'=>0,
                            'msg'=> '保存成功！'
                        ];
                    } else {
                        $system_info = DB::name('system_info')->where('id', $param['id'])->find();
                        $this->setRedis($system_info);
                        $result = [
                            'code'=>-1,
                            'msg'=> '保存失败！'
                        ];
                    }
                } else {
                    $result = [
                        'code'=>-1,
                        'msg'=> '设置失败！'
                    ];
                }
            } else {
                if (DB::name("system_info")->insert($param)) {
                    $system_info = DB::name('system_info')->find();
                    if ($this->setRedis($system_info)) {
                        $result = [
                            'code'=>0,
                            'msg'=> '保存成功！'
                        ];
                    } else {
                        DB::name('system_info')->where('id', $system_info['id'])->delete();
                        $result = [
                            'code'=>-1,
                            'msg'=> '设置失败！'
                        ];
                    }
                } else {
                    $result = [
                        'code'=>-1,
                        'msg'=> '保存失败！'
                    ];
                }
            }
            echo json_encode($result);
            return;
        }
        // 获取发帖相关的信息
        $info = DB::name('system_info')->field('id,tie_pride_show,tie_pride_num,tie_pride_gold,tie_pride_sliver,tie_limit_words,tie_limit_seconds,tie_limit_relieve,tie_limit_refender_seconds')->find();
        $this->assign([
            'title'=>'发帖设置',
            'back_url'=>url('Admin/Luntan/index'),
            'info'=>$info,
        ]);
        return $this->fetch();
    }
    // 回帖设置
    public function huitie()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            // 将时间转换为时间戳
            $param['huitie_time_start'] = strtotime($param['huitie_time_start']);
            $param['huitie_time_end'] = strtotime($param['huitie_time_end']);
            if ($param['id']) {
                if ($this->updateRedis($param)) {
                    if (DB::name('system_info')->update($param)) {
                        $result['code'] = 0;
                        $result['msg'] = '保存成功！';
                    } else {
                        $system_info = DB::name('system_info')->where('id', $param['id'])->find();
                        $this->setRedis($system_info);
                        $result['code'] = -1;
                        $result['msg'] = '保存失败！';
                    }
                } else {
                    $result = [
                        'code'=>-1,
                        'msg'=>'设置失败！',
                    ];
                }
            } else {
                if (DB::name('system_info')->insert($param)) {
                    $system_info = DB::name('system_info')->find();
                    if ($this->setRedis($system_info)) {
                        $result = [
                            'code'=>0,
                            'msg'=> '保存成功！'
                        ];
                    } else {
                        DB::name('system_info')->where('id', $system_info['id'])->delete();
                        $result = [
                            'code'=>-1,
                            'msg'=> '设置失败！'
                        ];
                    }
                } else {
                    $result['code'] = -1;
                    $result['msg'] = '保存失败！';
                }
            }
            echo json_encode($result);
            return;
        }
        // 获取回帖设置的相关信息
        $info = DB::name('system_info')->field('id,huitie_open,huitie_time_start,huitie_time_end,huitie_order,huitie_num,huitie_gold,huitie_sliver,huitie_vip_gold,huitie_vip_sliver,huitie_repeate,huitie_refender_seconds')->find();

        $this->assign([
            'title'=>'回帖设置',
            'back_url'=>url('Admin/Luntan/index'),
            'info'=>$info,
        ]);
        return $this->fetch();
    }


    // 添加分区或者修改分区
    public function addFenQu()
    {
        $param = $this->request->param();
        $info = [];
        if ($this->request->isPost()) {
            $src = $this->uploadLogo();
            if ($src && $src != -1) {
                $param['img'] = $src;
            } elseif ($src == -1) {
                $result  = [
                    'code'=>-1,
                    'msg'=>'保存失败！'
                ];
                echo json_encode($result);
                return ;
            }
            // 判断是否为修改分区
            if (isset($param['id'])&&$param['id']) {
                $oldImg = DB::name('forum_zone')->where('id', $param['id'])->value('img');
                if (DB::name('forum_zone')->update($param)) {
                    if ($oldImg && $oldImg != '/bcweb/public/luntan/img/badge/red.png') {
                        // 删除旧的非默认logo图片
                        if (is_file($_SERVER['DOCUMENT_ROOT'].$oldImg)) {
                            unlink($_SERVER['DOCUMENT_ROOT'].$oldImg);
                        }
                    }
                    $result = [
                        'code'=>0,
                        'msg'=>'保存成功！',
                    ];
                } else {
                    if ($src) {
                        // 删除logo图片
                        if (is_file($_SERVER['DOCUMENT_ROOT'].$src)) {
                            unlink($_SERVER['DOCUMENT_ROOT'].$src);
                        }
                    }
                    $result  = [
                        'code'=>-1,
                        'msg'=>'保存失败！'
                    ];
                }
            } else { // 添加分区
                if (!$src) {
                    // 赋值默认的LOGO
                    $param['img'] = '/bcweb/public/luntan/img/badge/red.png';
                }
                if (DB::name('forum_zone')->insert($param)) {
                    $result = [
                        'code'=>0,
                        'msg'=>'保存成功！',
                    ];
                } else {
                    if ($src) {
                        // 删除logo图片
                        if (is_file($_SERVER['DOCUMENT_ROOT'].$src)) {
                            unlink($_SERVER['DOCUMENT_ROOT'].$src);
                        }
                    }
                    $result  = [
                        'code'=>-1,
                        'msg'=>'保存失败！'
                    ];
                }
            }
            echo json_encode($result);
            return;
        } elseif (isset($param['id'])&&$param['id']) {// 修改分区
            // 获取分区信息
            $info = DB::name('forum_zone')->where(['id'=>$param['id']])->find();
        } else {
            $info = [
                'id'=>'',
                'name'=>'',
                'title'=>'',
                'door'=>0,
                'gold'=>0,
                'pride_percent'=>0,
                'limit_tie'=>0,
                'img'=>'/bcweb/public/luntan/img/badge/red.png'
            ];
        }
        $this->assign([
            'title'=>$info['id'] ? '修改分区' : '添加分区',
            'back_url'=>url('Admin/Luntan/index'),
            'info'=>$info,
        ]);
        return $this->fetch();
    }


    public function uploadLogo()
    {
        $file = $this->request->file('img');
        if ($file) {
            $savePath = config('template.tpl_replace_string.__PUBLIC__').DS.'luntan'.DS.'zone_logo';
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].$savePath)) {
                mkdir($_SERVER['DOCUMENT_ROOT'].$savePath, 0777, true);
            }
            $info = $file->move($_SERVER['DOCUMENT_ROOT'].$savePath);
            if ($info) {
                return $savePath.DS.$info->getSaveName();
            } else {
                return -1;
            }
        } else {
            return false;
        }
    }

    // 删除分区
    public function deleteFenQu()
    {
        $id = $this->request->param('id');
        $result = [
            'code'=>0,
            'msg'=>'删除成功！',
        ];
        $res = $this->log($id);
        // 启动事务
        DB::startTrans();
        try {
            DB::name('forum_zone')->where('id', $id)->delete();
            DB::name('forum_post')->where('zone_id', $id)->delete();
            if (isset($res['forum_comment'])&&!empty($res['forum_comment'])) {
                DB::name('forum_comment')->where('post_id', 'in', $res['forum_comment'])->delete();
            }
            if (isset($res['forum_reply'])&&!empty($res['forum_reply'])) {
                DB::name('forum_reply')->where('comment_id', 'in', $res['forum_reply'])->delete();
            }
            // echo '[id:'.$id.']';
            // 提交事务
            DB::commit();
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollback();
            $result = [
                'code'=>-1,
                'msg'=>'删除失败！',
            ];
        }
        if (!$result['code']) {
            $path = __ROOT__.DS.'Logs';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            file_put_contents($path.DS.'data-'.time().'.json', json_encode($res['log']));
        }
        echo json_encode($result);
    }


    private function log($id)
    {
        $info = DB::name('forum_zone')->where('id', $id)->find();
        $log['forum_zone'] = $info;
        $tieInfo = DB::name('forum_post')->where('zone_id', $id)->select();
        $log['forum_post'] = $tieInfo;
        $retrunValue['result'] = true;

        if (!empty($tieInfo)) {
            foreach ($tieInfo as $key => $value) {
                $where[] = $value['id'];
            }
            if (isset($where)&&!empty($where)) {
                $retrunValue['forum_comment'] = $where;
                $comment = DB::name('forum_comment')->where('post_id', 'in', $where)->select();
                $log['forum_comment'] = $comment;
                if (!empty($comment)) {
                    foreach ($comment as $key => $value) {
                        $w[] = $value['id'];
                    }
                    if (isset($w)&&!empty($w)) {
                        $retrunValue['forum_reply'] = $w;
                        $reply = DB::name('forum_reply')->where('comment_id', 'in', $w)->select();
                        $log['forum_reply'] = $reply;
                    }
                }
            }
        }
        $retrunValue['log'] = $log;
        return $retrunValue;
    }
}
