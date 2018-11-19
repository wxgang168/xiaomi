<?php

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require(dirname(__FILE__) . '/plugins/aliyunoss/autoload.php');

include('includes/cls_json.php');

$json   = new JSON;
$res    = array('err_msg' => '', 'err_no' => 0, 'result' => '');

$rootPath  = ROOT_PATH; // 设置附件上传根目录

$act = isset($_REQUEST['act']) ? addslashes_deep($_REQUEST['act']) : 'upload';
$bucket = isset($_REQUEST['bucket']) ? addslashes_deep($_REQUEST['bucket']) : '';
$keyid = isset($_REQUEST['keyid']) ? addslashes_deep($_REQUEST['keyid']) : '';
$keysecret = isset($_REQUEST['keysecret']) ? addslashes_deep($_REQUEST['keysecret']) : '';
$endpoint = isset($_REQUEST['endpoint']) ? addslashes_deep($_REQUEST['endpoint']) : '';
$is_cname = isset($_REQUEST['is_cname']) ? intval($_REQUEST['is_cname']) : 1;
$object = isset($_REQUEST['object']) ? $_REQUEST['object'] : array();
$file = '';

/* 是否删除图片 */
$type = isset($_REQUEST['type']) && !empty($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;

if($is_cname == 1){
	$is_cname = true;
}else{
	$is_cname = false;
}

$ossClient = new \OSS\OssClient($keyid, $keysecret, $endpoint, $is_cname);

/*
 *----------------------------
 *阿里云OSS文件上传
 *----------------------------
 */
if ($act == 'upload') {
    
    if (is_array($object)) {
        foreach ($object as $row) {
            if ($row) {
                $file = $rootPath . $row;
                $objects = $row;
                $ossClient->putObject($bucket, $objects, '{$row}');
                $res_oss = $ossClient->uploadFile($bucket, $objects, $file);

                if($res_oss['is_ok'] && $type){
                    dsc_unlink($file);
                }
            }
        }
    } else {
        $file = $rootPath . $object;

        $ossClient->putObject($bucket, $object, '{$object}');
        $res_oss = $ossClient->uploadFile($bucket, $object, $file);
        
        if ($res_oss['is_ok'] && $type) {
            dsc_unlink($file);
        }
    }
}
/*
 *----------------------------
 *阿里云OSS文件删除
 *----------------------------
 */
 elseif ($act == 'del_file') {
    $ossClient->deleteObjects($bucket, $object); //删除对象文件
}

/*
 *----------------------------
 *阿里云OSS文件列表
 *----------------------------
 */
elseif ($act == 'list_file') {

    $list = $ossClient->listObjects($bucket, $object);
    $list = object_array($list);
    
    $arr = array();
    foreach($list as $key=>$row){
        if(is_array($row)){
            $key = str_replace(array("OSS\Model\ObjectListInfo", 'List'), '', $key);
            
            foreach($row as $kr=>$krow){
                $row[$kr] = array_values($krow);
            }
            
            $arr[$key] = $row;
        }
    }
    
    $res['list'] = $arr;
}

$res['object'] = $object;
$res['type'] = $type;

die($json->encode($res));