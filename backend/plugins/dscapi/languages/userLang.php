<?php

/**
 * DSC 会员言语包
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: Zhuo $
 * $Id: orderLang.php 2016-01-04 Zhuo $
 */

namespace languages;

class userLang {

    static private $lang_update_conf;
    static private $lang_insert_conf;

    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * 获取会员数据言语包
     *
     * @access  public
     * @return  bool
     */
    static public function lang_user_request() {
        self::$lang_insert_conf = array(
            'msg_success' => array(
                'success' => '成功获取数据',
                'error' => 0
            ),
            'msg_failure' => array(
                'failure' => '数据为空值',
                'error' => 1
            ),
            'where_failure' => array(
                'failure' => '条件为空',
                'error' => 2,
            )
        );

        return self::$lang_insert_conf;
    }

    /**
     * 会员数据插入言语包
     *
     * @access  public
     * @return  bool
     */
    static public function lang_user_insert() {

        self::$lang_insert_conf = array(
            'msg_success' => array(
                'success' => '数据提交成功',
                'error' => 0
            ),
            'msg_failure' => array(
                'failure' => '数据提交失败',
                'error' => 1
            )
        );

        return self::$lang_insert_conf;
    }

    /**
     * 会员数据更新言语包
     *
     * @access  public
     * @return  bool
     */
    static public function lang_user_update() {

        self::$lang_update_conf = array(
            'msg_success' => array(
                'success' => '数据更新成功',
                'error' => 0,
            ),
            'msg_failure' => array(
                'failure' => '数据为空',
                'error' => 1,
            ),
            'where_failure' => array(
                'failure' => '条件为空',
                'error' => 2,
            ),
            'is_user_name' => array(
                'failure' => '信息（会员名称或手机号）已存在，无法修改',
                'error' => 3,
            ),
            'null_failure' => array(
                 'failure' => '数据不存在',
                'error' => 4,
            )
        );

        return self::$lang_update_conf;
    }

    /**
     * 会员数据更新言语包
     *
     * @access  public
     * @return  bool
     */
    static public function lang_user_delete() {

        self::$lang_update_conf = array(          
            'msg_success' => array(
                'success' => '删除成功',
                'error' => 0,
            ),
            'msg_failure' => array(
                'failure' => '删除失败',
                'error' => 1,
            ),
            'where_failure' => array(
                'failure' => '条件为空',
                'error' => 2,
            )
        );

        return self::$lang_update_conf;
    }
    
    static public function __callStatic($method, $arguments) {
        return call_user_func_array(array(self,$method), $arguments);
    }

}
