<?php
namespace app\Admin\controller;
use app\Admin\controller;
use think\Db;
use think\facade\Session;
use think\facade\Config;
class LimitInput extends Common
{
	
    public function index(){
        // dump(time());die;
        if($this->request->isPost()){
            $param = $this->request->param();
            // $old_filter_allow = $param['old_filter_allow'];
            // unset($param['old_filter_allow']);
            if($param['id']){
                if($this->updateRedis($param)){
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
				}else{
					$result = [
						'code'=>-1,
						'msg'=> '设置失败！'
					];
				}
            }else{
                if(DB::name('system_info')->insert($param)){
                    $system_info = DB::name('system_info')->find();
                    if ($this->setRedis($system_info)) {
                        $result = [
                            'code'=>0,
                            'msg'=> '保存成功！'
                        ];
                    } else {
						DB::name('system_info')->where('id',$system_info['id'])->delete();
                        $result = [
                            'code'=>-1,
                            'msg'=> '设置失败！'
                        ];
                    }
                }else{
                    $result = [
                        'code'=>-1,
                        'msg'=>'保存失败！',
                    ];
                }
            }
            echo json_encode($result);
            // if(!$result['code']){
            //     // DB::name('user_user')->update('allow_times', ($param['filter_allow'] - $old_filter_allow));
            //     $sql = 'update bc_user_user set allow_times='.$param['filter_allow'];
            //     DB::execute($sql);
            // }
            return;
        }
        $info = DB::name('system_info')->field('id,filter_mod,filter_replace,filter_words,filter_input,filter_show,filter_tips,filter_allow,filter_defriend,defriend_mod,filter_notice')->find();
        $this->assign([
            'title'=>'输入限制',
            'back_url'=>url('Admin/Index/index'),
            'info'=>$info,
        ]);
        return $this->fetch();
    }
}