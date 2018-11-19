<?php

/**
 * ECSHOP 商品类型管理程序
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: goods_type.php 17217 2018-07-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

$exc = new exchange($ecs->table("goods_type"), $db, 'cat_id', 'cat_name');
$exc_cat = new exchange($ecs->table("goods_type_cat"), $db, 'cat_id', 'cat_name');
//ecmoban模板堂 --zhuo start
$adminru = get_admin_ru_id();
if($adminru['ru_id'] == 0){
        $smarty->assign('priv_ru',   1);
}else{
        $smarty->assign('priv_ru',   0);
}
//ecmoban模板堂 --zhuo end

/*------------------------------------------------------ */
//-- 管理界面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'manage') {
    assign_query_info();

    $smarty->assign('ur_here', $_LANG['08_goods_type']);
    $smarty->assign('full_page', 1);

    $good_type_list = get_goodstype($adminru['ru_id']);
    $good_in_type = '';

    $smarty->assign('goods_type_arr', $good_type_list['type']);
    $smarty->assign('filter', $good_type_list['filter']);
    $smarty->assign('record_count', $good_type_list['record_count']);
    $smarty->assign('page_count', $good_type_list['page_count']);

    $query = $db->query("SELECT a.cat_id FROM " . $ecs->table('attribute') . " AS a RIGHT JOIN " . $ecs->table('goods_attr') . " AS g ON g.attr_id = a.attr_id GROUP BY a.cat_id ORDER BY a.sort_order, a.attr_id, g.goods_attr_id");
    while ($row = $db->fetchRow($query)) {
        $good_in_type[$row['cat_id']] = 1;
    }
    $smarty->assign('good_in_type', $good_in_type);

    //ecmoban模板堂 --zhuo start
    if ($GLOBALS['_CFG']['attr_set_up'] == 0) {
        if ($adminru['ru_id'] == 0) {
            $smarty->assign('action_link', array('text' => $_LANG['new_goods_type'], 'href' => 'goods_type.php?act=add'));
            $smarty->assign('attr_set_up', 1);
        } else {
            $smarty->assign('attr_set_up', 0);
        }
    } elseif ($GLOBALS['_CFG']['attr_set_up'] == 1) {
        $smarty->assign('action_link', array('text' => $_LANG['new_goods_type'], 'href' => 'goods_type.php?act=add'));
        $smarty->assign('attr_set_up', 1);
    }
    //ecmoban模板堂 --zhuo end
    //属性分类
    $smarty->assign('action_link1', array('text' => $_LANG['type_cart'], 'href' => 'goods_type.php?act=cat_list'));
    $smarty->assign('action_link2', array('text' => $_LANG['08_goods_type'], 'href' => 'goods_type.php?act=manage'));
    $smarty->assign('act_type',        $_REQUEST['act']);
    
    //区分自营和店铺
    self_seller(BASENAME($_SERVER['PHP_SELF']), 'manage');
    
    $store_list = get_common_store_list();
    $smarty->assign('store_list',        $store_list);

    $smarty->display('goods_type.dwt');
}

/*------------------------------------------------------ */
//-- 获得列表
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query')
{
    $good_type_list = get_goodstype($adminru['ru_id']);
	
    //ecmoban模板堂 --zhuo start
    if($GLOBALS['_CFG']['attr_set_up'] == 0){
            if($adminru['ru_id'] == 0){
                    $smarty->assign('attr_set_up',   1);
            }else{
                    $smarty->assign('attr_set_up',   0);
            }
    }elseif($GLOBALS['_CFG']['attr_set_up'] == 1){
            $smarty->assign('attr_set_up',   1);
    }
    //ecmoban模板堂 --zhuo end

    $smarty->assign('goods_type_arr',   $good_type_list['type']);
    $smarty->assign('filter',       $good_type_list['filter']);
    $smarty->assign('record_count', $good_type_list['record_count']);
    $smarty->assign('page_count',   $good_type_list['page_count']);

    make_json_result($smarty->fetch('goods_type.dwt'), '',
        array('filter' => $good_type_list['filter'], 'page_count' => $good_type_list['page_count']));
}
/*------------------------------------------------------ */
//-- 属性分类
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'cat_list'){
    assign_query_info();
    admin_priv('goods_type');
    $smarty->assign('ur_here', $_LANG['type_cart']);
    $smarty->assign('full_page', 1);
    $level = empty($_REQUEST['level']) ? 1 : intval($_REQUEST['level']) + 1;
    
    $good_type_cat = get_typecat($level);

    $smarty->assign('goods_type_arr', $good_type_cat['type']);
    $smarty->assign('filter', $good_type_cat['filter']);
    $smarty->assign('record_count', $good_type_cat['record_count']);
    $smarty->assign('page_count', $good_type_cat['page_count']);
    //属性分类
    $smarty->assign('action_link', array('text' => $_LANG['type_cart_add'], 'href' => 'goods_type.php?act=cat_add'));
    $smarty->assign('action_link1', array('text' => $_LANG['type_cart'], 'href' => 'goods_type.php?act=cat_list'));
    $smarty->assign('action_link2', array('text' => $_LANG['08_goods_type'], 'href' => 'goods_type.php?act=manage'));
    $smarty->assign('act_type',        $_REQUEST['act']);
    $smarty->assign('level',        $level);
    //区分自营和店铺
    self_seller(BASENAME($_SERVER['PHP_SELF']), 'cat_list');
    
    $smarty->display('goods_type_cat.dwt');
}
/*------------------------------------------------------ */
//-- 属性分类AJAX
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'cat_list_query'){
    
    check_authz_json('goods_type');
    $level = empty($_REQUEST['level']) ? 1 : intval($_REQUEST['level']);
    $good_type_cat = get_typecat($level);
    $smarty->assign('goods_type_arr', $good_type_cat['type']);
    $smarty->assign('filter', $good_type_cat['filter']);
    $smarty->assign('record_count', $good_type_cat['record_count']);
    $smarty->assign('page_count', $good_type_cat['page_count']);
    $smarty->assign('level',        $level);

    make_json_result($smarty->fetch('goods_type_cat.dwt'), '',
        array('filter' => $good_type_cat['filter'], 'page_count' => $good_type_cat['page_count']));
}
/*------------------------------------------------------ */
//-- 属性分类添加
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'cat_add' || $_REQUEST['act'] == 'cat_edit')
{
    admin_priv('goods_type');
	
	if($_REQUEST['act'] == 'cat_add'){
		$smarty->assign('ur_here', $_LANG['type_cart_add']);
	}
	else
	{
		$smarty->assign('ur_here', $_LANG['type_cart_edit']);
	}
	
	$smarty->assign('action_link', array('text' => $_LANG['type_cart'], 'href' => 'goods_type.php?act=cat_list'));
	
    $cat_id = !empty($_REQUEST['cat_id'])  ?  intval($_REQUEST['cat_id']) : 0;
    //获取全部一级的分类
    
    if($cat_id > 0)
    {
        $sql = "SELECT cat_id ,cat_name ,parent_id ,sort_order ,level,user_id FROM".$ecs->table('goods_type_cat')."WHERE cat_id = '$cat_id' LIMIT 1";
        $type_cat = $db->getRow($sql);
        $cat_tree = get_type_cat_arr($type_cat['parent_id'],2);
        $smarty->assign("cat_tree",$cat_tree);
        $smarty->assign("type_cat",$type_cat);
        $smarty->assign("form_act","cat_update");
        $ru_id = $type_cat['user_id'];
    }
    else
    {
        $smarty->assign("form_act","cat_insert");
        $ru_id = 0;
    }
    $cat_level = get_type_cat_arr(0,0,0,$ru_id);
    $smarty->assign("cat_level",$cat_level);
    $smarty->display('goods_type_cat_info.dwt');
}
/*------------------------------------------------------ */
//-- 属性分类入库
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'cat_insert' || $_REQUEST['act'] == 'cat_update')
{
    $cat_name = !empty($_REQUEST['cat_name'])  ?  trim($_REQUEST['cat_name']) : '';
    $parent_id = !empty($_REQUEST['attr_parent_id'])  ?  intval($_REQUEST['attr_parent_id']) : 0;
    $sort_order = !empty($_REQUEST['sort_order'])  ?  intval($_REQUEST['sort_order']) : 50;
    $cat_id = !empty($_REQUEST['cat_id'])  ?  intval($_REQUEST['cat_id']) : 0;
    //获取入库分类的层级
    if($parent_id > 0)
    {
        $sql = "SELECT level FROM".$ecs->table("goods_type_cat")." WHERE cat_id = '$parent_id' LIMIT 1";
        $level = ($db->getOne($sql)) + 1;
    }
    else
    {
        $level = 1;
    }
    //处理入库数组
    $cat_info = array(
        'cat_name'      => $cat_name,
        'parent_id'     => $parent_id,
        'level'         => $level,
        'sort_order'    => $sort_order
    );
    
    $where = " user_id = '" .$adminru['ru_id']. "'";
    if($_REQUEST['act'] == 'cat_insert')
    {
        /*检查是否重复*/
        $is_only = $exc_cat->is_only('cat_name', $cat_name, 0, $where);
        if (!$is_only)
        {
            sys_msg(sprintf($_LANG['exist_cat'], stripslashes($cat_name)), 1);
        }
        
        $db->autoExecute($ecs->table('goods_type_cat'), $cat_info, 'INSERT');
        $link[0]['text'] = $_LANG['continue_add'];
        $link[0]['href'] = 'goods_type.php?act=cat_add';

        $link[1]['text'] = $_LANG['back_list'];
        $link[1]['href'] = 'goods_type.php?act=cat_list';

        sys_msg($_LANG['add_succeed'],0, $link);
    }
    else
    {
        /*检查是否重复*/
        $is_only = $exc_cat->is_only('cat_name', $cat_name, $cat_id, $where);
        if (!$is_only)
        {
            sys_msg(sprintf($_LANG['exist_cat'], stripslashes($cat_name)), 1);
        }
        $db->autoExecute($ecs->table('goods_type_cat'), $cat_info, 'UPDATE', "cat_id = '$cat_id'");
        $link[0]['text'] = $_LANG['back_list'];
        $link[0]['href'] = 'goods_type.php?act=cat_list';
        sys_msg($_LANG['edit_succeed'],0, $link);
    }
}
/*------------------------------------------------------ */
//-- 删除类型分类
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'remove_cat'){
    check_authz_json('goods_type');
    $id = intval($_GET['id']);
    //判断是否存在下级
    $sql = "SELECT COUNT(*) FROM".$ecs->table('goods_type_cat')."WHERE parent_id = '$id'";
    $cat_count = $db->getOne($sql);
    //判断分类下是否存在类型
     $sql = "SELECT COUNT(*) FROM".$GLOBALS['ecs']->table('goods_type')."WHERE c_id = '$id'";
     $type_count = $GLOBALS[db]->getOne($sql);
     //如果存在下级 ，或者分类下存在类型，则不能删除
     if($cat_count > 0 || $type_count > 0){
         make_json_error($_LANG['remove_prompt']);
     }else{
         $exc_cat->drop($id);
     }
    $url = 'goods_type.php?act=cat_list_query&' . str_replace('act=remove_cat', '', $_SERVER['QUERY_STRING']);
    ecs_header("Location: $url\n");
    exit;
}
/*------------------------------------------------------ */
//-- 编辑排序序号
/*------------------------------------------------------ */

if ($_REQUEST['act'] == 'edit_sort_order')
{
    check_authz_json('goods_type');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc_cat->edit("sort_order = '$val'", $id);
    clear_cache_files();

    make_json_result($val);
}
/*------------------------------------------------------ */
//-- 修改商品类型名称
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_type_name')
{
    check_authz_json('goods_type');

    $type_id   = !empty($_POST['id'])  ? intval($_POST['id']) : 0;
    $type_name = !empty($_POST['val']) ? json_str_iconv(trim($_POST['val']))  : '';

    /* 检查名称是否重复 */
    $is_only = $exc->is_only('cat_name', $type_name, $type_id);

    if ($is_only)
    {
        $exc->edit("cat_name='$type_name'", $type_id);

        admin_log($type_name, 'edit', 'goods_type');

        make_json_result(stripslashes($type_name));
    }
    else
    {
        make_json_error($_LANG['repeat_type_name']);
    }
}

/*------------------------------------------------------ */
//-- 切换启用状态
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'toggle_enabled')
{
    check_authz_json('goods_type');

    $id     = intval($_POST['id']);
    $val    = intval($_POST['val']);

    $exc->edit("enabled='$val'", $id);

    make_json_result($val);
}

/*------------------------------------------------------ */
//-- 添加商品类型
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('goods_type');
	
    //ecmoban模板堂 --zhuo start
    if($GLOBALS['_CFG']['attr_set_up'] == 0){
            if($adminru['ru_id'] > 0){
                    $links = array(array('href' => 'goods_type.php?act=manage', 'text' => $_LANG['back_list']));
            sys_msg('暂时没有添加属性权限', 0, $links);
                    exit;
            }
    }
    //ecmoban模板堂 --zhuo end
    $cat_level = get_type_cat_arr();
    $smarty->assign('ur_here',     $_LANG['new_goods_type']);
    $smarty->assign('action_link', array('href'=>'goods_type.php?act=manage', 'text' => $_LANG['goods_type_list']));
    $smarty->assign('action',      'add');
    $smarty->assign('form_act',    'insert');
    $smarty->assign('goods_type',  array('enabled' => 1));
    $smarty->assign('cat_level',    $cat_level);
    
    assign_query_info();
    $smarty->display('goods_type_info.dwt');
}

elseif ($_REQUEST['act'] == 'insert')
{
    $parent_id = !empty($_REQUEST['attr_parent_id']) ? intval($_REQUEST['attr_parent_id']) : 0;
    $goods_type['cat_name']   = sub_str($_POST['cat_name'], 60);
    $goods_type['attr_group'] = sub_str($_POST['attr_group'], 255);
    $goods_type['enabled']    = intval($_POST['enabled']);
    $goods_type['c_id']    = $parent_id;
    //ecmoban模板堂 --zhuo start
    $goods_type['user_id']    = $adminru['ru_id'];
    //ecmoban模板堂 --zhuo end

    if ($db->autoExecute($ecs->table('goods_type'), $goods_type) !== false)
    {
        $links = array(array('href' => 'goods_type.php?act=manage', 'text' => $_LANG['back_list']));
        sys_msg($_LANG['add_goodstype_success'], 0, $links);
    }
    else
    {
        sys_msg($_LANG['add_goodstype_failed'], 1);
    }
}

/*------------------------------------------------------ */
//-- 编辑商品类型
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'edit')
{
    $goods_type = get_goodstype_info(intval($_GET['cat_id']));

    if (empty($goods_type))
    {
        sys_msg($_LANG['cannot_found_goodstype'], 1);
    }

    admin_priv('goods_type');
	
    //ecmoban模板堂 --zhuo start
    if($GLOBALS['_CFG']['attr_set_up'] == 0){
            if($adminru['ru_id'] > 0){
                    $links = array(array('href' => 'goods_type.php?act=manage', 'text' => $_LANG['back_list']));
            sys_msg('暂时没有添加属性权限', 0, $links);
                    exit;
            }
    }
    //ecmoban模板堂 --zhuo end
    //获取分类数组
    $cat_level = get_type_cat_arr(0,0,0,$goods_type['user_id']);
    $smarty->assign('cat_level',    $cat_level);
    $cat_tree = get_type_cat_arr($goods_type['c_id'],2,0,$goods_type['user_id']);
    $cat_tree1 = array('checked_id'=>$cat_tree['checked_id']);
    if($cat_tree['checked_id'] > 0){
        $cat_tree1 = get_type_cat_arr($cat_tree['checked_id'],2,0,$goods_type['user_id']);
    }
    $smarty->assign("cat_tree",$cat_tree);
    $smarty->assign("cat_tree1",$cat_tree1);
    $smarty->assign('ur_here',     $_LANG['edit_goods_type']);
    $smarty->assign('action_link', array('href'=>'goods_type.php?act=manage', 'text' => $_LANG['goods_type_list']));
    $smarty->assign('action',      'add');
    $smarty->assign('form_act',    'update');
    $smarty->assign('goods_type',  $goods_type);

    assign_query_info();
    $smarty->display('goods_type_info.dwt');
}

elseif ($_REQUEST['act'] == 'update')
{
    $parent_id = !empty($_REQUEST['attr_parent_id'])  ?  intval($_REQUEST['attr_parent_id']) : 0;
    $goods_type['c_id']   = $parent_id;
    $goods_type['cat_name']   = sub_str($_POST['cat_name'], 60);
    $goods_type['attr_group'] = sub_str($_POST['attr_group'], 255);
    $goods_type['enabled']    = intval($_POST['enabled']);
    $cat_id                   = intval($_POST['cat_id']);
    $old_groups               = get_attr_groups($cat_id);

    if ($db->autoExecute($ecs->table('goods_type'), $goods_type, 'UPDATE', "cat_id='$cat_id'") !== false)
    {
        /* 对比原来的分组 */
        $new_groups = explode("\n", str_replace("\r", '', $goods_type['attr_group']));  // 新的分组

        foreach ($old_groups AS $key=>$val)
        {
            $found = array_search($val, $new_groups);

            if ($found === NULL || $found === false)
            {
                /* 老的分组没有在新的分组中找到 */
                update_attribute_group($cat_id, $key, 0);
            }
            else
            {
                /* 老的分组出现在新的分组中了 */
                if ($key != $found)
                {
                    update_attribute_group($cat_id, $key, $found); // 但是分组的key变了,需要更新属性的分组
                }
            }
        }

        $links = array(array('href' => 'goods_type.php?act=manage', 'text' => $_LANG['back_list']));
        sys_msg($_LANG['edit_goodstype_success'], 0, $links);
    }
    else
    {
        sys_msg($_LANG['edit_goodstype_failed'], 1);
    }
}

/*------------------------------------------------------ */
//-- 删除商品类型
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('goods_type');

    $id = intval($_GET['id']);

    $name = $exc->get_name($id);

    if ($exc->drop($id))
    {
        admin_log(addslashes($name), 'remove', 'goods_type');

        /* 清除该类型下的所有属性 */
        $sql = "SELECT attr_id FROM " .$ecs->table('attribute'). " WHERE cat_id = '$id'";
        $arr = $db->getCol($sql);

        $GLOBALS['db']->query("DELETE FROM " .$ecs->table('attribute'). " WHERE attr_id " . db_create_in($arr));
        $GLOBALS['db']->query("DELETE FROM " .$ecs->table('goods_attr'). " WHERE attr_id " . db_create_in($arr));

        $url = 'goods_type.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

        ecs_header("Location: $url\n");
        exit;
    }
    else
    {
        make_json_error($_LANG['remove_failed']);
    }
}
//获取下级分类
elseif($_REQUEST['act'] == 'get_childcat')
{
    require(ROOT_PATH . '/includes/cls_json.php');
    $json = new JSON;
    $result = array('content' => '', 'error' => '');
    
    $cat_id = !empty($_REQUEST['cat_id'])  ?  intval($_REQUEST['cat_id']) : 0;
    $level = !empty($_REQUEST['level'])  ?  intval($_REQUEST['level']) + 1 : 0;
    $type = !empty($_REQUEST['type'])  ?  intval($_REQUEST['type']) : 0;
    $typeCat = !empty($_REQUEST['typeCat'])  ?  intval($_REQUEST['typeCat']) : 0;
    $child_cat = get_type_cat_arr($cat_id);
    if(!empty($child_cat)){
        $result['error'] = 0;
        $smarty->assign('child_cat',$child_cat);
        $smarty->assign('level',$level);
        $smarty->assign('type',$type);
        $smarty->assign('typeCat',$typeCat);
        $result['content'] = $smarty->fetch("library/type_cat.lbi");
    }
    else
    {
        $result['error'] = 1;
    }
    die($json->encode($result));
}
//获取指定分类下的类型
elseif($_REQUEST['act'] == 'get_childtype'){
    require(ROOT_PATH . '/includes/cls_json.php');
    $json = new JSON;
    $result = array('content' => '', 'error' => '');
    
    $cat_id = !empty($_REQUEST['cat_id'])  ?  intval($_REQUEST['cat_id']) : 0;
    $typeCat = !empty($_REQUEST['typeCat'])  ?  intval($_REQUEST['typeCat']) : 0;
    $where = "WHERE 1 ";
    if($cat_id > 0){
        $cat_keys = get_type_cat_arr($cat_id,1,1);//获取指定分类下的所有下级分类
        $where .= " AND c_id in ($cat_keys) AND c_id != 0 ";
    }
    $sql = "SELECT cat_id,cat_name FROM".$ecs->table("goods_type").$where;
    $type_list = $db->getAll($sql);
    //获取分类数组下的所有类型
    $result['error'] = 0;
    $smarty->assign('goods_type_list',$type_list);
    $smarty->assign('type_html',1);
    $smarty->assign('typeCat',$typeCat);
    $result['content'] = $smarty->fetch("library/type_cat.lbi");
    
    die($json->encode($result));
}
/**
 * 获得所有商品类型
 *
 * @access  public
 * @return  array
 */
function get_goodstype($ru_id)
{
    //ecmoban模板堂 --zhuo start
    $where = ' WHERE 1 ';

    if ($GLOBALS['_CFG']['attr_set_up'] == 0) {
        if ($ru_id > 0) {
            $where .= " AND t.user_id = 0 ";
        }
    } elseif ($GLOBALS['_CFG']['attr_set_up'] == 1) {
        if ($ru_id > 0) {
            $where .= " AND t.user_id = '$ru_id'";
        }
    }
    //ecmoban模板堂 --zhuo end

    $result = get_filter();
    if ($result === false)
    {
        /* 过滤信息 */
        if (!empty($_GET['is_ajax']) && $_GET['is_ajax'] == 1)
        {
            $_REQUEST['keyword'] = json_str_iconv($_REQUEST['keyword']);
        }
        $filter['cat_id'] = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
        $filter['keyword'] = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        $filter['merchant_id'] = isset($_REQUEST['merchant_id']) ? intval($_REQUEST['merchant_id']) : -1;
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'cat_id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);
        $filter['seller_list'] = isset($_REQUEST['seller_list']) && !empty($_REQUEST['seller_list']) ? 1 : 0;  //商家和自营订单标识
        
        if($filter['cat_id'] > 0){
            $cat_keys = get_type_cat_arr($filter['cat_id'],1,1);
            $where .= " AND t.c_id in ($cat_keys) ";
        }
        if ($filter['keyword'])
        {
            $where .= " AND t.cat_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%' ";
        }
        
        if ($filter['merchant_id'] > -1)
        {
            $where .= " AND t.user_id = '" .$filter['merchant_id']. "' ";
        }
        
        $where .= !empty($filter['seller_list']) ? " AND t.user_id > 0 " : " AND t.user_id = 0 "; //区分商家和自营 

        /* 记录总数以及页数 */
        $sql = "SELECT COUNT(*) FROM ". $GLOBALS['ecs']->table('goods_type'). " AS t ".
               "LEFT JOIN ". $GLOBALS['ecs']->table('attribute'). " AS a ON a.cat_id=t.cat_id ".
               $where. "GROUP BY t.cat_id ";
        $filter['record_count'] = count($GLOBALS['db']->getAll($sql));

        $filter = page_and_size($filter);

        /* 查询记录 */
        $sql = "SELECT t.*, COUNT(a.cat_id) AS attr_count ,gt.cat_name as gt_cat_name ".
               "FROM ". $GLOBALS['ecs']->table('goods_type'). " AS t ".
               "LEFT JOIN ". $GLOBALS['ecs']->table('attribute'). " AS a ON a.cat_id=t.cat_id ".
               "LEFT JOIN ". $GLOBALS['ecs']->table('goods_type_cat'). " AS gt ON gt.cat_id=t.c_id ".
               $where. "GROUP BY t.cat_id " .
               " ORDER BY $filter[sort_by] $filter[sort_order] " .
               'LIMIT ' . $filter['start'] . ',' . $filter['page_size'];
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $all = $GLOBALS['db']->getAll($sql);

    foreach ($all AS $key=>$val)
    {
        $all[$key]['attr_group'] = strtr($val['attr_group'], array("\r" => '', "\n" => ", "));
        $all[$key]['user_name'] = get_shop_name($val['user_id'], 1);
    }

    return array('type' => $all, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/**
 * 获得指定的商品类型的详情
 *
 * @param   integer     $cat_id 分类ID
 *
 * @return  array
 */
function get_goodstype_info($cat_id)
{
    $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('goods_type'). " WHERE cat_id='$cat_id'";

    return $GLOBALS['db']->getRow($sql);
}

/**
 * 更新属性的分组
 *
 * @param   integer     $cat_id     商品类型ID
 * @param   integer     $old_group
 * @param   integer     $new_group
 *
 * @return  void
 */
function update_attribute_group($cat_id, $old_group, $new_group)
{
    $sql = "UPDATE " . $GLOBALS['ecs']->table('attribute') .
            " SET attr_group='$new_group' WHERE cat_id='$cat_id' AND attr_group='$old_group'";
    $GLOBALS['db']->query($sql);
}

?>
