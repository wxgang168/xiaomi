<?php

/**
 * ECSHOP 首页文件
 * ============================================================================
 * * 旺旺：ecshop2012版权所有，并保留所有权利。* 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z 旺旺ecshop2012 $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

require(ROOT_PATH . '/includes/lib_area.php');  //旺旺ecshop2012--zuo

$article_id = isset($_REQUEST['id'])  ? intval($_REQUEST['id']) : $_CFG['marticle_id'];

/*------------------------------------------------------ */
//-- 判断是否存在缓存，如果存在则调用缓存，反之读取相应内容
/*------------------------------------------------------ */
/* 缓存编号 */
$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('merchants.dwt'))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置
    
    $categories_pro = get_category_tree_leve_one();
    $smarty->assign('categories_pro',  $categories_pro); // 分类树加强版
//	print_arr($categories_pro);
    //旺旺ecshop2012--zuo start

    $marticle = explode(',',$_CFG['marticle']);

    $article_menu1 = get_merchants_article_menu($marticle[0]);
    $article_menu2 = get_merchants_article_menu($marticle[1]);

    $article_info = get_merchants_article_info($article_id);

    for($i=1;$i<=$_CFG['auction_ad'];$i++){
            $ad_arr .= "'merch".$i.",";
    }
    if (defined('THEME_EXTENSION')){
        
        for($i=1;$i<=$_CFG['auction_ad'];$i++){
                $merchants_index_top .= "'merchants_index_top".$i.",";//入驻首页头部广告
                $merchants_index_category_ad .= "'merchants_index_category_ad".$i.",";//入驻首页类目广告
                $merchants_index_case_ad .= "'merchants_index_case_ad".$i.",";//入驻首页类目广告
        }
        $smarty->assign('merchants_index_case_ad',       $merchants_index_case_ad);
        $smarty->assign('merchants_index_category_ad',       $merchants_index_category_ad);
        $smarty->assign('merchants_index_top',       $merchants_index_top); // 分类广告位
        if (isset($_CFG['marticle_index']) && !empty($_CFG['marticle_index'])) {
            $sql = "SELECT title,description,article_id FROM" . $ecs->table("article") . " WHERE is_open = 1 AND article_id IN (" . $_CFG['marticle_index'] . ")";
            $articles_imp = $db->getAll($sql);
            $smarty->assign('articles_imp', $articles_imp);
        }
    }
    $smarty->assign('adarr',       $ad_arr); // 分类广告位
    $smarty->assign('article',         $article_info);  // 文章内容
    $smarty->assign('article_menu1',         $article_menu1);  // 文章列表
    $smarty->assign('article_menu2',         $article_menu2);  // 文章列表
    $smarty->assign('article_id',         $article_id);  // 文章ID
    $smarty->assign('marticle',         $marticle[0]); 
    //旺旺ecshop2012--zuo end
    if (defined('THEME_EXTENSION')){
        $user_id = isset($_SESSION['user_id'])  ?  $_SESSION['user_id'] : 0;
        $smarty->assign('user_id',       $user_id);
		/* 区分入驻页面样式 */
		$smarty->assign('footer', 2);
	}
    $smarty->assign('helps',      get_shop_help());       // 网店帮助
   
    /* 页面中的动态内容 */
    assign_dynamic('merchants');
}

$smarty->display('merchants.dwt');

?>