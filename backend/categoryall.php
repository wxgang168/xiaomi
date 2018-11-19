<?php

/**
 * ECSHOP 文章内容
 * ============================================================================
 * 旺旺：ecshop2012版权所有，并保留所有权利。* 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: article.php 17069 2010-03-26 05:28:01Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

require(ROOT_PATH . '/includes/lib_area.php');  //旺旺ecshop2012--zuo

//旺旺ecshop2012--zuo start
$area_info = get_area_info($province_id);
$area_id = $area_info['region_id'];

$where = "regionId = '$province_id'";
$date = array('parent_id');
$region_id = get_table_date('region_warehouse', $where, $date, 2);
//旺旺ecshop2012--zuo end

/*------------------------------------------------------ */
//-- PROCESSOR
/*------------------------------------------------------ */

$cache_id = sprintf('%X', crc32($_REQUEST['id'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('category_all.dwt', $cache_id))
{
    $position = assign_ur_here(0, $_LANG['all_category']);

    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置
    
    for($i=1;$i<=$_CFG['auction_ad'];$i++){
        $category_all_left .= "'category_all_left".$i.","; //左边广告位
        $category_all_right .= "'category_all_right".$i.","; //左边广告位
    }
    
    $smarty->assign('category_all_left',  $category_all_left);
    $smarty->assign('category_all_right',  $category_all_right);
    
    $categories_list = get_category_tree_leve_one(0, 1);
    $smarty->assign('categories_list',  $categories_list);
    
    $categories_pro = get_category_tree_leve_one();
    $smarty->assign('categories_pro', $categories_pro); // 分类树加强版

    $top_goods = get_top10(0, '', 0, $region_id, $area_id);
    $smarty->assign('top_goods',       $top_goods);           // 销售排行
    $smarty->assign('helps',           get_shop_help());       // 网店帮助
        
    assign_dynamic('category_all');
    assign_template('c', $catlist);
}

$smarty->display('category_all.dwt', $cache_id);



/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

?>