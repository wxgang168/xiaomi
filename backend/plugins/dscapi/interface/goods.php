<?php

/**
 * DSC 商品接口列表
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: zhuo $
 * $Id: goods.php zhuo $
 */

$goods_action = array(
    'dsc.goods.list.get',                           //获取商品列表
    'dsc.goods.info.get',                           //获取商品信息
    'dsc.goods.insert.post',                        //插入商品信息
    'dsc.goods.update.post',                        //更新商品信息
    'dsc.goods.del.post',                           //删除商品信息
    
    /* 商品仓库模式 */
    'dsc.goods.warehouse.list.get',                 //获取商品仓库列表
    'dsc.goods.warehouse.info.get',                 //获取单条商品仓库信息
    'dsc.goods.warehouse.insert.post',              //插入商品仓库信息
    'dsc.goods.warehouse.update.post',              //更新商品仓库信息
    'dsc.goods.warehouse.del.post',                 //删除商品仓库信息
    
    /* 商品地区模式 */
    'dsc.goods.area.list.get',                      //获取商品地区列表
    'dsc.goods.area.info.get',                      //获取单条商品地区信息
    'dsc.goods.area.insert.post',                   //插入商品地区信息
    'dsc.goods.area.update.post',                   //更新商品地区信息
    'dsc.goods.area.del.post',                      //删除商品地区信息
    
    /* 商品相册 */
    'dsc.goods.gallery.list.get',                   //获取商品相册
    'dsc.goods.gallery.info.get',                   //获取单条商品相册
    'dsc.goods.gallery.insert.post',                //插入商品相册
    'dsc.goods.gallery.update.post',                //更新商品相册
    'dsc.goods.gallery.del.post',                   //删除商品相册
    
    /* 商品属性 */
    'dsc.goods.attr.list.get',                      //获取商品属性
    'dsc.goods.attr.info.get',                      //获取单条商品属性
    'dsc.goods.attr.insert.post',                   //插入商品属性
    'dsc.goods.attr.update.post',                   //更新商品属性
    'dsc.goods.attr.del.post',                      //删除商品属性
    
    /* 商品单独运费模板 */
    'dsc.goods.freight.list.get',                   //获取商品运费模板列表
    'dsc.goods.freight.info.get',                   //获取单条商品运费模板信息
    'dsc.goods.freight.insert.post',                //插入商品运费模板
    'dsc.goods.freight.update.post',                //更新商品运费模板信息
    'dsc.goods.freight.del.post',                   //删除商品运费模板
);
