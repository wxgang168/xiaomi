<?php

/**
 * ECSHOP 管理中心news页面可视化
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: account_log.php 17217 2018-07-19 06:29:08Z liubo $
 */
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . '/includes/lib_visual.php');
/* 权限判断 */
    admin_priv('article_manage');
if($_REQUEST['act'] == 'visual'){
    
    $des = ROOT_PATH . 'data/cms_Templates/'.$GLOBALS['_CFG']['template'];
    //如果存在缓存文件  ，调用缓存文件
    $is_temp = 0;
    if(file_exists($des."/".$code."/temp/pc_page.php")){
        $filename = $des."/temp/pc_page.php";
        $is_temp = 1;
    }else{
        $filename = $des.'/pc_page.php';
    }
   
    $news = get_html_file($filename);
    $smarty->assign('pc_page',$news);
    $smarty->assign('is_temp',$is_temp);
    $smarty->display('news.dwt');
}
elseif($_REQUEST['act'] == 'restore'){
     require(ROOT_PATH . '/includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => '','content' => '');
    
    $des = ROOT_PATH . 'data/cms_Templates/'.$GLOBALS['_CFG']['template'];
    del_DirAndFile($des);
    die(json_encode($result));
}
?>