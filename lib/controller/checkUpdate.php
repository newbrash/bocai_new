<?php
header("Access-Control-Allow-Headers: Content-Type,XFILENAME,XFILECATEGORY,XFILESIZE");
header('Access-Control-Allow-Origin:*');

$updateContent = file_get_contents("../res/updateFile.json");
echo $updateContent;
// file_put_contents('../res/updateFile.json', json_encode([]));
// return $updateContent;
