<?php

/**
 * 商创 可视化首页文件
 * ============================================================================
 * * 旺旺：ecshop2012版权所有，并保留所有权利。* 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: index.php 17217 2011-01-19 06:29:08Z 旺旺ecshop2012 $
*/

if (!$smarty->is_cached('homeindex.dwt', $cache_id) || $preview == 1)
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $position['title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
    $smarty->assign('flash_theme',     $_CFG['flash_theme']);  // Flash轮播图片模板

    $smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL

    $smarty->assign('warehouse_id',       $region_id);
    $smarty->assign('area_id',       $area_id);

    $smarty->assign('helps',           get_shop_help());       // 网店帮助

    /* 页面中的动态内容 */
    assign_dynamic('homeindex', $region_id, $area_id);

     /*重写图片链接*/
    $replace_data = array(
        'http://localhost/ecmoban_dsc2.0.5_20170518/',
        'http://localhost/ecmoban_dsc2.2.6_20170727/',
        'http://localhost/ecmoban_dsc2.3/'
    );

    //获取首页可视化模板
    $page = get_html_file($dir."/pc_html.php");
    $nav_page = get_html_file($dir.'/nav_html.php');
    $topBanner = get_html_file($dir.'/topBanner.php');

    $topBanner = str_replace($replace_data, $ecs->url(), $topBanner);
    $page = str_replace($replace_data, $ecs->url(), $page);

    //OSS文件存储ecmoban模板堂 --zhuo start
    if ($GLOBALS['_CFG']['open_oss'] == 1) {
        $bucket_info = get_bucket_info();
        $endpoint = $bucket_info['endpoint'];
    } else {
        $endpoint = !empty($GLOBALS['_CFG']['site_domain']) ? $GLOBALS['_CFG']['site_domain'] : '';
    }

    if ($page && $endpoint) {
        $desc_preg = get_goods_desc_images_preg($endpoint, $page);
        $page = $desc_preg['goods_desc'];
    }
    if ($topBanner && $endpoint) {
        $desc_preg = get_goods_desc_images_preg($endpoint, $topBanner);
        $topBanner = $desc_preg['goods_desc'];
    }
    //OSS文件存储ecmoban模板堂 --zhuo end
    $user_id = !empty($_SESSION['user_id'])  ?  $_SESSION['user_id'] : 0;

    if (!defined('THEME_EXTENSION')) {
        $categories_pro = get_category_tree_leve_one();
        $smarty->assign('categories_pro', $categories_pro); // 分类树加强版
    }

    $pc_page['tem'] = $suffix;
    $smarty->assign('pc_page',       $pc_page);
    $smarty->assign('nav_page',       $nav_page);
    $smarty->assign('page',       $page);
    $smarty->assign('topBanner',       $topBanner);
    $smarty->assign('user_id',       $user_id);

    $smarty->assign('site_domain',$_CFG['site_domain']);
}

$bonusadv = getleft_attr("bonusadv", 0, $suffix, $GLOBALS['_CFG']['template']);

if ($bonusadv['img_file']) {
    $bonusadv['img_file'] = get_image_path(0, $bonusadv['img_file']);

    if (strpos($bonusadv['img_file'], $_COOKIE['index_img_file']) !== false) {
        if ($_COOKIE['bonusadv'] == 1) {
            $bonusadv['img_file'] = '';
        } else {
            if ($bonusadv['img_file']) {
                setcookie('bonusadv', 1, gmtime() + 3600 * 10, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
                setcookie('index_img_file', $bonusadv['img_file'], gmtime() + 3600 * 10, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
            }
        }
    } else {
        setcookie('bonusadv', 1, gmtime() + 3600 * 10, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
        setcookie('index_img_file', $bonusadv['img_file'], gmtime() + 3600 * 10, $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
    }
}

$smarty->assign('bonusadv', $bonusadv);
if ($preview == 1) {
    $smarty->display('homeindex.dwt');
} else {
    $smarty->display('homeindex.dwt', $cache_id);
}

