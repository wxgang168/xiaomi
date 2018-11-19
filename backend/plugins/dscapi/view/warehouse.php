<?php

/**
 * DSC 仓库地区接口入口
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: zhuo $
 * $Id: warehouse.php zhuo $
 */
/* 获取传值 */
$region_id = isset($_REQUEST['region_id']) ? $base->get_intval($_REQUEST['region_id']) : -1;                  //仓库地区ID
$region_code = isset($_REQUEST['region_code']) ? $base->get_addslashes($_REQUEST['region_code']) : -1;        //编码CODE
$parent_id = isset($_REQUEST['parent_id']) ? $base->get_intval($_REQUEST['parent_id']) : -1;                  //仓库地区父级ID
$region_name = isset($_REQUEST['region_name']) ? $base->get_addslashes($_REQUEST['region_name']) : -1;        //仓库地区名称
$region_type = isset($_REQUEST['region_type']) ? $base->get_intval($_REQUEST['region_type']) : -1;            //仓库地区层级val

$val = array(
    'region_id' => $region_id,
    'region_code' => $region_code,
    'parent_id' => $parent_id,
    'region_name' => $region_name,
    'region_type' => $region_type,
    'warehouse_select' => $data,
    'page_size' => $page_size,
    'page' => $page,
    'sort_by' => $sort_by,
    'sort_order' => $sort_order,
    'format' => $format
);

/* 初始化商品类 */
$warehouse = new app\controller\warehouse($val);

switch ($method) {

    /**
     * 获取仓库地区列表
     */
    case 'dsc.warehouse.list.get':
        
        $table = array(
            'warehouse' => 'region_warehouse'
        );

        $result = $warehouse->get_warehouse_list($table);

        die($result);
        break;

    /**
     * 获取单条仓库地区信息
     */
    case 'dsc.warehouse.info.get':
        
        $table = array(
            'warehouse' => 'region_warehouse'
        );

        $result = $warehouse->get_warehouse_info($table);

        die($result);
        break;

    /**
     * 插入仓库地区信息
     */
    case 'dsc.warehouse.insert.post':
        
        $table = array(
            'warehouse' => 'region_warehouse'
        );

        $result = $warehouse->get_warehouse_insert($table);

        die($result);
        break;

    /**
     * 更新仓库地区信息
     */
    case 'dsc.warehouse.update.post':
        
        $table = array(
            'warehouse' => 'region_warehouse'
        );

        $result = $warehouse->get_warehouse_update($table);

        die($result);
        break;
    
    /**
     * 删除仓库地区信息
     */
    case 'dsc.warehouse.del.post':
        
        $table = array(
            'warehouse' => 'region_warehouse'
        );

        $result = $warehouse->get_brand_delete($table);

        die($result);
        break;

    default :

        echo "非法接口连接";
        break;
}