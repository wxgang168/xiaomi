<?php

/**
 * ECSHOP 管理中心批发管理
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: wholesale.php 17217 2018-07-19 06:29:08Z liubo $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
include_once('../includes/lib_goods.php');
include_once('includes/lib_goods.php');
include_once(ROOT_PATH . 'includes/cls_json.php');
include_once('../includes/lib_wholesale.php');
include_once(ROOT_PATH . '/includes/lib_visual.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$smarty->assign('menus',$_SESSION['menus']);
$smarty->assign('action_type',"bonus");

//ecmoban模板堂 --zhuo start
$adminru = get_admin_ru_id();
if($adminru['ru_id'] == 0){
    $smarty->assign('priv_ru',   1);
}else{
    $smarty->assign('priv_ru',   0);
} 	
//ecmoban模板堂 --zhuo end
$admin_id = get_admin_id();
$smarty->assign('controller', basename(PHP_SELF,'.php'));
/*------------------------------------------------------ */
//-- 活动列表页
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    admin_priv('whole_sale');

    /* 模板赋值 */
    $smarty->assign('full_page',   1);
    $smarty->assign('primary_cat',     $_LANG['supply_and_demand']);
    $smarty->assign('ur_here',     $_LANG['wholesale_list']);
    $smarty->assign('action_link', array('href' => 'wholesale.php?act=add', 'text' => $_LANG['add_wholesale'], 'class' => 'icon-plus'));

    $list = seller_wholesale_list($adminru['ru_id']);
	
	//分页
	$page_count_arr = seller_page($list,$_REQUEST['page']);
    $smarty->assign('page_count_arr',$page_count_arr);	

    $smarty->assign('wholesale_list',  $list['item']);
    $smarty->assign('filter',          $list['filter']);
    $smarty->assign('record_count',    $list['record_count']);
    $smarty->assign('page_count',      $list['page_count']);
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* 显示商品列表页面 */
    assign_query_info();
    $smarty->display('wholesale_list.dwt');
}

/*------------------------------------------------------ */
//-- 分页、排序、查询
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query')
{
    $list = seller_wholesale_list($adminru['ru_id']);
	
	//分页
	$page_count_arr = seller_page($list,$_REQUEST['page']);
    $smarty->assign('page_count_arr',$page_count_arr);	

    $smarty->assign('wholesale_list',  $list['item']);
    $smarty->assign('filter',          $list['filter']);
    $smarty->assign('record_count',    $list['record_count']);
    $smarty->assign('page_count',      $list['page_count']);
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);

    $sort_flag  = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('wholesale_list.dwt'), '',
        array('filter' => $list['filter'], 'page_count' => $list['page_count']));
}

/*------------------------------------------------------ */
//-- 删除
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('whole_sale');

    $id = intval($_GET['id']);
    $wholesale = wholesale_info($id);
    
    if ($wholesale['user_id'] != $adminru['ru_id']) {
        $url = 'wholesale.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
        ecs_header("Location: $url\n");
        exit;
    }

    if (empty($wholesale))
    {
        make_json_error($_LANG['wholesale_not_exist']);
    }
    $name = $wholesale['goods_name'];

    /* 删除记录 */
    $sql = "DELETE FROM " . $ecs->table('wholesale') .
            " WHERE act_id = '$id' LIMIT 1";
    $db->query($sql);

    /* 记日志 */
    admin_log($name, 'remove', 'wholesale');

    /* 清除缓存 */
    clear_cache_files();

    $url = 'wholesale.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch')
{
    /* 取得要操作的记录编号 */
    if (empty($_POST['checkboxes']))
    {
        sys_msg($_LANG['no_record_selected']);
    }
    else
    {
        /* 检查权限 */
        admin_priv('whole_sale');

        $ids = $_POST['checkboxes'];

        if (isset($_POST['drop']))
        {
            /* 删除记录 */
            $sql = "DELETE FROM " . $ecs->table('wholesale') .
                    " WHERE act_id " . db_create_in($ids);
            $db->query($sql);

            /* 记日志 */
            admin_log('', 'batch_remove', 'wholesale');

            /* 清除缓存 */
            clear_cache_files();

            $links[] = array('text' => $_LANG['back_wholesale_list'], 'href' => 'wholesale.php?act=list&' . list_link_postfix());
            sys_msg($_LANG['batch_drop_ok'], 0, $links);
        }
    }
}

/*------------------------------------------------------ */
//-- 修改排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'toggle_enabled')
{
    check_authz_json('whole_sale');

    $id  = intval($_POST['id']);
    $val = intval($_POST['val']);

    $sql = "UPDATE " . $ecs->table('wholesale') .
            " SET enabled = '$val'" .
            " WHERE act_id = '$id' LIMIT 1";
    $db->query($sql);

    make_json_result($val);
}

/*------------------------------------------------------ */
//-- 添加、编辑
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit')
{
    /* 检查权限 */
    admin_priv('whole_sale');
    $smarty->assign('primary_cat',     $_LANG['supply_and_demand']);
    $smarty->assign('menu_select', array('action' => 'supply_and_demand', 'current' => '01_wholesale'));

    /* 是否添加 */
    $is_add = $_REQUEST['act'] == 'add';
    $smarty->assign('form_action', $is_add ? 'insert' : 'update');

    /* 初始化、取得批发活动信息 */
    if ($is_add) {
        $wholesale = array(
            'act_id' => 0,
            'goods_id' => 0,
            'goods_name' => $_LANG['pls_search_goods'],
            'enabled' => '1',
            'price_list' => array(),
            'shipping_fee' => '0.00',
            'goods_extend' => array('is_delivery' => 0, 'is_return' => 0, 'is_free' => 0),
            'start_time' => strtotime("1 day"),
            'end_time' => strtotime("3 day")
        );
    }
	else 
	{	
        if (empty($_GET['id'])) {
            sys_msg('invalid param');
        }
        $id = intval($_GET['id']);
        $wholesale = wholesale_info($id);
        if (empty($wholesale)) {
            sys_msg($_LANG['wholesale_not_exist']);
        }
       
        if ($wholesale['user_id'] != $adminru['ru_id']) {
            $Loaction = "wholesale.php?act=list";
            ecs_header("Location: $Loaction\n");
            exit;
        }		
    }
/* 取得用户等级 */
    $user_rank_list = array();
    $sql = "SELECT rank_id, rank_name FROM " . $ecs->table('user_rank') .
            " ORDER BY special_rank, min_points";
    $res = $db->query($sql);
    while ($rank = $db->fetchRow($res)) {
        if (!empty($wholesale['rank_ids']) && strpos($wholesale['rank_ids'], $rank['rank_id']) !== false) {
            $rank['checked'] = 1;
        }
        $user_rank_list[] = $rank;
    }
    $smarty->assign('user_rank_list', $user_rank_list);
    /* 如果不是限时批发，处理限时批发日期 */
	if (isset($wholesale['is_promote']) && $wholesale['is_promote'] == '0') {
		unset($wholesale['start_time']);
		unset($wholesale['end_time']);
	} else {
		$wholesale['start_time'] = local_date($GLOBALS['_CFG']['time_format'], $wholesale['start_time']);
		$wholesale['end_time'] = local_date($GLOBALS['_CFG']['time_format'], $wholesale['end_time']);
	}

	$wholesale['goods_extend'] = get_wholesale_extend($wholesale['goods_id']);
	$smarty->assign('wholesale', $wholesale);

    $cat_select = wholesale_cat_list(0, $cat_info['parent_id'], false, 0, true, '', 1);

    /* 简单处理缩进 */
    foreach ($cat_select as $k => $v) {
        if ($v['level']) {
            $level = str_repeat('&nbsp;', $v['level'] * 4);
            $cat_select[$k]['name'] = $level . $v['name'];
        }
    }

    $smarty->assign('cat_select', $cat_select);	

    set_default_filter(0, 0, $adminru['ru_id']); //by wu
    $smarty->assign('filter_brand_list', search_brand_list());

    /* 显示模板 */
    if ($is_add) {
        $smarty->assign('ur_here', $_LANG['add_wholesale']);
    } else {
        $smarty->assign('ur_here', $_LANG['edit_wholesale']);
    }
    $href = 'wholesale.php?act=list';
    if (!$is_add) {
        $href .= '&' . list_link_postfix();
    }

	//商品属性类型
    $smarty->assign('goods_type_list', goods_type_list($goods_type, $wholesale['goods_id'], 'array'));
    $smarty->assign('goods_type_name', $GLOBALS['db']->getOne(" SELECT cat_name FROM " . $GLOBALS['ecs']->table('goods_type') . " WHERE cat_id = '$goods_type' "));	

	//阶梯设置
	$volume_price_list = get_wholesale_volume_price_list($wholesale['goods_id']);
    $smarty->assign('volume_price_list', $volume_price_list);
	
    $smarty->assign('action_link', array('href' => $href, 'text' => $_LANG['wholesale_list'], 'class' => 'icon-reply'));
    $smarty->assign('ru_id', $adminru['ru_id']);

    assign_query_info();
    $smarty->display('wholesale_info.dwt');
}

/*------------------------------------------------------ */
//-- 添加、编辑后提交
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update')
{
    /* 检查权限 */
    admin_priv('whole_sale');

    //运费获取运费参数
    $freight = !empty($_REQUEST['freight'])  ?  intval($_REQUEST['freight']) : 0;
    $shipping_fee = !empty($_REQUEST['shipping_fee'])  ?  intval($_REQUEST['shipping_fee']) : 0.00;
    $is_recommend = !empty($_REQUEST['is_recommend'])  ?  intval($_REQUEST['is_recommend']) : 0;
    $tid = !empty($_REQUEST['tid'])  ?  intval($_REQUEST['tid']) : 0;
    
    /*是否为限时批发*/
    if (!isset($_POST['is_promote'])) {
        $is_promote = 0;
    } else {
        $is_promote = $_POST['is_promote'];
    }
    
    /*获取限时批发时间*/
    $promote_start_date = ($is_promote && !empty($_POST['promote_start_date'])) ? local_strtotime($_POST['promote_start_date']) : 0;
    $promote_end_date = ($is_promote && !empty($_POST['promote_end_date'])) ? local_strtotime($_POST['promote_end_date']) : 0;	
	
    /* 是否添加 */
    $is_add = $_REQUEST['act'] == 'insert';

    /* 取得goods */
    $goods_id = intval($_POST['goods_id']);
    if ($goods_id <= 0)
    {
        sys_msg($_LANG['pls_search_goods']);
    }

    /* 同一个商品，会员等级不能重叠 */
    if (isset($_POST['rank_id']))
    {
        foreach ($_POST['rank_id'] as $rank_id)
        {
            $sql = "SELECT COUNT(*) FROM " . $ecs->table('wholesale') .
                    " WHERE goods_id = '$goods_id' " .
                    " AND CONCAT(',', rank_ids, ',') LIKE CONCAT('%,', '$rank_id', ',%')";
            if (!$is_add)
            {
                $sql .= " AND act_id <> '$_POST[act_id]'";
            }
            if ($db->getOne($sql) > 0)
            {
                sys_msg($_LANG['user_rank_exist']);
            }
        }
    }
    /* 取得cat_id */
    $cat_id = intval($_POST['cat_id']);
    if ($cat_id <= 0)
    {
        sys_msg($_LANG['pls_choice_cat']);
    }	
	
    $sql = "SELECT goods_name FROM " . $ecs->table('goods') .
            " WHERE goods_id = '$goods_id'";
    $goods_name = $db->getOne($sql);
    $goods_name = addslashes($goods_name);
    if (is_null($goods_name))
    {
        sys_msg('invalid goods id: ' . $goods_id);
    }

	if ($goods_id) {
        //商品扩展信息
        $is_delivery = !empty($_POST['is_delivery']) ? intval($_POST['is_delivery']) : 0;
        $is_return = !empty($_POST['is_return']) ? intval($_POST['is_return']) : 0;
        $is_free = !empty($_POST['is_free']) ? intval($_POST['is_free']) : 0;
        $extend = $db->getOne("select count(goods_id) from " . $ecs->table('wholesale_extend') . " where goods_id='$goods_id'");
        if ($extend > 0) {
            //跟新商品扩展信息
            $extend_sql = "update " . $ecs->table('wholesale_extend') . " SET `is_delivery`='$is_delivery',`is_return`='$is_return',`is_free`='$is_free' WHERE goods_id='$goods_id'";
        } else {
            //插入商品扩展信息
            $extend_sql = "INSERT INTO " . $ecs->table('wholesale_extend') . "(`goods_id`, `is_delivery`, `is_return`, `is_free`) VALUES ('$goods_id','$is_delivery','$is_return','$is_free')";
        }
        $db->query($extend_sql);
        
        get_updel_goods_attr($goods_id);
    }

    /* 处理优惠价格 */
    if (intval($_POST['price_model']) && isset($_POST['volume_number']) && isset($_POST['volume_price']))
    {
        handle_wholesale_volume_price($goods_id, intval($_POST['price_model']), $_POST['volume_number'], $_POST['volume_price'], $_POST['id']);
    }	

    /* 提交值 */
    $wholesale = array(
        'act_id'        	=> intval($_POST['act_id']),
        'goods_id'      	=> $goods_id,
        'wholesale_cat_id'	=> $cat_id,
        'goods_name'    	=> $goods_name,
        'rank_ids'      	=> isset($_POST['rank_id']) ? join(',', $_POST['rank_id']) : '',
        'review_status' 	=> 1,
        'is_recommend'    	=> $is_recommend,
        'is_promote'        => $is_promote,
        'freight'           => $freight,//运费模式
        'shipping_fee'      => $shipping_fee,//固定运费
        'tid'               => $tid,//运费模板id
        'enabled'           => empty($_POST['enabled']) ? 0 : 1,
        'price_model'       => intval($_POST['price_model']),
        'goods_type'        => intval($_POST['goods_type']),
        'goods_price'       => floatval($_POST['goods_price']),
        'moq'               => intval($_POST['moq']),
        'goods_number'      => intval($_POST['goods_number']),
        'start_time'        => $promote_start_date,
        'end_time'          => $promote_end_date
    );

    /* 保存数据 */
    if ($is_add)
    {
        $wholesale['user_id'] = $adminru['ru_id'];
        $db->autoExecute($ecs->table('wholesale'), $wholesale, 'INSERT');
        $wholesale['act_id'] = $db->insert_id();
    }
    else
    {
        if (isset($_POST['review_status'])) {
            $review_status = !empty($_POST['review_status']) ? intval($_POST['review_status']) : 1;
            $review_content = !empty($_POST['review_content']) ? addslashes(trim($_POST['review_content'])) : '';

            $wholesale['review_status'] = $review_status;
            $wholesale['review_content'] = $review_content;
        }
        
        $db->autoExecute($ecs->table('wholesale'), $wholesale, 'UPDATE', "act_id = '$wholesale[act_id]'");
    }
	
    /** ************* 处理货品数据 start ************** */
    $where_products = "";
    $goods_model = isset($_POST['goods_model']) && !empty($_POST['goods_model']) ? intval($_POST['goods_model']) : 0;
    $warehouse = isset($_POST['warehouse']) && !empty($_POST['warehouse']) ? intval($_POST['warehouse']) : 0;
    $region = isset($_POST['region']) && !empty($_POST['region']) ? intval($_POST['region']) : 0;
    $arrt_page_count = isset($_POST['arrt_page_count']) && !empty($_POST['arrt_page_count']) ? intval($_POST['arrt_page_count']) : 1; //属性分页
    
    
    /* 处理属性 */
    if ((isset($_POST['attr_id_list']) && isset($_POST['attr_value_list'])) || (empty($_POST['attr_id_list']) && empty($_POST['attr_value_list'])))
    {
        // 取得原有的属性值
        $goods_attr_list = array();

        $sql = "SELECT attr_id, attr_index FROM " . $ecs->table('attribute') . " WHERE cat_id = '$goods_type'";
        $attr_res = $db->query($sql);

        $attr_list = array();
        while ($row = $db->fetchRow($attr_res))
        {
            $attr_list[$row['attr_id']] = $row['attr_index'];
        }

        $sql = "SELECT ga.*, a.attr_type
                FROM " . $ecs->table('wholesale_goods_attr') . " AS ga
                    LEFT JOIN " . $ecs->table('attribute') . " AS a
                        ON a.attr_id = ga.attr_id
                WHERE ga.goods_id = '$goods_id'";

        $res = $db->query($sql);

        while ($row = $db->fetchRow($res))
        {
            $goods_attr_list[$row['attr_id']][$row['attr_value']] = array('sign' => 'delete', 'goods_attr_id' => $row['goods_attr_id']);
        }
        
        // 循环现有的，根据原有的做相应处理
        if (isset($_POST['attr_id_list'])) {
            foreach ($_POST['attr_id_list'] AS $key => $attr_id) {
                $attr_value = $_POST['attr_value_list'][$key];
                $attr_sort = $_POST['attr_sort_list'][$key]; //ecmoban模板堂 --zhuo
                if (!empty($attr_value)) {
                    if (isset($goods_attr_list[$attr_id][$attr_value])) {
                        // 如果原来有，标记为更新
                        $goods_attr_list[$attr_id][$attr_value]['sign'] = 'update';
                        $goods_attr_list[$attr_id][$attr_value]['attr_sort'] = $attr_sort; 
                    } else {
                        // 如果原来没有，标记为新增
                        $goods_attr_list[$attr_id][$attr_value]['sign'] = 'insert';
                        $goods_attr_list[$attr_id][$attr_value]['attr_sort'] = $attr_sort; 
                    }
                }
            }
        }
        
        // 循环现有的，根据原有的做相应处理
        if (isset($_POST['gallery_attr_id'])) {
            foreach ($_POST['gallery_attr_id'] AS $key => $attr_id) {
                $gallery_attr_value = $_POST['gallery_attr_value'][$key];
                $gallery_attr_sort = $_POST['gallery_attr_sort'][$key];
                if (!empty($gallery_attr_value)) {
                    if (isset($goods_attr_list[$attr_id][$gallery_attr_value])) {
                        // 如果原来有，标记为更新
                        $goods_attr_list[$attr_id][$gallery_attr_value]['sign'] = 'update';
                        $goods_attr_list[$attr_id][$gallery_attr_value]['attr_sort'] = $gallery_attr_sort;
                    } else {
                        // 如果原来没有，标记为新增
                        $goods_attr_list[$attr_id][$gallery_attr_value]['sign'] = 'insert';
                        $goods_attr_list[$attr_id][$gallery_attr_value]['attr_sort'] = $gallery_attr_sort; 
                    }
                }
            }
        }
        	
        /* 插入、更新、删除数据 */
        foreach ($goods_attr_list as $attr_id => $attr_value_list)
        {
            foreach ($attr_value_list as $attr_value => $info)
            {
                if ($info['sign'] == 'insert')
                {
                    $sql = "INSERT INTO " .$ecs->table('wholesale_goods_attr'). " (attr_id, goods_id, attr_value, attr_sort)".
                            "VALUES ('$attr_id', '$goods_id', '$attr_value', '$info[attr_sort]')";
                }
                elseif ($info['sign'] == 'update')
                {
                    $sql = "UPDATE " .$ecs->table('wholesale_goods_attr'). " SET attr_sort = '$info[attr_sort]' WHERE goods_attr_id = '$info[goods_attr_id]' LIMIT 1";
                }
                else
                {
                    if($model_attr == 1){
                        $table = 'products_warehouse';
                    }elseif($model_attr == 2){
                        $table = 'products_area';
                    }else{
                        $table = 'products';
                    }

                    $where = " AND goods_id = '$goods_id'";
                    $ecs->get_del_find_in_set($info['goods_attr_id'], $where, $table, 'goods_attr', '|');
    
                    $sql = "DELETE FROM " .$ecs->table('wholesale_goods_attr'). " WHERE goods_attr_id = '" .$info['goods_attr_id']. "' LIMIT 1";
                }
                $db->query($sql);
            }
        }
    }
    
    
    
    if ($goods_model == 1) {
        //数据表
        $table = "products_warehouse";
        //地区id
        $region_id = $warehouse;
        //插入补充数据
        $products_extension_insert_name = " , warehouse_id ";
        $products_extension_insert_value = " , '$warehouse' ";
        //补充筛选
        $where_products .= " AND warehouse_id = '$warehouse' ";
    } elseif ($goods_model == 2) {
        $table = "products_area";
        $region_id = $region;
        $products_extension_insert_name = " , area_id ";
        $products_extension_insert_value = " , '$region' ";
        $where_products .= " AND area_id = '$region' ";
    } else {
        $table = "wholesale_products";
        $products_extension_insert_name = "";
        $products_extension_insert_value = "";
    }
    
	
	
	
    if ($is_insert) {
        $sql = "UPDATE" . $ecs->table($table) . " SET goods_id = '$goods_id' WHERE goods_id = 0 AND admin_id = '$admin_id'";
        $db->query($sql);
    }
    
    //if($arrt_page_count == 1){
        $product['goods_id'] = $goods_id;
        $product['attr'] = isset($_POST['attr']) ? $_POST['attr'] : array();
        $product['product_id'] = isset($_POST['product_id']) ? $_POST['product_id'] : array();
        $product['product_sn'] = isset($_POST['product_sn']) ? $_POST['product_sn'] : array();
        $product['product_number'] = isset($_POST['product_number']) ? $_POST['product_number'] : array();
        $product['product_price'] = isset($_POST['product_price']) ? $_POST['product_price'] : array(); //货品价格
        $product['product_market_price'] = isset($_POST['product_market_price']) ? $_POST['product_market_price'] : array(); //货品市场价格
        $product['product_warn_number'] = isset($_POST['product_warn_number']) ? $_POST['product_warn_number'] : array(); //警告库存
        $product['bar_code'] = isset($_POST['product_bar_code']) ? $_POST['product_bar_code'] : array(); //货品条形码

        /* 是否存在商品id */
        if (empty($product['goods_id']))
        {
            sys_msg($_LANG['sys']['wrong'] . $_LANG['cannot_found_goods'], 1, array(), false);
        }

        /* 取出商品信息 */
        $sql = "SELECT goods_sn, goods_name, goods_type, shop_price, model_inventory, model_attr FROM " . $ecs->table('goods') . " WHERE goods_id = '$goods_id' LIMIT 1";
        $goods = $db->getRow($sql);

        /* 货号 */
        if(empty($product['product_sn']))
        {
            $product['product_sn'] = array();
        }

        foreach($product['product_sn'] as $key => $value)
        {
            //过滤
            $product['product_number'][$key] = trim($product['product_number'][$key]); //库存
            $product['product_id'][$key] = isset($product['product_id'][$key]) && !empty($product['product_id'][$key]) ? intval($product['product_id'][$key]) : 0; //货品ID

            $logs_other = array(
                'goods_id' => $goods_id,
                'order_id' => 0,
                'admin_id' => $_SESSION['admin_id'],
                'model_inventory' => $goods['model_inventory'],
                'model_attr' => $goods['model_attr'],
                'add_time' => gmtime()
            );

            if ($goods_model == 1) {
                $logs_other['warehouse_id'] = $warehouse;
                $logs_other['area_id'] = 0;
            } elseif ($goods_model == 2) {
                $logs_other['warehouse_id'] = 0;
                $logs_other['area_id'] = $region;
            } else {
                $logs_other['warehouse_id'] = 0;
                $logs_other['area_id'] = 0;
            }

            if($product['product_id'][$key]){

                /* 货品库存 */
                $goods_product = get_wholesale_product_info($product['product_id'][$key], 'product_number', $goods_model);

                if ($goods_product['product_number'] != $product['product_number'][$key]) {
                    if ($goods_product['product_number'] > $product['product_number'][$key]) {
                        $number = $goods_product['product_number'] - $product['product_number'][$key];
                        $number = "- " . $number;
                        $logs_other['use_storage'] = 10;
                    } else {
                        $number = $product['product_number'][$key] - $goods_product['product_number'];
                        $number = "+ " . $number;
                        $logs_other['use_storage'] = 11;
                    }

                    $logs_other['number'] = $number;
                    $logs_other['product_id'] = $product['product_id'][$key];
                    $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
                }

                $sql = "UPDATE " . $GLOBALS['ecs']->table($table) . " SET product_number = '" . $product['product_number'][$key] . "'" .
                        " WHERE product_id = '" . $product['product_id'][$key] . "'";
                $GLOBALS['db']->query($sql);

            }else{
                $number = 0;
                //获取规格在商品属性表中的id
                foreach($product['attr'] as $attr_key => $attr_value)
                {
                    /* 检测：如果当前所添加的货品规格存在空值或0 */
                    if (empty($attr_value[$key]))
                    {
                        continue 2;
                    }

                    $is_spec_list[$attr_key] = 'true';

                    $value_price_list[$attr_key] = $attr_value[$key] . chr(9) . ''; //$key，当前

                    $id_list[$attr_key] = $attr_key;
                }
                $goods_attr_id = handle_wholesale_goods_attr($product['goods_id'], $id_list, $is_spec_list, $value_price_list);

                /* 是否为重复规格的货品 */
                $goods_attr = sort_wholesale_goods_attr_id_array($goods_attr_id);

                if (!empty($goods_attr['sort'])) {
                    $goods_attr = implode('|', $goods_attr['sort']);
                }else{
                    $goods_attr = "";
                }

                if (check_wholesale_goods_attr_exist($goods_attr, $product['goods_id'], 0, $region_id)) //by wu
                {	
                    continue;
                }

                /* 插入货品表 */
                $sql = "INSERT INTO " . $GLOBALS['ecs']->table($table) .
                                " (goods_id, goods_attr, product_sn, product_number ".$products_extension_insert_name.") VALUES ".
								" ('" . $product['goods_id'] . "', '$goods_attr', '$value', '" . $product['product_number'][$key] ."'".$products_extension_insert_value.")";
                if (!$GLOBALS['db']->query($sql))
                {
                    continue;
                }else{
                    $product_id = $GLOBALS['db']->insert_id();

                    //货品号为空 自动补货品号
                    if (empty($value))
                    {
                        $sql = "UPDATE " . $GLOBALS['ecs']->table($table) . "
                                SET product_sn = '" . $goods['goods_sn'] . "g_p" . $GLOBALS['db']->insert_id() . "'
                                WHERE product_id = '$product_id'";
                        $GLOBALS['db']->query($sql);
                    }

                    //库存日志
                    $number = "+ " . $product['product_number'][$key];
                    $logs_other['use_storage'] = 9;
                    $logs_other['product_id'] = $product_id;
                    $logs_other['number'] = $number;
                    $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
                }
            }  
        }
    //}    
    /*************** 处理货品数据 end ***************/	

    /* 记日志 */
    if ($is_add)
    {
        admin_log($wholesale['goods_name'], 'add', 'wholesale');
    }
    else
    {
        admin_log($wholesale['goods_name'], 'edit', 'wholesale');
    }

    /* 清除缓存 */
    clear_cache_files();

    /* 提示信息 */
    if ($attr_error)
    {
        $links = array(
            array('href' => 'wholesale.php?act=list', 'text' => $_LANG['back_wholesale_list'])
        );
        sys_msg(sprintf($_LANG['save_wholesale_falid'], $wholesale['goods_name']), 1, $links);
    }

    if ($is_add)
    {
        $links = array(
            array('href' => 'wholesale.php?act=add', 'text' => $_LANG['continue_add_wholesale']),
            array('href' => 'wholesale.php?act=list', 'text' => $_LANG['back_wholesale_list'])
        );
        sys_msg($_LANG['add_wholesale_ok'], 0, $links);
    }
    else
    {
        $links = array(
            array('href' => 'wholesale.php?act=list&' . list_link_postfix(), 'text' => $_LANG['back_wholesale_list'])
        );
        sys_msg($_LANG['edit_wholesale_ok'], 0, $links);
    }
}

/*------------------------------------------------------ */
//-- 搜索商品
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'search_goods')
{
    check_authz_json('whole_sale');

    include_once(ROOT_PATH . 'includes/cls_json.php');

    $json   = new JSON;
    $filter = $json->decode($_GET['JSON']);
    $arr    = get_goods_list($filter);
    if (empty($arr))
    {
        $arr[0] = array(
            'goods_id'   => 0,
            'goods_name' => $_LANG['search_result_empty']
        );
    }

    make_json_result($arr);
}

/*------------------------------------------------------ */
//-- 取得商品信息
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'get_goods_info')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();

    $goods_id = intval($_REQUEST['goods_id']);
    $goods_attr_list = array_values(get_goods_attr($goods_id));

    // 将数组中的 goods_attr_list 元素下的元素的数字下标转换成字符串下标
    if (!empty($goods_attr_list))
    {
        foreach ($goods_attr_list as $goods_attr_key => $goods_attr_value)
        {
            if (isset($goods_attr_value['goods_attr_list']) && !empty($goods_attr_value['goods_attr_list']))
            {
                foreach ($goods_attr_value['goods_attr_list'] as $key => $value)
                {
                    $goods_attr_list[$goods_attr_key]['goods_attr_list']['c' . $key] = $value;
                    unset($goods_attr_list[$goods_attr_key]['goods_attr_list'][$key]);
                }
            }
        }
    }

    echo $json->encode($goods_attr_list);
}

/*--------------------------------------------------------*/
// 切换商品类型
/*--------------------------------------------------------*/
 elseif ($_REQUEST['act'] == 'get_attribute') {
    check_authz_json('goods_manage');

    $goods_id = empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']);
    $goods_type = empty($_REQUEST['goods_type']) ? 0 : intval($_REQUEST['goods_type']);
    $model = !isset($_REQUEST['modelAttr']) ? -1 : intval($_REQUEST['modelAttr']);
    $result = array('error' => 0, 'message' => '', 'content' => '');
	
    $attribute = set_wholesale_goods_attribute($goods_type, $goods_id, $model, 'wholesale_goods_attr');
    $result['goods_attribute'] = $attribute['goods_attribute'];
    $result['goods_attr_gallery'] = $attribute['goods_attr_gallery'];
    $result['model'] = $model;
    $result['goods_id'] = $goods_id;
    $result['is_spec'] = $attribute['is_spec'];

    die(json_encode($result));
}
/*------------------------------------------------------ */
//-- 删除属性
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'drop_product')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;
    
    check_authz_json('goods_manage');
    $group_attr = empty($_REQUEST['group_attr']) ? '' : $_REQUEST['group_attr'];
    $group_attr = $json->decode($group_attr, true);
    $product_id = empty($_REQUEST['product_id']) ? 0 : intval($_REQUEST['product_id']);
    
    //地区模式
    if($group_attr['goods_model'] == 1){
        $table = 'products_warehouse';
    }elseif($group_attr['goods_model'] == 2){
        $table = 'products_area';
    }else{
        $table = 'wholesale_products';
    }
    
    
    /* 删除数据 */
    $sql = "DELETE FROM " . $GLOBALS['ecs']->table($table) . " WHERE product_id = '$product_id' LIMIT 1";
    $GLOBALS['db']->query($sql);
    
    clear_cache_files();
    make_json_result_too($product_id, 0, '', $group_attr);
}

/*--------------------------------------------------------*/
// 设置属性表格
/*--------------------------------------------------------*/
elseif ($_REQUEST['act'] == 'set_attribute_table' || $_REQUEST['act'] == 'wholesale_attribute_query') {
    check_authz_json('goods_manage');

    $goods_id = empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']);
    $goods_type = empty($_REQUEST['goods_type']) ? 0 : intval($_REQUEST['goods_type']);
    $attr_id_arr = empty($_REQUEST['attr_id']) ? array() : explode(',', $_REQUEST['attr_id']);
    $attr_value_arr = empty($_REQUEST['attr_value']) ? array() : explode(',', $_REQUEST['attr_value']);
    $goods_model = empty($_REQUEST['goods_model']) ? 0 : intval($_REQUEST['goods_model']); //商品模式
    $region_id = empty($_REQUEST['region_id']) ? 0 : intval($_REQUEST['region_id']); //地区id
    $search_attr = !empty($_REQUEST['search_attr']) ? trim($_REQUEST['search_attr']) : '';
    $result = array('error' => 0, 'message' => '', 'content' => '');
    
    /* ajax分页 start */
    $filter['goods_id']     = $goods_id;
    $filter['goods_type']   = $goods_type;
    $filter['attr_id']      = $_REQUEST['attr_id'];
    $filter['attr_value']   = $_REQUEST['attr_value'];
    $filter['goods_model']  = $goods_model;
    $filter['region_id']    = $region_id;
    $filter['search_attr']    = $search_attr;
    /* ajax分页 end */
if($search_attr){
        $search_attr = explode(',', $search_attr);
    }else{
        $search_attr = array();
    }
    $group_attr = array(
        'goods_id' => $goods_id,
        'goods_type' => $goods_type,
        'attr_id' => empty($attr_id_arr) ? '' : implode(',', $attr_id_arr),
        'attr_value' => empty($attr_value_arr) ? '' : implode(',', $attr_value_arr),
        'goods_model' => $goods_model,
        'region_id' => $region_id,
    );

    $result['group_attr'] = json_encode($group_attr);

    //商品模式
    if ($goods_model == 0) {
        $model_name = "";
    } elseif ($goods_model == 1) {
        $model_name = "仓库";
    } elseif ($goods_model == 2) {
        $model_name = "地区";
    }
    $region_name = $GLOBALS['db']->getOne(" SELECT region_name FROM " . $GLOBALS['ecs']->table('region_warehouse') . " WHERE region_id ='$region_id' ");
    $smarty->assign('region_name', $region_name);
    $smarty->assign('goods_model', $goods_model);
    $smarty->assign('model_name', $model_name);

    //商品基本信息
    $goods_info = $GLOBALS['db']->getRow(" SELECT market_price, shop_price, model_attr FROM " . $GLOBALS['ecs']->table("goods") . " WHERE goods_id = '$goods_id' ");
    $smarty->assign('goods_info', $goods_info);
    
    //将属性归类
    foreach ($attr_id_arr as $key => $val) {
        $attr_arr[$val][] = $attr_value_arr[$key];
    }
    
    $attr_spec = array();
    $attribute_array = array();

    if (count($attr_arr) > 0) {
        //属性数据
        $i = 0;
        foreach ($attr_arr as $key => $val) {
            
            $sql = "SELECT attr_name, attr_type FROM " . $GLOBALS['ecs']->table('attribute') . " WHERE attr_id ='$key' LIMIT 1";
            $attr_info = $GLOBALS['db']->getRow($sql);
            
            $attribute_array[$i]['attr_id'] = $key;
            $attribute_array[$i]['attr_name'] = $attr_info['attr_name'];
            $attribute_array[$i]['attr_value'] = $val;
            /* 处理属性图片 start */
            $attr_values_arr = array();
            foreach ($val as $k => $v) {
                $data = get_wholesale_goods_attr_id(array('attr_id' => $key, 'attr_value' => $v, 'goods_id' => $goods_id), array('ga.*, a.attr_type'), array(1, 2), 1);
                if (!$data) {
                    
                    $sql = "SELECT MAX(goods_attr_id) AS goods_attr_id FROM " .$GLOBALS['ecs']->table('wholesale_goods_attr'). " WHERE 1 ";
                    $max_goods_attr_id = $GLOBALS['db']->getOne($sql);
                    $attr_sort =  $max_goods_attr_id + 1;
                    
                    $sql = " INSERT INTO " . $GLOBALS['ecs']->table('wholesale_goods_attr') . " (goods_id, attr_id, attr_value, attr_sort, admin_id) " .
                            " VALUES " .
                            " ('$goods_id', '$key', '$v', '$attr_sort', '" .$_SESSION['admin_id']. "') ";
                    $GLOBALS['db']->query($sql);
                    $data['goods_attr_id'] = $GLOBALS['db']->insert_id();
                    $data['attr_type'] = $attr_info['attr_type'];
                    $data['attr_sort'] = $attr_sort;
                }
                $data['attr_id'] = $key;
                $data['attr_value'] = $v;
                $data['is_selected'] = 1;
                $attr_values_arr[] = $data;
            }
              
            $attr_spec[$i] = $attribute_array[$i];
            $attr_spec[$i]['attr_values_arr'] = $attr_values_arr;
            
            $attribute_array[$i]['attr_values_arr'] = $attr_values_arr;
            
            if($attr_info['attr_type'] == 2){
                unset($attribute_array[$i]);
            }
            /* 处理属性图片 end */			
            $i++;
        }
        
        $attr_arr = get_goods_unset_attr($goods_id, $attr_arr);
        
        //将属性组合
        if (count($attr_arr) == 1) {
            foreach (reset($attr_arr) as $key => $val) {
                $attr_group[][] = $val;
            }
        } else {
            $attr_group = attr_group($attr_arr);
        }
        //搜索筛选
        if(!empty($attr_group) && !empty($search_attr)){
           
            foreach($attr_group as $k=>$v){
                $array_intersect = array_intersect($search_attr,$v);//获取查询出的属性与搜索数组的差集
                if(empty($array_intersect)){
                    unset($attr_group[$k]);
                }
            }
        }
        /* ajax分页 start */
        $filter['page']         = !empty($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $filter['page_size']    = isset($_REQUEST['page_size']) ? intval($_REQUEST['page_size']) : 15;
        $products_list = $ecs->page_array($filter['page_size'], $filter['page'], $attr_group, 0, $filter);
        
        $filter = $products_list['filter'];
        $attr_group = $products_list['list'];
        /* ajax分页 end */
        
        //取得组合补充数据
        foreach ($attr_group as $key => $val) {
            $group = array();
            
            //货品信息
            $product_info = get_wholesale_product_info_by_attr($goods_id, $val, $goods_model, $region_id);
            if (!empty($product_info)) {
                $group = $product_info;
            }
            
            //组合信息
            foreach ($val as $k => $v) {
                if($v){
                    $group['attr_info'][$k]['attr_id'] = $attribute_array[$k]['attr_id'];
                    $group['attr_info'][$k]['attr_value'] = $v;
                }
            }
            
            if($group){
                $attr_group[$key] = $group;
            }else{
                $attr_group = array();
            }
        }
        
        $smarty->assign('attr_group', $attr_group);
        $smarty->assign('attribute_array', $attribute_array);
        
        /* ajax分页 start */
        $smarty->assign('filter', $filter);

	$page_count_arr = seller_page($products_list, $filter['page']);
        $smarty->assign('page_count_arr',$page_count_arr);	
        if($_REQUEST['act'] == 'set_attribute_table'){
            $smarty->assign('full_page',    1);
        }else{
            $smarty->assign('group_attr', $result['group_attr']);
            $smarty->assign('goods_attr_price', $GLOBALS['_CFG']['goods_attr_price']);
            make_json_result($smarty->fetch('library/wholesale_attribute_query.lbi'), '', array('filter' => $products_list['filter'], 'page_count' => $products_list['page_count']));
        }
        /* ajax分页 end */
    }

    $smarty->assign('group_attr', $result['group_attr']);
    $smarty->assign('goods_attr_price', $GLOBALS['_CFG']['goods_attr_price']);
    
    $GLOBALS['smarty']->assign('goods_id', $goods_id);
    $GLOBALS['smarty']->assign('goods_type', $goods_type);

    $result['content'] = $smarty->fetch('library/wholesale_attribute_table.lbi');
	
    /* 处理属性图片 start */
    $smarty->assign('attr_spec', $attr_spec);
	$smarty->assign('spec_count', count($attr_spec));
    $result['goods_attr_gallery'] = $smarty->fetch('library/wholesale_goods_attr_gallery.lbi');
    /* 处理属性图片 end */	

    die(json_encode($result));
}

/*------------------------------------------------------ */
//-- 修改货品库存
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'edit_product_number') {
    check_authz_json('goods_manage');

    $product_id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
    $product_number = intval($_POST['val']);
    $goods_model = isset($_REQUEST['goods_model']) ? intval($_REQUEST['goods_model']) : 0;
    
    if($product_id){
        
        if ($goods_model == 1) {
            $filed = ", warehouse_id";
        } elseif ($goods_model == 2) {
            $filed = ", area_id";
        } else {
            $filed = "";
        }
    
        /* 货品库存 */
        $product = get_product_info($product_id, 'product_number, goods_id' . $filed, $goods_model);

        if ($product['product_number'] != $product_number) {

            if ($product['product_number'] > $product_number) {
                $number = $product['product_number'] - $product_number;
                $number = "- " . $number;
                $log_use_storage = 10;
            } else {
                $number = $product_number - $product['product_number'];
                $number = "+ " . $number;
                $log_use_storage = 11;
            }

            //库存日志
            $logs_other = array(
                'goods_id' => $product['goods_id'],
                'order_id' => 0,
                'use_storage' => $log_use_storage,
                'admin_id' => $_SESSION['admin_id'],
                'number' => $number,
                'model_inventory' => $goods_model,
                'model_attr' => $goods_model,
                'product_id' => $product_id,
                'warehouse_id' => isset($product['warehouse_id']) ? $product['warehouse_id'] : 0,
                'area_id' => isset($product['area_id']) ? $product['area_id'] : 0,
                'add_time' => gmtime()
            );

            $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
        }
    }
    
    if ($goods_model == 1) {
        $table = "products_warehouse";
    } elseif ($goods_model == 2) {
        $table = "products_area";
    } else {
        $table = "products";
    }

    /* 修改货品库存 */
    $sql = "UPDATE " . $ecs->table($table) . " SET product_number = '$product_number' WHERE product_id = '$product_id'";
	
    $result = $db->query($sql);

    if ($result) {
        clear_cache_files();
        make_json_result($product_number);
    }
    
}

/*------------------------------------------------------ */
//-- 修改属性排序
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'edit_attr_sort') {
    check_authz_json('goods_manage');

    $goods_attr_id = intval($_REQUEST['id']);
    $attr_sort = intval($_POST['val']);
    
    /* 修改 */
    $sql = "UPDATE " . $ecs->table('wholesale_goods_attr') . " SET attr_sort = '$attr_sort' WHERE goods_attr_id = '$goods_attr_id'";
    $result = $db->query($sql);
    if ($result) {
        clear_cache_files();
        make_json_result($attr_sort);
    }
}

/*------------------------------------------------------ */
//-- 修改属性价格
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'edit_attr_price') {
    check_authz_json('goods_manage');

    $goods_attr_id = intval($_REQUEST['id']);
    $attr_price = floatval($_POST['val']);
    
    /* 修改 */
    $sql = "UPDATE " . $ecs->table('wholesale_goods_attr') . " SET attr_price = '$attr_price' WHERE goods_attr_id = '$goods_attr_id'";
    $result = $db->query($sql);
    if ($result) {
        clear_cache_files();
        make_json_result($attr_price);
    }
}

/*------------------------------------------------------ */
//-- 修改货品号
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'edit_product_sn') {
    check_authz_json('goods_manage');

    $product_id = intval($_REQUEST['id']);

    $product_sn = json_str_iconv(trim($_POST['val']));
    $product_sn = ($_LANG['n_a'] == $product_sn) ? '' : $product_sn;
    $goods_model = isset($_REQUEST['goods_model']) ? intval($_REQUEST['goods_model']) : 0;

    if (check_product_sn_exist($product_sn, $product_id, $adminru['ru_id'], $goods_model)) {
        make_json_error($_LANG['sys']['wrong'] . $_LANG['exist_same_product_sn']);
    }
    
    if($goods_model == 1){
        $table = "products_warehouse";
    }elseif($goods_model == 2){
        $table = "products_area";
    }else{
        $table = "wholesale_products";
    }

    /* 修改 */
    $sql = "UPDATE " . $ecs->table($table) . " SET product_sn = '$product_sn' WHERE product_id = '$product_id'";
    $result = $db->query($sql);
    if ($result) {
        clear_cache_files();
        make_json_result($product_sn);
    }
}

/*------------------------------------------------------ */
//-- 修改属性排序
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'edit_attr_sort') {
    check_authz_json('goods_manage');

    $goods_attr_id = intval($_REQUEST['id']);
    $attr_sort = intval($_POST['val']);
    
    /* 修改 */
    $sql = "UPDATE " . $ecs->table('wholesale_goods_attr') . " SET attr_sort = '$attr_sort' WHERE goods_attr_id = '$goods_attr_id'";
    $result = $db->query($sql);
    if ($result) {
        clear_cache_files();
        make_json_result($attr_sort);
    }
}

/*------------------------------------------------------ */
//-- 商品单选复选属性手工录入
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'attr_input_type') {
    $json = new JSON;
    $result = array('content' => '', 'sgs' => '');
    
    $attr_id = isset($_REQUEST['attr_id']) && !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
    $goods_id = isset($_REQUEST['goods_id']) && !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
    
    $smarty->assign('attr_id',     $attr_id);
    $smarty->assign('goods_id',     $goods_id);
    
    $goods_attr = get_dialog_wholesale_goods_attr_type($attr_id, $goods_id);
    $smarty->assign('goods_attr',     $goods_attr);

    $result['content'] = $GLOBALS['smarty']->fetch('library/attr_input_type.lbi');
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 商品单选复选属性手工录入
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'insert_attr_input') {
    $json = new JSON;
    $result = array('content' => '', 'sgs' => '');
    
    $attr_id = isset($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
    $goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
    $goods_attr_id = isset($_REQUEST['goods_attr_id']) ? $_REQUEST['goods_attr_id'] : array();
    $attr_value_list = isset($_REQUEST['attr_value_list']) ? $_REQUEST['attr_value_list'] : array();
    
    if($goods_id){
        $where = " AND goods_id = '$goods_id'";
    }else{
        $where = " AND goods_id = 0 AND admin_id = '$admin_id'";
    }
              
    /* 插入、更新、删除数据 */
    foreach ($attr_value_list as $key => $attr_value)
    {
        if($attr_value){
            if($goods_attr_id[$key]){
                $sql = "UPDATE " .$ecs->table('wholesale_goods_attr'). " SET attr_value = '$attr_value' WHERE goods_attr_id = '" .$goods_attr_id[$key]. "' LIMIT 1";
            }else{
                
                $sql = "SELECT MAX(attr_sort) AS attr_sort FROM " .$GLOBALS['ecs']->table('wholesale_goods_attr'). " WHERE attr_id = '$attr_id'" . $where;
                $max_attr_sort = $GLOBALS['db']->getOne($sql);
                
                if($max_attr_sort){
                    $key = $max_attr_sort + 1;
                }else{
                    $key += 1;
                }
                
                $sql = "INSERT INTO " .$ecs->table('wholesale_goods_attr'). " (attr_id, goods_id, attr_value, attr_sort, admin_id)".
                        "VALUES ('$attr_id', '$goods_id', '$attr_value', '$key', '$admin_id')";
            }
            
            $db->query($sql);
        }
    }
    
    $result['attr_id'] = $attr_id;
    $result['goods_id'] = $goods_id;
    
    $goods_attr = get_dialog_wholesale_goods_attr_type($attr_id, $goods_id);
    $smarty->assign('goods_attr',     $goods_attr);
    $smarty->assign('attr_id',     $attr_id);
    
    $result['content'] = $GLOBALS['smarty']->fetch('library/attr_input_type_list.lbi');
    
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 删除商品勾选属性 //ecmoban模板堂 --zhuo
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'del_goods_attr') {
    $json = new JSON;
    $result = array('error' => 0, 'message' => '', 'content' => '');
    $goods_id = isset($_REQUEST['goods_id']) && !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
    $attr_id = isset($_REQUEST['attr_id']) && !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
    $goods_attr_id = isset($_REQUEST['goods_attr_id']) && !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
    $attr_value = isset($_REQUEST['attr_value']) && !empty($_REQUEST['attr_value']) ? addslashes($_REQUEST['attr_value']) : '';
    
    if($goods_attr_id){
        $where = "goods_attr_id = '$goods_attr_id'";
    }else{
        $where = "goods_id = '$goods_id' AND attr_value = '$attr_value' AND attr_id = '$attr_id' AND admin_id = '$admin_id'";
    }
    
    $sql = "DELETE FROM " .$GLOBALS['ecs']->table("wholesale_goods_attr"). " WHERE $where";
    $GLOBALS['db']->query($sql);
    
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 添加属性图片 //ecmoban模板堂 --zhuo
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'add_attr_img') {
    $json = new JSON;
    $result = array('error' => 0, 'message' => '','content' => '');

    $goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
	$goods_name = !empty($_REQUEST['goods_name']) ? trim($_REQUEST['goods_name']) : '';
    $attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
    $goods_attr_id = !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
    $goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '';

    $goods_date = array('goods_name');
    $goods_info = get_table_date('goods', "goods_id = '$goods_id'", $goods_date);
	if(!isset($goods_info['goods_name'])){
		$goods_info['goods_name'] = $goods_name;
	}

    $goods_attr_date = array('attr_img_flie, attr_img_site, attr_checked, attr_gallery_flie');
    $goods_attr_info = get_table_date('wholesale_goods_attr', "goods_id = '$goods_id' and attr_id = '$attr_id' and goods_attr_id = '$goods_attr_id'", $goods_attr_date);
    
    $attr_date = array('attr_name');
    $attr_info = get_table_date('attribute', "attr_id = '$attr_id'", $attr_date);

    $smarty->assign('goods_info', $goods_info);
    $smarty->assign('attr_info', $attr_info);
    $smarty->assign('goods_attr_info', $goods_attr_info);
    $smarty->assign('goods_attr_name', $goods_attr_name);
    $smarty->assign('goods_id', $goods_id);
    $smarty->assign('attr_id', $attr_id);
    $smarty->assign('goods_attr_id', $goods_attr_id);
    $smarty->assign('form_action', 'insert_attr_img');

    $result['content'] = $GLOBALS['smarty']->fetch('library/goods_attr_img_info.lbi');
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 添加属性图片插入数据 //ecmoban模板堂 --zhuo
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert_attr_img')
{
    $json = new JSON;
    $result = array('error' => 0, 'message' => '','content' => '', 'is_checked' => 0);
    
    $goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
    $goods_attr_id = !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
    $attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
    $goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? $_REQUEST['goods_attr_name'] : '';
    $img_url = !empty($_REQUEST['img_url']) ? $_REQUEST['img_url'] : '';
    
    /* 允许上传的文件类型 */
    $allow_file_types = '|GIF|JPG|JEPG|PNG|';
    
    if(!empty($_FILES['attr_img_flie'])){
        $other['attr_img_flie'] = get_upload_pic('attr_img_flie');
        get_oss_add_file(array($other['attr_img_flie']));
    }else{
        $other['attr_img_flie'] = '';
    }

    $goods_attr_date = array('attr_img_flie, attr_img_site');
    $goods_attr_info = get_table_date('wholesale_goods_attr', "goods_id = '$goods_id' and attr_id = '$attr_id' and goods_attr_id = '$goods_attr_id'", $goods_attr_date);

    if(empty($other['attr_img_flie'])){
            $other['attr_img_flie'] = $goods_attr_info['attr_img_flie'];
    }else{
        @unlink(ROOT_PATH  . $goods_attr_info['attr_img_flie']);
    }

    $other['attr_img_site'] = !empty($_REQUEST['attr_img_site']) ? $_REQUEST['attr_img_site'] : '';
    $other['attr_checked'] = !empty($_REQUEST['attr_checked']) ? intval($_REQUEST['attr_checked']) : 0;
    $other['attr_gallery_flie'] = $img_url;
    
    if($other['attr_checked'] == 1){
        $db->autoExecute($ecs->table('wholesale_goods_attr'), array('attr_checked' => 0), 'UPDATE', 'attr_id = ' . $attr_id . ' and goods_id = ' . $goods_id);
        $result['is_checked'] = 1;
    }
    
    $db->autoExecute($ecs->table('wholesale_goods_attr'), $other, 'UPDATE', 'goods_attr_id = ' . $goods_attr_id . ' and attr_id = ' . $attr_id . ' and goods_id = ' . $goods_id);
    
    $result['goods_attr_id'] = $goods_attr_id;
    
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 删除属性图片 //ecmoban模板堂 --zhuo
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'drop_attr_img')
{
    $json = new JSON;
    $result = array('error' => 0, 'message' => '','content' => '');
    
    $goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
    $goods_attr_id = isset($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
    $attr_id = isset($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
    $goods_attr_name = isset($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '';
    
    $sql = "select attr_img_flie from " .$ecs->table('wholesale_goods_attr'). " where goods_attr_id = '$goods_attr_id'";
    $attr_img_flie = $db->getOne($sql);
    
    get_oss_del_file(array($attr_img_flie));
    
    @unlink(ROOT_PATH  . $attr_img_flie);
    $other['attr_img_flie'] = '';
    $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_goods_attr'), $other, "UPDATE", "goods_attr_id = '$goods_attr_id'");
    
    $result['goods_attr_id'] = $goods_attr_id;
    
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 选择属性图片 --zhuo
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'choose_attrImg') {
    $json = new JSON;
    $result = array('error' => 0, 'message' => '', 'content' => '');

    $goods_id = empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']);
    $goods_attr_id = empty($_REQUEST['goods_attr_id']) ? 0 : intval($_REQUEST['goods_attr_id']);
    $on_img_id = isset($_REQUEST['img_id']) ? intval($_REQUEST['img_id']) : 0;

    $sql = "SELECT attr_gallery_flie FROM " . $GLOBALS['ecs']->table('wholesale_goods_attr') . " WHERE goods_attr_id = '$goods_attr_id' AND goods_id = '$goods_id'";
    $attr_gallery_flie = $GLOBALS['db']->getOne($sql);

    /* 删除数据 */
    $sql = "SELECT img_id, thumb_url, img_url FROM " . $GLOBALS['ecs']->table('goods_gallery') . " WHERE goods_id = '$goods_id'";
    $img_list = $GLOBALS['db']->getAll($sql);

    $str = "<ul>";
    foreach ($img_list as $idx => $row) {
        if ($attr_gallery_flie == $row['img_url']) {
            $str .= '<li id="gallery_' . $row['img_id'] . '" onClick="gallery_on(this,' . $row['img_id'] . ',' . $goods_id . ',' . $goods_attr_id . ')" class="on"><img src="../' . $row['thumb_url'] . '" width="87" /><i><img src="images/yes.png"></i></li>';
        } else {
            $str .= '<li id="gallery_' . $row['img_id'] . '" onClick="gallery_on(this,' . $row['img_id'] . ',' . $goods_id . ',' . $goods_attr_id . ')"><img src="../' . $row['thumb_url'] . '" width="87" /><i><img src="images/gallery_yes.png" width="30" height="30"></i></li>';
        }
    }
    $str .= "</ul>";

    $result['content'] = $str;

    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 选择属性图片 --zhuo
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'insert_gallery_attr') {
    $json = new JSON;
    $result = array('error' => 0, 'message' => '', 'content' => '');

    $goods_id = intval($_REQUEST['goods_id']);
    $goods_attr_id = intval($_REQUEST['goods_attr_id']);
    $gallery_id = intval($_REQUEST['gallery_id']);

    if (!empty($gallery_id)) {
        $sql = "SELECT img_id, img_url FROM " . $ecs->table('goods_gallery') . "WHERE img_id='$gallery_id'";
        $img = $db->getRow($sql);
        $result['img_id'] = $img['img_id'];
        $result['img_url'] = $img['img_url'];

        $sql = "UPDATE " . $ecs->table('wholesale_goods_attr') . " SET attr_gallery_flie = '" . $img['img_url'] . "' WHERE goods_attr_id = '$goods_attr_id' AND goods_id = '$goods_id'";
        $db->query($sql);
    } else {
        $result['error'] = 1;
    }
    
    $result['goods_attr_id'] = $goods_attr_id;

    die($json->encode($result));
}


/*
 * 取得批发活动列表
 * @return   array
 */
function seller_wholesale_list($ru_id)
{ 
    /* 查询会员等级 */
    $rank_list = array();
    $sql = "SELECT rank_id, rank_name FROM " . $GLOBALS['ecs']->table('user_rank');
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $rank_list[$row['rank_id']] = $row['rank_name'];
    }

    $result = get_filter();
    if ($result === false)
    {
        /* 过滤条件 */
        $filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'w.act_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
        
        $filter['review_status']    = empty($_REQUEST['review_status']) ? 0 : intval($_REQUEST['review_status']);

        $where = "";
        if (!empty($filter['keyword']))
        {
            $where .= " AND w.goods_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
        }
        
        //ecmoban模板堂 --zhuo start
        if($ru_id > 0){
            $where .= " AND w.user_id = '$ru_id' ";
        }
        //ecmoban模板堂 --zhuo end
        
        if( $filter['review_status']){
            $where .= " AND w.review_status = '" .$filter['review_status']. "' ";
        }
        
        //管理员查询的权限 -- 店铺查询 start
        $filter['store_search'] = !isset($_REQUEST['store_search']) ? -1 : intval($_REQUEST['store_search']);
        $filter['merchant_id'] = isset($_REQUEST['merchant_id']) ? intval($_REQUEST['merchant_id']) : 0;
        $filter['store_keyword'] = isset($_REQUEST['store_keyword']) ? trim($_REQUEST['store_keyword']) : '';
        
        $store_where = '';
        $store_search_where = '';
        if($filter['store_search'] > -1){
           if($ru_id == 0){ 
                if($filter['store_search'] > 0){
                    if($_REQUEST['store_type']){
                        $store_search_where = "AND msi.shopNameSuffix = '" .$_REQUEST['store_type']. "'";
                    }

                    if($filter['store_search'] == 1){
                        $where .= " AND w.user_id = '" .$filter['merchant_id']. "' ";
                    }elseif($filter['store_search'] == 2){
                        $store_where .= " AND msi.rz_shopName LIKE '%" . mysql_like_quote($filter['store_keyword']) . "%'";
                    }elseif($filter['store_search'] == 3){
                        $store_where .= " AND msi.shoprz_brandName LIKE '%" . mysql_like_quote($filter['store_keyword']) . "%' " . $store_search_where;
                    }

                    if($filter['store_search'] > 1){
                        $where .= " AND (SELECT msi.user_id FROM " . $GLOBALS['ecs']->table('merchants_shop_information') .' as msi ' .  
                                  " WHERE msi.user_id = w.user_id $store_where) > 0 ";
                    }
                }else{
                    $where .= " AND w.user_id = 0";
                }    
           }
        }
        //管理员查询的权限 -- 店铺查询 end

        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('wholesale') ." AS w ".
                " WHERE 1 $where";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        /* 分页大小 */
        $filter = page_and_size($filter);

        /* 查询 */
        $sql = "SELECT w.* ".
                "FROM " . $GLOBALS['ecs']->table('wholesale') ." AS w ".
                " WHERE 1 $where ".
                " ORDER BY $filter[sort_by] $filter[sort_order] ".
                " LIMIT ". $filter['start'] .", $filter[page_size]";

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $res = $GLOBALS['db']->query($sql);

    $list = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $rank_name_list = array();
        if ($row['rank_ids'])
        {
            $rank_id_list = explode(',', $row['rank_ids']);
            foreach ($rank_id_list as $id)
            {
                if (isset($rank_list[$id]))
                {
                    $rank_name_list[] = $rank_list[$id];
                }
            }
        }
        $row['rank_names'] = join(',', $rank_name_list);
        $row['price_list'] = unserialize($row['prices']);
        $row['ru_name'] = get_shop_name($row['user_id'], 1); //ecmoban模板堂 --zhuo

        $list[] = $row;
    }

    return array('item' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

?>