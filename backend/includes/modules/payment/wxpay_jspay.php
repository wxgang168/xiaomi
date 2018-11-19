<?php
/**
 * ECSHOP 微信支付
 * ============================================================================
 * 版权所有 2014 上海商创网络科技有限公司，并保留所有权利。
 * 网站地址: http://lvruanjian.taobao.com；
 * ============================================================================
 * $Author: z1988.com $
 * $Id: upop_wap.php 17063 2010-03-25 06:35:46Z douqinghua $
 */


// 包含配置文件
$payment_lang = ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/payment/'. basename(__FILE__);

if (file_exists($payment_lang)) {
    global $_LANG;

    include_once($payment_lang);
}


/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE) {
    $i = isset($modules) ? count($modules) : 0;
    /* 代码 */
    $modules[$i]['code'] = basename(__FILE__, '.php');
    /* 描述对应的语言项 */
    $modules[$i]['desc'] = 'wxpay_jspay_desc';
    /* 是否支持货到付款 */
    $modules[$i]['is_cod'] = '0';
    /* 是否支持在线支付 */
    $modules[$i]['is_online'] = '1';
    /* 作者 */
    $modules[$i]['author'] = 'tb.z1988.com';
    /* 网址 */
    $modules[$i]['website'] = 'http://tb.z1988.com/';
    /* 版本号 */
    $modules[$i]['version'] = '3.3';
    /* 配置信息 */
    $modules[$i]['config'] = array(
        // 微信公众号身份的唯一标识
        array(
            'name' => 'wxpay_jspay_appid',
            'type' => 'text',
            'value' => ''
        ),
        // JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
        array(
            'name' => 'wxpay_jspay_appsecret',
            'type' => 'text',
            'value' => ''
        ),
        // 商户支付密钥Key
        array(
            'name' => 'wxpay_jspay_key',
            'type' => 'text',
            'value' => ''
        ),
        // 受理商ID
        array(
            'name' => 'wxpay_jspay_mchid',
            'type' => 'text',
            'value' => ''
        )
    );
    
    return;
}


/**
 * 微信支付类
 */
class wxpay_jspay
{
	private $dir  ;
	private $site_url;



	
	/**
     * 生成支付代码
     * @param   array   $order  订单信息
     * @param   array   $payment    支付方式信息
     */
	function get_code($order, $payment)
	{
		
		return '';
		
	}
	

    function respond()
    {
		
		return false;
		
    }

}
?>