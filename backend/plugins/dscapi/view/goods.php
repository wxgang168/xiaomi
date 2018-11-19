<?php

/**
 * DSC 商品接口入口
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: zhuo $
 * $Id: goods.php zhuo $
 */
/* 获取传值 */
$seller_type = isset($_REQUEST['seller_type']) ? $base->get_intval($_REQUEST['seller_type']) : -1;              //商家ID字段类型
$seller_id = isset($_REQUEST['seller_id']) ? $base->get_intval($_REQUEST['seller_id']) : -1;                    //商家ID
$cat_id = isset($_REQUEST['cat_id']) ? $base->get_intval($_REQUEST['cat_id']) : -1;                             //商品分类ID
$user_cat = isset($_REQUEST['user_cat']) ? $base->get_intval($_REQUEST['user_cat']) : -1;                       //商家商品分类ID
$goods_id = isset($_REQUEST['goods_id']) ? $base->get_intval($_REQUEST['goods_id']) : -1;                       //商品ID
$brand_id = isset($_REQUEST['brand_id']) ? $base->get_intval($_REQUEST['brand_id']) : -1;                       //品牌ID
$goods_sn = isset($_REQUEST['goods_sn']) ? $base->get_addslashes($_REQUEST['goods_sn']) : -1;                   //商品货品
$bar_code = isset($_REQUEST['bar_code']) ? $base->get_addslashes($_REQUEST['bar_code']) : -1;                   //商品条形码
$w_id = isset($_REQUEST['w_id']) ? $base->get_intval($_REQUEST['w_id']) : -1;                                   //商品仓库ID
$a_id = isset($_REQUEST['a_id']) ? $base->get_intval($_REQUEST['a_id']) : -1;                                   //商品地区ID
$region_id = isset($_REQUEST['region_id']) ? $base->get_intval($_REQUEST['region_id']) : -1;                    //仓库地区ID
$region_sn = isset($_REQUEST['region_sn']) ? $base->get_addslashes($_REQUEST['region_sn']) : -1;                //商品仓库\地区货号
$img_id = isset($_REQUEST['img_id']) ? $base->get_intval($_REQUEST['img_id']) : -1;                             //商品相册ID
$attr_id = isset($_REQUEST['attr_id']) ? $base->get_intval($_REQUEST['attr_id']) : -1;                          //属性类型
$goods_attr_id = isset($_REQUEST['goods_attr_id']) ? $base->get_intval($_REQUEST['goods_attr_id']) : -1;        //商品属性ID
$tid = isset($_REQUEST['tid']) ? $base->get_addslashes($_REQUEST['tid']) : -1;                                  //商品运费模板ID

//$data = array('goods_name', 'shop_price', 'review_status');
//$data = array('goods_name' => '嘿嘿', 'shop_price' => '33.2', 'review_status' => 3);

/*
//插入/更新运费模板 数据示例
$data = array(
    array(
        'ru_id' => 0,
        'type' => 1,
        'title' => "aaaa",
        'update_time' => gmtime()
    ),
    array(
        'tid' => 0,
        'ru_id' => 0,
        'area_id' => 0,
        'top_area_id' => 0,
        'sprice' => '3.6'
    ),
    array(
        'tid' => 0,
        'ru_id' => 0,
        'shipping_id' => 0,
        'shipping_fee' => '0.3'
    ),
);*/

$val = array(
    'seller_type' => $seller_type,
    'seller_id' => $seller_id,
    'brand_id' => $brand_id,
    'cat_id' => $cat_id,
    'user_cat' => $user_cat,
    'goods_id' => $goods_id,
    'goods_sn' => $goods_sn,
    'bar_code' => $bar_code,
    'w_id' => $w_id,
    'a_id' => $a_id,
    'region_id' => $region_id,
    'region_sn' => $region_sn,
    'img_id' => $img_id,
    'attr_id' => $attr_id,
    'goods_attr_id' => $goods_attr_id,
    'tid' => $tid,
    'goods_select' => $data,
    'page_size' => $page_size,
    'page' => $page,
    'sort_by' => $sort_by,
    'sort_order' => $sort_order,
    'format' => $format
);

/* 初始化商品类 */
$goods = new app\controller\goods($val);

switch ($method) {

    /**
     * 获取商品列表
     */
    case 'dsc.goods.list.get':
        
        $table = array(
            'goods' => 'goods'
        );

        $goods_list = $goods->get_goods_list($table);

        die($goods_list);
        break;

    /**
     * 获取单条商品信息
     */
    case 'dsc.goods.info.get':
        
        $table = array(
            'goods' => 'goods'
        );

        $goods_info = $goods->get_goods_info($table);

        die($goods_info);
        break;

    /**
     * 插入商品信息
     */
    case 'dsc.goods.insert.post':
        
        $table = array(
            'goods' => 'goods'
        );

        $result = $goods->get_goods_insert($table);

        die($result);
        break;

    /**
     * 更新商品信息
     */
    case 'dsc.goods.update.post':
        
        $table = array(
            'goods' => 'goods'
        );

        $result = $goods->get_goods_update($table);

        die($result);
        break;
    
    /**
     * 删除商品信息
     */
    case 'dsc.goods.del.post':
        
        $table = array(
            'goods' => 'goods'
        );

        $result = $goods->get_goods_delete($table);

        die($result);
        break;
    
    /**
     * 获取商品仓库信息
     * 仓库模式
     */
    case 'dsc.goods.warehouse.list.get':
        
        $table = array(
            'warehouse' => 'warehouse_goods'
        );
        
        $result = $goods->get_goods_warehouse_list($table);

        die($result);
        break;

    /**
     * 获取单条商品仓库信息
     * 仓库模式
     */
    case 'dsc.goods.warehouse.info.get':
        
        $table = array(
            'warehouse' => 'warehouse_goods'
        );
        
        $result = $goods->get_goods_warehouse_info($table);

        die($result);
        break;
    
    /**
     * 插入商品仓库信息
     * 仓库模式
     */
    case 'dsc.goods.warehouse.insert.post':
        
        $table = array(
            'warehouse' => 'warehouse_goods'
        );

        $result = $goods->get_goods_warehouse_insert($table);

        die($result);
        break;
    
    /**
     * 更新商品仓库信息
     * 仓库模式
     */
    case 'dsc.goods.warehouse.update.post':
        
        $table = array(
            'warehouse' => 'warehouse_goods'
        );

        $result = $goods->get_goods_warehouse_update($table);

        die($result);
        break;
    
    /**
     * 删除商品仓库信息
     */
    case 'dsc.goods.warehouse.del.post':
        
        $table = array(
            'warehouse' => 'warehouse_goods'
        );

        $result = $goods->get_goods_warehouse_delete($table);

        die($result);
        break;
    
    /**
     * 获取商品仓库地区信息
     * 地区模式
     */
    case 'dsc.goods.area.list.get':
        
        $table = array(
            'area' => 'warehouse_area_goods'
        );
        
        $result = $goods->get_goods_area_list($table);

        die($result);
        break;

    /**
     * 获取单条商品仓库地区信息
     * 地区模式
     */
    case 'dsc.goods.area.info.get':
        
        $table = array(
            'area' => 'warehouse_area_goods'
        );
        
        $result = $goods->get_goods_area_info($table);

        die($result);
        break;
    
    /**
     * 插入商品仓库地区信息
     * 地区模式
     */
    case 'dsc.goods.area.insert.post':
        
        $table = array(
            'area' => 'warehouse_area_goods'
        );

        $result = $goods->get_goods_area_insert($table);

        die($result);
        break;
    
    /**
     * 更新商品仓库地区信息
     * 地区模式
     */
    case 'dsc.goods.area.update.post':
        
        $table = array(
            'area' => 'warehouse_area_goods'
        );

        $result = $goods->get_goods_area_update($table);

        die($result);
        break;
    
    /**
     * 删除商品仓库地区信息
     * 地区模式
     */
    case 'dsc.goods.area.del.post':
        
        $table = array(
            'area' => 'warehouse_area_goods'
        );
        
        $result = $goods->get_goods_area_delete($table);

        die($result);
        break;
    
    /**
     * 获取商品相册列表
     */
    case 'dsc.goods.gallery.list.get':
        
        $table = array(
            'gallery' => 'goods_gallery'
        );
        
        $result = $goods->get_goods_gallery_list($table);

        die($result);
        break;

    /**
     * 获取单条商品相册
     */
    case 'dsc.goods.gallery.info.get':
        
        $table = array(
            'gallery' => 'goods_gallery'
        );
        
        $result = $goods->get_goods_gallery_info($table);

        die($result);
        break;
    
    /**
     * 插入商品相册
     */
    case 'dsc.goods.gallery.insert.post':
        
        $table = array(
            'gallery' => 'goods_gallery'
        );

        $result = $goods->get_goods_gallery_insert($table);

        die($result);
        break;
    
    /**
     * 更新商品相册
     */
    case 'dsc.goods.gallery.update.post':
        
        $table = array(
            'gallery' => 'goods_gallery'
        );

        $result = $goods->get_goods_gallery_update($table);

        die($result);
        break;
    
    /**
     * 删除商品相册
     */
    case 'dsc.goods.gallery.del.post':
        
        $table = array(
            'gallery' => 'goods_gallery'
        );
        
        $result = $goods->get_goods_gallery_delete($table);

        die($result);
        break;
    
    /**
     * 获取商品属性列表
     */
    case 'dsc.goods.attr.list.get':
        
        $table = array(
            'attr' => 'goods_attr'
        );
        
        $result = $goods->get_goods_attr_list($table);

        die($result);
        break;

    /**
     * 获取单条商品属性
     */
    case 'dsc.goods.attr.info.get':
        
        $table = array(
            'attr' => 'goods_attr'
        );
        
        $result = $goods->get_goods_attr_info($table);

        die($result);
        break;
    
    /**
     * 插入商品属性
     */
    case 'dsc.goods.attr.insert.post':
        
        $table = array(
            'attr' => 'goods_attr'
        );

        $result = $goods->get_goods_attr_insert($table);

        die($result);
        break;
    
    /**
     * 更新商品属性
     */
    case 'dsc.goods.attr.update.post':
        
        $table = array(
            'attr' => 'goods_attr'
        );

        $result = $goods->get_goods_attr_update($table);

        die($result);
        break;
    
    /**
     * 删除商品属性
     */
    case 'dsc.goods.attr.del.post':
        
        $table = array(
            'attr' => 'goods_attr'
        );
        
        $result = $goods->get_goods_attr_delete($table);

        die($result);
        break;
    
    /**
     * 获取商品运费模板列表
     */
    case 'dsc.goods.freight.list.get':
        
        $table = array(
            array(
                'table' => 'goods_transport',   //表名
                'alias' => "gt",                //表别名
            ),
            array(
                'table' => 'goods_transport_extend',   //表名
                'alias' => "gted",                      //表别名
            ),
            array(
                'table' => 'goods_transport_express',    //表名
                'alias' => "gtes",                      //表别名
            )
        );
         
        $result = $goods->get_goods_freight_list($table);

        die($result);
        break;

    /**
     * 获取单条商品运费模板
     */
    case 'dsc.goods.freight.info.get':
        
        $table = array(
            array(
                'table' => 'goods_transport',   //表名
                'alias' => "gt",                //表别名
            ),
            array(
                'table' => 'goods_transport_extend',   //表名
                'alias' => "gted",                      //表别名
            ),
            array(
                'table' => 'goods_transport_express',    //表名
                'alias' => "gtes",                      //表别名
            )
        );
        
        $result = $goods->get_goods_freight_info($table);

        die($result);
        break;
    
    /**
     * 插入商品运费模板
     */
    case 'dsc.goods.freight.insert.post':
        
        $table = array(
            'goods_transport',   //表名
            'goods_transport_extend',   //表名
            'goods_transport_express'    //表名
        );

        $result = $goods->get_goods_freight_insert($table);

        die($result);
        break;
    
    /**
     * 更新商品运费模板
     */
    case 'dsc.goods.freight.update.post':
        
        $table = array(
            'goods_transport',   //表名
            'goods_transport_extend',   //表名
            'goods_transport_express'    //表名
        );

        $result = $goods->get_goods_freight_update($table);

        die($result);
        break;
    
    /**
     * 删除商品运费模板
     */
    case 'dsc.goods.freight.del.post':
        
        $table = array(
            'goods_transport',   //表名
            'goods_transport_extend',   //表名
            'goods_transport_express'    //表名
        );
        
        $result = $goods->get_goods_freight_delete($table);

        die($result);
        break;

    default :

        echo "非法接口连接";
        break;
}