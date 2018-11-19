<?php

/**
 * DSC 会员接口入口
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: zhuo $
 * $Id: order.php zhuo $
 */
/* 获取传值 */
$user_id = isset($_REQUEST['user_id']) ? $base->get_intval($_REQUEST['user_id']) : -1;                  //会员ID
$user_name = isset($_REQUEST['user_name']) ? $base->get_addslashes($_REQUEST['user_name']) : -1;            //会员名称

//会员手机号
if (isset($_REQUEST['mobile'])) {
    $mobile = isset($_REQUEST['mobile']) ? $base->get_addslashes($_REQUEST['mobile']) : -1;                 
} else if (isset($_REQUEST['mobile_phone'])) {
    $mobile = isset($_REQUEST['mobile_phone']) ? $base->get_addslashes($_REQUEST['mobile_phone']) : -1;
}

$rank_id = isset($_REQUEST['rank_id']) ? $base->get_intval($_REQUEST['rank_id']) : -1;                  //等级ID
$address_id = isset($_REQUEST['address_id']) ? $base->get_intval($_REQUEST['address_id']) : -1;         //收货地址ID

$val = array(
    'user_id' => $user_id,
    'user_name' => $user_name,
    'mobile' => $mobile,
    'rank_id' => $rank_id,
    'address_id' => $address_id,
    'user_select' => $data,
    'page_size' => $page_size,
    'page' => $page,
    'sort_by' => $sort_by,
    'sort_order' => $sort_order,
    'format' => $format
);

/* 初始化商品类 */
$user = new app\controller\user($val);

switch ($method) {

    /**
     * 获取会员列表
     */
    case 'dsc.user.list.get':
        
        $table = array(
            'users' => 'users'
        );

        $result = $user->get_user_list($table);

        die($result);
        break;

    /**
     * 获取单条会员信息
     */
    case 'dsc.user.info.get':
        
        $table = array(
            'users' => 'users'
        );

        $result = $user->get_user_info($table);

        die($result);
        break;

    /**
     * 插入会员信息
     */
    case 'dsc.user.insert.post':
        
        $table = array(
            'users' => 'users'
        );

        $result = $user->get_user_insert($table);

        die($result);
        break;

    /**
     * 更新会员信息
     */
    case 'dsc.user.update.post':
        
        $table = array(
            'users' => 'users'
        );

        $result = $user->get_user_update($table);

        die($result);
        break;
    
    /**
     * 删除会员信息
     */
    case 'dsc.user.del.post':
        
        $table = array(
            'users' => 'users'
        );

        $result = $user->get_user_delete($table);

        die($result);
        break;
    
    /**
     * 获取会员等级列表
     */
    case 'dsc.user.rank.list.get':
        
        $table = array(
            'rank' => 'user_rank'
        );

        $result = $user->get_user_rank_list($table);

        die($result);
        break;

    /**
     * 获取单条会员等级信息
     */
    case 'dsc.user.rank.info.get':
        
        $table = array(
            'rank' => 'user_rank'
        );

        $result = $user->get_user_rank_info($table);

        die($result);
        break;

    /**
     * 插入会员等级信息
     */
    case 'dsc.user.rank.insert.post':
        
        $table = array(
            'rank' => 'user_rank'
        );

        $result = $user->get_user_rank_insert($table);

        die($result);
        break;

    /**
     * 更新会员等级信息
     */
    case 'dsc.user.rank.update.post':
        
        $table = array(
            'rank' => 'user_rank'
        );

        $result = $user->get_user_rank_update($table);

        die($result);
        break;
    
    /**
     * 删除会员等级信息
     */
    case 'dsc.user.rank.del.post':
        
        $table = array(
            'rank' => 'user_rank'
        );

        $result = $user->get_user_rank_delete($table);

        die($result);
        break;
    
    /**
     * 获取会员收货地址列表
     */
    case 'dsc.user.address.list.get':
        
        $table = array(
            'address' => 'user_address'
        );

        $result = $user->get_user_address_list($table);

        die($result);
        break;

    /**
     * 获取单条会员收货地址信息
     */
    case 'dsc.user.address.info.get':
        
        $table = array(
            'address' => 'user_address'
        );

        $result = $user->get_user_address_info($table);

        die($result);
        break;

    /**
     * 插入会员收货地址信息
     */
    case 'dsc.user.address.insert.post':
        
        $table = array(
            'address' => 'user_address'
        );

        $result = $user->get_user_address_insert($table);

        die($result);
        break;

    /**
     * 更新会员收货地址信息
     */
    case 'dsc.user.address.update.post':
        
        $table = array(
            'rank' => 'user_rank'
        );

        $result = $user->get_user_address_update($table);

        die($result);
        break;
    
    /**
     * 删除会员收货地址信息
     */
    case 'dsc.user.address.del.post':
        
        $table = array(
            'address' => 'user_address'
        );

        $result = $user->get_user_address_delete($table);

        die($result);
        break;
    
    default :

        echo "非法接口连接";
        break;
}