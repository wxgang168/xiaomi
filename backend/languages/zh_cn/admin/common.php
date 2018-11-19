<?php

/**
 * ECSHOP 管理中心共用语言文件
 * ============================================================================
 * * 版权所有 2005-2017 上海商创网络科技有限公司，并保留所有权利。
 * 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: common.php 17217 2018-07-19 06:29:08Z liubo $
*/

$_LANG['order_vcard_return'] = '【订单退款】储值卡退款金额：%s';

/**
 * 首页左侧 start
 */

/* 邮件 */
$_LANG['01_email_manage'] = '邮件群发管理';
$_LANG['mail'] = '邮件';

/* 门店 */
$_LANG['10_offline_store'] = '门店管理';
$_LANG['12_offline_store'] = "门店列表";
$_LANG['offline_store'] = "门店管理";
$_LANG['2_order_stats'] = '门店订单统计';

//模板
$_LANG['03_template'] = '模板管理';
$_LANG['12_template'] = '模板';

/**
 * 首页左侧 end
 */

//短信语言 start
$_LANG['edit_seller_info'] = '后台新账号：%s，新密码：%s，操作员：%s，变更时间：%s'; 
//短信语言 end

$_LANG['09_seller_domain'] = "店铺域名";

//楼层设置内容
$_LANG['filename'] = "模板名称";
$_LANG['floor_name'] = "楼层名称";
$_LANG['content_name'] = "品牌信息";
$_LANG['web_template'] = "网站模板";

$_LANG['brand_name_cn'] = "品牌中文名称";
$_LANG['brand_name_en'] = "品牌英文名称";

//ecmoban 批量导入会员
$_LANG['11_add_order'] = '批量添加订单'; 
$_LANG['11_users_add'] = '会员批量添加';
//ecmoban

$_LANG['sale_notice'] = '商品降价通知';
$_LANG['notice_logs'] = '降价通知日志';
$_LANG['sale_notice_sms'] = '您申请的商品(%s)已经降价了，当前价格是：%s';

$_LANG['discuss_circle'] = '网友讨论圈'; 
$_LANG['comment_seller'] = '商家满意度'; 
$_LANG['comment_seller_rank'] = '商家满意度'; 
$_LANG['seller_industry_baseline'] = '商家评分基线'; 
$_LANG['13_comment_seller_rank']    = '店铺满意度';

$_LANG['11_back_cause'] = '退货原因列表';
$_LANG['12_back_apply'] = '单品退货单列表';

$_LANG['user_keywords_list'] = '用户检索记录';

$_LANG['11_order_detection']='检测已发货订单';
$_LANG['button_detection'] = '一键确认收货';
$_LANG['await_time'] = '自动确认收货时间';
$_LANG['auto_confirm_time'] = '订单应收货时间';
$_LANG['not_confirm_order'] = '未确认收货';

//ecmoban
$_LANG['goods_steps_name'] = '商家名称';
$_LANG['rs_name'] = '卖场名称';

$_LANG['09_warehouse_management'] = '仓库管理';
$_LANG['09_region_area_management'] = '区域管理';
$_LANG['default_shipping'] = '默认配送方式';

$_LANG['warehouse'] = '仓库';
$_LANG['warehouse_delivery'] = '发货仓库';

$_LANG['warehouse_batch'] = '仓库库存批量上传';
$_LANG['produts_batch'] = '仓库属性批量上传';
$_LANG['area_batch'] = '商品地区批量上传';
$_LANG['area_attr_batch'] = '地区属性批量上传';

$_LANG['back_warehouse_batch_list'] = '仓库库存批量上传';
$_LANG['back_area_batch_list'] = '商品地区批量上传';

$_LANG['03_goods_edit'] = '编辑商品';
$_LANG['goto_goods'] = '返回商品详情页';

$_LANG['11_order_export'] = '导出订单'; //插件
$_LANG['12_users_export'] = '导出会员列表';  //插件

$_LANG['12_user_address_list'] = '收货地址列表';
$_LANG['13_goods_inventory_logs'] = '商品库存日志';
//ecmoban
$_LANG['seller_signin_sms'] = '您在 %s 平台下的 %s 后台登录账号信息已修改，%s';

$_LANG['please_select'] = '请选择';
$_LANG['country'] = '国家';
$_LANG['province'] = '省';
$_LANG['city'] = '市';
$_LANG['area'] = '区';

$_LANG['app_name'] = 'ECSHOP';
$_LANG['cp_home'] = '管理中心';
$_LANG['copyright'] = '版权所有 &copy; 2017-2023 淘健康商城平台，并保留所有权利。';
$_LANG['query_info'] = '共执行 %d 个查询，用时 %s 秒';
$_LANG['memory_info'] = '，内存占用 %0.3f MB';
$_LANG['gzip_enabled'] = '，Gzip 已启用';
$_LANG['gzip_disabled'] = '，Gzip 已禁用';
$_LANG['loading'] = '正在处理您的请求...';
$_LANG['js_languages']['process_request'] = "<i class='icon-spinner icon-spin'></i>";
$_LANG['js_languages']['todolist_caption'] = '记事本';
$_LANG['js_languages']['todolist_autosave'] = '自动保存';
$_LANG['js_languages']['todolist_save'] = '保存';
$_LANG['js_languages']['todolist_clear'] = '清除';
$_LANG['js_languages']['todolist_confirm_save'] = '是否将更改保存到记事本？';
$_LANG['js_languages']['todolist_confirm_clear'] = '是否清空内容？';
$_LANG['auto_redirection'] = '如果您不做出选择，将在 <span id="spanSeconds">3</span> 秒后跳转到第一个链接地址';
$_LANG['password_rule'] = '密码应只包含英文字符、数字.长度在6--16位之间';
$_LANG['username_rule'] = '用户名应为汉字、英文字符、数字组合，3到15位';
$_LANG['plugins_not_found'] = '插件 %s 无法定位';
$_LANG['no_records'] = '没有找到任何记录';
$_LANG['role_describe'] = '角色描述';

$_LANG['require_field'] = '<span class="require-field">*</span>';
$_LANG['yes'] = '是';
$_LANG['no'] = '否';
$_LANG['yes_or_no'] = '是否公共';
$_LANG['record_id'] = '编号';
$_LANG['handler'] = '操作';
$_LANG['not_handler'] = '暂无操作';
$_LANG['install'] = '安装';
$_LANG['uninstall'] = '卸载';
$_LANG['list'] = '列表';
$_LANG['add'] = '添加';
$_LANG['edit'] = '编辑';
$_LANG['view'] = '查看';
$_LANG['set_goods'] = '设置商品';
$_LANG['remove'] = '移除';
$_LANG['drop'] = '删除';
$_LANG['check'] = '审核';
$_LANG['log'] = '日志';
$_LANG['confirm_delete'] = '您确定要删除吗？';
$_LANG['disabled'] = '禁用';
$_LANG['enabled'] = '启用';
$_LANG['setup'] = '设置';
$_LANG['success'] = '成功';
$_LANG['sort_order'] = '排序';
$_LANG['trash'] = '回收站';
$_LANG['restore'] = '还原';
$_LANG['close_window'] = '关闭窗口';
$_LANG['btn_select'] = '选择';
$_LANG['operator'] = '操作人';
$_LANG['cancel'] = '取消';
$_LANG['illegal_operate'] = '非法操作';
$_LANG['please'] = '请先';

$_LANG['empty'] = '不能为空';
$_LANG['repeat'] = '已存在';
$_LANG['is_int'] = '应该为整数';

$_LANG['button_submit'] = ' 确定 ';
$_LANG['button_submit_alt'] = '确定';
$_LANG['button_save'] = ' 保存 ';
$_LANG['button_reset'] = ' 重置 ';
$_LANG['button_reset_alt'] = '重置';
$_LANG['button_search'] = ' 搜索 ';
$_LANG['button_inquire'] = '提交查询';

$_LANG['priv_error'] = '对不起,您没有执行此项操作的权限!';
$_LANG['drop_confirm'] = '您确认要删除这条记录吗?';
$_LANG['drop_confirm_pro'] = '您确认要删除这条记录吗?（同时删除该记录下的商品，无法恢复）';
$_LANG['form_notice'] = '点击此处查看提示信息';
$_LANG['upfile_type_error'] = '上传文件的类型不正确!';
$_LANG['upfile_error'] = '上传文件失败!';
$_LANG['no_operation'] = '您没有选择任何操作';

$_LANG['go_back'] = '返回上一页';
$_LANG['go_back_level'] = '返回上一级';
$_LANG['back'] = '返回';
$_LANG['continue'] = '继续';
$_LANG['system_message'] = '系统信息';
$_LANG['check_all'] = '全选';
$_LANG['check_back'] = '反选';
$_LANG['check_all_back'] = '全选/反选';
$_LANG['select_please'] = '请选择...';
$_LANG['all_category'] = '所有分类';
$_LANG['all_brand'] = '所有品牌';
$_LANG['refresh'] = '刷新';
$_LANG['update_sort'] = '更新排序';
$_LANG['modify_failure'] = '修改失败!';
$_LANG['attradd_succed'] = '操作成功!';
$_LANG['attradd_failed'] = '操作失败!';
$_LANG['todolist'] = '记事本';
$_LANG['n_a'] = 'N/A';
$_LANG['search_word'] = '搜索';
$_LANG['text_enco'] = '文件编码';
$_LANG['keywords'] = '关键字';
$_LANG['memo_info'] = '备注信息';

/* 提示 */
$_LANG['sys']['wrong'] = '错误：';

/* 编码 */
$_LANG['charset']['utf8'] = '国际化编码（utf8）';
$_LANG['charset']['zh_cn'] = '简体中文';
$_LANG['charset']['zh_tw'] = '繁体中文';
$_LANG['charset']['en_us'] = '美国英语';
$_LANG['charset']['en_uk'] = '英文';

/* 批量 */
$_LANG['batch'] = '批量'; 
$_LANG['select_csv_file'] = '请上传批量csv文件';
$_LANG['download_file_zh_cn'] = '下载批量CSV文件（简体中文）';
$_LANG['download_file_zh_tw'] = '下载批量CSV文件（繁体中文）';


/* 新订单通知 */
$_LANG['order_notify'] = '新订单通知';
$_LANG['new_order_1'] = '您有新的订单';
$_LANG['new_order_2'] = ' 您有新付款的订单 ';
$_LANG['new_order_3'] = ' 个新付款的订单';
$_LANG['new_order_link'] = '点击查看新订单';

/*语言项*/
$_LANG['chinese_simplified'] = '简体中文';
$_LANG['english'] = '英文';

/* 分页 */
$_LANG['total_records'] = '总计 ';
$_LANG['total_pages'] = '个记录';
$_LANG['page_feiwei'] = '分为';
$_LANG['page_ye'] = '页';
$_LANG['page_size'] = '每页';
$_LANG['page_current'] = '页当前第';
$_LANG['page_first'] = '第一页';
$_LANG['page_prev'] = '上一页';
$_LANG['page_next'] = '下一页';
$_LANG['page_last'] = '最末页';
$_LANG['admin_home'] = '起始页';

/* 重量 */
$_LANG['gram'] = '克';
$_LANG['kilogram'] = '千克';

/* 菜单分类部分 */
$_LANG['02_cat_and_goods'] = '商品管理';
$_LANG['03_goods_storage'] = '库存管理';
$_LANG['02_promotion'] = '促销管理';
$_LANG['04_order'] = '订单管理';
$_LANG['05_banner'] = '广告管理';
$_LANG['06_stats'] = '统计';
$_LANG['07_content'] = '文章管理';
$_LANG['08_members'] = '会员';
$_LANG['09_others'] = '杂项管理';
$_LANG['10_priv_admin'] = '权限管理';
$_LANG['11_system'] = '系统设置';
$_LANG['01_system'] = '设置'; //by wu
$_LANG['12_template'] = '模板管理';
$_LANG['13_backup'] = '数据库管理';
$_LANG['14_sms'] = '短信管理';
$_LANG['15_rec'] = '推荐管理';
$_LANG['16_email_manage'] = '邮件群发管理';
$_LANG['17_transfer_manage'] = '迁移数据管理';
$_LANG['merch_virualcard']    = '更改加密串';// by kong

/* 商家入驻 ecmoban模板堂 --zhuo start */ 
$_LANG['17_merchants'] = '店铺管理'; 
$_LANG['01_seller_stepup'] = '店铺设置';
$_LANG['01_merchants_steps_list'] = '入驻流程';
$_LANG['02_merchants_users_list'] = '店铺列表';
$_LANG['03_merchants_commission'] = '店铺结算';
$_LANG['03_users_merchants_priv'] = '权限管理';
$_LANG['04_create_seller_grade'] = '店铺评分';
$_LANG['10_seller_grade']        = '等级管理';//  by kong grade
$_LANG['11_seller_apply']        = '店铺申请等级';//  by kong grade
$_LANG['12_seller_store']        = '店铺门店';//  by kong grade

$_LANG['18_batch_manage'] = '批量管理'; 
$_LANG['07_merchants_brand'] = '商家品牌';

//自营
$_LANG['19_self_support'] = '自营'; 
$_LANG['01_self_offline_store'] = '自营门店';
$_LANG['02_self_order_stats'] = '门店订单统计';
$_LANG['03_self_support_info'] = '自营设置';
$_LANG['04_self_basic_info'] = '基本信息设置';

$_LANG['20_ectouch'] = '手机端管理'; 
$_LANG['01_oauth_admin'] = '授权登录';
$_LANG['02_touch_nav_admin'] = '导航管理';
$_LANG['03_touch_ads'] = '广告管理';
$_LANG['04_touch_ad_position'] = '广告位管理';
$_LANG['05_touch_dashboard'] = '可视化装修';


/*云服务*/
$_LANG['21_cloud'] = '云服务中心'; 
$_LANG['01_cloud_services'] = '资源专区';
$_LANG['02_platform_recommend'] = '平台推荐';
$_LANG['03_best_recommend'] = '好货推荐';
/* 商家入驻 ecmoban模板堂 --zhuo end */

/* 商品管理 */
$_LANG['01_goods_list'] = '商品列表';
$_LANG['02_goods_add'] = '添加新商品';
$_LANG['03_category_manage'] = '商品分类';
$_LANG['03_category_list'] = '平台商品分类';
$_LANG['03_store_category_list'] = '店铺商品分类'; //ecmoban模板堂 --zhuo
$_LANG['04_category_add'] = '添加分类';
$_LANG['05_comment_manage'] = '用户评论';
$_LANG['06_goods_brand'] = '品牌管理';
$_LANG['06_goods_brand_list'] = '自营品牌';
$_LANG['07_brand_add'] = '添加品牌';
$_LANG['08_goods_type'] = '商品类型';
$_LANG['09_attribute_list'] = '商品属性';
$_LANG['10_attribute_add'] = '添加属性';
$_LANG['11_goods_trash'] = '商品回收站';
$_LANG['01_review_status'] = '商品审核';
$_LANG['12_batch_pic'] = '图片批量处理';
$_LANG['13_batch_add'] = '商品批量上传';
$_LANG['15_batch_edit'] = '商品批量修改';
$_LANG['16_goods_script'] = '生成商品代码';
$_LANG['17_tag_manage'] = '标签管理';
$_LANG['18_product_list'] = '货品列表';
$_LANG['19_is_sale'] = '已上架商品';
$_LANG['20_is_sale'] = '未上架商品';
$_LANG['52_attribute_add'] = '编辑属性';
$_LANG['53_suppliers_goods'] = '供货商商品管理';
$_LANG['001_goods_setting'] = '商品设置'; // 商品设置
$_LANG['20_goods_lib'] = '本地商品库';
$_LANG['04_goods_lib_list'] = '商品库商品';
$_LANG['21_goods_lib_cat'] = '商品库商品分类';

//库存管理
$_LANG['01_goods_storage_put'] = '库存入库';
$_LANG['02_goods_storage_out'] = '库存出库';

$_LANG['14_goods_export'] = '商品批量导出';

$_LANG['50_virtual_card_list'] = '虚拟商品列表';
$_LANG['51_virtual_card_add'] = '添加虚拟商品';
$_LANG['52_virtual_card_change'] = '更改加密串';
$_LANG['goods_auto'] = '商品自动上下架';
$_LANG['article_auto'] = '文章自动发布';
$_LANG['navigator'] = '自定义导航栏';
$_LANG['presale_cat'] = '预售分类';

/* 促销管理 */
$_LANG['02_marketing_center'] = '营销中心';
$_LANG['02_snatch_list'] = '夺宝奇兵';
$_LANG['snatch_add'] = '添加夺宝奇兵';
$_LANG['04_bonustype_list'] = '红包类型';
$_LANG['bonustype_add'] = '添加红包类型';
$_LANG['05_bonus_list'] = '线下红包';
$_LANG['bonus_add'] = '添加会员红包';
$_LANG['06_pack_list'] = '商品包装';
$_LANG['07_card_list'] = '祝福贺卡';
$_LANG['pack_add'] = '添加新包装';
$_LANG['card_add'] = '添加新贺卡';
$_LANG['08_group_buy'] = '团购活动';
$_LANG['09_topic'] = '专题管理';
$_LANG['topic_add'] = '添加专题';
$_LANG['topic_list'] = '专题列表';
$_LANG['10_auction'] = '拍卖活动';
$_LANG['12_favourable'] = '优惠活动';
$_LANG['13_wholesale'] = '批发管理';
$_LANG['ebao_commend'] = '易宝推荐';
$_LANG['14_package_list'] = '超值礼包';
$_LANG['package_add'] = '添加超值礼包';
//ecmoban模板堂 --zhuo start
$_LANG['take_list'] = '礼品卡提货列表';
$_LANG['gift_gard_type_list'] = '礼品卡类型列表';
$_LANG['gift_gard_type_add'] = '添加礼品卡类型';
$_LANG['gift_gard_list'] = '礼品卡列表';
$_LANG['gift_gard_add'] = '添加礼品卡';
//ecmoban模板堂 --zhuo end
$_LANG['16_presale'] = '预售活动';
$_LANG['17_coupons'] = '优惠券';
$_LANG['18_value_card'] = '储值卡';

//拼团
if (file_exists(MOBILE_TEAM)) {
    $_LANG['18_team'] = '拼团活动';
}
//砍价
if (file_exists(MOBILE_BARGAIN)) {
    $_LANG['19_bargain'] = '砍价活动';
}

//秒杀 liu
$_LANG['03_seckill_list'] = '秒杀活动';

/* 订单管理 */
$_LANG['02_order_list'] = '订单列表';
$_LANG['03_order_query'] = '订单查询';
$_LANG['04_merge_order'] = '合并订单';
$_LANG['05_edit_order_print'] = '订单打印';
$_LANG['06_undispose_booking'] = '缺货登记';
$_LANG['08_add_order'] = '添加订单';
$_LANG['09_delivery_order'] = '发货单列表';
$_LANG['10_back_order'] = '退货单列表';

/* 广告管理 */
$_LANG['ad_position'] = '广告位置';
$_LANG['ad_list'] = '广告列表';

/* 报表统计 */
$_LANG['flow_stats'] = '流量分析';
$_LANG['searchengine_stats'] = '搜索引擎';
$_LANG['report_order'] = '订单统计';
$_LANG['report_sell'] = '销售概况';
$_LANG['sell_stats'] = '销售排行';
$_LANG['sale_list'] = '销售明细';
$_LANG['report_guest'] = '客户统计';
$_LANG['report_users'] = '会员排行';
$_LANG['visit_buy_per'] = '访问购买率';
$_LANG['exchange_count'] = '积分明细';
$_LANG['exchange_count_goods'] = '积分明细商品列表';
$_LANG['z_clicks_stats'] = '站外投放JS';

/* 文章管理 */
$_LANG['02_articlecat_list'] = '文章分类';
$_LANG['articlecat_add'] = '添加文章分类';
$_LANG['03_article_list'] = '文章列表';
$_LANG['article_add'] = '添加新文章';
$_LANG['shop_article'] = '网店文章';
$_LANG['shop_info'] = '网店信息';
$_LANG['shop_help'] = '网店帮助';
$_LANG['vote_list'] = '在线调查';
$_LANG['03_visualnews'] = 'CMS可视化';

/* 会员管理 */
$_LANG['08_unreply_msg'] = '会员留言';
$_LANG['03_users_list'] = '会员列表';
$_LANG['04_users_add'] = '添加会员';
$_LANG['05_user_rank_list'] = '会员等级';
$_LANG['06_list_integrate'] = '会员整合';
$_LANG['09_user_account'] = '充值和提现申请';
$_LANG['10_user_account_manage'] = '资金管理';
$_LANG['13_user_baitiao_info'] = '会员白条';//@author bylu 语言-会员白条;
$_LANG['15_user_vat_info'] = '会员增票资质';// liu
$_LANG['16_users_real'] = '实名认证';
$_LANG['16_seller_users_real'] = '商家实名认证';
$_LANG['12_seller_account'] = '店铺账户';

/* 权限管理 */
$_LANG['01_admin_list'] = '管理员列表';//by kong
$_LANG['02_admin_seller']='下级管理员列表';//by kong
$_LANG['kefu_list']='客服设置';
$_LANG['admin_list_role'] = '角色列表';
$_LANG['admin_role'] = '角色管理';
$_LANG['admin_add'] = '添加管理员';
$_LANG['admin_add_role'] = '添加角色';
$_LANG['admin_edit_role'] = '修改角色';
$_LANG['admin_logs'] = '管理员日志';
$_LANG['agency_list'] = '办事处列表';
$_LANG['suppliers_list'] = '供货商列表';
$_LANG['admin_message'] = '管理员留言';
$_LANG['services_list'] = '客服管理';
$_LANG['seller_grade']    = '商家等级/标准管理';
$_LANG['seller_apply']    = '等级入驻管理';

/* 系统设置 */
$_LANG['01_shop_config'] = '商店设置';
$_LANG['shop_authorized'] = '授权证书';
$_LANG['shp_webcollect'] = '网罗天下';
$_LANG['02_payment_list'] = '支付方式';
$_LANG['03_shipping_list'] = '配送方式';
$_LANG['03_area_shipping'] = '地区&配送';
$_LANG['shipping_date_list'] = '指定配送时间';
$_LANG['05_area_list'] = '地区列表';
$_LANG['07_cron_schcron'] = '计划任务';
$_LANG['08_friendlink_list'] = '友情链接';
$_LANG['09_partnerlink_list'] = '合作伙伴';
$_LANG['shipping_area_list'] = '配送区域';
$_LANG['sitemap'] = '站点地图';
$_LANG['check_file_priv'] = '文件权限检测';
$_LANG['captcha_manage'] = '验证码设置';
$_LANG['fckfile_manage'] = 'Fck上传文件管理';
$_LANG['ucenter_setup'] = 'UCenter设置';
$_LANG['file_check'] = '文件校验';
$_LANG['16_reg_fields'] = '注册项设置';
$_LANG['third_party_service'] = '第三方服务';
$_LANG['website'] = '第三方登录插件管理';
$_LANG['oss_configure'] = '阿里云OSS配置';
$_LANG['open_api'] = '开放对外接口';
$_LANG['api'] = '接口对接';
$_LANG['alidayu_configure'] = '大于短信';
$_LANG['huyi_configure'] = '互亿短信';
$_LANG['alitongxin_configure'] = '阿里短信';
$_LANG['01_sms_setting'] = '短信设置';

/* 模板管理 */
$_LANG['02_template_select'] = '模板选择';
$_LANG['03_template_setup'] = '设置模板';
$_LANG['04_template_library'] = '库项目管理';
$_LANG['05_edit_languages'] = '语言项编辑';
$_LANG['06_template_backup'] = '模板设置备份';
$_LANG['01_visualhome'] = '首页可视化';//by wang
$_LANG['floor_content_list'] = '楼层内容列表';
$_LANG['floor_content_add'] = '添加楼层内容';
$_LANG['set_floor'] = '设置楼层';
$_LANG['all_goods'] = '可选商品';
$_LANG['group_goods'] = '已选商品';

/* 数据库管理 */
$_LANG['02_db_manage'] = '数据备份';
$_LANG['03_db_optimize'] = '数据表优化';
$_LANG['04_sql_query'] = 'SQL查询';
$_LANG['05_synchronous'] = '同步数据';
$_LANG['convert'] = '转换数据';
$_LANG['05_table_prefix'] = '修改表前缀';
$_LANG['09_clear_cache'] = "清除缓存";
$_LANG['08_db_fields'] = '更新字段';

/* 迁移数据管理 */
$_LANG['06_transfer_config'] = '源站点信息设置';
$_LANG['07_transfer_choose'] = '迁移数据';
$_LANG['transfer_confirm'] = '迁移数据确认';

/* 短信管理 */
$_LANG['02_sms_my_info'] = '账号信息';
$_LANG['03_sms_send'] = '发送短信';
$_LANG['04_sms_charge'] = '账户充值';
$_LANG['05_sms_send_history'] = '发送记录';
$_LANG['06_sms_charge_history'] = '充值记录';

$_LANG['affiliate'] = '推荐设置';
$_LANG['affiliate_ck'] = '分成管理';
$_LANG['flashplay'] = '首页主广告管理';
$_LANG['search_log'] = '搜索关键字';

/* 邮件管理 */
$_LANG['01_mail_settings'] = '邮件服务器设置';
$_LANG['02_attention_list'] = '关注管理';
$_LANG['03_email_list'] = '邮件订阅管理';
$_LANG['04_magazine_list'] = '杂志管理';
$_LANG['05_view_sendlist'] = '邮件队列管理';
$_LANG['06_mail_template_manage'] = '邮件消息模板';

/* 积分兑换管理 */
$_LANG['15_exchange_goods'] = '积分商城商品';
$_LANG['15_exchange_goods_list'] = '积分商城商品列表';
$_LANG['exchange_goods_add'] = '添加积分商品';

//ecmoban模板堂 --zhuo start
$_LANG['gift_gard_manage'] = '礼品卡列表';
$_LANG['take_manage'] = '礼品卡提货列表';
//ecmoban模板堂 --zhuo end

/* cls_image类的语言项 */
$_LANG['directory_readonly'] = '目录 % 不存在或不可写';
$_LANG['invalid_upload_image_type'] = '不是允许的图片格式';
$_LANG['upload_failure'] = '文件 %s 上传失败。';
$_LANG['missing_gd'] = '没有安装GD库';
$_LANG['missing_orgin_image'] = '找不到原始图片 %s ';
$_LANG['nonsupport_type'] = '不支持该图像格式 %s ';
$_LANG['creating_failure'] = '创建图片失败';
$_LANG['writting_failure'] = '图片写入失败';
$_LANG['empty_watermark'] = '水印文件参数不能为空';
$_LANG['missing_watermark'] = '找不到水印文件%s';
$_LANG['create_watermark_res'] = '创建水印图片资源失败。水印图片类型为%s';
$_LANG['create_origin_image_res'] = '创建原始图片资源失败，原始图片类型%s';
$_LANG['invalid_image_type'] = '无法识别水印图片 %s ';
$_LANG['file_unavailable'] = '文件 %s 不存在或不可读';

/* 邮件发送错误信息 */
$_LANG['smtp_setting_error'] = '邮件服务器设置信息不完整';
$_LANG['smtp_connect_failure'] = '无法连接到邮件服务器 %s';
$_LANG['smtp_login_failure'] = '邮件服务器验证帐号或密码不正确';
$_LANG['sendemail_false'] = '邮件发送失败，请检查您的邮件服务器设置！';
$_LANG['smtp_refuse'] = '服务器拒绝发送该邮件';
$_LANG['disabled_fsockopen'] = '服务器已禁用 fsocketopen 函数。';

//批量导出
$_LANG['time'] = '处理时间';
$_LANG['wait'] = '正在处理.....';
$_LANG['page_format'] = '第 %d 页';
$_LANG['total_format'] = '共 %d 页';
$_LANG['time_format'] = '耗时 %s 秒';

/* 虚拟卡 */
$_LANG['virtual_card_oos'] = '虚拟卡已缺货';

$_LANG['span_edit_help'] = '点击修改内容';
$_LANG['href_sort_help'] = '点击对列表排序';

$_LANG['catname_exist'] = '已存在相同的分类名称!';
$_LANG['brand_name_exist'] = '已存在相同的品牌名称!';

$_LANG['alipay_login'] = '<a href="https://www.alipay.com/user/login.htm?goto=https%3A%2F%2Fwww.alipay.com%2Fhimalayas%2Fpracticality_profile_edit.htm%3Fmarket_type%3Dfrom_agent_contract%26customer_external_id%3D%2BC4335319945672464113" target="_blank">立即免费申请支付接口权限</a>';
$_LANG['alipay_look'] = '<a href=\"https://www.alipay.com/himalayas/practicality.htm\" target=\"_blank\">请申请成功后登录支付宝账户查看</a>';

/*大商创1.5后台新增*/
$_LANG['dsc_admin'] ='大商创管理中心';
$_LANG['self'] ='自营';

$_LANG['steps_shop_name'] = '店铺名称';
$_LANG['steps_shop_type'] = '店铺类型';
$_LANG['platform_self'] = '平台自营';
$_LANG['s_shop_name'] = '按店铺名称';
$_LANG['s_qw_shop_name'] = '按期望店铺名称';
$_LANG['s_brand_type'] = '按入驻品牌+类型';
$_LANG['flagship_store'] = '旗舰店';
$_LANG['exclusive_shop'] = '专卖店';
$_LANG['franchised_store'] = '专营店';
$_LANG['shop_store'] = '馆';

$_LANG['have_audited'] = '已审核';
$_LANG['not_audited'] = '未审核';
$_LANG['not_through'] = '未通过';
$_LANG['yes_through'] = '通过';
$_LANG['audited_yes_adopt'] = '审核已通过';
$_LANG['audited_not_adopt'] = '审核未通过';
$_LANG['adopt_reply'] = '审核回复';
$_LANG['wuxu_adopt'] = '无需审核';
$_LANG['adopt_goods'] = '审核商品';
$_LANG['adopt_brand'] = '审核品牌';
$_LANG['adopt_status'] = '审核状态';
$_LANG['allow'] = '允许';
$_LANG['not_allow'] = '不允许';

$_LANG['search_key'] = '请输入查询关键字...';
$_LANG['window_name'] = '橱窗名称';
$_LANG['window_type'] = '橱窗类型';
$_LANG['window_color'] = '橱窗色调';
$_LANG['window_css'] = '橱窗样式';
$_LANG['whether_display'] = '是否显示';
$_LANG['notice_custom'] = '决定是否在店铺首页显示该橱窗';
$_LANG['custom_content'] = '自定义内容';
$_LANG['merchandise_cabinet'] = '商品柜';
$_LANG['select_color'] = '选色';
$_LANG['display'] = '显示';
$_LANG['add_product'] = '添加商品';

$_LANG['background_color'] = '背景颜色';
$_LANG['imgage'] = '图片';
$_LANG['color'] = '颜色';
$_LANG['view_content'] = '查看内容';

$_LANG['use_type'] = '使用类型';
$_LANG['seller'] = '商家';
$_LANG['full_court'] = '全场';
$_LANG['act_name'] = '活动名称';
$_LANG['general_audience'] = '全场通用';
$_LANG['autonomous_use'] = '自主使用';
$_LANG['user_name'] = '用户名';
$_LANG['order_id'] = '订单号';
$_LANG['yuan'] = '元';
$_LANG['separator_null'] = '分隔符不可以不填写';

$_LANG['product_desc'] = '商品描述相符';
$_LANG['seller_fwtd'] = '卖家服务态度';
$_LANG['logistics_speed'] = '物流发货速度';
$_LANG['logistics_senders'] = '配送人员态度';
$_LANG['comment_time'] = '评论时间';

$_LANG['upload_image'] = '上传图片';
$_LANG['close'] = '关闭';
$_LANG['open'] = '开启';

$_LANG['man'] = '满';
$_LANG['lijian'] = '立减';

$_LANG['all_region'] ='所有区域';
$_LANG['optional_region'] ='可选地区';

$_LANG['goods_name'] = '商品名称';
$_LANG['start_time'] = '开始时间';
$_LANG['end_time'] = '结束时间';
$_LANG['default'] = '默认';
$_LANG['click'] = '点击';
$_LANG['keyword'] = '关键词';
$_LANG['submit'] = '提交';

$_LANG['select_batch_file'] = '选择批量上传';

$_LANG['carousel_image'] = '轮播图片';
$_LANG['image_href'] = '图片超链接';
$_LANG['image_explain'] = '图片说明';
$_LANG['transform_style'] = '变换样式';
$_LANG['background_image'] = '背景图片';
$_LANG['background_repeat'] = '背景重复';
$_LANG['not_repeat'] = '不重复';
$_LANG['repeat'] = '平铺';
$_LANG['left_right_repeat'] = '左右平铺';
$_LANG['vertical_repeat'] = '垂直平铺';
$_LANG['shop_background_color'] = '店铺背景颜色';
$_LANG['shop_background'] = '店铺背景颜色';
$_LANG['display_color'] = '显示颜色';
$_LANG['display_image'] = '显示图片';
$_LANG['adv_image'] = '广告图片';
$_LANG['adv_href'] = '广告链接';
$_LANG['adv_href_notice'] = '链接地址格式如:http://xxxxx.com';
$_LANG['display_notice'] = '(决定是否在导航上显示)';
$_LANG['image_transform'] = '图片变换方式';
$_LANG['gradient'] = '渐变';
$_LANG['roll'] = '滚动';
$_LANG['image_transform_notice'] = '(多张图片设置的效果不一样时,将以排在首张的图片效果变化)';
$_LANG['images_explain'] = '图片说明';
$_LANG['enable_custom_background'] = '启用自定义背景';
$_LANG['confirm_background'] = '确认背景';
$_LANG['setup_color'] = '已设置的颜色有';
$_LANG['view_image'] = '查看图片';
$_LANG['batch_delete'] = '批量删除';
$_LANG['select_attr'] = '属性选择';
$_LANG['search_comment_tlq'] = '讨论关键字';
$_LANG['have_no_file'] = '文件不存在或已删除'; //by wu
$_LANG['goods_alt'] = '商品';
$_LANG['tiao'] = '条';
$_LANG['wu'] = '无';
$_LANG['you'] = '有';
$_LANG['report_form'] = '报表';
$_LANG['optional_brand'] = '可选品牌';
$_LANG['selected_brand'] = '可选品牌';
$_LANG['src_list'] = '待选列表';
$_LANG['dest_list'] = '已选列表';
$_LANG['brand'] = '品牌';

/* 众筹管理 by liu */
$_LANG['09_crowdfunding'] = '众筹管理';
$_LANG['01_crowdfunding_list'] = '众筹项目列表';
$_LANG['02_crowdfunding_cat'] = '众筹分类';
$_LANG['03_project_initiator'] = '发起人管理';
$_LANG['04_topic_list'] = '话题管理';
$_LANG['category'] = '分类';


/*后台头部语言包*/
$_LANG['menuplatform'] = "平台";
$_LANG['menushopping'] = "商城";
$_LANG['menuinformation'] = "资源";
$_LANG['third_party'] = "第三方服务";
$_LANG['ectouch'] = "手机";
$_LANG['finance'] = "财务";
$_LANG['ecjia'] = "APP";

// APP 一级菜单 语言包 qin
$_LANG['20_ecjia_app'] = "移动应用（mobile）";
$_LANG['22_ecjia_shipping'] = "配送方式";
$_LANG['24_ecjia_sms'] = "短信管理";
$_LANG['26_ecjia_feedback'] = "留言反馈";
$_LANG['28_ecjia_marketing'] = "营销顾问管理";
$_LANG['30_ecjia_push'] = "推送消息";


// APP二级菜单 移动应用
$_LANG['02_ecjia_app_shortcut'] = "快捷菜单";
$_LANG['03_ecjia_app_shortcut_ipad'] = "iPad快捷菜单";
$_LANG['04_ecjia_app_cycleimage'] = "手机端轮播图";
$_LANG['05_ecjia_app_cycleimage_ipad'] = "iPad手机端轮播图";
$_LANG['06_ecjia_app_discover'] = "百宝箱";
$_LANG['08_ecjia_app_device'] = "移动设备";
$_LANG['10_ecjia_app_news'] = "今日热点";
$_LANG['12_ecjia_app_config'] = "应用配置";
$_LANG['14_ecjia_app_manage'] = "客户端管理";
$_LANG['16_ecjia_app_toutiao'] = "商城头条";
$_LANG['18_ecjia_app_activity'] = "活动列表";


// APP二级菜单 配送方式
$_LANG['02_ecjia_shipping_ship'] = "配送方式";

// APP二级菜单 短信管理
$_LANG['02_ecjia_sms_record'] = "短信记录";
$_LANG['04_ecjia_sms_template'] = "短信模板";
$_LANG['06_ecjia_sms_config'] = "短信配置";

// APP二级菜单 留言反馈
$_LANG['02_ecjia_feedback_order'] = "订单留言";
$_LANG['04_ecjia_feedback_user'] = "会员留言";
$_LANG['06_ecjia_feedback_public'] = "公共留言";
$_LANG['08_ecjia_feedback_mobile'] = "手机资讯";

// APP二级菜单 留言反馈
$_LANG['02_ecjia_marketing_adviser'] = "营销顾问";

// APP二级菜单 推送消息
$_LANG['02_ecjia_push_record'] = "消息记录";
$_LANG['04_ecjia_push_event'] = "消息事件";
$_LANG['06_ecjia_push_template'] = "消息模板";
$_LANG['08_ecjia_push_config'] = "消息配置";

// 手机端菜单语言包
$_LANG['20_ectouch'] = '手机端管理'; 
$_LANG['01_oauth_admin'] = '授权登录';
$_LANG['02_touch_nav_admin'] = '导航管理';
$_LANG['03_touch_ads'] = '广告管理';
$_LANG['04_touch_ad_position'] = '广告位管理';

//微信通菜单语言包
if (file_exists(MOBILE_WECHAT)) {
    $_LANG['22_wechat'] = '微信通管理';
    $_LANG['01_wechat_admin'] = '公众号设置';
    $_LANG['02_mass_message'] = '群发消息';
    $_LANG['03_auto_reply'] = '自动回复';
    $_LANG['04_menu'] = '自定义菜单';
    $_LANG['05_fans'] = '粉丝管理';
    $_LANG['06_media'] = '素材管理';
    $_LANG['07_qrcode'] = '二维码管理';
    $_LANG['08_share'] = '扫码引荐';
    $_LANG['09_extend'] = '功能扩展';
    $_LANG['10_market'] = '营销中心';
    $_LANG['11_template'] = '消息提醒';
    $_LANG['30_wxppconfig'] = '小程序设置';

}
//微分销菜单语言包
if (file_exists(MOBILE_DRP)) {
    $_LANG['23_drp'] = '分销管理';
    $_LANG['01_drp_config'] = '店铺设置';
    $_LANG['02_drp_shop'] = '分销商管理';
    $_LANG['03_drp_list'] = '分销排行';
    $_LANG['04_drp_order_list'] = '分销订单操作';
    $_LANG['05_drp_set_config'] = '分销比例设置';
}

/*页面公共语言*/
$_LANG['operating_hints']                  =    '操作提示';
$_LANG['fold_tips']                        =    '收起提示';
$_LANG['refresh_data']                     =    '刷新数据';
$_LANG['total_data']                       =    '共';
$_LANG['data']                             =    '条数据';
$_LANG['advanced_search']                  =    '高级搜索';
$_LANG['pack_up']                          =    '收起边栏';
$_LANG['select_cat']                       =    '请选择分类';
$_LANG['select_barnd']                     =    '请选择品牌';
$_LANG['optional_goods']                   =    '可选择商品';
$_LANG['input_keywords']                   =    '请输入关键字';
$_LANG['refresh_common']                   =    '刷新 - 共';
$_LANG['record']                   		   =    '条记录';
$_LANG['return_to_superior']               =    '返回上级';
$_LANG['add_next_level']               	   =    '新增下一级';
$_LANG['view_next_level']                  =    '查看下一级';
$_LANG['has_ended']                        =    '已结束';
$_LANG['please_search_goods']              =    '请先搜索商品';
$_LANG['view_tutorials']              	   =    '查看教程';
$_LANG['view_record']					   =    '查看记录';
$_LANG['region_select']					   =    '地区选择';

/* 页面公共操作提示 start*/
$_LANG['operation_prompt_content_common']  =    '标识“<em>*</em>”的选项为必填项，其余为选填项。';
/* 页面公共操作提示 end*/

$_LANG['article'] ='文章';
$_LANG['order_word'] ='订单';

$_LANG['gallery_album'] = "图片库管理";
$_LANG['goods_report'] = "举报管理";
$_LANG['promotion'] = "促销";


/*佣金模式 by wu*/
$_LANG['commission_model']['1'] = '分类模式';
$_LANG['commission_model']['0'] = '默认模式';
$_LANG['privilege_seller'] = "编辑个人资料";

$_LANG['self_run'] = "自营";
$_LANG['report_conf']           = '举报设置';
$_LANG['report_conf_success']           = '举报设置成功';
$_LANG['13_complaint'] = "投诉管理";//by kong
$_LANG['complain_conf']         = '投诉设置';
$_LANG['complain_conf_success']           = '投诉设置成功';

//b2b
$_LANG['supply_and_demand'] = '供求';
$_LANG['01_wholesale_purchase'] = '求购列表';
$_LANG['02_wholesale_order'] = '采购订单';
$_LANG['03_wholesale_purchase'] = '求购列表';
$_LANG['wholesale_purchase'] = '求购列表';
$_LANG['wholesale_order'] = '采购订单';
$_LANG['01_wholesale'] = '批发管理';

// 第三方服务
$_LANG['24_sms'] = '短信管理'; 
$_LANG['25_file'] = '文件管理';
$_LANG['26_login'] = '登录管理';
$_LANG['27_interface'] = '接口管理';

//商品设置
$_LANG['goods_setup'] = '商品设置';
$_LANG['goods_setup_success'] = '商品设置成功';

//短信配置
$_LANG['sms_setting'] = '短信配置';

//短信群发
$_LANG['17_mass_sms'] = '短信群发';
$_LANG['mass_sms'] = '短信群发';

$_LANG['template_mall'] = '店铺模板';

//佣金设置
$_LANG['commission_setting'] = '商品佣金设置';

//进销存
$_LANG['01_psi_purchase'] = '商品入库';
$_LANG['03_psi_inventory'] = '库存管理';
$_LANG['goods_psi'] = '进销存管理';

//快递鸟、电子面单
$_LANG['kdniao'] = '快递鸟配置';
$_LANG['order_print_setting'] = '打印设置';

//日期
$_LANG['js_languages']['start_data_notnull'] = '开始日期不能为空';
$_LANG['js_languages']['end_data_notnull'] = '结束日期不能为空';
$_LANG['js_languages']['data_invalid_gt'] = '输入的结束时间应大于起始日期';
$_LANG['js_languages']['file_not_null'] = '上传文件不能为空';
$_LANG['js_languages']['confirm_delete'] = '确定删除吗?';
$_LANG['js_languages']['confirm_delete_fail'] = '删除失败';
$_LANG['js_languages']['file_null'] = '请选择上传文件';
$_LANG['js_languages']['title_name_one'] = '已完成更新，请关闭该窗口！';
$_LANG['js_languages']['title_name_two'] = '正在更新数据中，请勿关闭该窗口！';

//卖场
$_LANG['18_region_store'] = '卖场';
$_LANG['01_region_store_manage'] = '卖场管理';

//首页
$_LANG['00_home'] = '首页';
$_LANG['01_admin_core'] = '管理中心';
$_LANG['02_operation_flow'] = '业务流程';
$_LANG['03_novice_guide'] = '新手向导';
?>