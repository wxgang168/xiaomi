<?php
/**
 * ECSHOP 微信扫码支付
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: douqinghua $
 * $Id: unionpay.php 17063 2015-08-006Z z1988.com $
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

		
// 包含配置文件
$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/wxpay_native.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'wxpay_native_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'z1988.com';

    /* 网址 */
    $modules[$i]['website'] = 'http://tb.z1988.com';

    /* 版本号 */
    $modules[$i]['version'] = '3.3.0';

    /* 配置信息 */
       $modules[$i]['config'] = array(
        // 微信公众号身份的唯一标识
        array(
            'name' => 'wxpay_native_appid',
            'type' => 'text',
            'value' => ''
        ),
        // JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
        array(
            'name' => 'wxpay_native_appsecret',
            'type' => 'text',
            'value' => ''
        ),
        // 商户支付密钥Key
        array(
            'name' => 'wxpay_native_key',
            'type' => 'text',
            'value' => ''
        ),
        // 受理商ID
        array(
            'name' => 'wxpay_native_mchid',
            'type' => 'text',
            'value' => ''
        )
    );

    return;
}

require_once ( dirname(__FILE__).'/wxpay/WxPay.Config.php' );
require_once ( dirname(__FILE__).'/wxpay/WxPay.Api.php' );
require_once ( dirname(__FILE__).'/wxpay/WxPay.Notify.php' );
require_once ( dirname(__FILE__).'/wxpay/WxPay.PayNotifyCallBack.php' );
require_once ( dirname(__FILE__).'/wxpay/log.php' );

/**
 * 类
 */
class wxpay_native
{
	private $dir  ;
	private $site_url;


	function _config( $payment )
	{
		WxPayConfig::set_appid( $payment['wxpay_native_appid'] );
		WxPayConfig::set_mchid( $payment['wxpay_native_mchid'] );
		WxPayConfig::set_key( $payment['wxpay_native_key'] );
		WxPayConfig::set_appsecret( $payment['wxpay_native_appsecret']);	
	}
	
	/**
     * 生成支付代码
     * @param   array   $order  订单信息
     * @param   array   $payment    支付方式信息
     */
	function get_code($order, $payment)
	{
		
		$this->_config($payment);
		$root_url = str_replace('/seller/', '/', $GLOBALS['ecs']->url());
		$notify_url = $root_url.'wxpay_native_notify.php';
		
		$out_trade_no = $order['order_sn'].'O'.$order['log_id'] .'O'.(date('is'));
		
		$body = $order['order_sn'];
		
		$sql = "select * from " . $GLOBALS['ecs']->table('pay_log') . "  WHERE log_id = '". $order['log_id'] ."' ";
		$pay_log = $GLOBALS['db']->getRow($sql);		
		if (!empty( $pay_log ) ){
			if ( $pay_log['order_type'] == 0 ){
				//$sql = "select goods_name from " . $GLOBALS['ecs']->table('order_goods') . "  WHERE order_id = '". $pay_log['order_id'] ."' ";
				//$body = $GLOBALS['db']->getOne($sql);
				//$body = $this->msubstr($body,0, 20);
				$body = '购物订单号：'.$order['order_sn']	;	
			}
			elseif ( $pay_log['order_type'] == 1 ){
				$body = '在线充值';
			}
		}

		$input = new WxPayUnifiedOrder();
		$input->SetBody( $body );
		$input->SetAttach( $order['log_id'] );		//商户支付日志
		$input->SetOut_trade_no( $out_trade_no );		//商户订单号 
		$input->SetTotal_fee( strval(($order['order_amount']*100)) ); //总金额
		$input->SetTime_start(date("YmdHis"));
		//$input->SetTime_expire(date("YmdHis", time() + 600));
		//$input->SetGoods_tag("test");
		$input->SetNotify_url( $notify_url );	//通知地址 
		$input->SetTrade_type("NATIVE");	//交易类型
		$input->SetProduct_id( $order['order_sn'] );

		$result = $this->GetPayUrl($input);
		$url2 = null;
		$error = '出错了'; 
		if ( empty( $result ) ){
			return $this->return_error($error);
		}
		if( $result["return_code"] == 'FAIL'){
			return  $this->return_error($result["return_msg"]);

		}
		if( $result["result_code"] == 'FAIL'){
			return  $this->return_error($result["err_code_des"]);		
		}
		$url2 = $result["code_url"];
		
		if ( empty( $result["code_url"] ) ){
			return  $this->return_error($error);
		}	
		
	        $url2 = $result["code_url"];
			
            $html = '<div class="wx_qrcode" style="text-align:center">';
			$html .= "</div>";
            //$html .= $this->getcode($code_url);
			$img = '<img alt="扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data='.urlencode($url2).'" style=""/>';
   
			$img = $this->getcode($url2,$out_trade_no);

            $html = '<div id="z1988comDialog" style="display:none;"><div id="wxpay_z1988comdialog"><div style="text-align:center" id="z1988conmQrcode"><p>微信扫一扫，立即支付</p><div>'. $img .'</div></div><div id="z1988comWxPhone"></div><div style="clear:both"></div></div></div>';
			
			
			
			$html .='<script type="text/javascript">
				function get_wxpayz1988com_status( id ){
					if( false && typeof(Ajax)== "object" ){
						Ajax.call("'. $root_url .'wxpay_native_query.php", "id="+id, return_wxpay_order_status_z1988com, "GET", "JSON");
					}else{
						jQuery.get("'. $root_url .'wxpay_native_query.php", "id="+id,function( result ){
							if ( result.error == 0 && result.is_paid == 1 ){
								window.location.href = result.url;
							}
						}, "json");
					}	
				}
				function return_wxpay_order_status_z1988com(  result ){
					if ( result.error == 0 && result.is_paid == 1 ){
						window.location.href = result.url;
					}
				}
				window.setInterval(function(){ get_wxpayz1988com_status("'. $order['log_id'] .'"); }, 2000); 
				$(function(){
					//微信扫码
					$("#pay_wxpayZ1988com").on("click",function(){
						var content = $("#z1988comDialog").html();
						pb({
							id: "scanCode",
							title: "",
							width: 726,
							content: content,
							drag: true,
							foot: false,
							cl_cBtn: false,
							cBtn: false
						});
					});
					if ( typeof(pb) !== "function" ){
						$("#z1988comDialog").show();
					}
				});
				
			</script>';
			$html .='<style>#wxpay_z1988comdialog{width:645px;margin:0 auto;}#z1988comWxPhone{float:left;width:320px;height:421px;padding-left:50px;background:url('. $root_url .'includes/modules/payment/wxpay/z1988com-phone-bg.png) 50px 0 no-repeat}#z1988conmQrcode{display:block;float:left;margin-top:30px}#z1988conmQrcode img{height:259px;width:259px;padding:5px;border:1px solid #ddd}#z1988conmQrcode p{padding:15px 0;background:#157058;color:#fff;margin:10px 0}</style>';

         return '<a href="javascript:;" id="pay_wxpayZ1988com" style="display:block;"><img src="'. $root_url .'includes/modules/payment/wxpay/wxpay-icon.png" alt="'. $GLOBALS['_LANG']['wxpay_native']  .'"></a>'.$html;
	}
	
	function respond()
	{
		return true;
	}
	
	/**
	 * 字符串截取，支持中文和其他编码
	 * @static
	 * @access public
	 * @param string $str 需要转换的字符串
	 * @param string $start 开始位置
	 * @param string $length 截取长度
	 * @param string $charset 编码格式
	 * @param string $suffix 截断显示字符
	 * @return string
	 */
	function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
		if(function_exists("mb_substr"))
			$slice = mb_substr($str, $start, $length, $charset);
		elseif(function_exists('iconv_substr')) {
			$slice = iconv_substr($str,$start,$length,$charset);
		}else{
			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
			$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
			$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
			preg_match_all($re[$charset], $str, $match);
			$slice = join("",array_slice($match[0], $start, $length));
		}
		return $suffix ? $slice.'...' : $slice;
	}

	
	function return_error( $error ){
		$root_url = str_replace('mobile/', '', $GLOBALS['ecs']->url());
		$html = '<a id="pay_wxpayz1988com"  onclick="javascript:alert(\''. $error .'\')" style="display:block;"><img src="'. $root_url .'includes/modules/payment/wxpay/wxpay-icon.png" alt="'. $GLOBALS['_LANG']['wxpay_native']  .'"></a>';
		return $html;
	}
	
    function notify()
    {
		$payment  = get_payment('wxpay_native');
		$this->_config($payment);

		$lib_path	= dirname(__FILE__).'/wxpay/';
		$logHandler= new CLogFileHandler($lib_path."logs/".date('Y-m-d').'.log');
		$log = Log::Init($logHandler, 15);
		
		Log::DEBUG("begin notify");
		$notify = new PayNotifyCallBack( );
		$notify->Handle(true);
		
		$data = $notify->data;
		
		//判断签名
			if ($data['result_code'] == 'SUCCESS') {
				
					$transaction_id = $data['transaction_id'];
				 // 获取log_id
                    $out_trade_no	= explode('O', $data['out_trade_no']);
                    $order_sn		= $out_trade_no[0];
					$log_id			= (int)$out_trade_no[1]; // 订单号log_id
					$payment_amount = $data['total_fee']/100;
					$openid			= $data['openid'];
	
					
					/* 检查支付的金额是否相符 */
					if (!check_money($log_id, $payment_amount))
					{
						 echo 'fail';
						 exit();
					}
					$sql = "update  " . $GLOBALS['ecs']->table('pay_log') . " set openid='$openid',transid='$transaction_id' WHERE log_id = '$log_id' ";
					//$GLOBALS['db']->query($sql);		
						
					$action_note = 'result_code' . ':' 
					. $data['result_code']
					. ' return_code:'
					. $data['return_code']
					. ' orderId:'
					. $data['out_trade_no']		
					. ' openid:'
					. $data['openid']
					. ' '.$GLOBALS['_LANG']['wxpay_native_transaction_id'] . ':' 
					. $transaction_id;
					// 完成订单。
					order_paid($log_id, PS_PAYED, $action_note);
					return true;
			}else{
				 echo 'fail';
			}
			
		return false;
		
    }


    function getcode($url, $out_trade_no){
        if(file_exists(ROOT_PATH . 'includes/phpqrcode/phpqrcode.php')){
            include_once(ROOT_PATH . 'includes/phpqrcode/phpqrcode.php');
        }elseif(file_exists(ROOT_PATH . 'includes/phpqrcode.php')){
            include_once(ROOT_PATH . 'includes/phpqrcode.php');
        }
        // 纠错级别：L、M、Q、H 
        $errorCorrectionLevel = 'Q';  
        // 点的大小：1到10 
        $matrixPointSize = 7;
        // 生成的文件名
        $tmp = ROOT_PATH .'images/qrcode/';
        if(!is_dir($tmp)){
            @mkdir($tmp);
        }
        $filename = $tmp . $errorCorrectionLevel . $matrixPointSize .$out_trade_no. '.png';
        QRcode::png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		
		$root_url = str_replace('/seller/', '/', $GLOBALS['ecs']->url());
		
        return '<img src="'.$root_url. 'images/qrcode/'.basename($filename).'" />';
    }
    
    function log($file,$txt)
    {
       $fp =  fopen($file,'ab+');
       fwrite($fp,'-'.local_date('Y-m-d H:i:s').'---');
       fwrite($fp,$txt);
       fwrite($fp,"\r\n");
       fclose($fp);
    }
	
/**
	 * 
	 * 生成扫描支付URL,模式一
	 * @param BizPayUrlInput $bizUrlInfo
	 */
	public function GetPrePayUrl($productId)
	{
		$biz = new WxPayBizPayUrl();
		$biz->SetProduct_id($productId);
		$values = WxpayApi::bizpayurl($biz);
		$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
		return $url;
	}
	
	/**
	 * 
	 * 参数数组转换为url参数
	 * @param array $urlObj
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			$buff .= $k . "=" . $v . "&";
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	public function GetPayUrl($input)
	{
		if($input->GetTrade_type() == "NATIVE")
		{
			$result = WxPayApi::unifiedOrder($input);
			return $result;
		}
	}
	

}

?>