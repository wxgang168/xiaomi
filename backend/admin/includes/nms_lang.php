<?php

/**
 * 牛模式ECSHOP采集插件:http://niumos.com/(淘宝店：new-modle.taobao.com QQ：303441162)
 * ============================================================================
 * 版权所有 牛模式团队，并保留所有权利。
 * 网站地址: http://www.niumos.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: yxn $
 * $Id: nms_menu.php 17217 2016-01-12 yxn $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
/*------------------------------------------------------ */
//-- 语言项
/*------------------------------------------------------ */

/*淘宝管理*/
$_LANG['02_taobao'] 				= '淘宝数据采集';

$_LANG['17_3setting'] 				= '<font style="color:#0066FF">采集设置</font>';
$_LANG['17_3onekey'] 				= '<font style="color:#0066FF">按分类采集</font>';
$_LANG['17_1others'] 				= '<font style="color:#0066FF">常规采集</font>';
$_LANG['17_1nms_tbk_api'] 			= '<font style="color:#0066FF">淘客API采集</font>';
$_LANG['17_2oalmm'] 				= '<font style="color:#0066FF">店铺采集</font>';
$_LANG['17_20oalmm'] 				= '<font style="color:#0066FF">批量ID采集</font>';
$_LANG['17_200oalmm'] 				= '<font style="color:#0066FF">常规采集</font>';
$_LANG['17_1single'] 				= '<font style="color:#0066FF">单品采集</font>';
$_LANG['17_2collect'] 				= '<font style="color:#0066FF">批量采集</font>';
$_LANG['17_2jiu'] 					= '<font style="color:#0066FF">9.9包邮采集</font>';
$_LANG['17_3talmm'] 				= '<font style="color:#0066FF">工具箱</font>';
$_LANG['17_4adj_attr'] 				= '<font style="color:#0066FF">整理属性</font>';
$_LANG['17_4nmsinfo'] 					= '<font style="color:#0066FF">插件信息</font>';

/*阿里巴巴管理*/
$_LANG['03_albb'] 				= '阿里数据采集';
$_LANG['3_3setting'] 				= '<font style="color:#0066FF">采集设置</font>';
$_LANG['3_3onekey'] 				= '<font style="color:#0066FF">按分类采集</font>';
$_LANG['3_3search'] 				= '<font style="color:#0066FF">搜索页采集</font>';
$_LANG['3_2oalmm'] 					= '<font style="color:#0066FF">店铺采集</font>';
$_LANG['3_20oalmm'] 				= '<font style="color:#0066FF">批量ID采集</font>';
$_LANG['3_200oalmm'] 				= '<font style="color:#0066FF">常规采集</font>';
$_LANG['3_4tools'] 					= '<font style="color:#0066FF">工具箱</font>';
$_LANG['3_4nmsinfo'] 				= '<font style="color:#0066FF">插件信息</font>';

/*阿里国际采集*/
$_LANG['03_alwd'] 				= '阿里国际采集';
$_LANG['5_3setting'] 				= '<font style="color:#0066FF">采集设置</font>';
$_LANG['5_3onekey'] 				= '<font style="color:#0066FF">按分类采集</font>';
$_LANG['5_3search'] 				= '<font style="color:#0066FF">搜索页采集</font>';
$_LANG['5_2oalmm'] 					= '<font style="color:#0066FF">店铺采集</font>';
$_LANG['5_20oalmm'] 				= '<font style="color:#0066FF">单品采集</font>';
$_LANG['5_200oalmm'] 				= '<font style="color:#0066FF">关键词采集</font>';
$_LANG['5_4tools'] 					= '<font style="color:#0066FF">工具箱</font>';
$_LANG['5_4nmsinfo'] 				= '<font style="color:#0066FF">插件信息</font>';

//京东管理
$_LANG['03_jingdong'] 			= '京东数据采集';
$_LANG['4_6setting'] 				= '<font style="color:#0066FF">采集设置</font>';
$_LANG['4_5onekey'] 				= '<font style="color:#0066FF">按分类采集</font>';
$_LANG['4_1others'] 				= '<font style="color:#0066FF">关键词采集</font>';
$_LANG['4_4shop'] 					= '<font style="color:#0066FF">店铺采集</font>';
$_LANG['4_3batchid'] 				= '<font style="color:#0066FF">单品采集</font>';
$_LANG['4_7tools'] 					= '<font style="color:#0066FF">工具箱</font>';
$_LANG['4_8nmsinfo'] 					= '<font style="color:#0066FF">插件信息</font>';


/*商品列表*/
$_LANG['goods_thumb'] 		= '缩略图';
$_LANG['shop_title'] 		= '商铺名称';
$_LANG['commission_num'] 	= '商品来源';
$_LANG['commission_rate'] 	= '佣金比例';
$_LANG['commission'] 		= '佣金';
$_LANG['to_taobao'] 		= '去淘宝';
$_LANG['setting_ok'] 		= '采集设置已保存';

$_LANG[NULL] 		= '本地';
$_LANG[0] 			= '本地';
$_LANG[1] 			= '淘宝';
$_LANG[2] 			= '天猫';
$_LANG[100] 		= '阿里';
$_LANG[200] 		= 'albb';
$_LANG[300] 		= '京东';
$_LANG['tag'][1] 	= 'shops';
$_LANG['tag'][2] 	= 'shops';
$_LANG['tag'][100] 	= 'albbshops';
$_LANG['tag'][200] 	= 'alwdshops';
$_LANG['tag'][300] 	= 'jdshops';

//牛模式采集插件:http://niumos.com/(淘宝店：new-modle.taobao.com QQ：303441162)-end
?>
