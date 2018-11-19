<?php

/**
 * DSC 地区模型
 * 抽象类
 * 不可（new）实例化
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: zhuo $
 * $Id: regionModel.php 2017-01-11 zhuo $
 */

namespace app\model;

use app\func\common;
use app\func\base;
use languages\regionLang;

abstract class regionModel extends common {

    private $alias_config;

    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function __construct() {
        $this->regionModel();
    }

    /**
     * 构造函数
     *
     * @access  public
     * @param   integer $goods_id     商品ID
     * @return  bool
     */
    public function regionModel($table = '') {
        
        $this->alias_config = array(
            'region' => 'r',                         //地区表
        );
        
        if($table){
            return $this->alias_config[$table];
        }else{
            return $this->alias_config;
        }
        
    }
    
    /**
     * 查询条件
     *
     * @access  public
     * @param   string where    查询条件
     * @return  string
     */
    public function get_where($val = array(), $alias = '') {

        $where = 1;

        /* 地区ID */
        $where .= base::get_where($val['region_id'], $alias . 'region_id');
        
        /* 地区父级ID */
        $where .= base::get_where($val['parent_id'], $alias . 'parent_id');
        
        /* 地区名称 */
        $where .= base::get_where($val['region_name'], $alias . 'region_name');
        
        /* 地区名称 */
        $where .= base::get_where($val['region_type'], $alias . 'region_type');
        
        return $where;
    }
    
    /**
     * 查询获取列表数据
     *
     * @access  public
     * @param   string $table    表名称
     * @param   string $select    查询字段
     * @param   string where    查询条件
     * @param   string $page_size    页码
     * @param   string $page    当前页
     * @return  string
     */
    public function get_select_list($table, $select, $where, $page_size, $page, $sort_by, $sort_order){
        
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table($table) . " WHERE " . $where;
        $result['record_count'] = $GLOBALS['db']->getOne($sql);

        if ($sort_by) {
            $where .= " ORDER BY $sort_by $sort_order ";
        }

        $where .= " LIMIT " . ($page - 1) * $page_size . ",$page_size";
        
        $sql = "SELECT " . $select . " FROM " . $GLOBALS['ecs']->table($table) . " WHERE " . $where;
        $result['list'] = $GLOBALS['db']->getAll($sql);

        return $result;
    }
    
    /**
     * 查询获取单条数据
     *
     * @access  public
     * @param   string $table    表名称
     * @param   string $select    查询字段
     * @param   string where    查询条件
     * @return  string
     */
    public function get_select_info($table, $select, $where) {

        $sql = "SELECT " . $select . " FROM " . $GLOBALS['ecs']->table($table) . " WHERE " . $where . " LIMIT 1";
        $result = $GLOBALS['db']->getRow($sql);
        return $result;
    }
    
    /**
     * 插入数据
     *
     * @access  public
     * @param   string where    查询条件
     * @return  string
     */
    public function get_insert($table, $select, $format){
        
        $regionLang = regionLang::lang_region_insert();

        $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $select, "INSERT");
        $id = $GLOBALS['db']->insert_id();

        $common_data = array(
            'result' => empty($id) ? "failure" : 'success',
            'msg' => empty($id) ? $regionLang['msg_failure']['failure'] : $regionLang['msg_success']['success'],
            'error' => empty($id) ? $regionLang['msg_failure']['error'] : $regionLang['msg_success']['error'],
            'format' => $format
        );

        common::common($common_data);
        return common::data_back();
    }
    
    /**
     * 更新数据
     *
     * @access  public
     * @param   string where    查询条件
     * @return  string
     */
    public function get_update($table, $select, $where, $format){
        
        $regionLang = regionLang::lang_region_update();
        
        if (strlen($where) != 1) {
            $info = $this->get_select_info($table, "*", $where);
            if (!$info) {
                $common_data = array(
                    'result' => 'failure',
                    'msg' => $regionLang['null_failure']['failure'],
                    'error' => $regionLang['null_failure']['error'],
                    'format' => $format
                );
            } else {
                $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table($table), $select, "UPDATE", $where);

                $common_data = array(
                    'result' => empty($select) ? "failure" : 'success',
                    'msg' => empty($select) ? $regionLang['msg_failure']['failure'] : $regionLang['msg_success']['success'],
                    'error' => empty($select) ? $regionLang['msg_failure']['error'] : $regionLang['msg_success']['error'],
                    'format' => $format
                );
            }
        } else {
            $common_data = array(
                'result' => 'failure',
                'msg' => $regionLang['where_failure']['failure'],
                'error' => $regionLang['where_failure']['error'],
                'format' => $format
            );
        }

        common::common($common_data);
        return common::data_back();
    }
    
    /**
     * 数据删除
     *
     * @access  public
     * @param   string where    查询条件
     * @return  string
     */
    public function get_delete($table, $where, $format){
        
        $regionLang = userLang::lang_region_delete();

        if (strlen($where) != 1) {

            $sql = "DELETE FROM " . $GLOBALS['ecs']->table($table) . " WHERE " . $where;
            $GLOBALS['db']->query($sql);

            $common_data = array(
                'result' => 'success',
                'msg' => $regionLang['msg_success']['success'],
                'error' => $regionLang['msg_success']['error'],
                'format' => $format
            );
        } else {
            $common_data = array(
                'result' => 'failure',
                'msg' => $regionLang['where_failure']['failure'],
                'error' => $regionLang['where_failure']['error'],
                'format' => $format
            );
        }
        
        common::common($common_data);
        return common::data_back();
    }
    
    /**
     * 格式化返回值
     *
     * @access  public
     * @return  string
     */
    public function get_list_common_data($result, $page_size, $page, $regionLang, $format){
        $common_data = array(
            'page_size' => $page_size,
            'page' => $page,
            'result' => empty($result) ? "failure" : 'success',
            'msg' => empty($result) ? $regionLang['msg_failure']['failure'] : $regionLang['msg_success']['success'],
            'error' => empty($result) ? $regionLang['msg_failure']['error'] : $regionLang['msg_success']['error'],
            'format' => $format
        );

        common::common($common_data);
        $result = common::data_back($result, 1);
        
        return $result;
    }
    
    /**
     * 格式化返回值
     *
     * @access  public
     * @return  string
     */
    public function get_info_common_data_fs($result, $regionLang, $format) {
        $common_data = array(
            'result' => empty($result) ? "failure" : 'success',
            'msg' => empty($result) ? $regionLang['msg_failure']['failure'] : $regionLang['msg_success']['success'],
            'error' => empty($result) ? $regionLang['msg_failure']['error'] : $regionLang['msg_success']['error'],
            'format' => $format
        );

        common::common($common_data);
        $result = common::data_back($result);
        
        return $result;
    }
    
    /**
     * 格式化返回值
     *
     * @access  public
     * @return  string
     */
    public function get_info_common_data_f($regionLang, $format) {
        
        $result = array();
        
        $common_data = array(
            'result' => 'failure',
            'msg' => $regionLang['where_failure']['failure'],
            'error' => $regionLang['where_failure']['error'],
            'format' => $format
        );
        
        common::common($common_data);
        $result = common::data_back($result);
        
        return $result;
    }
}
