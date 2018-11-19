<?php

/**
 * ECSHOP 管理中心模板管理语言文件
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: template.php 17217 2018-07-19 06:29:08Z liubo $
*/

$_LANG['template_manage'] = '模板管理';
$_LANG['current_template'] = '当前模板';
$_LANG['available_templates'] = '可用模板';
$_LANG['select_template'] = '请选择一个模板：';
$_LANG['floor_brand_setup'] = '楼层品牌设置';
$_LANG['select_library'] = '请选择一个库项目：';
$_LANG['library_name'] = '库项目';
$_LANG['region_name'] = '区域';
$_LANG['sort_order'] = '序号';
$_LANG['contents'] = '内容';
$_LANG['number'] = '数量';
$_LANG['display'] = '显示';
$_LANG['select_plz'] = '请选择...';
$_LANG['button_restore'] = '还原到上一修改';

/* 提示信息 */
$_LANG['library_not_written'] = '库文件 %s 没有修改权限，该库文件将无法修改';
$_LANG['install_template_success'] = '启用模板成功。';
$_LANG['setup_success'] = '设置模板内容成功。';
$_LANG['modify_dwt_failed'] = '模板文件 %s 无法修改';
$_LANG['update_lib_success'] = '库项目内容已经更新成功。';
$_LANG['update_lib_failed'] = '编辑库项目内容失败。请检查 %s 目录是否可以写入。';
$_LANG['backup_success'] = "所有模板文件已备份到templates/backup目录下。\n您现在要下载备份文件吗？。";
$_LANG['backup_failed'] = '备份模板文件失败，请检查templates/backup 目录是否可以写入。';
$_LANG['not_editable'] = '非可编辑区库文件无选择项';
$_LANG['category_repeat'] = '首页楼层分类不能重复';
$_LANG['number_repeat'] = '首页楼层序号不能重复';

/* 每一个模板文件对应的语言 */
$_LANG['template_files']['article'] = '文章内容模板';
$_LANG['template_files']['article_cat'] = '文章分类模板';
$_LANG['template_files']['brand'] = '品牌专区';
//$_LANG['template_files']['catalog'] = '所有分类页';
$_LANG['template_files']['category'] = '商品分类页模板';
$_LANG['template_files']['flow'] = '购物流程模板';
$_LANG['template_files']['goods'] = '商品详情模板';
$_LANG['template_files']['group_buy_goods'] = '团购商品详情模板';
$_LANG['template_files']['group_buy_list'] = '团购商品列表模板';
$_LANG['template_files']['index'] = '首页模板';
$_LANG['template_files']['search'] = '商品搜索模板';
$_LANG['template_files']['compare'] = '商品比较模板';
$_LANG['template_files']['snatch_list'] = '夺宝奇兵'; //ecmoban模板堂 --zhuo
$_LANG['template_files']['snatch'] = '夺宝奇兵详情模板'; //ecmoban模板堂 --zhuo
$_LANG['template_files']['tag_cloud'] = '标签云模板';
$_LANG['template_files']['brand'] = '商品品牌页';
$_LANG['template_files']['auction_list'] = '拍卖活动列表';
$_LANG['template_files']['auction'] = '拍卖活动详情';
$_LANG['template_files']['message_board'] = '留言板';
//$_LANG['template_files']['quotation'] = '报价单';
$_LANG['template_files']['exchange_list'] = '积分商城列表';
//ecmoban模板堂 --zhuo start
$_LANG['template_files']['merchants'] = '商家入驻';
$_LANG['template_files']['merchants_steps'] = '商家入驻流程';
$_LANG['template_files']['merchants_store'] = '独立商家';
//ecmoban模板堂 --zhuo end

//ecmoban模板堂 --yan start
$_LANG['template_files']['merchants_index'] = '店铺首页';
//ecmoban模板堂 --yan end

/* 每一个库项目的描述 */
$_LANG['template_libs']['history_goods'] = '商品浏览历史'; //ecmoban模板堂 --zhuo
$_LANG['template_libs']['ad_position'] = '广告位';
$_LANG['template_libs']['index_ad'] = '首页主广告位';
$_LANG['template_libs']['cat_articles'] = '文章列表';
$_LANG['template_libs']['articles'] = '文章列表';
$_LANG['template_libs']['goods_attrlinked'] = '属性关联的商品';
$_LANG['template_libs']['recommend_best'] = $_LANG['template_libs']['recommend_best_goods'] = '精品推荐';
$_LANG['template_libs']['recommend_promotion'] = '促销商品';
$_LANG['template_libs']['recommend_hot'] = $_LANG['template_libs']['recommend_hot_goods'] = '热卖商品';
$_LANG['template_libs']['recommend_new'] = $_LANG['template_libs']['recommend_new_goods'] = '新品上架';
$_LANG['template_libs']['bought_goods'] = '购买过此商品的人还买过的商品';
$_LANG['template_libs']['bought_note_guide'] = '购买记录';
$_LANG['template_libs']['brand_goods'] = '品牌的商品';
$_LANG['template_libs']['brands'] = '品牌专区';
$_LANG['template_libs']['cart'] = '购物车';
$_LANG['template_libs']['cat_goods'] = '分类下的商品';
$_LANG['template_libs']['category_tree'] = '商品分类树';
$_LANG['template_libs']['comments'] = '用户评论列表';
$_LANG['template_libs']['consignee'] = '收货地址表单';
$_LANG['template_libs']['goods_fittings'] = '相关配件';
$_LANG['template_libs']['page_footer'] = '页脚';
$_LANG['template_libs']['goods_gallery'] = '商品相册';
$_LANG['template_libs']['goods_article'] = '相关文章';
$_LANG['template_libs']['goods_list'] = '商品列表';
$_LANG['template_libs']['goods_tags'] = '商品标记';
$_LANG['template_libs']['group_buy'] = '团购商品';
$_LANG['template_libs']['group_buy_fee'] = '团购商品费用总计';
$_LANG['template_libs']['help'] = '帮助内容';
$_LANG['template_libs']['history'] = '商品浏览历史';
$_LANG['template_libs']['comments_list'] = '评论内容';
$_LANG['template_libs']['invoice_query'] = '发货单查询';
$_LANG['template_libs']['member'] = '会员区';
$_LANG['template_libs']['member_info'] = '会员信息';
$_LANG['template_libs']['new_articles'] = '最新文章';
$_LANG['template_libs']['order_total'] = '订单费用总计';
$_LANG['template_libs']['page_header'] = '页面顶部';
$_LANG['template_libs']['pages'] = '列表分页';
$_LANG['template_libs']['goods_related'] = '相关商品';
$_LANG['template_libs']['search_form'] = '搜索表单';
$_LANG['template_libs']['signin'] = '登录表单';
$_LANG['template_libs']['snatch'] = '夺宝奇兵出价';
$_LANG['template_libs']['snatch_price'] = '夺宝奇兵最新出价';
$_LANG['template_libs']['top10'] = '销售排行';
$_LANG['template_libs']['ur_here'] = '当前位置';
$_LANG['template_libs']['user_menu'] = '用户中心菜单';
$_LANG['template_libs']['vote'] = '调查';
$_LANG['template_libs']['auction'] = '拍卖商品';
$_LANG['template_libs']['article_category_tree'] = '文章分类树';
$_LANG['template_libs']['order_query'] = '前台订单状态查询';
$_LANG['template_libs']['email_list'] = '前台邮件订阅';
$_LANG['template_libs']['vote_list'] = '在线调查';
$_LANG['template_libs']['price_grade'] = '价格范围';
$_LANG['template_libs']['filter_attr'] = '属性筛选';
$_LANG['template_libs']['promotion_info'] = '促销信息';
$_LANG['template_libs']['categorys'] = '商品分类';
$_LANG['template_libs']['myship'] = '配送方式';
$_LANG['template_libs']['online'] = '统计在线人数';
$_LANG['template_libs']['relatetag'] = '其他应用关联标签数据';
$_LANG['template_libs']['message_list'] = '留言列表';
$_LANG['template_libs']['exchange_hot'] = '积分商城热卖商品';
$_LANG['template_libs']['exchange_best'] = '积分商城推荐商品'; //ecmoban模板堂 --zhuo
$_LANG['template_libs']['exchange_list'] = '积分商城列表商品';
$_LANG['template_libs']['auction_hot'] = '热门拍卖商品';  //ecmoban模板堂 --zhuo
$_LANG['template_libs']['snatch_hot'] = '热门夺宝商品';  //ecmoban模板堂 --zhuo
//sunle 新增
$_LANG['template_libs']['active_gallery'] = '拍卖商品详情相册';
$_LANG['template_libs']['article_channel_left_ad'] = 'CMS频道左侧广告';
$_LANG['template_libs']['basic_type'] = '申请入驻流程步骤一';
$_LANG['template_libs']['brand_list_left_ad'] = '品牌商品列表顶部左侧广告';
$_LANG['template_libs']['brand_list_right_ad'] = '品牌商品列表顶部右侧广告';
$_LANG['template_libs']['brank_type'] = '申请入驻流程申请品牌';
$_LANG['template_libs']['brank_type_search'] = '申请入驻流程品牌搜索';
$_LANG['template_libs']['bouns_available_list'] = '会员中心红包列表';
$_LANG['template_libs']['brand_cat_ad'] = '品牌首页分类下广告';
$_LANG['template_libs']['cart_favourable_box'] = '购物车商品促销信息';
$_LANG['template_libs']['cart_favourable_list'] = '购物车商品促销列表';
$_LANG['template_libs']['cart_gift_box'] = '购物车显示赠品商品';
$_LANG['template_libs']['cart_html'] = '购物车操作弹框';
$_LANG['template_libs']['cart_info'] = '购物车信息';
$_LANG['template_libs']['brandn_header'] = '品牌详情页导航栏';
$_LANG['template_libs']['brandn_left_ad'] = '品牌详情页左侧广告位';
$_LANG['template_libs']['brandn_top_ad'] = '品牌详情页顶部banner广告位';
$_LANG['template_libs']['cart_menu_info'] = '前台页面右侧悬浮工具栏';
$_LANG['template_libs']['cat_goods_banner'] = '首页楼层左侧轮播广告图';
$_LANG['template_libs']['cat_goods_change'] = '顶级分类页楼层商品换一组切换';
$_LANG['template_libs']['cat_goods_hot'] = '首页每个楼层底边热门商品';
$_LANG['template_libs']['cat_top_ad'] = '顶级分类页banner广告位';
$_LANG['template_libs']['cat_top_floor_ad'] = '顶级分类页首页楼层左侧广告幻灯片';
$_LANG['template_libs']['cat_top_new_ad'] = '顶级分类页首页新品首发左侧上广告';
$_LANG['template_libs']['cat_top_newt_ad'] = '顶级分类页首页新品首发左侧下广告';
$_LANG['template_libs']['cat_top_prom_ad'] = '顶级分类页首页幻灯片下优惠商品左侧广告';
$_LANG['template_libs']['cate_top_history_goods'] = '顶级分类页浏览历史';
$_LANG['template_libs']['cate_type'] = '商家入驻流程选择商品分类';
$_LANG['template_libs']['category_all_left'] = '全部商品分类左侧广告';
$_LANG['template_libs']['category_all_right'] = '全部商品分类右侧广告';
$_LANG['template_libs']['category_parent_brands'] = '顶级分类页分类栏分类下的品牌logo';
$_LANG['template_libs']['category_recommend_best'] = '推广商品列表';
$_LANG['template_libs']['category_recommend_hot'] = '分类页顶部热门推荐商品';
$_LANG['template_libs']['category_screening'] = '分类页商品筛选栏';
$_LANG['template_libs']['category_top_banner'] = '顶级分类页默认模板顶部幻灯片广告位';
$_LANG['template_libs']['category_top_left'] = '顶级分类页默认模板左侧广告位';
$_LANG['template_libs']['collection_goods_list'] = '用户中心商品收藏';
$_LANG['template_libs']['collection_store_list'] = '用户中心店铺关注';
$_LANG['template_libs']['comment_image'] = '用户评论上传晒单图片';
$_LANG['template_libs']['comment_repay'] = '商品评论回复';
$_LANG['template_libs']['comment_reply'] = '商品评论回复';
$_LANG['template_libs']['comments_discuss_list1'] = '网友讨论圈内容页';
$_LANG['template_libs']['comments_discuss_list2'] = '网友讨论圈内容页';
$_LANG['template_libs']['comments_form'] = '用户中心评论晒单表单';
$_LANG['template_libs']['common_html'] = '弹出框提示信息';
$_LANG['template_libs']['compare_tab3'] = '商品对比结果页面';
$_LANG['template_libs']['consignee_flow'] = '编辑收货人信息';
$_LANG['template_libs']['consignee_new'] = '新增收货人信息';
$_LANG['template_libs']['coudan_top_list'] = '购物凑单顶部商品';
$_LANG['template_libs']['discuss_left'] = '网友讨论圈左侧商品信息';
$_LANG['template_libs']['duibi'] = '对比框';
$_LANG['template_libs']['flow_cart_goods'] = '结算页面送货清单';
$_LANG['template_libs']['flow_info'] = '购物车总价';
$_LANG['template_libs']['gift_gard_list'] = '礼品卡商品列表';
$_LANG['template_libs']['goods_attr'] = '商品属性';
$_LANG['template_libs']['goods_comment_title'] = '商品详情页商品评论';
$_LANG['template_libs']['goods_delivery_area'] = '商品详情页配送地区选择';
$_LANG['template_libs']['goods_discuss_title'] = '商品详情页商品评论区';
$_LANG['template_libs']['goods_fittings_cnt'] = '商品详情页搭配配件';
$_LANG['template_libs']['goods_fittings_result'] = '搭配配件弹出框口';
$_LANG['template_libs']['goods_fittings_result_type'] = '搭配配件属性';
$_LANG['template_libs']['goods_merchants'] = '商品详情页店铺信息';
$_LANG['template_libs']['goods_stock_exhausted'] = '无货结算';
$_LANG['template_libs']['goods_warehouse'] = '商品详情页仓库';
$_LANG['template_libs']['guess_goods_love'] = '商品详情页猜你喜欢';
$_LANG['template_libs']['guess_you_like'] = '首页猜你喜欢';
$_LANG['template_libs']['have_a_look'] = '随便看看';
$_LANG['template_libs']['header_region_style'] = '页面顶部导航栏';
$_LANG['template_libs']['history_search_filter'] = '浏览历史排序';
$_LANG['template_libs']['index_ad_position'] = '首页banner轮播图';
$_LANG['template_libs']['index_banner_group_ad'] = '首页限时抢购广告位';
$_LANG['template_libs']['index_brand_street'] = '首页品牌街品牌logo';
$_LANG['template_libs']['index_cat_brand_ad'] = '首页分类栏品牌logo';
$_LANG['template_libs']['index_brand_banner'] = '首页品牌街右侧广告位';
$_LANG['template_libs']['index_cat_topic'] = '首页分类栏热门推荐分类';
$_LANG['template_libs']['index_cat_tree'] = '首页分类栏二级分类';
$_LANG['template_libs']['index_group_ad'] = '首页团购广告位';
$_LANG['template_libs']['index_group_banner'] = '首页团购广告位内容';
$_LANG['template_libs']['index_banner_group_list'] = '首页分类小广告';
$_LANG['template_libs']['index_brand_ad'] = '首页品牌街';
$_LANG['template_libs']['invoice'] = '发票内容页面';
$_LANG['template_libs']['left_help'] = '文章页面左侧分类';
$_LANG['template_libs']['load_brands'] = '品牌街异步加载';
$_LANG['template_libs']['load_cat_goods'] = '首页楼层异步加载';
$_LANG['template_libs']['load_category_top'] = '顶级分类页楼层异步加载';
$_LANG['template_libs']['login_banner'] = '登录页轮播广告';
$_LANG['template_libs']['login_dialog_body'] = '未登录时登录弹出框';
$_LANG['template_libs']['merchants_cate_checked_list'] = '商家入驻时添加的分类列表';
$_LANG['template_libs']['merchants_cate_list'] = '商家入驻时添加二级分类';
$_LANG['template_libs']['merchants_city_list'] = '商家城市列表';
$_LANG['template_libs']['merchants_steps_catePermanent'] = '商家入驻类目行业资质';
$_LANG['template_libs']['notic_down_ad'] = 'CMS页面商城公告下面广告';
$_LANG['template_libs']['page_footer_flow'] = '购物车结算页面通用底部';
$_LANG['template_libs']['page_header_category'] = '分类页通用头部';
$_LANG['template_libs']['page_header_flow'] = '购物车结算页通用头部';
$_LANG['template_libs']['page_header_index'] = '首页通用头部';
$_LANG['template_libs']['page_header_merchants_flow'] = '商家入驻通用头部';
$_LANG['template_libs']['page_header_narrow'] = '商家入驻首页头部';
$_LANG['template_libs']['page_header_presale'] = '预售通用头部';
$_LANG['template_libs']['page_header_presale_index'] = '预售首页头部';
$_LANG['template_libs']['page_header_store'] = '商家店铺默认页头部';
$_LANG['template_libs']['page_header_store_tpl'] = '商家店铺装修过模板头部';
$_LANG['template_libs']['page_header_user'] = '用户中心头部';
$_LANG['template_libs']['page_header_coupons'] = '优惠券页面头部';
$_LANG['template_libs']['picksite'] = '结算页面自提点弹出框内容';
$_LANG['template_libs']['picksite_date'] = '结算页面自提点时间选择';
$_LANG['template_libs']['position_get_adv'] = '页面最顶部广告位';
$_LANG['template_libs']['position_get_adv_small'] = '入驻商家首页头部广告';
$_LANG['template_libs']['position_merchantsIn'] = '';
$_LANG['template_libs']['position_merchantsIn_users'] = '';
$_LANG['template_libs']['position_merchants_usersBott'] = '';
$_LANG['template_libs']['presale_banner'] = '预售首页大轮播图';
$_LANG['template_libs']['presale_banner_advance'] = '预售抢先订页轮播图';
$_LANG['template_libs']['presale_banner_category'] = '预售分类页轮播图';
$_LANG['template_libs']['presale_banner_new'] = '预售新品轮播图';
$_LANG['template_libs']['presale_banner_small'] = '预售首页小轮播';
$_LANG['template_libs']['presale_banner_small_left'] = '预售首页小轮播左侧的banner';
$_LANG['template_libs']['presale_banner_small_right'] = '预售首页小轮播右侧的banner';
$_LANG['template_libs']['range_gift_list'] = '优惠活动页展开优惠商品';
$_LANG['template_libs']['return_goods_img'] = '退换货图片轮播';
$_LANG['template_libs']['right_float_cart_info'] = '右侧悬浮导航菜单栏购物车展开栏';
$_LANG['template_libs']['right_float_collection_info'] = '右侧悬浮导航菜单栏我的收藏展开栏';
$_LANG['template_libs']['right_float_histroy_info'] = '右侧悬浮导航菜单栏浏览历史展开栏';
$_LANG['template_libs']['right_float_order_info'] = '右侧悬浮导航菜单栏我的订单展开栏';
$_LANG['template_libs']['right_float_total_info'] = '右侧悬浮导航菜单栏我的资产展开栏';
$_LANG['template_libs']['right_float_yhq_info'] = '右侧悬浮导航菜单栏我的优惠券展开栏';
$_LANG['template_libs']['search_brand_filter'] = '品牌商品列表页筛选栏';
$_LANG['template_libs']['search_filter'] = '搜索商品列表页筛选栏';
$_LANG['template_libs']['search_goods_list'] = '搜索页面商品列表页';
$_LANG['template_libs']['search_left_ad'] = '搜索商品页头部左侧广告';
$_LANG['template_libs']['search_right_ad'] = '搜索商品页头部右侧广告';
$_LANG['template_libs']['search_store_shop_list'] = '店铺搜索页面店铺列表';
$_LANG['template_libs']['search_street_filter'] = '店铺搜索页面筛选栏';
$_LANG['template_libs']['secondlevel_cat_tree2'] = '留言板左侧分类栏';
$_LANG['template_libs']['shop_info'] = '商家入驻店铺命名';
$_LANG['template_libs']['shop_type'] = '商家入驻店铺类型及类目信息';
$_LANG['template_libs']['show_div_info'] = '商品详情页添加购物车弹出框';
$_LANG['template_libs']['single_sun_img'] = '晒单图片';
$_LANG['template_libs']['store_shaixuan'] = '店铺默认模板商品筛选';
$_LANG['template_libs']['store_shop_list'] = '店铺街店铺列表';
$_LANG['template_libs']['street_region_list'] = '店铺街分类地区筛选';
$_LANG['template_libs']['top_style_elec_brand'] = '顶级分类页家电模板品牌广告位';
$_LANG['template_libs']['top_style_food'] = '顶级分类页底部横幅广告';
$_LANG['template_libs']['top_style_food_hot'] = '顶级分类页（食品）热门广告';
$_LANG['template_libs']['top_style_tpl_0'] = '顶级分类页（默认模板）';
$_LANG['template_libs']['top_style_tpl_1'] = '顶级分类页（女装模板）';
$_LANG['template_libs']['top_style_tpl_2'] = '顶级分类页（食品模板）';
$_LANG['template_libs']['top_style_tpl_3'] = '顶级分类页（家电模板）';
$_LANG['template_libs']['user_menu_position'] = '右侧悬浮导航菜单';
$_LANG['template_libs']['user_order_list'] = '订单列表';
$_LANG['template_libs']['zc_backer_list'] = '众筹支持者列表';
$_LANG['template_libs']['zc_filter'] = '众筹筛选列表';
$_LANG['template_libs']['zc_index_banner'] = '众筹首页轮播图';
$_LANG['template_libs']['zc_more'] = '众筹更多项目';
$_LANG['template_libs']['zc_search'] = '众筹搜索结果';
$_LANG['template_libs']['zc_topic_list'] = '众筹话题列表';
$_LANG['template_libs']['consignee_zc'] = '众筹添加收货地址';
$_LANG['template_libs']['consignee_zcflow'] = '众筹收货地址选择';
$_LANG['template_libs']['coupons_index'] = '优惠券首页广告';
$_LANG['template_libs']['more_goods'] = '异步加载更多分类商品';
$_LANG['template_libs']['more_goods_best'] = '异步加载更多右侧推荐商品';
$_LANG['template_libs']['more_goods_page'] = '异步加载商品分页';
$_LANG['template_libs']['brandn_best_goods'] = '品牌页异步加载精品商品';
$_LANG['template_libs']['cat_store_list'] = '可视化店铺首页加载分类';
$_LANG['template_libs']['category_filter'] = '商品列表页搜索栏';
$_LANG['template_libs']['category_top_ad'] = '商品分类页分类小广告';
$_LANG['template_libs']['collection_brands_list'] = '会员中心关注品牌列表';
$_LANG['template_libs']['floor_cat_content'] = '首页楼层鼠标移动分类切换商品';
$_LANG['template_libs']['goods_lately_store_pick'] = '门店预约到店弹窗';
$_LANG['template_libs']['goods_store_pick'] = '预约到店切换门店弹窗';
$_LANG['template_libs']['js_languages'] = '处理js语言包js引入文件';
$_LANG['template_libs']['page_header_w1390'] = '品牌，分类，搜索，历史页面头部';
$_LANG['template_libs']['position_merchantsIn_users'] = '店铺轮播图';
$_LANG['template_libs']['position_merchants_usersBott'] = '店铺显示首页分类小广告';
$_LANG['template_libs']['position_merchantsIn'] = '店铺广告';
$_LANG['template_libs']['remove_bind_body'] = '储值卡解绑弹窗';
$_LANG['template_libs']['store_info'] = '店铺页头';
$_LANG['template_libs']['store_list_body'] = '门店下单弹窗';
$_LANG['template_libs']['store_select_shop'] = '预约到店弹窗异步加载';
$_LANG['template_libs']['to_pay_body'] = '储值卡充值弹窗';

/* 模板布局备份 */
$_LANG['backup_setting'] = '备份模板设置';
$_LANG['cur_setting_template'] = '当前可备份的模板设置';
$_LANG['no_setting_template'] = '没有可备份的模板设置';
$_LANG['cur_backup'] = '可使用的模板设置备份';
$_LANG['no_backup'] = '没有模板设置备份';
$_LANG['remarks'] = '备份注释';
$_LANG['backup_setting'] = '备份模板设置';
$_LANG['select_all'] = '全选';
$_LANG['remarks_exist'] = '备份注释 %s 已经用过，请换个注释名称';
$_LANG['backup_template_ok'] = '备份设置成功';
$_LANG['del_backup_ok'] = '备份删除成功';
$_LANG['restore_backup_ok'] = '恢复备份成功';

/* JS 语言项 */
$_LANG['js_languages']['setupConfirm'] = '启用新的模板将覆盖原来的模板。\n您确定要启用选定的模板吗？';
$_LANG['js_languages']['reinstall'] = '重新安装当前模板';
$_LANG['backup'] = '备份当前模板';
$_LANG['js_languages']['selectPlease'] = '请选择...';
$_LANG['js_languages']['removeConfirm'] = '您确定要删除选定的内容吗？';
$_LANG['js_languages']['empty_content'] = '对不起，库项目的内容不能为空。';
$_LANG['js_languages']['save_confirm'] = '您已经修改了模板内容，您确定不保存么？';

?>