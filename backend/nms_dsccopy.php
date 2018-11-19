<?php

/**
 * 牛模式ECSHOP采集插件:http://niumos.com/(淘宝店：new-modle.taobao.com QQ：303441162)
 * ============================================================================
 * 版权所有 牛模式团队，并保留所有权利。
 * 网站地址: http://www.niumos.com；
 * ----------------------------------------------------------------------------
 * 牛模式插件安装程序
 * ============================================================================
 * $Author: yxn $
 * $Id: nms_install.php 17217 2016-01-12 yxn $
*/

define('IN_ECS', true);
define('IN_PRINCE', true);
//$max_time=ini_get("max_execution_time");
//print_r($max_time);
ini_set("max_execution_time", 300);

$hostdir=dirname(__FILE__);
//$filenames = get_filenamesbydir($hostdir . '/000xjd');  
////打印所有文件名，包括路径  
//foreach ($filenames as $value) {  
//    echo $value."<br />";  
//} 
//exit;
require($hostdir . '/includes/init.php');
$heads='<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<style type="text/css">
body{ padding:5px 0; background:#FFF; text-align:center; width:600px;margin: 0 auto;background: #F5F5F5;}
body, td, input, textarea, select, button{ color:#666; font:12px/1.5 Verdana, Tahoma, Arial, "Microsoft Yahei", "Simsun", sans-serif; }
.container{ overflow:hidden; margin:0 auto; width:700px; height:auto !important;text-align:left; border:1px solid #B5CFD9; }
.main{ padding:20px 20px 0; background:#F7FBFE url(bg_repx.gif) repeat-x 0 -194px; }
.main h3{ margin:10px auto; width:75%; color:#6CA1B4; font-weight:700; }
#notice {overflow-y:scroll; margin: 20px; padding: 5px 20px; border: 1px solid #B5CFD9; text-align: left; background: #fff;height:70%;}
#notice img{margin: 5px 0 0;width:30px; height:30px; border: 2px solid #ccc;vertical-align: bottom; }
#notice .yuantu{width:16px; height:16px; border:none;vertical-align: bottom; }
#notice a{color: #666;}
#notice a:hover{color: #FF6600;}
.hide{display:none}
.cj_green{color:#009900;}
.cj_red{color:#FF0000;}
.cj_bulue{color:#0033FF;}
.cj_cn{color:#FF00FF;}
.cj_hui{color:#999;}
.cj_fanyi{color:#009900;}
.cj_black{color:#000;}
.cj_over1{color:#000;}
.cj_over{color:#FF0000;}
</style>
<meta name="Copyright" content="Comsenz Inc.">
</head>
<body>
<script type="text/javascript">
function showmessage(message,ext,isbr) {
	isbr_str=(isbr==1)? "":"<br/>";
    document.getElementById("notice1").innerHTML += message + isbr_str;
	if (ext==1){
			document.getElementById("zload").innerHTML="";
    }
	document.getElementById("notice").scrollTop = 100000000;
}
</script><br />
<div id="notice">
<div id="notice1"></div>
<div id="zload"><img src=https://img.alicdn.com/imgextra/i2/619666972/TB2tFwrjVXXXXXnXpXXXXXXXXXX-619666972.gif class=yuantu></div>
</div>';


if (!is_writable($hostdir.'/index.php'))
{
	echo('请设置网站目录可写权限！');
	exit;
}



	flush_echo_nms($heads);
	
	
	//开始备份
	$param=array();
	$param[] = 'admin/includes/init.php';
	$param[] = 'admin/includes/lib_goods.php';
	$param[] = 'admin/includes/lib_main.php';
	$param[] = 'admin/includes/inc_menu.php';
	$param[] = 'admin/templates/goods_info.dwt';
	$param[] = 'admin/templates/goods_list.dwt';
	$param[] = 'admin/templates/product_info.dwt';
	$param[] = 'admin/js/common.js';
	$param[] = 'admin/goods.php';
	$param[] = 'includes/lib_common.php';
	$param[] = 'includes/lib_goods.php';
	$param[] = 'includes/lib_ecmobanFunc.php';
	$param[] = 'goods.php';
	$param[] = 'themes/ecmoban_dsc2017/goods.dwt';
		$param[] = 'seller/includes/init.php';
		$param[] = 'seller/includes/lib_goods.php';
		$param[] = 'seller/includes/inc_menu.php';
		$param[] = 'seller/templates/goods_list.dwt';
		$param[] = 'seller/templates/product_info.dwt';
		$param[] = 'seller/goods.php';
		//其他要处理的文件
		$param[] = 'mobile/resources/views/goods/index.html';
		$param[] = 'mobile/app/helpers/common_helper.php';
		$param[] = 'mobile/app/helpers/scfunction_helper.php';
		$param[] = 'mobile/app/http/goods/controllers/Index.php';
	
	showjsmessage('正在创建备份....');	
	foreach((array)$param as $key => $value)
	{
		$value = str_replace('admin',ADMIN_PATH,$value);
		$value = str_replace('default',$_CFG['template'],$value);
		$value = str_replace('1.','',$value);
		createDir(dirname($hostdir . '/nmsbak/'.$value),$hostdir);
	}
	showjsmessage('正在备份....');	
	foreach((array)$param as $key => $value)
	{
		$value = str_replace('admin',ADMIN_PATH,$value);
		$value = str_replace('default',$_CFG['template'],$value);
		$value = str_replace('1.','',$value);
		
		if (!file_exists($hostdir . '/nmsbak/' . $value))
		{ 
			copy($hostdir . '/' . $value, 				$hostdir . '/nmsbak/' . $value);
			showjsmessage('已备份文件：'.$value);
		}
		else
			showjsmessage('已存在文件：'.$value);
			

	}	
	showjsmessage('备份完成....');	
	//开始修改
exit;
function get_allfiles($path,&$files) {  
    if(is_dir($path)){  
        $dp = dir($path);  
        while ($file = $dp ->read()){  
            if($file !="." && $file !=".."){  
                get_allfiles($path."/".$file, $files);  
            }  
        }  
        $dp ->close();  
    }  
    if(is_file($path)){  
        $files[] =  $path;  
    }  
}  
     
function get_filenamesbydir($dir){  
    $files =  array();  
    get_allfiles($dir,$files);  
    return $files;  
}  
     
function get_detail_text($url)
{
	if(!function_exists('curl_init'))
	{ 
		$file_contents = file_get_contents($url); 
	} else { 
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
		//设置允许curl请求连接的最长秒数，如果设置为0，则无限 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20); 
		//设置允许curl所有动作执行的最长秒数，如果设置为0，则无限 
		curl_setopt ($ch, CURLOPT_TIMEOUT,60); 
		$file_contents = curl_exec($ch); 
		curl_close($ch); 
	} 
	return $file_contents; 

}
function get_curl_data($param,$folder,$session_key='')
{
		$url = "http://121.199.160.218/ins_nms.php";
		$host=getdomain($_SERVER['HTTP_HOST']);
		$ip_address = real_ip();
		$postFields = array(
			'param' 		=> $param,
			'folder' 		=> $folder,
			'host' 			=> $host,
			'ip_address' 	=> $ip_address, 
			'session_key'	=>$session_key,
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (is_array($postFields) && 0 < count($postFields))
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		}

		$reponse = curl_exec($ch);
		curl_close($ch);
		if (strpos($reponse,'请联系牛模式官方')>0)
		{
			echo($reponse);
			exit;
		}
		return $reponse;
}

function flush_echo_nms($data) {

//	echo str_pad(' ', 64000);
	ob_end_flush();
	ob_implicit_flush(true);
	echo $data;

}

function showjsmessage($message,$ext=0,$is_br=0) {
//echo('showmessage(\''.addslashes($message).' \','.$ext.')');
//exit;
		flush_echo_nms('<script type="text/javascript">showmessage(\''.addslashes($message).'\','.$ext.','.$is_br.');</script>'."\r\n");
		
}
function createDir($path,$hostdir)
{
    if (!file_exists($path)){ 
//		showjsmessage("已创建目录：".str_replace($hostdir,'',$path));
        createDir(dirname($path),$hostdir); 
        mkdir($path, 0777);
    }
}

function getdomain($url) { 
	$host = strtolower ( $url ); 
	if (strpos ( $host, '/' ) !== false) { 
	$parse = @parse_url ( $host ); 
	$host = $parse ['host']; 
	} 
	$topleveldomaindb = array ('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me' ); 
	$str = ''; 
	foreach((array) $topleveldomaindb as $v ) { 
	$str .= ($str ? '|' : '') . $v; 
	} 
	
	$matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$"; 
	if (preg_match ( "/" . $matchstr . "/ies", $host, $matchs )) { 
	$domain = $matchs ['0']; 
	} else { 
	$domain = $host; 
	} 
	return $domain; 
} 

?>