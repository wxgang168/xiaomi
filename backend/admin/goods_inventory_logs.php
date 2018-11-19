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

$step = isset($_REQUEST['step']) ? addslashes($_REQUEST['step']) : '';

/*------------------------------------------------------ */
//-- 获取所有日志列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 权限的判断 */
    admin_priv('order_view');
    
    $storage = '';
    
    if ($step) {
        if ($step == 'put') {
            $storage = "-" . $_LANG['01_goods_storage_put'];
            $smarty->assign('step', 'put');
        } else {
            $storage = "-" . $_LANG['02_goods_storage_out'];
            $smarty->assign('step', 'out');
        }
    }

    $smarty->assign('ur_here', $_LANG['13_goods_inventory_logs'] . $storage);
    $smarty->assign('ip_list',   $ip_list);
    $smarty->assign('full_page', 1);

    $log_list = get_goods_inventory_logs($adminru['ru_id']);
    
    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);
    
    $warehouse_list = get_warehouse_list_goods();  
    $smarty->assign('warehouse_list',			$warehouse_list); //仓库列表

    $sort_flag  = sort_flag($log_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('goods_inventory_logs.dwt');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $log_list = get_goods_inventory_logs($adminru['ru_id']);

    $smarty->assign('log_list',        $log_list['list']);
    $smarty->assign('filter',          $log_list['filter']);
    $smarty->assign('record_count',    $log_list['record_count']);
    $smarty->assign('page_count',      $log_list['page_count']);
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);
    
    $warehouse_list = get_warehouse_list_goods();  
    $smarty->assign('warehouse_list',			$warehouse_list); //仓库列表

    $sort_flag  = sort_flag($log_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('goods_inventory_logs.dwt'), '',
        array('filter' => $log_list['filter'], 'page_count' => $log_list['page_count']));
}

/*------------------------------------------------------ */
//-- 查询仓库地区
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'search_area'){
    check_authz_json('order_view');

    $warehouse_id = intval($_REQUEST['warehouse_id']);
    
    $sql = "SELECT region_id, region_name FROM " .$GLOBALS['ecs']->table('region_warehouse'). " WHERE region_type = 1 AND parent_id = '$warehouse_id'";
    $region_list = $GLOBALS['db']->getAll($sql);
	
    $select .= '<div class="cite">' . $_LANG['please_select'] . '</div><ul>';
    if($region_list){
        foreach($region_list AS $key=>$row){
             $select .= '<li><a href="javascript:;" data-value="' .$row['region_id']. '" class="ftx-01">' .$row['region_name']. '</a></li>';
        }
    }
    $select .= '</ul><input name="area_id" type="hidden" value="" id="area_id_val">';
	
    $result = $select;
    
    make_json_result($result);
}

/*------------------------------------------------------ */
//-- 批量删除日志记录
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_drop')
{
    admin_priv('order_view');

    $drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';

    
    $count = 0;
    foreach ($_POST['checkboxes'] AS $key => $id)
    {
        $sql = "DELETE FROM " .$ecs->table('goods_inventory_logs'). " WHERE id = '$id'";
        $result = $db->query($sql);

        $count++;
    }
    if ($result)
    {
        admin_log('', 'remove', 'goods_inventory_logs');
        
        if($step){
            $step = '&step=' . $step;
        }
        
        $link[] = array('text' => $_LANG['go_back'], 'href' => 'goods_inventory_logs.php?act=list' . $step);
        sys_msg(sprintf($_LANG['batch_drop_success'], $count), 0, $link);
    }
}

/* 获取管理员操作记录 */
function get_goods_inventory_logs($ru_id)
{
    include_once(ROOT_PATH . 'includes/lib_order.php');
    
     /* 过滤条件 */
    $result = get_filter();
    if ($result === false)
    {
        $filter['keyword']          = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        $filter['order_sn']      = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
            $filter['order_sn'] = json_str_iconv($filter['order_sn']);
        }
        
        $filter['start_time']      = empty($_REQUEST['start_time']) ? '' : trim($_REQUEST['start_time']);
        $filter['end_time']      = empty($_REQUEST['end_time']) ? '' : trim($_REQUEST['end_time']);
        $filter['warehouse_id']      = !isset($_REQUEST['warehouse_id']) ? 0 : intval($_REQUEST['warehouse_id']);
        $filter['area_id']      = !isset($_REQUEST['end_time']) ? 0 : intval($_REQUEST['area_id']);
        
        $filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'gil.id' : trim($_REQUEST['sort_by']);
        $filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        
        $filter['step']          = empty($_REQUEST['step']) ? '' : trim($_REQUEST['step']);
        $filter['operation_type'] = !isset($_REQUEST['operation_type']) ? -1 : intval($_REQUEST['operation_type']);
        
        //卖场 start
        $filter['rs_id'] = empty($_REQUEST['rs_id']) ? 0 : intval($_REQUEST['rs_id']);
        $adminru = get_admin_ru_id();
        if($adminru['rs_id'] > 0){
            $filter['rs_id'] = $adminru['rs_id'];
        }
        //卖场 end
        
        //查询条件
        $where = " WHERE 1 ";

        if($ru_id > 0){
            $where .= " AND g.user_id = '$ru_id'";
        }
        
        /* 关键字 */
        if (!empty($filter['keyword']))
        {
            $where .= " AND g.goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
        }
        
        /* 订单号 */
        if (!empty($filter['order_sn']))
        {
            $where .= " AND oi.order_sn = '" .$filter['order_sn']. "'";
        }

        /* 操作时间 */
        if (!empty($filter['start_time']) || !empty($filter['end_time']))
        {
            $start_time = local_strtotime($filter['start_time']);
            $end_time = local_strtotime($filter['end_time']);
            $where .= " AND gil.add_time > '" .$start_time. "' AND gil.add_time < '" .$end_time. "'";
	}
        
        /*仓库*/
        if($filter['warehouse_id'] && empty($filter['area_id'])){
            $where .= " AND (gil.model_inventory = 1 OR gil.model_attr = 1) AND gil.warehouse_id = '" .$filter['warehouse_id']. "'";
        }
        
        
        if($filter['area_id'] && $filter['warehouse_id']){
            $where .= " AND (gil.model_inventory = 2 OR gil.model_attr = 2) AND gil.area_id = '" .$filter['area_id']. "'";
        }
        
        //卖场
        $where .= get_rs_null_where('g.user_id', $filter['rs_id']);
        
        //管理员查询的权限 -- 店铺查询 start
        $filter['store_search'] = empty($_REQUEST['store_search']) ? 0 : intval($_REQUEST['store_search']);
        $filter['merchant_id'] = isset($_REQUEST['merchant_id']) ? intval($_REQUEST['merchant_id']) : 0;
        $filter['store_keyword'] = isset($_REQUEST['store_keyword']) ? trim($_REQUEST['store_keyword']) : '';
        
        $store_where = '';
        $store_search_where = '';
        if($filter['store_search'] !=0){
            if($ru_id == 0){ 
                if($filter['store_search'] > 0){
                   if($_REQUEST['store_type']){
                        $store_search_where = "AND msi.shopNameSuffix = '" .$_REQUEST['store_type']. "'";
                    }

                    if($filter['store_search'] == 1){
                        $where .= " AND g.user_id = '" .$filter['merchant_id']. "' ";
                    }elseif($filter['store_search'] == 2){
                        $store_where .= " AND msi.rz_shopName LIKE '%" . mysql_like_quote($filter['store_keyword']) . "%'";
                    }elseif($filter['store_search'] == 3){
                        $store_where .= " AND msi.shoprz_brandName LIKE '%" . mysql_like_quote($filter['store_keyword']) . "%' " . $store_search_where;
                    }

                    if($filter['store_search'] > 1){
                        $where .= " AND (SELECT msi.user_id FROM " . $GLOBALS['ecs']->table('merchants_shop_information') .' as msi ' .  
                                  " WHERE msi.user_id = g.user_id $store_where) > 0 ";
                    }
                }else{
                   $where .= " AND g.user_id = '" .$filter['store_search']. "' ";
                }
            }
        }
        //管理员查询的权限 -- 店铺查询 end

        if ($filter['operation_type'] == -1) {
            //出库
            if ($filter['step'] == 'out') {
                $where .= " AND use_storage IN(0,1,4,8,10)";
            }

            //入库
            if ($filter['step'] == 'put') {
                $where .= " AND use_storage IN(2,3,5,6,7,9,11,13)";
            }
        } else {
            $where .= " AND use_storage = '" . $filter['operation_type'] . "'";
        }

        /* 获得总记录数据 */
        $sql = 'SELECT COUNT(*) FROM ' .$GLOBALS['ecs']->table('goods_inventory_logs') ." as gil " .
                " LEFT JOIN " .$GLOBALS['ecs']->table('goods') ." as g ON gil.goods_id = g.goods_id". 
                " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') ." as oi ON gil.order_id = oi.order_id ".
                $where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 获取管理员日志记录 */
        $list = array();
        $sql  = 'SELECT gil.*, g.user_id,g.goods_id,g.goods_thumb,g.brand_id, g.goods_name, oi.order_sn, au.user_name AS admin_name, og.goods_attr FROM ' .$GLOBALS['ecs']->table('goods_inventory_logs') . " as gil ". 
                " LEFT JOIN " . $GLOBALS['ecs']->table('goods') ." as g ON gil.goods_id = g.goods_id".
                " LEFT JOIN " . $GLOBALS['ecs']->table('order_info') ." as oi ON gil.order_id = oi.order_id ".
                " LEFT JOIN " . $GLOBALS['ecs']->table('order_goods') ." as og ON gil.goods_id = og.goods_id AND gil.order_id = og.order_id ".
                " LEFT JOIN " . $GLOBALS['ecs']->table('admin_user') ." as au ON gil.admin_id = au.user_id ".
                $where . ' GROUP BY gil.id ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];
        $res  = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql, $param_str);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }    
    
    //当前域名协议
    $http = $GLOBALS['ecs']->http();

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
        $rows['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $rows['add_time']);
        $rows['shop_name'] = get_shop_name($rows['user_id'], 1);
        $rows['warehouse_name'] = get_inventory_region($rows['warehouse_id']);
        $rows['area_name'] = get_inventory_region($rows['area_id']);
        if(empty($rows['admin_name'])){
            $rows['admin_name'] = '前台会员下单';
        }
        if($rows['brand_id'] > 0){
            $rows['brand_name'] =$GLOBALS['db']->getOne( "SELECT brand_name  FROM".$GLOBALS['ecs']->table("brand")." WHERE brand_id = '".$rows['brand_id']."'");
        }
        if($rows['product_id']){
            if($rows['model_attr'] == 1){
                $table = "products_warehouse";
            }elseif($rows['model_attr'] == 2){
                $table = "products_area";
            }else{
                $table = "products";
            }
            
            $sql = "SELECT goods_attr FROM " .$GLOBALS['ecs']->table($table). " WHERE product_id = '" .$rows['product_id']. "' LIMIT 1";
            $spec = $GLOBALS['db']->getRow($sql);
            $spec['goods_attr'] = explode("|", $spec['goods_attr']);
            
            $rows['goods_attr'] = get_goods_attr_info($spec['goods_attr'], 'pice', $rows['warehouse_id'], $rows['area_id']); //ecmoban模板堂 --zhuo
        }
        
        //图片显示
        $rows['goods_thumb'] = get_image_path($rows['goods_id'], $rows['goods_thumb'], true);

        $list[] = $rows;
    }
    return array('list' => $list, 'filter' => $filter, 'page_count' =>  $filter['page_count'], 'record_count' => $filter['record_count']);
}

function get_inventory_region($region_id){
    $sql = "SELECT region_name FROM " .$GLOBALS['ecs']->table('region_warehouse'). " WHERE region_id = '$region_id'";
    return $GLOBALS['db']->getOne($sql);
}
?>