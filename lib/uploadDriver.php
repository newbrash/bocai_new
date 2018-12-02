<?php
// namespace lib;
// 
// use  lib\controller\upload;

header("Access-Control-Allow-Headers: Content-Type,XFILENAME,XFILECATEGORY,XFILESIZE");
header('Access-Control-Allow-Origin:*');
//var_dump($_FILES);die;
require_once($_SERVER['DOCUMENT_ROOT'].'/bcweb/lib/controller/upload.php');

$uploadObj = new upload();
$post = $_POST;
if ($post['type'] == 'sendImage') {
    $uploadObj->uploadImage();
} else {
    $uploadObj->uploadAudio();
}
