<?php

/**
 * ECSHOP 记录管理员操作日志
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: admin_logs.php 17217 2018-07-19 06:29:08Z liubo $
*/

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

/* act操作项的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

//ecmoban模板堂 --zhuo start
$adminru = get_admin_ru_id();
if($adminru['ru_id'] == 0){
    $smarty->assign('priv_ru',   1);
}else{
    $smarty->assign('priv_ru',   0);
} 	
//ecmoban模板堂 --zhuo end

$smarty->assign('menu_select',array('action' => '02_cat_and_goods', 'current' => 'notice_logs'));

/*------------------------------------------------------ */
//-- 获取所有日志列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 权限的判断 */
    admin_priv('notice_logs');

    $user_id   = !empty($_REQUEST['id'])       ? intval($_REQUEST['id']) : 0;
    $admin_ip  = !empty($_REQUEST['ip'])       ? $_REQUEST['ip']         : '';
    $log_date  = !empty($_REQUEST['log_date']) ? $_REQUEST['log_date']   : '';

    $smarty->assign('ur_here',   '降价通知日志');
    $smarty->assign('ip_list',   $ip_list);
    $smarty->assign('full_page', 1);

    $log_list = get_notice_logs($adminru['ru_id']);

    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);

    $sort_flag  = sort_flag($log_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
    //区分自营和店铺
    self_seller(BASENAME($_SERVER['PHP_SELF']));

    assign_query_info();
    $smarty->display('notice_logs.dwt');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $log_list = get_notice_logs($adminru['ru_id']);

    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);

    $sort_flag  = sort_flag($log_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('notice_logs.dwt'), '',
        array('filter' => $log_list['filter'], 'page_count' => $log_list['page_count']));
}

/*------------------------------------------------------ */
//-- 批量删除日志记录
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'batch_drop')
{
    admin_priv('notice_logs');

    $drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';

    /* 按日期删除日志 */
    if ($drop_type_date)
    {
        if ($_POST['log_date'] == '0')
        {
            ecs_header("Location: notice_logs.php?act=list\n");
            exit;
        }
        elseif ($_POST['log_date'] > '0')
        {
            $where = " WHERE 1 ";
            switch ($_POST['log_date'])
            {
                case '1':
                    $a_week = gmtime()-(3600 * 24 * 7);
                    $where .= " AND send_time <= '".$a_week."'";
                    break;
                case '2':
                    $a_month = gmtime()-(3600 * 24 * 30);
                    $where .= " AND send_time <= '".$a_month."'";
                    break;
                case '3':
                    $three_month = gmtime()-(3600 * 24 * 90);
                    $where .= " AND send_time <= '".$three_month."'";
                    break;
                case '4':
                    $half_year = gmtime()-(3600 * 24 * 180);
                    $where .= " AND send_time <= '".$half_year."'";
                    break;
                case '5':
                    $a_year = gmtime()-(3600 * 24 * 365);
                    $where .= " AND send_time <= '".$a_year."'";
                    break;
            }
            $sql = "DELETE FROM " .$ecs->table('notice_log').$where;
            $res = $db->query($sql);
            if ($res)
            {
                admin_log('','remove', 'noticelog');

                $link[] = array('text' => $_LANG['back_list'], 'href' => 'notice_logs.php?act=list');
                sys_msg($_LANG['drop_sueeccud'], 1, $link);
            }
        }
    }
    /* 如果不是按日期来删除, 就按ID删除日志 */
    else
    {
        $count = 0;
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            $sql = "DELETE FROM " .$ecs->table('notice_log'). " WHERE id = '$id'";
            $result = $db->query($sql);

            $count++;
        }
        if ($result)
        {
            admin_log('', 'remove', 'noticelog');

            $link[] = array('text' => $_LANG['back_list'], 'href' => 'notice_logs.php?act=list');
            sys_msg(sprintf($_LANG['batch_drop_success'], $count), 0, $link);
        }
    }
}

/* 获取管理员操作记录 */
function get_notice_logs($ru_id)
{
    $filter = array();
    $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'id' : trim($_REQUEST['sort_by']);
    $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
    $filter['seller_list'] = isset($_REQUEST['seller_list']) && !empty($_REQUEST['seller_list']) ? 1 : 0;  //商家和自营订单标识

    //查询条件
    $where = " WHERE 1 ";
    
    if($ru_id > 0){
        $where .= " AND g.user_id = '$ru_id'";
    }
    $where .= !empty($filter['seller_list']) ? " AND g.user_id > 0 " : " AND g.user_id = 0 "; //区分商家和自营 

    /* 获得总记录数据 */
    $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('notice_log') ." as nl, " .$GLOBALS['ecs']->table('goods') ." as g ". $where . " AND nl.goods_id = g.goods_id ";
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);

    /* 获取管理员日志记录 */
    $list = array();
    $sql  = 'SELECT nl.*, g.user_id, g.goods_name FROM ' .$GLOBALS['ecs']->table('notice_log') . " as nl, ". 
            $GLOBALS['ecs']->table('goods') ." as g ".
            $where  . " AND nl.goods_id = g.goods_id " . ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];
    $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $rows['send_time'] = local_date($GLOBALS['_CFG']['time_format'], $rows['send_time']);
        $rows['shop_name'] = get_shop_name($rows['user_id'], 1);

        $list[] = $rows;
    }

    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>