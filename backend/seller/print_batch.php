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

/*------------------------------------------------------ */
//-- 打印订单页面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'print_batch')
{
    $checkboxes = !empty($_REQUEST['checkboxes'])  ?  trim($_REQUEST['checkboxes']) : '';
	
	//快递鸟、电子面单 start
	if(get_print_type($adminru['ru_id'])){
		$url = 'tp_api.php?act=kdniao_print&order_sn='.$checkboxes;
		ecs_header("Location: $url\n");
		exit;
	}
	//快递鸟、电子面单 end		
	
    if($checkboxes)
    {
        $smarty->assign('checkboxes',$checkboxes);
        $smarty->display('print_batch.dwt');
    }
}
/*------------------------------------------------------ */
//-- 异步打印快递单
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'ajax_print')
{
    require(ROOT_PATH . '/includes/cls_json.php');
    require_once(ROOT_PATH . 'includes/lib_order.php');
    require(ROOT_PATH . '/includes/lib_visual.php');
    $data = array('error' => 0, 'message' => '', 'content' => '');
    $adminru = get_admin_ru_id();
    $order_sn = isset($_REQUEST['order_sn'])  ?   trim($_REQUEST['order_sn']) : '';
    $data['order_sn'] = $order_sn;
    if($order_sn)
    {
        $order_sn = trim($_REQUEST['order_sn']);
        $order = order_info(0, $order_sn);
         $smarty->assign('order', $order);
        if (empty($order))
        {
            $data['error'] = 1;
            $data['message'] = "打印订单不存在，请查证";
            die(json_encode($data));
        }
        else
        {
            $order['invoice_no']    = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? $_LANG['ss'][SS_UNSHIPPED] : $order['invoice_no'];
           //商家店铺信息打印到订单和快递单上
            $sql = "select shop_name,country,province,city,district,shop_address,kf_tel from " . $ecs->table('seller_shopinfo') . " where ru_id='" . $adminru['ru_id'] . "'";
            $store = $db->getRow($sql);

            $store['shop_name'] = get_shop_name($order['ru_id'], 1); 
            //$smarty->assign('print_time',   local_date($_CFG['time_format']));
        //发货地址所在地
        $region_array = array();
        /*$region_id = !empty($store['country']) ? $store['country'] . ',' : '';
        $region_id .= !empty($store['province']) ? $store['province'] . ',' : '';
        $region_id .= !empty($store['city']) ? $store['city'] . ',' : '';
        $region_id = substr($region_id, 0, -1);
        //$region = $db->getAll("SELECT region_id, region_name FROM " . $ecs->table("region") . " WHERE region_id IN ($region_id)");*/
		$region = $db->getAll("SELECT region_id, region_name FROM " . $ecs->table("region")); //打印快递单地区 by wu
        if (!empty($region))
        {
            foreach($region as $region_data)
            {
                $region_array[$region_data['region_id']] = $region_data['region_name'];
            }
        }
        $smarty->assign('shop_name',    $store['shop_name']);
        $smarty->assign('order_id',    $order_id);
        $smarty->assign('province', $region_array[$store['province']]);
        $smarty->assign('city', $region_array[$store['city']]);
        $smarty->assign('district', $region_array[$store['district']]);
        $smarty->assign('shop_address', $store['shop_address']);
        $smarty->assign('service_phone',$store['kf_tel']);
        $shipping = $db->getRow("SELECT * FROM " . $ecs->table("shipping_tpl") . " WHERE shipping_id = '" . $order['shipping_id']."' and ru_id='".$order['ru_id']."'");

        //打印单模式
        if ($shipping['print_model'] == 2)
        {
            /* 可视化 */
            /* 快递单 */
            $shipping['print_bg'] = empty($shipping['print_bg']) ? '' : get_site_root_url() . $shipping['print_bg'];

            /* 取快递单背景宽高 */
            if (!empty($shipping['print_bg']))
            {
                $_size = @getimagesize($shipping['print_bg']);

                if ($_size != false)
                {
                    $shipping['print_bg_size'] = array('width' => $_size[0], 'height' => $_size[1]);
                }
            }

            if (empty($shipping['print_bg_size']))
            {
                $shipping['print_bg_size'] = array('width' => '1024', 'height' => '600');
            }

            /* 标签信息 */
            $lable_box = array();
            $lable_box['t_shop_country'] = $region_array[$store['country']]; //网店-国家
            $lable_box['t_shop_city'] = $region_array[$store['city']]; //网店-城市
            $lable_box['t_shop_province'] = $region_array[$store['province']]; //网店-省份          
			$sql = "select og.ru_id from " .$GLOBALS['ecs']->table('order_info') ." as oi ". "," .$GLOBALS['ecs']->table('order_goods'). " as og " .
					" where oi.order_id = og.order_id and oi.order_id = '" .$order['order_id']. "' group by oi.order_id";
			$ru_id = $GLOBALS['db']->getOne($sql);
			
			if($ru_id > 0){
				
				$sql = "select shoprz_brandName, shopNameSuffix from " .$GLOBALS['ecs']->table('merchants_shop_information') . " where user_id = '$ru_id'";
				$shop_info = $GLOBALS['db']->getRow($sql);
				
				$lable_box['t_shop_name'] = $shop_info['shoprz_brandName'] . $shop_info['shopNameSuffix']; //店铺-名称
			}else{
				$lable_box['t_shop_name'] = $_CFG['shop_name']; //网店-名称
			}
			
            $lable_box['t_shop_district'] = $region_array[$store['district']]; //网店-区/县
            $lable_box['t_shop_tel'] = $store['kf_tel']; //网店-联系电话
            $lable_box['t_shop_address'] = $store['shop_address']; //网店-地址
            $lable_box['t_customer_country'] = $region_array[$order['country']]; //收件人-国家
            $lable_box['t_customer_province'] = $region_array[$order['province']]; //收件人-省份
            $lable_box['t_customer_city'] = $region_array[$order['city']]; //收件人-城市
            $lable_box['t_customer_district'] = $region_array[$order['district']]; //收件人-区/县
            $lable_box['t_customer_tel'] = $order['tel']; //收件人-电话
            $lable_box['t_customer_mobel'] = $order['mobile']; //收件人-手机
            $lable_box['t_customer_post'] = $order['zipcode']; //收件人-邮编
            $lable_box['t_customer_address'] = $order['address']; //收件人-详细地址
            $lable_box['t_customer_name'] = $order['consignee']; //收件人-姓名

            $gmtime_utc_temp = gmtime(); //获取 UTC 时间戳
            $lable_box['t_year'] = date('Y', $gmtime_utc_temp); //年-当日日期
            $lable_box['t_months'] = date('m', $gmtime_utc_temp); //月-当日日期
            $lable_box['t_day'] = date('d', $gmtime_utc_temp); //日-当日日期

            $lable_box['t_order_no'] = $order['order_sn']; //订单号-订单
            $lable_box['t_order_postscript'] = $order['postscript']; //备注-订单
            $lable_box['t_order_best_time'] = $order['best_time']; //送货时间-订单
            $lable_box['t_pigeon'] = '√'; //√-对号
            $lable_box['t_custom_content'] = ''; //自定义内容

            //标签替换
            $temp_config_lable = explode('||,||', $shipping['config_lable']);
            if (!is_array($temp_config_lable))
            {
                $temp_config_lable[] = $shipping['config_lable'];
            }
            foreach ($temp_config_lable as $temp_key => $temp_lable)
            {
                $temp_info = explode(',', $temp_lable);
                if (is_array($temp_info))
                {
                    $temp_info[1] = $lable_box[$temp_info[0]];
                }
                $temp_config_lable[$temp_key] = implode(',', $temp_info);
            }
            $shipping['config_lable'] = implode('||,||',  $temp_config_lable);

            $data['shipping'] = $shipping;
            $data['error'] = 0;
            $data['print_model'] = 2;
            die(json_encode($data));
        }
        elseif (!empty($shipping['shipping_print']))
        {
            /* 代码 */
            $data['error'] = 0;
            $simulation_print = "simulation_print.html";
            $create_html = create_html($shipping['shipping_print'],$adminru['ru_id'],$simulation_print,'',2);
            $dir = ROOT_PATH . 'data/'.$simulation_print;
            $data['content'] = $GLOBALS['smarty']->fetch($dir);
            die(json_encode($data));
        }
        else
        {
            $shipping_code = $db->getOne("SELECT shipping_code FROM " . $ecs->table('shipping') . " WHERE shipping_id='" . $order['shipping_id']."'");
			
            /* 处理app */
            if($order['referer'] == 'mobile')
            {
                    $shipping_code = str_replace('ship_', '', $shipping_code);
                    die(json_encode($data));
            }			
			
            if ($shipping_code)
            {
                include_once(ROOT_PATH . 'includes/modules/shipping/' . $shipping_code . '.php');
            }

            if (!empty($_LANG['shipping_print']))
            {
                $data['error'] = 0;
                //模板写入文件  AJAX调取
                $simulation_print = "simulation_print.html";
                $create_html = create_html($_LANG['shipping_print'],$adminru['ru_id'],$simulation_print,'',2);
                $dir = ROOT_PATH . 'data/'.$simulation_print;
                $data['content'] = $GLOBALS['smarty']->fetch($dir);
                die(json_encode($data));
            }
            else
            {
                $data['error'] = 1;
                $data['message'] = "很抱歉,目前您还没有设置打印快递单模板.不能进行打印";
                die(json_encode($data));
            }
        }
        }
        
    }  
    else
    {
        $data['error'] = 1;
        $data['message'] = "请选择打印订单";
        die(json_encode($data));
    }
}
/**
 * 获取站点根目录网址
 *
 * @access  private
 * @return  Bool
 */
function get_site_root_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . SELLER_PATH . '/order.php', '', PHP_SELF);

}
?>