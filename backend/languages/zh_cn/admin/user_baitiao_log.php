<?php

/**
 * ECSHOP 白条管理语言项
 * ============================================================================
 * * 版权所有 2005-2017 上海商创网络科技有限公司，并保留所有权利。
 * 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: article.php 17217 2018-07-19 06:29:08Z liubo $
*/

$_LANG['bt_ur_here'] ='设置会员白条额度';
$_LANG['bt_list'] ='白条列表';
$_LANG['bt_details'] ='白条详情';
$_LANG['user_name'] = "会员名称";
$_LANG['financial_credit'] = "金融额度";
$_LANG['Credit_payment_days'] = '信用账期';
$_LANG['Suspended_term'] = "信用账期缓期期限";
$_LANG['user_baitiao_credit'] = "会员白条额度";
$_LANG['yes_delete_biaotiao'] = "你确定要删除该会员的会员白条吗？";
$_LANG['yes_delete_record'] = "你确定要删除该消费记录吗？";

$_LANG['total_amount'] = "总额度";
$_LANG['residual_amount'] = "剩余额度";
$_LANG['repayments_amount'] = "已还款总额";
$_LANG['pending_repayment_amount'] = "待还款总额";
$_LANG['baitiao_number'] = "白条数";

$_LANG['consumption_money'] = "消费记录";
$_LANG['billing_day'] = "消费记账日";
$_LANG['repayment_data'] = "客户还款日";
$_LANG['repayment_cycle'] = "还款周期";
$_LANG['order_amount'] = '应付金额';
$_LANG['conf_pay']     = "支付状态";

$_LANG['baitiao_by_stage']     = "白条分期";
$_LANG['order_refund']     = "已失效,订单已退款";
$_LANG['yuan_stage']     = "元/期";
$_LANG['stage']     = "期";
$_LANG['is_pay']    = '已付款';
$_LANG['dai_pay']   	= '待付款';

/*提示*/
$_LANG['notice_financial_credit'] = '元 如:3000元　(用户可支配的信用款额度)';
$_LANG['notice_Credit_payment_days'] = '天 如:30天　(会根据此值自动生成还款日期,到期未还款,用户将不能够用白条方式支付)';
$_LANG['notice_Suspended_term'] = "天 如:10天　(超过信用期限+该文本设置的天数总和后，用户将不能够下单)";

/* js 验证提示 */
$_LANG['confirm_bath'] = '你确定要删除所选的会员白条吗？';

/* 页面顶部操作提示 */
$_LANG['operation_prompt_content']['baitiao_list'][0] = '该页面展示了会员白条相关信息。';
$_LANG['operation_prompt_content']['baitiao_list'][1] = '可查看白条消费的订单信息，可设置白条额度等操作。';
$_LANG['operation_prompt_content']['baitiao_list'][2] = '可以输入会员名称关键字进行搜索。';

$_LANG['operation_prompt_content']['baitiao_log_list'][0] = '该页面展示白条消费订单信息。';
$_LANG['operation_prompt_content']['baitiao_log_list'][1] = '请谨慎操作白条信息。';
?>