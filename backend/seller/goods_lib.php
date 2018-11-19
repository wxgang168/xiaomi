<?php

/**
 * DSC 商品库管理程序
 * ============================================================================
 * * 版权所有 2005-2017 上海商创网络科技有限公司，并保留所有权利。
 * 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liu $
 * $Id: goods_lib.php 17217 2017-07-20 09:29:08 liu $
*/
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
require_once(ROOT_PATH . '/includes/cls_json.php');
$image = new cls_image($_CFG['bgcolor']);
$exc = new exchange($ecs->table('goods_lib'), $db, 'goods_id', 'goods_name');
$exc_extend = new exchange($ecs->table('goods_lib_extend'), $db, 'goods_id', 'extend_id');
$exc_gallery = new exchange($ecs->table('goods_lib_gallery'), $db, 'img_id', 'goods_id');

/* 管理员ID */
$admin_id = get_admin_id();

//ecmoban模板堂 --zhuo start
$adminru = get_admin_ru_id();
if($adminru['ru_id'] == 0){
        $smarty->assign('priv_ru',   1);
}else{
        $smarty->assign('priv_ru',   0);
}
$ru_id = $adminru['ru_id'];
$smarty->assign('review_goods',   $GLOBALS['_CFG']['review_goods']);
//ecmoban模板堂 --zhuo end

/*------------------------------------------------------ */
//-- 商品列表
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'list')
{
    admin_priv('goods_lib_list');
    
    get_del_goodsimg_null();
    get_del_goods_gallery();
    get_updel_goods_attr();

    $cat_id = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
    $code   = empty($_REQUEST['extension_code']) ? '' : trim($_REQUEST['extension_code']);
    $smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => '04_goods_lib_list'));
	$smarty->assign('primary_cat',     $_LANG['02_cat_and_goods']);

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['20_goods_lib']);

    $action_link = array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']);
    $smarty->assign('action_link',  $action_link);
    $smarty->assign('code',     $code);
    $smarty->assign('brand_list',   get_brand_list());
    $smarty->assign('store_brand',   get_store_brand_list()); //商家品牌
    $smarty->assign('intro_list',   get_intro_list());
    $smarty->assign('lang',         $_LANG);
    $smarty->assign('list_type',    $_REQUEST['act'] == 'list' ? 'goods' : 'trash');
    $smarty->assign('use_storage',  empty($_CFG['use_storage']) ? 0 : 1);

    $goods_list = lib_goods_list();
    $smarty->assign('goods_list',   $goods_list['goods']);
    $smarty->assign('filter',       $goods_list['filter']);
    $smarty->assign('record_count', $goods_list['record_count']);
    $smarty->assign('page_count',   $goods_list['page_count']);
    $smarty->assign('full_page',    1);
    
    /* 排序标记 */
    $sort_flag  = sort_flag($goods_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* 获取商品类型存在规格的类型 */
    $specifications = get_goods_type_specifications();
    $smarty->assign('specifications', $specifications);
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);
    
    $smarty->assign('nowTime', gmtime());
    
    //分页
	$page_count_arr = seller_page($goods_list,$_REQUEST['page']);
	$smarty->assign('page_count_arr',$page_count_arr);	
	
    set_default_filter(); //设置默认筛选
    
    $goods_list_type = get_goods_type_number($_REQUEST['act']);
    $smarty->assign('goods_list_type', $goods_list_type);
    
    $smarty->assign('cfg', $_CFG);
    $smarty->display('goods_lib_list.dwt');
}

/*------------------------------------------------------ */
//-- 排序、分页、查询
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
	check_authz_json('goods_lib_list');
    $code = empty($_REQUEST['extension_code']) ? '' : trim($_REQUEST['extension_code']);
    $goods_list = lib_goods_list();
    $smarty->assign('code',         $code);
    $smarty->assign('goods_list',   $goods_list['goods']);
    $smarty->assign('filter',       $goods_list['filter']);
    $smarty->assign('record_count', $goods_list['record_count']);
    $smarty->assign('page_count',   $goods_list['page_count']);
    $smarty->assign('use_storage',  empty($_CFG['use_storage']) ? 0 : 1);

    /* 排序标记 */
    $sort_flag  = sort_flag($goods_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* 获取商品类型存在规格的类型 */
    $specifications = get_goods_type_specifications();
    $smarty->assign('specifications', $specifications);
        
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);
    
    $smarty->assign('nowTime', gmtime());
	
    //分页
	$page_count_arr = seller_page($goods_list,$_REQUEST['page']);
	$smarty->assign('page_count_arr',$page_count_arr);		
	
	set_default_filter(); //设置默认筛选
	
    make_json_result($smarty->fetch('goods_lib_list.dwt'), '',
    array('filter' => $goods_list['filter'], 'page_count' => $goods_list['page_count']));
}

/* ------------------------------------------------------ */
//-- 商家导入商品库商品
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'seller_import') {
	check_authz_json('goods_lib_list');
    $json = new JSON;
    $result = array('error' => 0, 'message' => '','content' => '');
    $goods = array();
    $goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
	$sql = " SELECT goods_name FROM ".$ecs->table("goods_lib")." WHERE goods_id  = '$goods_id' ";
	$goods['goods_name'] = $db->getOne($sql);
	$goods['goods_id'] = $goods_id;
	
	$smarty->assign('goods', $goods);
    $result['content'] = $GLOBALS['smarty']->fetch('library/seller_import_list.lbi');
    
    die($json->encode($result));
}

/* ------------------------------------------------------ */
//-- 商家导入商品库商品执行程序
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'goods_import_action') {
	admin_priv('goods_lib_list');
	$lib_goods_id 	= isset($_POST['goods_id']) 		? intval($_POST['goods_id']) 		: 0;
	$goods_sn 		= isset($_POST['goods_sn']) 		? trim($_POST['goods_sn']) 			: 0;	
	$goods_number 	= isset($_POST['goods_number']) 	? intval($_POST['goods_number']) 	: 0;
	$store_best 	= isset($_POST['store_best']) 		? intval($_POST['store_best']) 		: 0;	//精品
	$store_new 		= isset($_POST['store_new']) 		? intval($_POST['store_new']) 		: 0;	//新品
	$store_hot 		= isset($_POST['store_hot']) 		? intval($_POST['store_hot']) 		: 0;	//热销
	$is_reality 	= isset($_POST['is_reality']) 		? intval($_POST['is_reality']) 		: 0;	//正品保证
	$is_return 		= isset($_POST['is_return'])		? intval($_POST['is_return']) 		: 0;	//包退服务
	$is_fast 		= isset($_POST['is_fast']) 			? intval($_POST['is_fast']) 		: 0;	//闪速配送
	$is_shipping 	= isset($_POST['is_shipping']) 		? intval($_POST['is_shipping']) 	: 0;	//免运费
	$is_on_sale 	= isset($_POST['is_on_sale']) 		? intval($_POST['is_on_sale']) 	: 0;	//上下架

    /* 检查货号是否重复 */
    if ($_POST['goods_sn'])
    {
        $sql = "SELECT COUNT(*) FROM " . $ecs->table('goods') .
                " WHERE goods_sn = '$_POST[goods_sn]' AND is_delete = 0 AND goods_id <> '$_POST[goods_id]'";
        if ($db->getOne($sql) > 0)
        {
            sys_msg($_LANG['goods_sn_exists'], 1, array(), false);
        }
    }
	
    /* 如果没有输入商品货号则自动生成一个商品货号 */
    if (empty($_POST['goods_sn']))
    {
        $max_id     = $is_insert ? $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$ecs->table('goods')) : $_REQUEST['goods_id'];
        $goods_sn   = generate_goods_sn($max_id);
    }
    else
    {
        $goods_sn   = trim($_POST['goods_sn']);
    }	
	
	$sql = " SELECT * FROM ".$ecs->table('goods_lib')." WHERE goods_id = '$lib_goods_id' ";
	$goods = $db->getRow($sql);
	if(!($db->getOne(" SELECT goods_id FROM ".$ecs->table('goods')." WHERE goods_id ='".$goods['lib_goods_id']."' AND user_id = '$ru_id' ")))
	{
		$goods_thumb = copy_img($goods['goods_thumb'], 'goods_thumb', $lib_goods_id);
		$goods_img = copy_img($goods['goods_img'], 'goods', $lib_goods_id);
		$original_img = copy_img($goods['original_img'], 'goods', $lib_goods_id);		

		$sql = "INSERT INTO " . $ecs->table('goods') .
				"(cat_id, user_id, goods_sn, bar_code, goods_name, goods_name_style, brand_id, goods_weight, market_price,".
				" cost_price, shop_price, keywords, goods_brief, goods_desc, desc_mobile, goods_thumb, goods_img, original_img, add_time, ".
				" goods_number, store_best, store_new, store_hot, is_shipping, is_on_sale, ".
				" is_real, extension_code, sort_order, goods_type, is_check, largest_amount, pinyin_keyword, from_seller ) " .
				" VALUES " .
				"('$goods[cat_id]', '$ru_id', '$goods_sn', '$goods[bar_code]', '$goods[goods_name]', '$goods[goods_name_style]', '$goods[brand_id]', '$goods[goods_weight]', '$goods[market_price]', ".
				" '$goods[cost_price]', '$goods[shop_price]', '$goods[keywords]', '$goods[goods_brief]', '$goods[goods_desc]', '$goods[desc_mobile]', '$goods[goods_thumb]', '$goods[goods_img]', '$goods[original_img]', '".gmtime()."', ".
				" '$goods_number', '$store_best', '$store_new', '$store_hot', '$is_shipping', '$is_on_sale', ".
				" '$goods[is_real]', '$goods[extension_code]', '$goods[sort_order]', '$goods[goods_type]', '$goods[is_check]', '$goods[largest_amount]', '$goods[pinyin_keyword]', '$goods[goods_from]' )";
		$db->query($sql);
		$goods_id = $db->insert_id();

		//插入商品扩展信息
		$extend_sql = "INSERT INTO " . $ecs->table('goods_extend') . "(`goods_id`, `is_reality`, `is_return`, `is_fast`) VALUES ('$goods_id','$is_reality','$is_return','$is_fast')";
        $db->query($extend_sql);
		
		$res = $db->getAll(" SELECT img_desc, img_url, thumb_url, img_original FROM ".$ecs->table('goods_lib_gallery')." WHERE goods_id = '$lib_goods_id' ");
		if($res){
			foreach($res as $k=>$v){
				$img_url 		= copy_img($v['img_url'], 'gallery', $goods_id);
				$thumb_url 		= copy_img($v['thumb_url'], 'gallery_thumb', $goods_id);
				$img_original 	= copy_img($v['img_original'], 'gallery', $goods_id);
				$sql = " INSERT INTO ".$ecs->table('goods_gallery').
						" ( goods_id, img_desc, img_url, thumb_url, img_original ) ".
						" VALUES ".
						" ( '$goods_id', '$v[img_desc]', '$img_url', '$thumb_url', '$img_original' ) ";	
				$db->query($sql);
			}
		}		
	}
	
	$link[] = array('text' => $_LANG['20_goods_lib'], 'href' => 'goods_lib.php?act=list&'.list_link_postfix());
	$link[] = array('text' => $_LANG['01_goods_list'], 'href' => 'goods.php?act=list');
	sys_msg($_LANG['import_success'], 0, $link);
}

/*------------------------------------------------------ */
//-- 商品库商品批量导入
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'batch')
{
    admin_priv('goods_lib_list');
	$smarty->assign('primary_cat',     $_LANG['02_cat_and_goods']);
    $smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => '04_goods_lib_list'));

    /* 模板赋值 */
    $smarty->assign('ur_here', $_LANG['20_goods_lib']);
	if($_POST['checkboxes']){
		$sql = " SELECT goods_id, goods_name FROM ".$ecs->table('goods_lib')." WHERE goods_id ".db_create_in($_POST['checkboxes']);	
		$goods_list = $db->getAll($sql);
		$smarty->assign('goods_list', $goods_list);
	}

    $smarty->display('goods_lib_batch.dwt');
}

/* ------------------------------------------------------ */
//-- 商家导入商品库商品执行程序
/* ------------------------------------------------------ */ 
elseif ($_REQUEST['act'] == 'batch_import') {
	admin_priv('goods_lib_list');
	$error = 0;
	// 循环更新每个商品
	if (!empty($_POST['goods_id']))
	{
		//检测填写的订单号是否有重复
		$array = array_values($_POST['goods_sn']);
		foreach($array as $key=>$val){
			unset($array[$key]);
			if(in_array($val,$array)){
				sys_msg('您输入了重复的货号，请重新填写！', 1, array(), false);
			}
		}
		
		foreach ($_POST['goods_id'] AS $goods_id)
		{
			$lib_goods_id 	= isset($goods_id) 							? intval($goods_id) 							: 0;
			$goods_sn 		= isset($_POST['goods_sn'][$goods_id]) 		? trim($_POST['goods_sn'][$goods_id]) 			: 0;	
			$goods_number 	= isset($_POST['goods_number'][$goods_id]) 	? intval($_POST['goods_number'][$goods_id]) 	: 0;
			$is_shipping 	= isset($_POST['is_shipping'][$goods_id]) 	? intval($_POST['is_shipping'][$goods_id]) 		: 0;	//免运费
			$is_on_sale 	= isset($_POST['is_on_sale'][$goods_id]) 	? intval($_POST['is_on_sale'][$goods_id]) 		: 0;	//上下架

			/* 检查货号是否重复 */
			if ($goods_sn)
			{
				$sql = "SELECT COUNT(*) FROM " . $ecs->table('goods') .
						" WHERE goods_sn = '$goods_sn' AND is_delete = 0 AND goods_id <> '$goods_id'";
				if ($db->getOne($sql) > 0)
				{
					sys_msg($_LANG['goods_sn_exists'], 1, array(), false);
				}
			}
			
			/* 如果没有输入商品货号则自动生成一个商品货号 */
			if (empty($goods_sn))
			{
				$max_id     = $is_insert ? $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$ecs->table('goods')) : $goods_id;
				$goods_sn   = generate_goods_sn($max_id);
			}
			else
			{
				$goods_sn   = trim($goods_sn);
			}	
			
			$sql = " SELECT * FROM ".$ecs->table('goods_lib')." WHERE goods_id = '$lib_goods_id' ";
			$goods = $db->getRow($sql);
            
			if(!($db->getOne(" SELECT goods_id FROM ".$ecs->table('goods')." WHERE goods_id ='$lib_goods_id' AND user_id = '$ru_id' ")))
			{
				$goods_thumb = copy_img($v['goods_thumb'], 'goods_thumb', $lib_goods_id);
				$goods_img = copy_img($v['goods_img'], 'goods', $lib_goods_id);
				$original_img = copy_img($v['original_img'], 'goods', $lib_goods_id);		
				$sql = "INSERT INTO " . $ecs->table('goods') .
						"(cat_id, user_id, goods_sn, bar_code, goods_name, goods_name_style, brand_id, goods_weight, market_price,".
						" cost_price, shop_price, keywords, goods_brief, goods_desc, desc_mobile, goods_thumb, goods_img, original_img, add_time, ".
						" goods_number, store_best, store_new, store_hot, is_shipping, is_on_sale, ".
						" is_real, extension_code, sort_order, goods_type, is_check, largest_amount, pinyin_keyword, from_seller ) " .
						" VALUES " .
						"('$goods[cat_id]', '$ru_id', '$goods_sn', '$goods[bar_code]', '$goods[goods_name]', '$goods[goods_name_style]', '$goods[brand_id]', '$goods[goods_weight]', '$goods[market_price]', ".
						" '$goods[cost_price]', '$goods[shop_price]', '$goods[keywords]', '$goods[goods_brief]', '$goods[goods_desc]', '$goods[desc_mobile]', '$goods[goods_thumb]', '$goods[goods_img]', '$goods[original_img]', '".gmtime()."', ".
						" '$goods_number', '$store_best', '$store_new', '$store_hot', '$is_shipping', '$is_on_sale', ".
						" '$goods[is_real]', '$goods[extension_code]', '$goods[sort_order]', '$goods[goods_type]', '$goods[is_check]', '$goods[largest_amount]', '$goods[pinyin_keyword]', '$goods[goods_from]' )";
				if(!$db->query($sql)){
					$error += 1;
				}
				$goods_id = $db->insert_id();

				//插入商品扩展信息
				$extend_sql = "INSERT INTO " . $ecs->table('goods_extend') . "(`goods_id`, `is_reality`, `is_return`, `is_fast`) VALUES ('$goods_id','$is_reality','$is_return','$is_fast')";
				$db->query($extend_sql);
				
				$res = $db->getAll(" SELECT img_desc, img_url, thumb_url, img_original FROM ".$ecs->table('goods_lib_gallery')." WHERE goods_id = '$lib_goods_id' ");
                if($res){
					foreach($res as $k=>$v){
						$img_url 		= copy_img($v['img_url'], 'gallery', $goods_id);
						$thumb_url 		= copy_img($v['thumb_url'], 'gallery_thumb', $goods_id);
						$img_original 	= copy_img($v['img_original'], 'gallery', $goods_id);
                        
						$sql = " INSERT INTO ".$ecs->table('goods_gallery').
								" ( goods_id, img_desc, img_url, thumb_url, img_original ) ".
								" VALUES ".
								" ( '$goods_id', '$v[img_desc]', '$img_url', '$thumb_url', '$img_original' ) ";	
						$db->query($sql);
					}
				}		
			}			
		}
	}
	
	$link[] = array('text' => $_LANG['20_goods_lib'], 'href' => 'goods_lib.php?act=list&'.list_link_postfix());
	$link[] = array('text' => $_LANG['01_goods_list'], 'href' => 'goods.php?act=list');
	if($error > 0){
		sys_msg($_LANG['import_success']."！包含错误数据".$error."条！", 0, $link);
	}else{
		sys_msg($_LANG['import_success'], 0, $link);		
	}
}

/*
* 复制商品图片
*/
function copy_img($image = '',$type = 'goods',$goods_id){
	if(stripos($image,"http://")!== false ||stripos($image,"https://")!== false){
        return $image;
    }
	$newname = '';
	
	$img_ext = substr($image, strrpos($image, '.'));
	$rand_name = gmtime() . sprintf("%03d", mt_rand(1,999));
    switch($type)
    {
        case 'goods':
            $img_name = $goods_id . '_G_' . $rand_name;
            break;
        case 'goods_thumb':
            $img_name = $goods_id . '_thumb_G_' . $rand_name;
            break;
        case 'gallery':
            $img_name = $goods_id . '_P_' . $rand_name;
            break;
        case 'gallery_thumb':
            $img_name = $goods_id . '_thumb_P_' . $rand_name;
            break;
        default:
            $img_name = $rand_name;
            break;
    }
	if($image){
		$img = ROOT_PATH. $image;
		$pos = strpos(basename($img), '.');
		$newname = dirname($img) . '/' . $img_name . $img_ext;
		
		//开启OSS 则先下载图片 否则拷贝图片
		if ($GLOBALS['_CFG']['open_oss'] == 1) {
			$bucket_info = get_bucket_info();
            $url = $bucket_info['endpoint']. $image; 	
			if (!file_exists(dirname($img))) {
                make_dir(dirname($img));
            }    
			get_http_basename($url, $newname, 1);				
		}
		elseif (!@copy($img, $newname)) 
		{
			return;
		}		
	}
    
	$new_name = str_replace(ROOT_PATH, '', $newname);
	get_oss_add_file(array($new_name));	
    return $new_name;	
}

?>