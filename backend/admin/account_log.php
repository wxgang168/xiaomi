<?php

/**
 * ECSHOP 管理中心帐户变动记录
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
include_once(ROOT_PATH . 'includes/lib_order.php');

/* ------------------------------------------------------ */
//-- 办事处列表
/* ------------------------------------------------------ */
if ($_REQUEST['act'] == 'list') {
    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
    if ($user_id <= 0) {
        sys_msg('invalid param');
    }
    $user = user_info($user_id);
    if (empty($user)) {
        sys_msg($_LANG['user_not_exist']);
    }
    $smarty->assign('user', $user);

    if (empty($_REQUEST['account_type']) || !in_array($_REQUEST['account_type'], array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
        $account_type = '';
    } else {
        $account_type = $_REQUEST['account_type'];
    }
    $smarty->assign('account_type', $account_type);

    $smarty->assign('ur_here', $_LANG['account_list']);
    $smarty->assign('action_link', array('text' => $_LANG['add_account'], 'href' => 'account_log.php?act=add&user_id=' . $user_id));
    if ($user_id > 0) {
        $smarty->assign('action_link2', array('href' => 'users.php?act=list', 'text' => '会员列表'));
    }
    $smarty->assign('full_page', 1);

    $smarty->assign("user_id", $user_id);
    $smarty->assign('form_action', 'account_log');
    $account_list = get_accountlist($user_id, $account_type);
    $smarty->assign('account_list', $account_list['account']);
    $smarty->assign('filter', $account_list['filter']);
    $smarty->assign('record_count', $account_list['record_count']);
    $smarty->assign('page_count', $account_list['page_count']);

    assign_query_info();
    $smarty->display('user_list_edit.dwt');
}

/* ------------------------------------------------------ */
//-- 排序、分页、查询
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'query') {
    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
    if ($user_id <= 0) {
        sys_msg('invalid param');
    }
    $user = user_info($user_id);
    if (empty($user)) {
        sys_msg($_LANG['user_not_exist']);
    }
    $smarty->assign('user', $user);

    if (empty($_REQUEST['account_type']) || !in_array($_REQUEST['account_type'], array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
        $account_type = '';
    } else {
        $account_type = $_REQUEST['account_type'];
    }

    $smarty->assign('ur_here', $_LANG['account_list']);
    $smarty->assign('account_type', $account_type);
    $smarty->assign("user_id", $user_id);
    $smarty->assign('form_action', 'account_log');
    $account_list = get_accountlist($user_id, $account_type);
    $smarty->assign('account_list', $account_list['account']);
    $smarty->assign('filter', $account_list['filter']);
    $smarty->assign('record_count', $account_list['record_count']);
    $smarty->assign('page_count', $account_list['page_count']);

    make_json_result($smarty->fetch('user_list_edit.dwt'), '', array('filter' => $account_list['filter'], 'page_count' => $account_list['page_count']));
}

/* ------------------------------------------------------ */
//-- 调节帐户
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'add') {
    /* 检查权限 */
    admin_priv('account_manage');
    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
	
	if ($user_id > 0) {
        $smarty->assign('action_link', array('href' => 'users.php?act=list&user_id=' . $user_id, 'text' => '会员列表'));
    }
	
    if ($user_id <= 0) {
        sys_msg('invalid param');
    }
    $user = user_info($user_id);
    if (empty($user)) {
        sys_msg($_LANG['user_not_exist']);
    }
    $smarty->assign('user', $user);

    $sc_rand = rand(1000, 9999);
    $sc_guid = sc_guid();

    $account_cookie = MD5($sc_guid . "-" . $sc_rand);
    setcookie('account_cookie', $account_cookie, gmtime() + 3600 * 24 * 30, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);

    $smarty->assign('sc_guid', $sc_guid);
    $smarty->assign('sc_rand', $sc_rand);

    /* 显示模板 */
    $smarty->assign('ur_here', $_LANG['add_account']);
    $smarty->assign('action_link', array('href' => 'account_log.php?act=list&user_id=' . $user_id, 'text' => $_LANG['account_list']));
    assign_query_info();
    $smarty->display('account_info.dwt');
}

/* ------------------------------------------------------ */
//-- 提交添加、编辑办事处
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update') {
    /* 检查权限 */
    admin_priv('account_manage');

    /* 检查参数 */
    $user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);

    /* 提示信息 */
    $links = array(
        array('href' => 'account_log.php?act=list&user_id=' . $user_id, 'text' => $_LANG['account_list']),
        array('href' => 'account_log.php?act=add&user_id=' . $user_id, 'text' => $_LANG['add_account'])
    );

    /* 防止重复提交 start */
    $sc_rand = isset($_POST['sc_rand']) && !empty($_POST['sc_rand']) ? trim($_POST['sc_rand']) : '';
    $sc_guid = isset($_POST['sc_guid']) && !empty($_POST['sc_guid']) ? trim($_POST['sc_guid']) : '';

    $account_cookie = MD5($sc_guid . "-" . $sc_rand);

    if (!empty($sc_guid) && !empty($sc_rand) && isset($_COOKIE['account_cookie'])) {

        if (!empty($_COOKIE['account_cookie'])) {
            if (!($_COOKIE['account_cookie'] == $account_cookie)) {
                sys_msg($_LANG['repeat_submit'], 0, $links);
            }
        } else {
            sys_msg($_LANG['log_account_change_no'], 0, $links);
        }

        $token = trim($_POST['token']);
        if ($token != $_CFG['token']) {
            sys_msg($_LANG['no_account_change'], 1);
        }

        if ($user_id <= 0) {
            sys_msg('invalid param');
        }
        
        $user = user_info($user_id);
        
        if (empty($user)) {
            sys_msg($_LANG['user_not_exist']);
        }

        /* 提交值 */
        $money_status = intval($_POST['money_status']);
        $add_sub_user_money = floatval($_POST['add_sub_user_money']);  // 值：1（增加） 值：-1（减少）
        $add_sub_frozen_money = floatval($_POST['add_sub_frozen_money']); // 值：1（增加） 值：-1（减少）
        $change_desc = sub_str($_POST['change_desc'], 255, false);
        $user_money = isset($_POST['user_money']) && !empty($_POST['user_money']) ? $add_sub_user_money * abs(floatval($_POST['user_money'])) : 0;
        $frozen_money = isset($_POST['frozen_money']) && !empty($_POST['frozen_money']) ? $add_sub_frozen_money * abs(floatval($_POST['frozen_money'])) : 0;
        $rank_points = floatval($_POST['add_sub_rank_points']) * abs(floatval($_POST['rank_points']));
        $pay_points = floatval($_POST['add_sub_pay_points']) * abs(floatval($_POST['pay_points']));

        if ($user_money == 0 && $frozen_money == 0 && $rank_points == 0 && $pay_points == 0) {
            sys_msg($_LANG['no_account_change']);
        }

        if ($money_status == 1) {
            if ($frozen_money > 0) {
                $user_money = '-' . $frozen_money;
            } else {

                if (!empty($frozen_money) && !(strpos($frozen_money, "-") === false)) {
                    $user_money = substr($frozen_money, 1);
                }
            }
        }
        
        if ($user) {
            $user_money = get_return_money($user_money, $user['user_money']);
            $frozen_money = get_return_money($frozen_money, $user['frozen_money']);
            $rank_points = get_return_money($rank_points, $user['rank_points']);
            $pay_points = get_return_money($pay_points, $user['pay_points']);

            if ($money_status == 1) {
                if ($frozen_money == 0) {
                    $user_money = 0;
                }
            }
        }

        /* 保存 */
        log_account_change($user_id, $user_money, $frozen_money, $rank_points, $pay_points, "【" . $_LANG['terrace_handle'] . "】" . $change_desc, ACT_ADJUSTING);
        
        //防止重复提交
        setcookie('account_cookie', '', gmtime() + 3600 * 24 * 30, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
    }
    /* 防止重复提交 end */

    sys_msg($_LANG['log_account_change_ok'], 0, $links);
}

/**
 * 取得帐户明细
 * @param   int     $user_id    用户id
 * @param   string  $account_type   帐户类型：空表示所有帐户，user_money表示可用资金，
 *                  frozen_money表示冻结资金，rank_points表示等级积分，pay_points表示消费积分
 * @return  array
 */
function get_accountlist($user_id, $account_type = '') {
    /* 检查参数 */
    $where = " WHERE user_id = '$user_id' ";
    if (in_array($account_type, array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
        $where .= " AND $account_type <> 0 ";
    }

    /* 初始化分页参数 */
    $filter = array(
        'user_id' => $user_id,
        'account_type' => $account_type
    );

    /* 查询记录总数，计算分页数 */
    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('account_log') . $where;
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
    $filter = page_and_size($filter);

    /* 查询记录 */
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('account_log') . $where .
            " ORDER BY log_id DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res)) {
        $row['change_time'] = local_date($GLOBALS['_CFG']['time_format'], $row['change_time']);
        $arr[] = $row;
    }

    return array('account' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>