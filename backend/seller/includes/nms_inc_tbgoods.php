<?php

/**
 * 牛模式ECSHOP采集插件:http://niumos.com/(淘宝店：new-modle.taobao.com QQ：303441162)
 * ============================================================================
 * 版权所有 牛模式团队，并保留所有权利。
 * 网站地址: http://www.niumos.com；
 * ----------------------------------------------------------------------------
 * 作用说明:用户可以添加采集时写入ecs_goods数据表的自定义字段
 * 使用说明:
 * 1、请先在ecs_goods添加你的数据库自定义字段；
 * 2、然后再以下代码里添加写入字段代码。
 * ============================================================================
 * $Author: yxn $
 * $Id: nms_inc_tbgoods.php 17217 2016-01-12 yxn $
*/

	/*请在以下空白处添加要入库的字段（新增字段必须已经添加到数据库表：ecs_goods） ，如需修改某个字段，请重新给此字段赋值，格式：
	$item['xxxxx']=$abcd;                                           */
	
   			$adminru = get_admin_ru_id();
			$goods['user_id']=$adminru['ru_id'];
			if ($goods['user_id']==0)
				$goods['review_status'] =5;
			else
				$goods['review_status'] =1;
	
				$goods['sales_volume'] =$goods['volume'] ;

?>
