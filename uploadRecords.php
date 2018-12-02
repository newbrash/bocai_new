<?php
header("Access-Control-Allow-Headers: Content-Type,XFILENAME,XFILECATEGORY,XFILESIZE");
header('Access-Control-Allow-Origin:*');
// var_dump($_FILES);die;
define('DS', DIRECTORY_SEPARATOR);
$file = $_FILES['videofile'];
// var_dump($file);
if ($file && !empty($file)) {
	if($file['type'] == 'audio/wav'){
		if($file['error']>0){
			echo json_encode([
				'status'=>false,
				'msg'=>'上传出错',
				'errcode'=>$file['error'],
			]);
		}else{
			$root = $_SERVER['DOCUMENT_ROOT'];
			$savePath = '/Voices'.DS.date('Ymd');
			if(!is_dir($root.$savePath)){
				mkdir($root.$savePath,0777 ,true);
			}
			$name = 'voice_'.rand().'_'.time().'.wav';
			if(is_file($root.$savePath.DS.$name)){
				$name = 'voice_'.rand().'_'.time().'.wav';
			}
			if(move_uploaded_file($file['tmp_name'], $root.$savePath.DS.$name)){
				echo json_encode([
					'status'=>true,
					'src'=>$savePath.DS.$name
				]);
			}else{
				echo json_encode([
					'status'=>false,
					'msg'=>'上传失败！',
				]);
			}
		}
	}else{
		echo json_encode([
			'status'=>false,
			'msg'=>'音频格式不对（'.$file['type'].'）',
		]);
	}
}