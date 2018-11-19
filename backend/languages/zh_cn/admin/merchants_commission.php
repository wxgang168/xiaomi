<?php

/**
 * ECSHOP 管理中心服务站管理语言文件
 * ============================================================================
 * * 版权所有 2005-2017 上海商创网络科技有限公司，并保留所有权利。
 * 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: testyang $
 * $Id: agency.php 15013 2008-10-23 09:31:42Z testyang $
 */
$_LANG['anonymous'] = '匿名用户';
$_LANG['seller_commission'] = '店铺结算';  
$_LANG['commission_setup'] = '结算设置';

$_LANG['seller_bill_account'] = '【账单】%s';
$_LANG['seller_bill_settlement'] = '【%s】商家账单结算';
$_LANG['seller_bill_unfreeze'] = '【%s】商家账单解冻金额';

$_LANG['update_bill_failure'] = '账单更新失败';
$_LANG['update_bill_success'] = '账单更新成功';

$_LANG['apply_for_failure_time'] = '账单未出账，无法申请账单';
$_LANG['apply_for_failure'] = '账单申请失败';
$_LANG['apply_for_success'] = '账单申请成功';
$_LANG['trash_goods_confirm'] = '您确实要删除账单吗？';

$_LANG['commission_bill_detail'] = '账单明细';
$_LANG['commission_bill'] = '账单列表';
$_LANG['commission_model'] = '结算模式';

$_LANG['settlement_cycle'] = '账单结算周期';
$_LANG['cfg_range']['settlement_cycle']['0'] = '每天';
$_LANG['cfg_range']['settlement_cycle']['1'] = '1周（七天）';
$_LANG['cfg_range']['settlement_cycle']['2'] = '15天（半个月）';
$_LANG['cfg_range']['settlement_cycle']['3'] = '1个月';
$_LANG['cfg_range']['settlement_cycle']['4'] = '1个季度';
$_LANG['cfg_range']['settlement_cycle']['5'] = '6个月';
$_LANG['cfg_range']['settlement_cycle']['6'] = '1年';
$_LANG['cfg_range']['settlement_cycle']['7'] = '按天数';

$_LANG['label_press_day_number'] = '按天数';

$_LANG['01_admin_settlement'] = "【%s】平台操作商家应结金额";
$_LANG['effective_favorable'] = '有效优惠';
$_LANG['freeze_status'] = '冻结状态';

$_LANG['commission'] = '结算';
$_LANG['category_model'] = '按分类比例';
$_LANG['seller_model'] = '按店铺比例';

/* 菜单 */
$_LANG['search_user'] = '搜索会员';
$_LANG['order_valid_total'] = '有效金额';
$_LANG['order_refund_total'] = '退款';
$_LANG['order_total'] = '订单有效总额';
$_LANG['order_start_time'] = '开始时间';  
$_LANG['order_end_time'] = '结束时间';
$_LANG['is_settlement_amount'] = '已结算订单金额';
$_LANG['no_settlement_amount'] = '未结算订单金额';
$_LANG['effective_amount_into'] = '有效结算';

$_LANG['brokerage_amount_list'] = '店铺结算';  
$_LANG['brokerage_order_list'] = '店铺订单列表';

$_LANG['add_suppliers_server'] = '设置商家结算';
$_LANG['edit_suppliers_server'] = '编辑商家结算';
$_LANG['suppliers_list_server'] = '店铺结算';
$_LANG['suppliers_bacth'] = '结算批量设置';

$_LANG['please_choose'] = '请选择...';
$_LANG['batch_remove'] = '批量删除';
$_LANG['batch_closed'] = '批量结算';

/* 列表页 */
$_LANG['suppliers_name'] = '会员名称';
$_LANG['suppliers_store'] = '店铺名称';
$_LANG['suppliers_company'] = '公司名称';
$_LANG['suppliers_address'] = '公司地址';
$_LANG['suppliers_contact'] = '联系方式'; 

$_LANG['suppliers_percent'] = '奖励金额';
$_LANG['suppliers_check'] = '状态';
$_LANG['suppliers_percent_list'] = '结算百分比列表'; 
$_LANG['export_all_suppliers'] = '导出表格'; //liu
$_LANG['export_merchant_commission'] = '导出商家结算表格'; //liu
$_LANG['is_settlement_amount'] = '已结算';//liu
$_LANG['no_settlement_amount'] = '未结算';//liu

/*批量操作*/
$_LANG['is not supported'] = '暂不支持此功能';  
$_LANG['no_order'] = '无可操作的订单!';  
$_LANG['batch_closed_success'] = '批量结算成功';  
$_LANG['choose_batch'] = '请选择您的操作!';  

/* 详情页 */
$_LANG['label_suppliers_server_desc'] = '结算描述：';
$_LANG['label_suppliers_percent'] = '应结百分比：';

/* 系统提示 */
$_LANG['continue_add_server_suppliers'] = '继续设置商家结算';
$_LANG['back_suppliers_server_list'] = '返回结算设置';
$_LANG['suppliers_server_ok'] = '设置商家结算成功';
$_LANG['batch_drop_ok'] = '批量删除成功';
$_LANG['batch_drop_no'] = '批量删除失败';
$_LANG['suppliers_edit_fail'] = '名称修改失败';
$_LANG['no_record_selected'] = '没有选择任何记录';

/* JS提示 */
$_LANG['js_languages']['no_suppliers_server_name'] = '没有设置商家结算';

//商家订单列表
$_LANG['order_sn'] = '订单编号';
$_LANG['order_time'] = '下单时间';
$_LANG['consignee'] = '收货人';
$_LANG['total_fee'] = '总金额';
$_LANG['order_amount'] = '应付金额';
$_LANG['return_amount'] = '退款金额';
$_LANG['all_status'] = '订单状态';
$_LANG['brokerage_amount'] = '应结金额';
$_LANG['all_brokerage_amount'] = '应结总金额';
$_LANG['all_drp_amount'] = '分销结算总额';
$_LANG['drp_comm'] = '分销结算';
$_LANG['is_brokerage_amount'] = '已结算金额';
$_LANG['no_brokerage_amount'] = '未结算金额';
$_LANG['all_order'] = '所有订单';
$_LANG['is_settlement'] = '已结算';
$_LANG['is_brokerage_amount'] = '已结';
$_LANG['no_brokerage_amount'] = '未结';
$_LANG['no_settlement'] = '未结算';

$_LANG['settlement_state'] = '结算状态';
$_LANG['percent_value'] = '结算百分比';

$_LANG['cs'][OS_UNCONFIRMED] = '待确认';
$_LANG['cs'][CS_AWAIT_PAY] = '待付款';
$_LANG['cs'][CS_AWAIT_SHIP] = '待发货';
$_LANG['cs'][CS_FINISHED] = '已完成';
$_LANG['cs'][PS_PAYING] = '付款中';
$_LANG['cs'][OS_CANCELED] = '取消';
$_LANG['cs'][OS_INVALID] = '无效';
$_LANG['cs'][OS_RETURNED] = '退货';
$_LANG['cs'][OS_SHIPPED_PART] = '部分发货';

/* 订单状态 */
$_LANG['os'][OS_UNCONFIRMED] = '未确认';
$_LANG['os'][OS_CONFIRMED] = '已确认';
$_LANG['os'][OS_CANCELED] = '<font color="red"> 取消</font>';
$_LANG['os'][OS_INVALID] = '<font color="red">无效</font>';
$_LANG['os'][OS_RETURNED] = '<font color="red">退货</font>';
$_LANG['os'][OS_SPLITED] = '已分单';
$_LANG['os'][OS_SPLITING_PART] = '部分分单';
$_LANG['os'][OS_RETURNED_PART] = '<font color="red">部分已退货</font>';

$_LANG['ss'][SS_UNSHIPPED] = '未发货';
$_LANG['ss'][SS_PREPARING] = '配货中';
$_LANG['ss'][SS_SHIPPED] = '已发货';
$_LANG['ss'][SS_RECEIVED] = '收货确认';
$_LANG['ss'][SS_SHIPPED_PART] = '已发货(部分商品)';
$_LANG['ss'][SS_SHIPPED_ING] = '发货中';

$_LANG['ps'][PS_UNPAYED] = '未付款';
$_LANG['ps'][PS_PAYING] = '付款中';
$_LANG['ps'][PS_PAYED] = '已付款';
$_LANG['refund']='退款';

//  by kong
$_LANG['handle_log'] = '操作日志';
$_LANG['admin_log']  = '操作人';
$_LANG['addtime']  = '操作时间';

$_LANG['not_settlement'] = '您已结算，钱已进入商家账户，不允许二次操作';
$_LANG['edit_order'] = '订单';

/* 微分销 */
$_LANG['all_drp_amount'] = '分销结算总额';
$_LANG['drp_comm'] = '分销结算';
$_LANG['is_brokerage_amount'] = '已结';
$_LANG['no_brokerage_amount'] = '未结';
/* 微分销 end */

$_LANG['suppliers_name_exist'] = '该商家已经设置结算';

/* 佣金订单导出 */
$_LANG['down']['order_sn'] = '订单编号';
$_LANG['down']['short_order_time'] = '下单时间';
$_LANG['down']['consignee_address'] = '收货人';
$_LANG['down']['total_fee'] = '总金额';
$_LANG['down']['shipping_fee'] = '运费';
$_LANG['down']['discount'] = '折扣';
$_LANG['down']['coupons'] = '优惠券';
$_LANG['down']['integral_money'] = '积分';
$_LANG['down']['bonus'] = '红包';
$_LANG['down']['return_amount_price'] = '退款金额';
$_LANG['down']['brokerage_amount_price'] = '有效分成金额';
$_LANG['down']['effective_amount_price'] = '订单状态';
$_LANG['down']['settlement_status'] = '应结金额';
$_LANG['down']['ordersTatus'] = '结算状态';
?>