<?php
// namespace lib\controller;

class upload
{
    public function __construct()
    {
        define('DS', DIRECTORY_SEPARATOR);
        define('__ROOT__', $_SERVER['DOCUMENT_ROOT']);
    }
    public function uploadAudio()
    {
        $file = $_FILES['videofile'];
        if ($file && !empty($file)) {
            if ($file['type'] == 'audio/wav') {
                if ($file['error']>0) {
                    echo json_encode([
                        'status'=>false,
                        'msg'=>'上传出错',
                        'errcode'=>$file['error'],
                    ]);
                } else {
                    $savePath = '/bcweb/lib/res/Voices'.DS.date('Ymd');
                    if (!is_dir(__ROOT__.$savePath)) {
                        mkdir(__ROOT__.$savePath, 0777, true);
                    }
                    $name = 'voice_'.mt_rand().'_'.time().'.wav';
                    if (is_file(__ROOT__.$savePath.DS.$name)) {
                        $name = 'voice_'.mt_rand().'_'.time().'.wav';
                    }
                    if (move_uploaded_file($file['tmp_name'], __ROOT__.$savePath.DS.$name)) {
                        echo json_encode([
                            'status'=>true,
                            'src'=>$savePath.DS.$name
                        ]);
                    } else {
                        echo json_encode([
                            'status'=>false,
                            'msg'=>'上传失败！',
                        ]);
                    }
                }
            } else {
                echo json_encode([
                    'status'=>false,
                    'msg'=>'音频格式不对（'.$file['type'].'）',
                ]);
            }
        } else {
            echo json_encode([
                'status'=>false,
                'msg'=>null,
            ]);
        }
    }
    public function uploadImage()
    {
        $file = $_FILES['image'];
        if ($file && !empty($file)) {
            // dump($file);
            // if($file['size'] > 5000){

            // }
            if ($file['type'] == 'image/jpg' ||
                $file['type'] == 'image/jpeg' ||
                $file['type'] == 'image/png' ||
                $file['type'] == 'image/gif') {
                if ($file['error']>0) {
                    echo json_encode([
                        'status'=>false,
                        'msg'=>'上传出错！',
                        'errcode'=>$file['error']
                    ]);
                } else {
                    $savePath = '/bcweb/lib/res/Images'.DS.date('Ymd');
                    if (!is_dir(__ROOT__.$savePath)) {
                        mkdir(__ROOT__.$savePath, 0777, true);
                    }
                    $name = 'iamge_'.mt_rand().'_'.time().'.'.substr($file['type'], (strrpos($file['type'], '/')+1));
                    if (move_uploaded_file($file['tmp_name'], __ROOT__.$savePath.DS.$name)) {
                        echo json_encode([
                            'status'=>true,
                            'src'=>$savePath.DS.$name
                        ]);
                    } else {
                        echo json_encode([
                            'status'=>false,
                            'msg'=>'上传失败！',
                        ]);
                    }
                }
            } else {
                echo json_encode([
                    'status'=>false,
                    'msg'=>'图片格式不正确！'
                ]);
            }
        } else {
            echo json_encode([
                'status'=>false,
                'msg'=>null,
            ]);
        }
    }
}
