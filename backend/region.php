<?php

/**
 * ECSHOP 地区切换程序
 * ============================================================================
 * * 旺旺：ecshop2012版权所有，并保留所有权利。* 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: region.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
//define('INIT_NO_USERS', true);
//define('INIT_NO_SMARTY', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_json.php');

header('Content-type: text/html; charset=' . EC_CHARSET);

$type   = !empty($_REQUEST['type'])   ? intval($_REQUEST['type'])   : 0;
$parent = !empty($_REQUEST['parent']) ? intval($_REQUEST['parent']) : 0;
$action  = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
$arr['regions'] = get_regions($type, $parent);
if($action == 'consigne'){
    $arr['type'] = $type+1;
    $smarty->assign('type',$arr['type']);
    $smarty->assign('regions_list',$arr['regions']);
    $arr['content'] = $smarty->fetch('library/dialog.lbi');
}else{
    $arr['type']    = $type;
    $arr['target']  = !empty($_REQUEST['target']) ? stripslashes(trim($_REQUEST['target'])) : '';
    $arr['target']  = htmlspecialchars($arr['target']);
}

$json = new JSON;
echo $json->encode($arr);

?>