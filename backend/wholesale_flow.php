<?php

/**
 * DSC 购物流程
 * ============================================================================
 * 旺旺：ecshop2012版权所有，并保留所有权利。* 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: Zhuo $
 * $Id: wholesale_flow.php 2016-01-04 Zhuo $
 */

define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_area.php');  //旺旺ecshop2012--zuo
require(ROOT_PATH . 'includes/lib_order.php');
require(ROOT_PATH . 'includes/lib_wholesale.php');

if($GLOBALS['_CFG']['wholesale_user_rank'] == 0){
    $is_seller = get_is_seller();
    if($is_seller == 0){
        ecs_header("Location: " .$ecs->url(). "\n");
    }
}

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');

//旺旺ecshop2012--zuo start
$area_info = get_area_info($province_id);
$area_id = $area_info['region_id'];

$where = "regionId = '$province_id'";
$date = array('parent_id');
$region_id = get_table_date('region_warehouse', $where, $date, 2);

if(isset($_COOKIE['region_id']) && !empty($_COOKIE['region_id'])){
    $region_id = $_COOKIE['region_id'];
}
//旺旺ecshop2012--zuo end

$smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
$smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));

/*------------------------------------------------------ */
//-- INPUT
/*------------------------------------------------------ */

if (!isset($_REQUEST['step']))
{
    $_REQUEST['step'] = "cart";
}

//旺旺ecshop2012--zuo start
if(!empty($_SESSION['user_id'])){
	$sess_id = " user_id = '" . $_SESSION['user_id'] . "' ";
	
	$a_sess = " a.user_id = '" . $_SESSION['user_id'] . "' ";
	$b_sess = " b.user_id = '" . $_SESSION['user_id'] . "' ";
	$c_sess = " c.user_id = '" . $_SESSION['user_id'] . "' ";
	
	$sess = "";
}else{
	$sess_id = " session_id = '" . real_cart_mac_ip() . "' ";
	
	$a_sess = " a.session_id = '" . real_cart_mac_ip() . "' ";
	$b_sess = " b.session_id = '" . real_cart_mac_ip() . "' ";
	$c_sess = " c.session_id = '" . real_cart_mac_ip() . "' ";
	
	$sess = real_cart_mac_ip();
}
//旺旺ecshop2012--zuo end

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

assign_template();
$position = assign_ur_here(0, $_LANG['shopping_flow']);
$smarty->assign('page_title',       $position['title']);    // 页面标题
$smarty->assign('ur_here',          $position['ur_here']);  // 当前位置
$smarty->assign('helps',            get_shop_help());       // 网店帮助
$smarty->assign('lang',             $_LANG);
$smarty->assign('show_marketprice', $_CFG['show_marketprice']);
if(defined('THEME_EXTENSION')){
	$wholesale_cat = get_wholesale_child_cat();
	$smarty->assign('wholesale_cat', $wholesale_cat);
}
$smarty->assign('data_dir',    DATA_DIR);       // 数据目录

$smarty->assign('user_id',   $_SESSION['user_id']);

/*------------------------------------------------------ */
//-- 添加商品到购物车
/*------------------------------------------------------ */
if ($_REQUEST['step'] == 'add_to_cart')
{
    include_once('includes/cls_json.php');
    $json = new JSON;
    $result = array('error' => 0, 'message' => '', 'content' => '');

    //处理数据
    $goods_id = empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']);
    //判断商品是否设置属性
    $goods_type = get_table_date('wholesale', "goods_id='$goods_id'", array('goods_type'), 2);
    if ($goods_type > 0) {
        $attr_array = empty($_REQUEST['attr_array']) ? array() : $_REQUEST['attr_array'];
        $num_array = empty($_REQUEST['num_array']) ? array() : $_REQUEST['num_array'];
        $total_number = array_sum($num_array);
    } else {
        $goods_number = empty($_REQUEST['goods_number']) ? 0 : intval($_REQUEST['goods_number']);
        $total_number = $goods_number;
    }

    if (!$_SESSION['user_id']) {
        //提示登陆
        $result['error'] = 2;
        $result['content'] = $_LANG['overdue_login'];
        die($json->encode($result));
    }
    //计算价格
    $price_info = calculate_goods_price($goods_id, $total_number);
    //商品信息
    $goods_info = get_table_date('goods', "goods_id='$goods_id'", array('goods_name, goods_sn, user_id'));
    //通用数据
    $common_data = array();
    $common_data['user_id'] = $_SESSION['user_id'];
    $common_data['session_id'] = $sess;
    $common_data['goods_id'] = $goods_id;
    $common_data['goods_sn'] = $goods_info['goods_sn'];
    $common_data['goods_name'] = $goods_info['goods_name'];
    $common_data['market_price'] = $price_info['market_price'];
    $common_data['goods_price'] = $price_info['unit_price'];
    $common_data['goods_number'] = 0;
    $common_data['goods_attr_id'] = '';
    $common_data['ru_id'] = $goods_info['user_id'];
    $common_data['add_time'] = gmtime();

    //加入购物车
    if ($goods_type > 0) {
        foreach ($attr_array as $key => $val) {
            //货品信息
            $attr = explode(',', $val);
            //处理数据
            $data = $common_data;
            $gooda_attr = get_goods_attr_array($val);
            foreach ($gooda_attr as $v) {
                $data['goods_attr'] .= $v['attr_name'] . ":" . $v['attr_value'] . "\n";
            }
            $data['goods_attr_id'] = $val;
            $data['goods_number'] = $num_array[$key];
            //货品数据
            $set = get_find_in_set($attr, 'goods_attr', ',');
            $sql = " SELECT * FROM " . $GLOBALS['ecs']->table('wholesale_products') . " WHERE goods_id = '$goods_id' $set ";
            $product_info = $GLOBALS['db']->getRow($sql);
            $data['goods_sn'] = $product_info['product_sn'];
            //判断是更新还是插入
            $set = get_find_in_set($attr, 'goods_attr_id', ',');
            $sql = " SELECT rec_id FROM " . $GLOBALS['ecs']->table('wholesale_cart') . " WHERE $sess_id AND goods_id = '$goods_id' $set ";
            $rec_id = $GLOBALS['db']->getOne($sql);
            if (!empty($rec_id)) {
                $db->autoExecute($ecs->table('wholesale_cart'), $data, 'UPDATE', "rec_id='$rec_id'");
            } else {
                $db->autoExecute($ecs->table('wholesale_cart'), $data, 'INSERT');
            }
        }
    } else {
        $data = $common_data;
        $data['goods_number'] = $goods_number;
        //判断是更新还是插入
        $sql = " SELECT rec_id FROM " . $GLOBALS['ecs']->table('wholesale_cart') . " WHERE $sess_id AND goods_id = '$goods_id' ";
        $rec_id = $GLOBALS['db']->getOne($sql);
        if (!empty($rec_id)) {
            $db->autoExecute($ecs->table('wholesale_cart'), $data, 'UPDATE', "rec_id='$rec_id'");
        } else {
            $db->autoExecute($ecs->table('wholesale_cart'), $data, 'INSERT');
        }
    }
    
    //重新计算价格并更新价格
    calculate_cart_goods_price($goods_id);
    $result['content'] = insert_wholesale_cart_info();
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 提交购物车商品
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'done')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');
    //公共数据
    $common_data['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);
    //$common_data['gender'] = empty($_REQUEST['gender'])? 0:intval($_REQUEST['gender']);
    $common_data['mobile'] = empty($_REQUEST['mobile']) ? '' : trim($_REQUEST['mobile']);
    $common_data['address'] = empty($_REQUEST['address']) ? '' : trim($_REQUEST['address']);
    $common_data['inv_type'] = empty($_REQUEST['inv_type']) ? 0 : intval($_REQUEST['inv_type']);
    $common_data['pay_id'] = empty($_REQUEST['pay_id']) ? 0 : intval($_REQUEST['pay_id']);
    $common_data['postscript'] = empty($_REQUEST['postscript']) ? '' : trim($_REQUEST['postscript']);
    $common_data['inv_payee'] = empty($_REQUEST['inv_payee']) ? '' : trim($_REQUEST['inv_payee']);
    $common_data['tax_id'] = empty($_REQUEST['tax_id']) ? '' : trim($_REQUEST['tax_id']);
    $common_data['pay_id'] = empty($_REQUEST['pay_id']) ? 0 : intval($_REQUEST['pay_id']);
    if ($common_data['pay_id'] == 0) {
        show_message("请选择支付方式", "返回购物车", 'wholesale_flow.php?step=cart', 'info');
    }
    //内部数据
    $main_order = $common_data;
    $main_order['order_sn'] = get_order_sn(); //获取订单号
    $main_order['main_order_id'] = 0; //主订单
    $main_order['user_id'] = $_SESSION['user_id'];
    $main_order['add_time'] = gmtime();
    $main_order['order_amount'] = 0;
    //插入主订单
    $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $main_order, 'INSERT');
    $main_order_id = $GLOBALS['db']->insert_id(); //主订单id
    //开始分单 start
    $rec_ids = empty($_REQUEST['rec_ids']) ? '' : implode(',', $_REQUEST['rec_ids']);
    $where = " WHERE user_id = '$_SESSION[user_id]' AND rec_id IN ($rec_ids) ";
    if (empty($rec_ids)) {
        //报错
    }
    $sql = " SELECT DISTINCT ru_id FROM " . $GLOBALS['ecs']->table('wholesale_cart') . $where;
    $ru_ids = $GLOBALS['db']->getCol($sql);
    foreach ($ru_ids as $key => $val) {
        //内部数据
        $child_order = $common_data;
        $child_order['order_sn'] = get_order_sn(); //获取订单号
        $child_order['main_order_id'] = $main_order_id; //主订单
        $child_order['user_id'] = $_SESSION['user_id'];
        $child_order['add_time'] = gmtime();
        $child_order['order_amount'] = 0;
        //插入子订单
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $child_order, 'INSERT');
        $child_order_id = $GLOBALS['db']->insert_id(); //子订单id		
        //购物车商品数据
        $sql = " SELECT goods_id, goods_name, goods_sn, goods_number, goods_price, goods_attr, goods_attr_id, ru_id FROM " .
                $GLOBALS['ecs']->table('wholesale_cart') . $where . " AND ru_id = '$val' ";
        $cart_goods = $GLOBALS['db']->getAll($sql);
        foreach ($cart_goods as $k => $v) {
            //插入订单商品表
            $v['order_id'] = $child_order_id;
            $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_goods'), $v, 'INSERT');
            //统计子订单金额
            $child_order['order_amount'] += $v['goods_price'] * $v['goods_number'];
        }
        //更新子订单数据
        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $child_order, 'update', "order_id ='$child_order_id'");
        insert_pay_log($child_order_id, $child_order['order_amount'], PAY_WHOLESALE);//更新子订单支付日志
        //统计主订单金额
        $main_order['order_amount'] += $child_order['order_amount'];
    }
    //更新主订单数据
    $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('wholesale_order_info'), $main_order, 'update', "order_id ='$main_order_id'");
    
    $sql = "SELECT order_amount FROM".$ecs->table('wholesale_order_info')."WHERE order_id ='$main_order_id'";
    $order_amount = $db->getOne($sql);
    $log_id = insert_pay_log($main_order_id, $order_amount, PAY_WHOLESALE);//更新主订单支付日志
    //开始分单 end
    //插入数据完成后删除购物车订单
    $sql = " DELETE FROM " . $GLOBALS['ecs']->table('wholesale_cart') . $where;
    $GLOBALS['db']->query($sql);
    
    ecs_header("Location: wholesale_flow.php?step=order_pay&order_id=".$main_order_id."\n");
}
elseif ($_REQUEST['step'] == 'order_pay') {

    include_once(ROOT_PATH . 'includes/lib_clips.php');
    include_once(ROOT_PATH . 'includes/lib_payment.php');
    $order_id = !empty($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0;
    $sql = "SELECT * FROM" . $ecs->table('wholesale_order_info') . "WHERE order_id ='$order_id'";
    $order_info = $db->getRow($sql);

    //获取支付方式信息
    $payment_info = payment_info($order_info['pay_id']);
    $payment_info['pay_name'] = addslashes($payment_info['pay_name']);
    $payment_info['pay_code'] = addslashes($payment_info['pay_code']);
    $pay_fee = pay_fee($common_data['pay_id'], $order_info['order_amount'], 0); //获取手续费
    //数组处理
    $order['order_amount'] = $order_info['order_amount'] + $pay_fee;
    $order['pay_name'] = $payment_info['pay_name'];
    $order['pay_fee'] = $pay_fee;
    //子订单数量
    $sql = "SELECT order_sn,address,consignee,mobile,order_amount FROM " . $GLOBALS['ecs']->table('wholesale_order_info') . " WHERE main_order_id = '$order_id'";
    $child_order_info = $db->getAll($sql);
    $child_num = count($child_order_info);
    if ($order_info['pay_status'] != 1) {
        if ($payment_info['pay_code'] == 'balance') {
            //查询出当前用户的剩余余额;
            $user_money = $db->getOne("SELECT user_money FROM " . $ecs->table('users') . " WHERE user_id='" . $_SESSION['user_id'] . "'");
            //如果用户余额足够支付订单;
            if ($user_money > $order['order_amount']) {
                $time = gmtime();
                /* 修改申请的支付状态 */
                $sql = " UPDATE " . $GLOBALS['ecs']->table('wholesale_order_info') . " SET pay_status = 1 ,pay_time = '$time'  WHERE order_id = '$order_id'";
                $GLOBALS['db']->query($sql);

                /* 修改此次支付操作的状态为已付款 */
                $sql = "UPDATE " . $ecs->table('pay_log') . "SET is_paid = 1 WHERE order_id = '" . $order_id . "' AND order_type = '" . PAY_WHOLESALE . "'";
                $db->query($sql);
                log_account_change($order['user_id'], $order['order_amount'] * (-1), 0, 0, 0, sprintf($_LANG['pay_who_order'], $order_info['order_sn']));

                //修改子订单状态为已付款
                if ($child_num > 0) {
                    $sql = 'SELECT order_id, order_sn, pay_id, order_amount ' . 'FROM ' . $GLOBALS['ecs']->table('wholesale_order_info') .
                            " WHERE main_order_id = '$order_id'";
                    $order_res = $GLOBALS['db']->getAll($sql);
                    foreach ($order_res AS $row) {
                        /* 修改此次支付操作子订单的状态为已付款 */
                        $sql = "UPDATE " . $ecs->table('pay_log') . "SET is_paid = 1 WHERE order_id = '" . $row['order_id'] . "' AND order_type = '" . PAY_WHOLESALE . "'";
                        $db->query($sql);

                        $child_pay_fee = order_pay_fee($row['pay_id'], $row['order_amount']); //获取支付费用
                        //修改子订单支付状态
                        $sql = 'UPDATE ' . $GLOBALS['ecs']->table('wholesale_order_info') .
                                " SET pay_status = 1, " .
                                " pay_time = '$time', " .
                                " pay_fee = '$child_pay_fee' " .
                                "WHERE order_id = '" . $row['order_id'] . "'";

                        $GLOBALS['db']->query($sql);
                    }
                }
                $smarty->assign('is_pay', 1);
            } else {
                show_message("您的余额已不足,请充值!", "返回购物车", 'wholesale_flow.php?step=cart', 'info');
            }
        } else {
            $payment = unserialize_config($payment_info['pay_config']);

            /* 调用相应的支付方式文件 */
            include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');
            /* 取得在线支付方式的支付按钮 */
            $pay_obj = new $payment_info['pay_code'];
            $payment_info['pay_button'] = $pay_obj->get_code($order, $payment);
        }
    } else {
        $smarty->assign('is_pay', 1);
    }
    if($child_num == 1){
        $sql = "SELECT order_sn FROM".$ecs->table('wholesale_order_info')." WHERE main_order_id = '$order_id'";
        $order_sn = $db->getOne($sql);
    }else{
        $order_sn = $order_info['order_sn'];
    }
    $order['log_id'] = $db->getOne("SELECT log_id FROM" . $ecs->table('pay_log') . "WHERE order_id = '$order_id' AND order_type = '" . PAY_WHOLESALE . "'");
    $order['order_sn'] = $order_info['order_sn'];
    $order['user_id'] = $_SESSION['user_id'];
    $smarty->assign('order_sn', $order_sn);
    $smarty->assign('order', $order);
    $smarty->assign('payment', $payment_info);
    $smarty->assign('child_order_info', $child_order_info);
    $smarty->assign('child_num', $child_num);
    $smarty->assign('main_order', $order_info);
    $smarty->assign('step', $_REQUEST['step']);
    $smarty->display('wholesale_flow.dwt');exit;
}
/*------------------------------------------------------ */
//-- 删除购物车商品
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'remove') {
    require_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();
    $result = array('error' => 0, 'message' => '', 'content' => '');

    $goods_id = empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']);
    if (!empty($goods_id)) {
        $sess_id .= " AND goods_id = '$goods_id' ";
        $sql = " DELETE FROM " . $GLOBALS['ecs']->table('wholesale_cart') . " WHERE $sess_id ";
        $GLOBALS['db']->query($sql);
    }

    die($json->encode($result));
} 

/*------------------------------------------------------ */
//-- 批量删除购物车商品
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'batch_remove') {
    require_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();
    $result = array('error' => 0, 'message' => '', 'content' => '');


    $goods_id = empty($_REQUEST['goods_id']) ? '' : trim($_REQUEST['goods_id']);
    if (!empty($goods_id)) {
        $sess_id .= " AND goods_id IN ($goods_id) ";
        $sql = " DELETE FROM " . $GLOBALS['ecs']->table('wholesale_cart') . " WHERE $sess_id ";
        $GLOBALS['db']->query($sql);
    }

    die($json->encode($result));
} 

/*------------------------------------------------------ */
//-- 更新购物车
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'ajax_update_cart') {
    require_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();
    $result = array('error' => 0, 'message' => '', 'content' => '');

    $rec_ids = empty($_REQUEST['rec_ids']) ? array() : $_REQUEST['rec_ids'];
    $rec_ids = implode(',', $rec_ids);

    //商品信息
    $cart_goods = wholesale_cart_goods(0, $rec_ids);
    $goods_list = array();
    foreach ($cart_goods as $key => $val) {
        foreach ($val['goods_list'] as $k => $g) {
            //处理阶梯价格
            $smarty->assign('goods', $g);
            $g['volume_price_lbi'] = $smarty->fetch('library/wholesale_cart_volume_price.lbi');
            //商品数据
            $goods_list[$g['goods_id']] = $g;
        }
    }
    $result['goods_list'] = $goods_list;

    //订单信息
    $cart_info = wholesale_cart_info(0, $rec_ids);
    $result['cart_info'] = $cart_info;

    die($json->encode($result));
} 

/*------------------------------------------------------ */
//-- 更新记录数量
/*------------------------------------------------------ */
elseif ($_REQUEST['step'] == 'update_rec_num')
{
    require_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON();
    $result = array('error' => 0, 'message' => '', 'content' => '');

    $rec_id = empty($_REQUEST['rec_id']) ? 0 : intval($_REQUEST['rec_id']);
    $rec_num = empty($_REQUEST['rec_num']) ? 0 : intval($_REQUEST['rec_num']);
    //查询库存
    $cart_info = get_table_date('wholesale_cart', "rec_id='$rec_id'", array('goods_id', 'goods_attr_id'));
    if (empty($cart_info['goods_attr_id'])) {
        $goods_number = get_table_date('wholesale', "goods_id='$cart_info[goods_id]'", array('goods_number'), 2);
    } else {
        $set = get_find_in_set(explode(',', $cart_info['goods_attr_id']));
        $goods_number = get_table_date('wholesale_products', "goods_id='$cart_info[goods_id]' $set", array('product_number'), 2);
    }
    $result['goods_number'] = $goods_number;

    if ($goods_number < $rec_num) {
        $result['error'] = 1;
        $result['message'] = "该商品库存只有{$goods_number}个";
        $rec_num = $goods_number;
    }

    $sql = " UPDATE " . $GLOBALS['ecs']->table('wholesale_cart') . " SET goods_number = '$rec_num' WHERE rec_id = '$rec_id' ";
    $GLOBALS['db']->query($sql);

    die($json->encode($result));
}

elseif ($_REQUEST['step'] == 'update_cart')
{

}

elseif ($_REQUEST['step'] == 'clear')
{
    $sql = "DELETE FROM " . $ecs->table('wholesale_cart') . " WHERE " . $sess_id;
    $db->query($sql);

    ecs_header("Location:./\n");
}

else
{
    $goods_id = empty($_REQUEST['goods_id']) ? 0 : trim($_REQUEST['goods_id']);
    $rec_ids = empty($_REQUEST['rec_ids']) ? '' : trim($_REQUEST['rec_ids']);
    $goods_data = wholesale_cart_goods($goods_id, $rec_ids);
    $smarty->assign('goods_data', $goods_data);
    $cart_info = wholesale_cart_info($goods_id, $rec_ids);
    $smarty->assign('cart_info', $cart_info);
}

$history_goods = get_history_goods(0, $region_id, $area_id);
$smarty->assign('history_goods', $history_goods);
$smarty->assign('historyGoods_count', count($history_goods));

//获取支付方式
// 给货到付款的手续费加<span id>，以便改变配送的时候动态显示
$payment_list = available_payment_list(1);

if (isset($payment_list)) {
    foreach ($payment_list as $key => $payment) {
        //pc端去除ecjia的支付方式
        if (substr($payment['pay_code'], 0, 4) == 'pay_') {
            unset($payment_list[$key]);
            continue;
        }

        if ($payment['is_cod'] == '1') {
            $payment_list[$key]['format_pay_fee'] = '<span id="ECS_CODFEE">' . $payment['format_pay_fee'] . '</span>';
        }
        /* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
        if ($payment['pay_code'] == 'yeepayszx') {
            unset($payment_list[$key]);
        }

        if ($payment['pay_code'] == 'alipay_wap') {
            unset($payment_list[$key]);
        }

        /* 如果有余额支付 */
        if ($payment['pay_code'] == 'balance') {
            /* 如果未登录，不显示 */
            if ($_SESSION['user_id'] == 0) {
                unset($payment_list[$key]);
            }
        }
        //过滤在现在线支付
        if($payment['pay_code'] == 'onlinepay' || $payment['pay_code'] == 'chunsejinrong'){
            unset($payment_list[$key]);
        }
    }
}

$arr = last_shipping_and_payment();//获取默认的支付方式
$smarty->assign('pay_id', $arr['pay_id']);
$smarty->assign('payment_list', $payment_list);

$smarty->assign('currency_format', $_CFG['currency_format']);
$smarty->assign('integral_scale',  price_format($_CFG['integral_scale']));
$smarty->assign('step',            $_REQUEST['step']);
assign_dynamic('shopping_flow');

$smarty->display('wholesale_flow.dwt');
/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

?>