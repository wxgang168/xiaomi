<?php

/**
 * ECSHOP 广告位置管理程序
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: ad_position.php 17217 2018-07-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/' .ADMIN_PATH. '/ads.php');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$smarty->assign('lang', $_LANG);
$exc = new exchange($ecs->table("ad_position"), $db, 'position_id', 'position_name');

//ecmoban模板堂 --zhuo start
$adminru = get_admin_ru_id();
if($adminru['ru_id'] == 0){
        $smarty->assign('priv_ru',   1);
}else{
        $smarty->assign('priv_ru',   0);
}
//ecmoban模板堂 --zhuo end

/*------------------------------------------------------ */
//-- 广告位置列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
	if($adminru['ru_id'] == 0){//限制商家不可操作添加广告位 liu
    $smarty->assign('ur_here',     $_LANG['ad_position']);
    $smarty->assign('action_link', array('text' => $_LANG['position_add'], 'href' => 'ad_position.php?act=add'));
	}
    $smarty->assign('full_page',   1);

    $position_list = ad_position_list($adminru['ru_id']);
    
    $smarty->assign('position_list',   $position_list['position']);
    $smarty->assign('filter',          $position_list['filter']);
    $smarty->assign('record_count',    $position_list['record_count']);
    $smarty->assign('page_count',      $position_list['page_count']);
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);

    assign_query_info();
    $smarty->display('ad_position_list.dwt');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $position_list = ad_position_list($adminru['ru_id']);

    $smarty->assign('position_list',   $position_list['position']);
    $smarty->assign('filter',          $position_list['filter']);
    $smarty->assign('record_count',    $position_list['record_count']);
    $smarty->assign('page_count',      $position_list['page_count']);
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);

    make_json_result($smarty->fetch('ad_position_list.dwt'), '',
        array('filter' => $position_list['filter'], 'page_count' => $position_list['page_count']));
}

/*------------------------------------------------------ */
//-- 添加广告位页面
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('ad_manage');

    /* 模板赋值 */
    $smarty->assign('ur_here',     $_LANG['position_add']);
    $smarty->assign('form_act',    'insert');

    $smarty->assign('action_link', array('href' => 'ad_position.php?act=list', 'text' => $_LANG['ad_position']));
    $smarty->assign('posit_arr',   array('position_style' => '<table cellpadding="0" cellspacing="0">' ."\n". '{foreach from=$ads item=ad}' ."\n". '<tr><td>{$ad}</td></tr>' ."\n". '{/foreach}' ."\n". '</table>'));

    assign_query_info();
    $smarty->display('ad_position_info.dwt');
}
elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('ad_manage');

    /* 对POST上来的值进行处理并去除空格 */
    $position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
	$position_model = !empty($_POST['position_model']) ? trim($_POST['position_model']) : '';
    $position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    $ad_width      = !empty($_POST['ad_width'])      ? intval($_POST['ad_width'])  : 0;
    $ad_height     = !empty($_POST['ad_height'])     ? intval($_POST['ad_height']) : 0;
    $is_public     = isset($_POST['is_public'])     ? intval($_POST['is_public']) : 0;  //ecmoban模板堂 --zhuo
    
    $template = $GLOBALS['_CFG']['template'];
    
    $where = " theme = '$template'";
    /* 查看广告位是否有重复 */
    if ($exc->num("position_name", $position_name, 0, $where) == 0)
    {
        /* 将广告位置的信息插入数据表 */
        $sql = 'INSERT INTO '.$ecs->table('ad_position').' (position_name, ad_width, ad_height, position_model, position_desc, position_style, user_id, is_public, theme) '.
               "VALUES ('$position_name', '$ad_width', '$ad_height', '$position_model', '$position_desc', '$_POST[position_style]', '$adminru[ru_id]', '$is_public', '$template')";

        $db->query($sql);
		
        /* 获取pid by wu */
        $insert_id = $db->insert_id();
        $pid = empty($insert_id) ? 0 : $insert_id;

        /* 记录管理员操作 */
        admin_log($position_name, 'add', 'ads_position');

        /* 提示信息 */
        $link[0]['text'] = $_LANG['ads_add'];
        $link[0]['href'] = 'ads.php?act=add'.'&pid='.$pid;

        $link[1]['text'] = $_LANG['continue_add_position'];
        $link[1]['href'] = 'ad_position.php?act=add';

        $link[2]['text'] = $_LANG['back_position_list'];
        $link[2]['href'] = 'ad_position.php?act=list';

        sys_msg($_LANG['add'] . "&nbsp;" . stripslashes($position_name) . "&nbsp;" . $_LANG['attradd_succed'], 0, $link);
    }
    else
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['posit_name_exist'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- 广告位编辑页面
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    admin_priv('ad_manage');

    $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

    /* 获取广告位数据 */
    $sql = 'SELECT * FROM ' .$ecs->table('ad_position'). " WHERE position_id='$id'";
    $posit_arr = $db->getRow($sql);

    $smarty->assign('ur_here',     $_LANG['position_edit']);
    $smarty->assign('action_link', array('href' => 'ad_position.php?act=list', 'text' => $_LANG['ad_position']));
    $smarty->assign('posit_arr',   $posit_arr);
    $smarty->assign('form_act',    'update');

    assign_query_info();
    $smarty->display('ad_position_info.dwt');
}
elseif ($_REQUEST['act'] == 'update')
{
    admin_priv('ad_manage');

    /* 对POST上来的值进行处理并去除空格 */
    $position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
	$position_model = !empty($_POST['position_model']) ? trim($_POST['position_model']) : '';
    $position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
    $ad_width      = !empty($_POST['ad_width'])      ? intval($_POST['ad_width'])  : 0;
    $ad_height     = !empty($_POST['ad_height'])     ? intval($_POST['ad_height']) : 0;
    $position_id   = !empty($_POST['id'])            ? intval($_POST['id'])        : 0;
    $is_public     = isset($_POST['is_public'])     ? intval($_POST['is_public']) : 0; //ecmoban模板堂 --zhuo
    
    $template = $GLOBALS['_CFG']['template'];
    
    /* 查看广告位是否与其它有重复 */
    $sql = 'SELECT COUNT(*) FROM ' .$ecs->table('ad_position').
           " WHERE position_name = '$position_name' AND theme = '$template' AND position_id <> '$position_id'";
    if ($db->getOne($sql) == 0)
    {
        $sql = "UPDATE " .$ecs->table('ad_position'). " SET ".
               "position_name    = '$position_name', ".
               "ad_width         = '$ad_width', ".
               "ad_height        = '$ad_height', ".
			   "position_model   = '$position_model', ".
               "position_desc    = '$position_desc', ".
               "is_public        = '$is_public', ". //ecmoban模板堂 --zhuo
               "position_style   = '$_POST[position_style]' ".
               "WHERE position_id = '$position_id'";
        if ($db->query($sql))
        {
           /* 记录管理员操作 */
           admin_log($position_name, 'edit', 'ads_position');

           /* 清除缓存 */
           clear_cache_files();

           /* 提示信息 */
           $link[] = array('text' => $_LANG['back_position_list'], 'href' => 'ad_position.php?act=list');
           sys_msg($_LANG['edit'] . ' ' .stripslashes($position_name).' '. $_LANG['attradd_succed'], 0, $link);
        }
    }
    else
    {
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
        sys_msg($_LANG['posit_name_exist'], 0, $link);
    }
}



/*------------------------------------------------------ */
//-- 删除广告位置
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('ad_manage');

    $id = intval($_GET['id']);

    /* 查询广告位下是否有广告存在 */
    $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('ad'). " WHERE position_id = '$id'";

    if ($db->getOne($sql) > 0)
    {
        make_json_error($_LANG['not_del_adposit']);
    }
    else
    {
        $exc->drop($id);
        admin_log('', 'remove', 'ads_position');
    }

    $url = 'ad_position.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}


/* 获取广告位置列表 */
function ad_position_list($ru_id)
{
    //ecmoban模板堂 --zhuo start
    $where = " WHERE 1";
    if($ru_id > 0){
        $where .= " and (p.user_id = '$ru_id' or p.is_public = 1) ";
    }
    //ecmoban模板堂 --zhuo end
	
    $filter = array();
	
    $filter['keyword'] = !empty($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
    if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
    }
    
    //管理员查询的权限 -- 店铺查询 start
    $filter['store_search'] = empty($_REQUEST['store_search']) ? 0 : intval($_REQUEST['store_search']);
    $filter['merchant_id'] = isset($_REQUEST['merchant_id']) ? intval($_REQUEST['merchant_id']) : 0;
    $filter['store_keyword'] = isset($_REQUEST['store_keyword']) ? trim($_REQUEST['store_keyword']) : '';

    $store_where = '';
    $store_search_where = '';
    if($filter['store_search'] !=0){
       if($ru_id == 0){ 

           if($_REQUEST['store_type']){
                $store_search_where = "AND msi.shopNameSuffix = '" .$_REQUEST['store_type']. "'";
            }

            if($filter['store_search'] == 1){
                $where .= " AND p.user_id = '" .$filter['merchant_id']. "' ";
            }elseif($filter['store_search'] == 2){
                $store_where .= " AND msi.rz_shopName LIKE '%" . mysql_like_quote($filter['store_keyword']) . "%'";
            }elseif($filter['store_search'] == 3){
                $store_where .= " AND msi.shoprz_brandName LIKE '%" . mysql_like_quote($filter['store_keyword']) . "%' " . $store_search_where;
            }

            if($filter['store_search'] > 1){
                $where .= " AND (SELECT msi.user_id FROM " . $GLOBALS['ecs']->table('merchants_shop_information') .' as msi ' .  
                          " WHERE msi.user_id = p.user_id $store_where) > 0 ";
            }
       }
    }
    //管理员查询的权限 -- 店铺查询 end

    /* 关键字 */
    if (!empty($filter['keyword']))
    {
        $where .= " AND (p.position_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'" . ")";     
    }
    
    //模板类型
    $where .= " AND p.theme = '" .$GLOBALS['_CFG']['template']. "'";

    /* 记录总数以及页数 */
    $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('ad_position') ." AS p ". $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);

    /* 查询数据 */
    $arr = array();
    $sql = 'SELECT p.* FROM ' .$GLOBALS['ecs']->table('ad_position') ." AS p ". $where .' ORDER BY p.position_id DESC';
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
	
	$idx = 0;
    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $position_desc = !empty($rows['position_desc']) ? sub_str($rows['position_desc'], 50, true) : '';
        $rows['position_desc'] = nl2br(htmlspecialchars($position_desc));
        $rows['user_name'] = get_shop_name($rows['user_id'], 1); //ecmoban模板堂 --zhuo
	
        $arr[$idx] = $rows;
		
		$idx++;
    }
	
    return array('position' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>