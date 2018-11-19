<?php

/**
 * ECSHOP 提交用户评论
 * ============================================================================
 * * 旺旺：ecshop2012版权所有，并保留所有权利。* 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: comment.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_clips.php');
require_once(ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/user.php');
require(ROOT_PATH . 'includes/cls_json.php');
if (!isset($_REQUEST['cmt']) && !isset($_REQUEST['act']))
{
    /* 只有在没有提交评论内容以及没有act的情况下才跳转 */
    ecs_header("Location: ./\n");
    exit;
}
$_REQUEST['cmt'] = isset($_REQUEST['cmt']) ? json_str_iconv($_REQUEST['cmt']) : '';

$json   = new JSON;
$result = array('error' => 0, 'message' => '', 'content' => '');


$cmt = new stdClass();
$cmt->id   = !empty($_GET['id'])   ? intval($_GET['id'])   : 0;
$cmt->type = !empty($_GET['type']) ? intval($_GET['type']) : 0;
$cmt->page = isset($_GET['page'])   && intval($_GET['page'])  > 0 ? intval($_GET['page'])  : 1;


if ($result['error'] == 0)
{
    $record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('collect_store').
                            " WHERE user_id='" .$_SESSION['user_id']. "'");
    
    if (defined('THEME_EXTENSION')){
        $size = 5;
    }else{
        $size = 3;
    }
    
    $collection_store = get_collection_store($_SESSION['user_id'], $record_count, $cmt->page, 'collection_store_gotoPage', $size);

    $smarty->assign('store_list', $collection_store['store_list']);
    $smarty->assign('pager', $collection_store['pager']);
    $smarty->assign('count', $collection_store['record_count']);
    $smarty->assign('size', $collection_store['size']);

    $smarty->assign('url',        $ecs->url());
    $lang_list = array(
    'UTF8'   => $_LANG['charset']['utf8'],
    'GB2312' => $_LANG['charset']['zh_cn'],
    'BIG5'   => $_LANG['charset']['zh_tw'],
    );
    $smarty->assign('lang_list',  $lang_list);
    $smarty->assign('user_id',  $_SESSION['user_id']);

    $smarty->assign('lang',       $_LANG);

    $result['content'] = $smarty->fetch("library/collection_store_list.lbi");
    $result['pages'] = $smarty->fetch("library/pages_ajax.lbi");
}

echo $json->encode($result);

?>