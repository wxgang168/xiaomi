<?php

/**
 * ECSHOP 商品批量上传、修改
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: goods_batch.php 17217 2018-07-19 06:29:08Z liubo $
 */
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require('includes/lib_goods.php');
$smarty->assign('menus', $_SESSION['menus']);
$smarty->assign('action_type', "goods_warehouse_batch");
// $smarty->assign('menu_select',array('action' => '02_cat_and_goods', 'current' => 'discuss_circle'));
$smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => 'warehouse_batch'));
/* ------------------------------------------------------ */
//-- 批量上传
/* ------------------------------------------------------ */
 
if ($_REQUEST['act'] == 'add') {
    $smarty->assign('primary_cat', $_LANG['18_batch_manage']);
    /* 检查权限 */
    admin_priv('goods_manage');

    $goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;

    if ($goods_id > 0) {
        $smarty->assign('action_link', array('text' => $_LANG['goto_goods'], 'href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code='));
    }

    /* 取得可选语言 */
    $dir = opendir('../languages');
    $lang_list = array(
        'UTF8' => $_LANG['charset']['utf8'],
        'GB2312' => $_LANG['charset']['zh_cn'],
        'BIG5' => $_LANG['charset']['zh_tw'],
    );
    $download_list = array();
    while (@$file = readdir($dir)) {
        if ($file != '.' && $file != '..' && $file != ".svn" && $file != "_svn" && is_dir('../languages/' . $file) == true) {
            $download_list[$file] = sprintf($_LANG['download_file'], isset($_LANG['charset'][$file]) ? $_LANG['charset'][$file] : $file);
        }
    }
    @closedir($dir);
    $smarty->assign('lang_list', $lang_list);
    $smarty->assign('download_list', $download_list);
    $smarty->assign('goods_id', $goods_id);

    $goods_date = array('goods_name');
    $where = "goods_id = '$goods_id'";
    $goods_name = get_table_date('goods', $where, $goods_date, 2);
    $smarty->assign('goods_name', $goods_name);

    /* 参数赋值 */
    $ur_here = $_LANG['13_batch_add'];
    $smarty->assign('ur_here', $ur_here);
    

    /* 显示模板 */
    assign_query_info();
    $smarty->assign('current', 'warehouse_batch');
    $smarty->display('goods_warehouse_batch_add.dwt');
}

/* ------------------------------------------------------ */
//-- 批量上传：处理
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'upload') {
    /* 检查权限 */
    admin_priv('goods_manage');
    
    $goods_id = isset($_REQUEST['goods_id']) && !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;

    //ecmoban模板堂 --zhuo start 仓库
    if ($_FILES['file']['name']) {
        $line_number = 0;
        $arr = array();
        $goods_list = array();
        $field_list = array_keys($_LANG['upload_warehouse']); // 字段列表
        $_POST['charset'] = 'GB2312';
        $data = file($_FILES['file']['tmp_name']);

        if (count($data) > 0) {
            foreach ($data AS $line) {
                // 跳过第一行
                if ($line_number == 0) {
                    $line_number++;
                    continue;
                }

                // 转换编码
                if (($_POST['charset'] != 'UTF8') && (strpos(strtolower(EC_CHARSET), 'utf') === 0)) {
                    $line = ecs_iconv($_POST['charset'], 'UTF8', $line);
                }

                // 初始化
                $arr = array();
                $buff = '';
                $quote = 0;
                $len = strlen($line);
                for ($i = 0; $i < $len; $i++) {
                    $char = $line[$i];

                    if ('\\' == $char) {
                        $i++;
                        $char = $line[$i];

                        switch ($char) {
                            case '"':
                                $buff .= '"';
                                break;
                            case '\'':
                                $buff .= '\'';
                                break;
                            case ',';
                                $buff .= ',';
                                break;
                            default:
                                $buff .= '\\' . $char;
                                break;
                        }
                    } elseif ('"' == $char) {
                        if (0 == $quote) {
                            $quote++;
                        } else {
                            $quote = 0;
                        }
                    } elseif (',' == $char) {
                        if (0 == $quote) {
                            if (!isset($field_list[count($arr)])) {
                                continue;
                            }
                            $field_name = $field_list[count($arr)];
                            $arr[$field_name] = trim($buff);
                            $buff = '';
                            $quote = 0;
                        } else {
                            $buff .= $char;
                        }
                    } else {
                        $buff .= $char;
                    }

                    if ($i == $len - 1) {
                        if (!isset($field_list[count($arr)])) {
                            continue;
                        }
                        $field_name = $field_list[count($arr)];
                        $arr[$field_name] = trim($buff);
                    }
                }
                $goods_list[] = $arr;
            }

            $goods_list = get_goods_bacth_warehouse_list($goods_list, $goods_id);
            get_insert_bacth_warehouse($goods_list);
            
            $link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']);
            if ($goods_id) {
                $link[] = array('href' => 'goods.php?act=edit&goods_id=' .$goods_id. '&extension_code=', 'text' => $_LANG['03_goods_edit']);
                $link[] = array('href' => 'goods_warehouse_batch.php?act=add&goods_id=' . $goods_id, 'text' => $_LANG['back_warehouse_batch_list']);
            }else{
                $link[] = array('href' => 'goods_warehouse_batch.php?act=add', 'text' => $_LANG['back_warehouse_batch_list']);
            }
            
            sys_msg($_LANG['save_products'], 0, $link);
            exit;
        }
    }
}

/* ------------------------------------------------------ */
//-- 下载文件
/* ------------------------------------------------------ */ elseif ($_REQUEST['act'] == 'download') {
    /* 检查权限 */
    admin_priv('goods_manage');

    $goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;

    // 文件标签
    // Header("Content-type: application/octet-stream");
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    Header("Content-Disposition: attachment; filename=warehouse_info_list.csv");

    // 下载
    if ($_GET['charset'] != $_CFG['lang']) {
        $lang_file = '../languages/' . $_GET['charset'] . '/' . ADMIN_PATH . '/goods_warehouse_batch.php';
        if (file_exists($lang_file)) {
            unset($_LANG['upload_warehouse']);
            require($lang_file);
        }
    }
    if (isset($_LANG['upload_warehouse'])) {
        /* 创建字符集转换对象 */
        if ($_GET['charset'] == 'zh_cn' || $_GET['charset'] == 'zh_tw') {
            $to_charset = $_GET['charset'] == 'zh_cn' ? 'GB2312' : 'BIG5';
            $data = join(',', $_LANG['upload_warehouse']) . "\t\n";

            $goods_date = array('goods_name');
            $where = "goods_id = '$goods_id'";
            $goods_name = get_table_date('goods', $where, $goods_date, 2);

            $area_date = array('region_name');
            $where = "region_type = 0";
            $area_info = get_table_date('region_warehouse', $where, $area_date, 1);
            $area_info = get_list_download($goods_name, $area_info);

            if (count($area_info) > 0) {
                for ($i = 0; $i < count($area_info); $i++) {
                    $data .= join(',', array($area_info[$i]['goods_name'], $area_info[$i]['area_name'], $area_info[$i]['number'], $area_info[$i]['minnumber'], $area_info[$i]['price'], $area_info[$i]['promote_price'])) . "\t\n";
                }
            }

            echo ecs_iconv(EC_CHARSET, $to_charset, $data);
        } else {
            echo join(',', $_LANG['upload_warehouse']);
        }
    } else {
        echo 'error: $_LANG[upload_warehouse] not exists';
    }
}

function get_list_download($goods_name = '', $area_info = array()) {
    if (count($area_info) > 0) {
        $arr = array();

        for ($i = 0; $i < count($area_info); $i++) {
            $arr[$i]['goods_name'] = $goods_name;
            $arr[$i]['area_name'] = $area_info[$i]['region_name'];
            $arr[$i]['number'] = '';
            $arr[$i]['minnumber'] = '';
            $arr[$i]['price'] = '';
            $arr[$i]['promote_price'] = '';
            $arr[$i]['give_integral'] = '';
            $arr[$i]['rank_integral'] = '';
            $arr[$i]['pay_integral'] = '';
        }

        return $arr;
    } else {
        return array();
    }
}

?>