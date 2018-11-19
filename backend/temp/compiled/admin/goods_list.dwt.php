<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>
<body class="iframe_body">
	<div class="warpper">
    	<div class="title"><?php echo $this->_var['lang']['goods_alt']; ?> - <?php echo $this->_var['ur_here']; ?></div>
        <div class="content">
            <?php echo $this->fetch('library/common_tabs_info.lbi'); ?>
            <div class="explanation mb10" id="explanation">
				<?php if ($this->_var['menu_select']['current'] == '50_virtual_card_list'): ?>
            	<div class="ex_tit">
					<i class="sc_icon"></i><h4><?php echo $this->_var['lang']['operating_hints']; ?></h4><span id="explanationZoom" title="<?php echo $this->_var['lang']['fold_tips']; ?>"></span>
                    <?php if ($this->_var['open'] == 1): ?>
                    <div class="view-case">
                    	<div class="view-case-tit"><i></i><?php echo $this->_var['lang']['view_tutorials']; ?></div>
                        <div class="view-case-info">
                        	<a href="http://help.ecmoban.com/article-3013.html" target="_blank">虚拟商品使用说明</a>
                        </div>
                    </div>			
                    <?php endif; ?>				
				</div>				
				<?php else: ?>
            	<div class="ex_tit"><i class="sc_icon"></i><h4><?php echo $this->_var['lang']['operating_hints']; ?></h4><span id="explanationZoom" title="<?php echo $this->_var['lang']['fold_tips']; ?>"></span></div>
				<?php endif; ?>
                <ul>
                	<li>该页面展示了商城所有的商品信息，可对商品进行编辑修改操作。</li>
                    <li>可输入商品名称关键字进行搜索，侧边栏进行高级搜索。</li>
                    <li>设置商品运费模板：平台->地区&amp;配送-><a href="goods_transport.php?act=list">运费管理</a></li>
                </ul>
            </div>
        	<div class="tabs_info">
            	<ul>
                    <li <?php if ($this->_var['menu_select']['current'] == '01_goods_list'): ?>class="curr"<?php endif; ?>>
                    	<a href="goods.php?act=list<?php echo $this->_var['seller_list']; ?>">普通商品 <?php if ($this->_var['menu_select']['current'] != '01_goods_list'): ?><?php if ($this->_var['goods_list_type']): ?><em class="li_color">(<?php echo empty($this->_var['goods_list_type']['ordinary']) ? '0' : $this->_var['goods_list_type']['ordinary']; ?>)</em><?php endif; ?><?php endif; ?></a>
                    </li>
                    <li <?php if ($this->_var['menu_select']['current'] == '50_virtual_card_list'): ?>class="curr"<?php endif; ?>>
                    	<a href="goods.php?act=list&extension_code=virtual_card<?php echo $this->_var['seller_list']; ?>">虚拟商品 <?php if ($this->_var['menu_select']['current'] != '50_virtual_card_list'): ?><?php if ($this->_var['goods_list_type']): ?><em class="li_color">(<?php echo empty($this->_var['goods_list_type']['virtual_card']) ? '0' : $this->_var['goods_list_type']['virtual_card']; ?>)</em><?php endif; ?><?php endif; ?></a>
                    </li>
                    <?php if ($this->_var['cfg']['review_goods'] && $this->_var['filter']['seller_list'] == 1): ?>
                	<li <?php if ($this->_var['menu_select']['current'] == '01_review_status'): ?>class="curr"<?php endif; ?>>
                    	<a href="goods.php?act=review_status<?php echo $this->_var['seller_list']; ?>">商品审核 <?php if ($this->_var['menu_select']['current'] != '01_review_status'): ?><?php if ($this->_var['goods_list_type']): ?><em class="li_color">(<?php echo empty($this->_var['goods_list_type']['review_status']) ? '0' : $this->_var['goods_list_type']['review_status']; ?>)</em><?php endif; ?><?php endif; ?></a>
                    </li>
                    <?php endif; ?>
					<li <?php if ($this->_var['menu_select']['current'] == '11_goods_trash'): ?>class="curr"<?php endif; ?>>
                    	<a href="goods.php?act=trash<?php echo $this->_var['seller_list']; ?>">商品回收站 <?php if ($this->_var['menu_select']['current'] != '11_goods_trash'): ?><?php if ($this->_var['goods_list_type']): ?><em class="li_color">(<?php echo empty($this->_var['goods_list_type']['delete']) ? '0' : $this->_var['goods_list_type']['delete']; ?>)</em><?php endif; ?><?php endif; ?></a>
                    </li>
                    <li <?php if ($this->_var['menu_select']['current'] == '19_is_sale'): ?>class="curr"<?php endif; ?>>
                    	<a href="goods.php?act=is_sale<?php echo $this->_var['seller_list']; ?>">上架商品 <?php if ($this->_var['menu_select']['current'] != '19_is_sale'): ?><?php if ($this->_var['goods_list_type']): ?><em class="li_color">(<?php echo empty($this->_var['goods_list_type']['is_sale']) ? '0' : $this->_var['goods_list_type']['is_sale']; ?>)</em><?php endif; ?><?php endif; ?></a>
                    </li>
                    
                    <li <?php if ($this->_var['menu_select']['current'] == '20_is_sale'): ?>class="curr"<?php endif; ?>>
                    	<a href="goods.php?act=on_sale<?php echo $this->_var['seller_list']; ?>">下架商品 <?php if ($this->_var['menu_select']['current'] != '20_is_sale'): ?><?php if ($this->_var['goods_list_type']): ?><em class="li_color">(<?php echo empty($this->_var['goods_list_type']['on_sale']) ? '0' : $this->_var['goods_list_type']['on_sale']; ?>)</em><?php endif; ?><?php endif; ?></a>
                    </li>
                </ul>
            </div>			
            <div class="flexilist">
            	<!--商品列表-->
                <div class="common-head">
                    <?php if (! $this->_var['rs_id']): ?>
                    <div class="fl">
						<a href="goods.php?act=add<?php if ($this->_var['code'] == 'virtual_card'): ?>&extension_code=virtual_card<?php endif; ?>"><div class="fbutton"><div class="add" title="添加商品"><span><i class="icon icon-plus"></i>添加商品</span></div></div></a>
                        <a href="goods.php?act=add_desc"><div class="fbutton"><div class="edit" title="商品统一描述"><span><i class="icon icon-edit"></i>商品统一描述</span></div></div></a>
                        <a href="goods.php?act=img_file_list"><div class="fbutton"><div class="edit" title="一键同步OSS图片"><span><i class="icon icon-edit"></i>一键同步OSS图片</span></div></div></a>
                    </div>
                    <?php endif; ?>
                    <div class="refresh">
                    	<div class="refresh_tit" title="<?php echo $this->_var['lang']['refresh_data']; ?>"><i class="icon icon-refresh"></i></div>
                    	<div class="refresh_span"><?php echo $this->_var['lang']['refresh_common']; ?><?php echo $this->_var['record_count']; ?><?php echo $this->_var['lang']['record']; ?></div>
                    </div>
					<div class="search">
                    	<form action="javascript:;" name="searchForm" onSubmit="searchGoodsname(this);">
                    	<div class="input">
                        	<input type="text" name="keyword" class="text nofocus w140" placeholder="商品名称/货号/条形码" autocomplete="off">
							<input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="" />
                        </div>
                        </form>
                    </div>
                </div>
                <div class="common-content">
					<form method="post" action="" name="listForm" onsubmit="return confirmSubmit(this)">
                    <div class="list-div" id="listDiv">
                    	<?php endif; ?>
                        <div class="flexigrid ht_goods_list<?php if ($this->_var['add_handler']): ?> xn_goods_list<?php endif; ?>">
                    	<table cellpadding="0" cellspacing="0" border="0">
                        	<thead>
                            	<tr>
                                	<th width="3%" class="sign"><div class="tDiv"><input type="checkbox" name="all_list" class="checkbox" id="all_list" /><label for="all_list" class="checkbox_stars"></label></div></th>
                                	<th width="3%" class="sky_id"><div class="tDiv"><a href="javascript:listTable.sort('goods_id');"><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_goods_id']; ?></div></th>
                                    <th width="10%"><div class="tDiv"><a href="javascript:listTable.sort('goods_name');"><?php echo $this->_var['lang']['goods_name']; ?></a><?php echo $this->_var['sort_goods_name']; ?></div></th>
                                       <!-- 淘宝采集修改start -->
                                    <th width="2%"><div class="tDiv"><?php echo $this->_var['lang']['commission_num']; ?></div></th>
                                    <th width="5%"><div class="tDiv"><?php echo $this->_var['lang']['shop_title']; ?></div></th>
                                       <!-- 淘宝采集修改endt -->
                                    <th width="8%"><div class="tDiv"><?php echo $this->_var['lang']['goods_steps_name']; ?></div></th>
                                    <!-- <th width="7%"><div class="tDiv"><?php echo $this->_var['lang']['lab_commission_rate']; ?></div></th> -->
                                    <th width="12%"><div class="tDiv"><?php echo $this->_var['lang']['shop_price']; ?>/<?php echo $this->_var['lang']['goods_sn']; ?>/<?php echo $this->_var['lang']['lab_freight']; ?></div></th>
                                    <th width="10%"><div class="tDiv"><?php echo $this->_var['lang']['goods_label']; ?></div></th>
                                    <th width="4%"><div class="tDiv"><a href="javascript:listTable.sort('sort_order');"><?php echo $this->_var['lang']['sort_order']; ?></a><?php echo $this->_var['sort_sort_order']; ?></div></th>
                                    <th width="3%"><div class="tDiv"><?php echo $this->_var['lang']['sku_storage']; ?></div></th>
                                    <th width="5%"><div class="tDiv"><?php echo $this->_var['lang']['audit_status']; ?></div></th>
                                    <th width="17%" class="handle"><?php echo $this->_var['lang']['handler']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
								<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                            	<tr>
                                    <td class="sign">
                                    <div class="tDiv">
										<input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['goods']['goods_id']; ?>" class="checkbox" id="checkbox_<?php echo $this->_var['goods']['goods_id']; ?>" />
										<label for="checkbox_<?php echo $this->_var['goods']['goods_id']; ?>" class="checkbox_stars"></label>
									</div>
                                    </td>
                                    <td class="sky_id"><div class="tDiv"><?php echo $this->_var['goods']['goods_id']; ?></div></td>
                                    <td>
                                    	<div class="tDiv goods_list_info">
											<div class="img"><a href="<?php echo $this->_var['HOME_URL']; ?>goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="68" height="68" /></a></div>
                                            <div class="desc">
                                        	<div class="name">
                                                <span onclick="listTable.edit(this, 'edit_goods_name', <?php echo $this->_var['goods']['goods_id']; ?>)" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" data-toggle="tooltip" class="span"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span>
                                            </div>
                                            	<?php if ($this->_var['goods']['brand_name']): ?><p class="brand">品牌：<em><?php echo $this->_var['goods']['brand_name']; ?></em></p><?php endif; ?>
                                                <p class="activity"> 
                                                    <?php if ($this->_var['goods']['is_shipping']): ?>
                                                    <em class="free">免邮</em>
                                                    <?php endif; ?>
    
                                                    <?php if ($this->_var['goods']['stages']): ?>
                                                    <em class="byStage">分期</em>
                                                    <?php endif; ?>
                                                    <?php if (! $this->_var['goods']['is_alone_sale']): ?>
                                                    <em class="parts">配件</em>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($this->_var['goods']['is_promote']): ?>
                                                        <?php if ($this->_var['nowTime'] >= $this->_var['goods']['promote_end_date']): ?>
                                                    <em class="saleEnd">特卖结束</em>
                                                        <?php else: ?>
                                                    <em class="sale">特卖</em>    
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($this->_var['goods']['is_xiangou']): ?>
                                                        <?php if ($this->_var['nowTime'] >= $this->_var['goods']['xiangou_end_date']): ?>
                                                    <em class="purchaseEnd">限购结束</em>
                                                        <?php else: ?>
                                                    <em class="purchase">限购</em>    
                                                        <?php endif; ?>
                                                    <?php endif; ?>
													
                                                    <?php if ($this->_var['goods']['is_distribution']): ?>
                                                    <em class="distribution">分销</em>
                                                    <?php endif; ?>													
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                   <!-- 淘宝采集修改start -->
                                       <td>
                                        <div class="tDiv">
                                            <a style="<?php if ($this->_var['goods']['r_img']): ?>color:red;<?php elseif (strpos ( $this->_var['goods']['goods_thumb'] , 'img.ectbk' ) > 0): ?>color:#0D34FF<?php endif; ?>" href="<?php if ($this->_var['goods']['commission_num'] > 0): ?><?php echo $this->_var['goods']['click_url']; ?><?php else: ?>../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?><?php endif; ?>" target="_blank"><?php echo $this->_var['lang'][$this->_var['goods']['commission_num']]; ?></a>
                                        </div>
                                    </td>
                                    <td><div class="tDiv"><?php echo $this->_var['goods']['shop_title']; ?></div></td>
                                    <!-- 淘宝采集修改end -->                                    
                                    <td>
                                        <div class="tDiv">
                                            <div class="goods_list_seller" title="<?php echo $this->_var['goods']['user_name']; ?>" data-toggle="tooltip"><?php if ($this->_var['goods']['user_name']): ?><font class="red"><?php echo $this->_var['goods']['user_name']; ?></font><?php else: ?><font class="blue3"><?php echo $this->_var['lang']['self']; ?></font><?php endif; ?></div>
                                        </div>
                                    </td>
                                    <!-- <td> -->
                                        <!-- <div class="tDiv"> -->
                                            <!-- <?php if ($this->_var['commission_setting']): ?> -->
                                        	<!-- <input class="text w30 tc fn" style="margin-right:0px;" onblur="listTable.editInput(this, 'edit_commission_rate', '<?php echo $this->_var['goods']['goods_id']; ?>' );" autocomplete="off" value="<?php echo empty($this->_var['goods']['commission_rate']) ? '0' : $this->_var['goods']['commission_rate']; ?>" type="text" <?php if (! $this->_var['goods']['user_id']): ?>disabled<?php endif; ?>>&nbsp;% -->
                                            <!-- <?php else: ?> -->
                                            <!-- <span class="red"><?php echo empty($this->_var['goods']['commission_rate']) ? '0' : $this->_var['goods']['commission_rate']; ?>%</span> -->
                                            <!-- <?php endif; ?> -->
                                        <!-- </div> -->
                                    <!-- </td> -->
                                    <td>
                                    	<div class="tDiv">
                                        	<div class="tDiv_item">
                                            	<span class="label"><?php echo $this->_var['lang']['shop_price']; ?>：</span>
                                            	<div class="value">
                                                <?php if ($this->_var['goods']['model_attr'] == 1): ?>
                                                    <input name="goods_model_price" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>" class="btn btn25 blue_btn" value="仓库价格" type="button">  
                                                <?php elseif ($this->_var['goods']['model_attr'] == 2): ?>
                                                    <input name="goods_model_price" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>" class="btn btn25 blue_btn" value="地区价格" type="button">
                                                <?php else: ?>
                                                    <span onclick="listTable.edit(this, 'edit_goods_price', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['shop_price']; ?></span>
                                                <?php endif; ?>
                                            	</div>
                                            </div>
                                            
                                            <div class="tDiv_item">
                                            	<span class="label"><?php echo $this->_var['lang']['goods_sn']; ?>：</span>
                                                <div class="value">
                                                    <span onclick="listTable.edit(this, 'edit_goods_sn', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_sn']; ?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="tDiv_item">
                                            	<span class="label"><?php echo $this->_var['lang']['lab_freight']; ?>：</span>
                                                <div class="value">
                                                    <?php if ($this->_var['goods']['freight'] == 1): ?>
                                                    	<?php echo $this->_var['lang']['lab_freight_fixed']; ?>
                                                    <?php elseif ($this->_var['goods']['freight'] == 2): ?>
                                                    	<a href="goods_transport.php?act=edit&tid=<?php echo $this->_var['goods']['tid']; ?>" target="_blank">
                                                    	<?php if ($this->_var['goods']['transport']['freight_type'] == 1): ?>
                                                        	<?php echo $this->_var['lang']['lab_freight_temp']; ?><em class="red">(<?php echo $this->_var['lang']['lab_freight_type']['two']; ?>)</em>
                                                        <?php else: ?>
                                                            <?php echo $this->_var['lang']['lab_freight_temp']; ?><em class="red">(<?php echo $this->_var['lang']['lab_freight_type']['one']; ?>)</em>
                                                        <?php endif; ?>
                                                        </a>
                                                    <?php else: ?>
                                                    	<?php echo $this->_var['lang']['lab_freight_area']; ?><em class="red">(<?php echo $this->_var['lang']['lab_goods_shipping']; ?>)</em>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                    	</div>
                                    </td>
                                    <td>
                                    	<div class="tDiv">
                                            <div class="tlist">
                                    <!-- 淘宝采集修改start -->
                                           <div class="tlist">
                                            	<span>去淘宝</span>
                                            	<div class="switch <?php if ($this->_var['goods']['is_taobao']): ?>active<?php endif; ?>" title="<?php if ($this->_var['goods']['is_taobao']): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_taobao', <?php echo $this->_var['goods']['goods_id']; ?>)">
                                                    <div class="circle"></div>
                                                </div>
                                                <input type="hidden" value="0" name="">
                                            </div>
                                   <!-- 淘宝采集修改start -->
                                            	<span><?php echo $this->_var['lang']['is_best']; ?>：</span>
                                            	<div class="switch <?php if ($this->_var['goods']['is_best']): ?>active<?php endif; ?>" title="<?php if ($this->_var['goods']['is_best']): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_best', <?php echo $this->_var['goods']['goods_id']; ?>)">
                                                    <div class="circle"></div>
                                                </div>
                                                <input type="hidden" value="<?php echo $this->_var['goods']['is_best']; ?>" name="">
                                            </div>
                                            <div class="tlist">
                                            	<span><?php echo $this->_var['lang']['is_new']; ?>：</span>
                                                <div class="switch <?php if ($this->_var['goods']['is_new']): ?>active<?php endif; ?>" title="<?php if ($this->_var['goods']['is_new']): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_new', <?php echo $this->_var['goods']['goods_id']; ?>)" title="<?php echo $this->_var['lang']['click']; ?>">
                                                    <div class="circle"></div>
                                                </div>
                                                <input type="hidden" value="<?php echo $this->_var['goods']['is_new']; ?>" name="">
                                            </div>
                                            <div class="tlist">
                                            	<span><?php echo $this->_var['lang']['is_hot']; ?>：</span>
                                            	<div class="switch <?php if ($this->_var['goods']['is_hot']): ?>active<?php endif; ?>" title="<?php if ($this->_var['goods']['is_hot']): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_hot', <?php echo $this->_var['goods']['goods_id']; ?>)">
                                                    <div class="circle"></div>
                                                </div>
                                                <input type="hidden" value="<?php echo $this->_var['goods']['is_hot']; ?>" name="">
                                            </div>
                                            <div class="tlist tlist-last">
                                            	<span><?php echo $this->_var['lang']['on_sale']; ?>：</span>
                                            	<div class="switch <?php if ($this->_var['goods']['is_on_sale']): ?>active<?php endif; ?>" title="<?php if ($this->_var['goods']['is_on_sale']): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_on_sale', <?php echo $this->_var['goods']['goods_id']; ?>)">
                                                    <div class="circle"></div>
                                                </div>
                                                <input type="hidden" value="<?php echo $this->_var['goods']['is_on_sale']; ?>" name="">
                                            </div>
                                        </div>
                                    </td>
                                    <td><div class="tDiv"><span onclick="listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['sort_order']; ?></span></div></td>
                                    <td>
                                    	<div class="tDiv">
                                    		<?php if ($this->_var['goods']['is_attr']): ?>
                                            	<a href="javascript:;" ectype="add_sku" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>" data-userid="<?php echo $this->_var['goods']['user_id']; ?>"><i class="icon icon-edit font16"></i></a>
                                            <?php else: ?>
                                            	<span onclick="listTable.edit(this, 'edit_goods_number', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_number']; ?></span>
                                            <?php endif; ?>
                                    	</div>
                                    </td>
                                    <td>
                                    	<div class="tDiv">
                                            <?php if ($this->_var['goods']['review_status'] == 1): ?>
                                            <font class="org2"><?php echo $this->_var['lang']['not_audited']; ?></font>
                                            <?php elseif ($this->_var['goods']['review_status'] == 2): ?>
                                            <font class="red"><?php echo $this->_var['lang']['audited_not_adopt']; ?></font><br/>
                                            <i class="tip yellow" title="<?php echo $this->_var['goods']['review_content']; ?>"  data-toggle="tooltip"><?php echo $this->_var['lang']['prompt']; ?></i>
                                            <?php elseif ($this->_var['goods']['review_status'] == 3 || $this->_var['goods']['review_status'] == 4): ?>
                                            <font class="blue"><?php echo $this->_var['lang']['audited_yes_adopt']; ?></font>
                                            <?php elseif ($this->_var['goods']['review_status'] == 5): ?>
                                            <font class="navy2"><?php echo $this->_var['lang']['wuxu_adopt']; ?></font>
                                            <?php endif; ?>									
                                        </div>
                                    </td>
                                    <td class="handle">
                                        <div class="tDiv ht_tdiv" style="padding-bottom:0px;">
                                        	<p>
                                            	<a href="<?php echo $this->_var['HOME_URL']; ?>goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" class="btn_see"><i class="sc_icon sc_icon_see"></i><?php echo $this->_var['lang']['view']; ?></a>
                                        		<a href="javascript:;" ectype="review_status" class="btn_see" data-type="<?php echo $this->_var['type']; ?>" data-goodsid="<?php echo empty($this->_var['goods']['goods_id']) ? '0' : $this->_var['goods']['goods_id']; ?>" data-goodsname="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"><i class="icon icon-edit"></i><?php echo $this->_var['lang']['check']; ?></a>
												<a href="goods.php?act=view_log&id=<?php echo $this->_var['goods']['goods_id']; ?>" class="btn_see"><i class="sc_icon sc_icon_see"></i><?php echo $this->_var['lang']['log']; ?></a>
                                            </p>
                                            <?php if (! $this->_var['add_handler']): ?>
                                            <p>
                                            	<a href="goods.php?act=edit&goods_id=<?php echo $this->_var['goods']['goods_id']; ?><?php if ($this->_var['code'] != 'real_goods'): ?>&extension_code=<?php echo $this->_var['code']; ?><?php endif; ?>" class="btn_edit"><i class="icon icon-edit"></i><?php echo $this->_var['lang']['edit']; ?></a>
                                                <a href="goods.php?act=copy&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&extension_code=<?php echo $this->_var['code']; ?>" class="btn_edit" title='<?php echo $this->_var['lang']['copy_goods']; ?>'><i class="icon icon-copy"></i><?php echo $this->_var['lang']['copy']; ?></a>
                                            	<a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '<?php echo $this->_var['lang']['trash_goods_confirm']; ?>')" class="btn_trash"><i class="icon icon-trash"></i><?php echo $this->_var['lang']['drop']; ?></a>	
                                   <!-- 淘宝采集修改start -->
                                          <?php if ($this->_var['goods']['num_iid']): ?>
                                          <a href="<?php if ($this->_var['goods']['commission_num'] == 100): ?>albbshops.php<?php else: ?>shops.php<?php endif; ?>?act=getRate&num_iid=<?php echo $this->_var['goods']['num_iid']; ?>&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" >评论</a>
                                          <?php endif; ?>
                                   <!-- 淘宝采集修改start -->
                                            </p>
                                            <?php else: ?>
                                            <p>
                                                <a href="goods.php?act=edit&goods_id=<?php echo $this->_var['goods']['goods_id']; ?><?php if ($this->_var['code'] != 'real_goods'): ?>&extension_code=<?php echo $this->_var['code']; ?><?php endif; ?>" class="btn_edit"><i class="icon icon-edit"></i><?php echo $this->_var['lang']['edit']; ?></a>
                                                <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '<?php echo $this->_var['lang']['trash_goods_confirm']; ?>')" class="btn_trash"><i class="icon icon-trash"></i><?php echo $this->_var['lang']['drop']; ?></a>
                                            </p>  
                                            <p>
                                                <a href="virtual_card.php?act=card&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" title="<?php echo $this->_var['lang']['card']; ?>" class="btn_see"><i class="icon icon-credit-card"></i><?php echo $this->_var['lang']['card']; ?></a>
                                                <a href="virtual_card.php?act=replenish&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" title="<?php echo $this->_var['lang']['replenish']; ?>" class="btn_see"><i class="icon icon-plus-sign"></i><?php echo $this->_var['lang']['replenish']; ?></a>
                                                <a href="virtual_card.php?act=batch_card_add&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" title="<?php echo $this->_var['lang']['batch_card_add']; ?>" class="btn_see"><i class="icon icon-paste"></i><?php echo $this->_var['lang']['batch_card_add']; ?></a>
                                            </p> 
                                   <!-- 淘宝采集修改start -->
                                          <?php if ($this->_var['goods']['num_iid']): ?>
                                          <a href="<?php echo $this->_var['lang']['tag'][$this->_var['goods']['commission_num']]; ?>.php?act=getRate&num_iid=<?php echo $this->_var['goods']['num_iid']; ?>&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" >评论</a>
                                          <?php endif; ?>
                                   <!-- 淘宝采集修改start -->
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
								<?php endforeach; else: ?>
								<tr><td class="no-records"  colspan="20"><?php echo $this->_var['lang']['no_records']; ?></td></tr>								
								<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                            <tfoot>
                            	<tr>
                                	<td colspan="12">
                                    	<div class="tDiv">
                                            <div class="tfoot_btninfo">
                                                <div class="checkbox_item fl font12 mt5 mr5">
                                                	<input type="checkbox" name="all_list" class="ui-checkbox" id="all_list"><label for="all_list" class="ui-label"><?php echo $this->_var['lang']['check_all']; ?></label>
                                                </div>
                                                <input type="hidden" name="act" value="batch" />
                                                <!-- 操作类型 start -->
                                                <div class="imitate_select select_w120">
                                                    <div class="cite"><?php echo $this->_var['lang']['please_select']; ?></div>
                                                    <ul>
                                                        <li><a href="javascript:changeAction();" data-value="" class="ftx-01"><?php echo $this->_var['lang']['select_please']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="trash" class="ftx-01"><?php echo $this->_var['lang']['trash']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="on_sale" class="ftx-01"><?php echo $this->_var['lang']['on_sale']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="not_on_sale" class="ftx-01"><?php echo $this->_var['lang']['not_on_sale']; ?></a></li>
														<li><a href="javascript:changeAction();" data-value="goods_transport" class="ftx-01">运费模板</a></li>
                                                        <?php if ($this->_var['priv_ru'] == 1): ?>
                                                        <li><a href="javascript:changeAction();" data-value="best" class="ftx-01"><?php echo $this->_var['lang']['best']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="not_best" class="ftx-01"><?php echo $this->_var['lang']['not_best']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="new" class="ftx-01"><?php echo $this->_var['lang']['new']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="not_new" class="ftx-01"><?php echo $this->_var['lang']['not_new']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="hot" class="ftx-01"><?php echo $this->_var['lang']['hot']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="not_hot" class="ftx-01"><?php echo $this->_var['lang']['not_hot']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="move_to" class="ftx-01"><?php echo $this->_var['lang']['move_to']; ?></a></li>
                                                        <li><a href="javascript:changeAction();" data-value="review_to" class="ftx-01"><?php echo $this->_var['lang']['adopt_goods']; ?></a></li>
	<li><a href="javascript:changeAction();" data-value="to_taobao" class="ftx-01">去淘宝</a></li>
	<li><a href="javascript:changeAction();" data-value="not_taobao" class="ftx-01">取消去淘宝</a></li>
	<li><a href="javascript:changeAction();" data-value="re_taobao" class="ftx-01">更新淘宝数据</a></li>
	<li><a href="javascript:changeAction();" data-value="img_local" class="ftx-01">图片本地化</a></li>
	<li><a href="javascript:changeAction();" data-value="get_rate" class="ftx-01">采集评论</a></li>
                                                        <li><a href="javascript:changeAction();" data-value="return_type" class="ftx-01"><?php echo $this->_var['lang']['return_lable']; ?></a></li>
                                                        <?php if ($this->_var['suppliers_list'] > 0): ?>
                                                        <li><a href="javascript:changeAction();" data-value="suppliers_move_to" class="ftx-01"><?php echo $this->_var['lang']['suppliers_move_to']; ?></a></li>
                                                        <?php endif; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <input name="type" type="hidden" value="" id="">
                                                </div>
                                                <!-- 操作类型 end -->
                                                
                                                <!-- 转移到分类 start -->
                                                <div class="search_select fl" id="move_cat_list" style="display: none;">
                                                    <div class="categorySelect">
                                                        <div class="selection">
                                                            <input type="text" name="category_name" id="category_name" class="text w250 valid" value="<?php echo $this->_var['lang']['select_cat']; ?>" autocomplete="off" readonly data-filter="cat_name" />
                                                            <input type="hidden" name="target_cat" id="category_id" value="0" data-filter="cat_id" />
                                                        </div>
                                                        <div class="select-container" style="display:none;">
                                                            <?php echo $this->fetch('library/filter_category.lbi'); ?>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <!-- 转移到分类 end -->
                                              
                                                <!-- 审核商品 start -->
                                                <div id="review_status" class="imitate_select select_w120" style="display:none">
                                                    <div class="cite"><?php echo $this->_var['lang']['please_select']; ?></div>
                                                    <ul>
                                                        <li><a href="javascript:get_review_status(1);" data-value="1" class="ftx-01"><?php echo $this->_var['lang']['not_audited']; ?></a></li>
                                                        <li><a href="javascript:get_review_status(2);" data-value="2" class="ftx-01"><?php echo $this->_var['lang']['audited_not_adopt']; ?></a></li>
                                                    </ul>
                                                    <input name="review_status" type="hidden" value="1" id="">
                                                </div>
                                                <input name="review_content" type="text" value="" class="text text_2 mr10 lh26" style="display:none" />
                                                <!-- 审核商品 end -->
												
                                                <!-- 商品运费模板 start -->
                                                <div id="goods_transport" class="imitate_select select_w120" style="display:none">
                                                    <div class="cite"><?php echo $this->_var['lang']['please_select']; ?></div>
                                                    <ul>
														<?php $_from = $this->_var['transport_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                                                        <li><a href="javascript:;" data-value="<?php echo $this->_var['item']['tid']; ?>" class="ftx-01" title="<?php echo $this->_var['item']['title']; ?>"><?php echo $this->_var['item']['title']; ?></a></li>
														<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                                    </ul>
                                                    <input name="tid" type="hidden" value="" id="">
                                                </div>
                                                <!-- 商品运费模板 end -->												
                                              
                                                <!-- 转移供货商 start -->
                                                <?php if ($this->_var['suppliers_list'] > 0): ?>
                                                <div id="suppliers_id" class="imitate_select select_w120" style="display:none;">
                                                    <div class="cite"><?php echo $this->_var['lang']['please_select']; ?></div>
                                                    <ul>
                                                        <li><a href="javascript:;" data-value="-1" class="ftx-01"><?php echo $this->_var['lang']['select_please']; ?></a></li>
                                                        <li><a href="javascript:;" data-value="0" class="ftx-01"><?php echo $this->_var['lang']['lab_to_shopex']; ?></a></li>
                                                        <?php $_from = $this->_var['suppliers_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sl');$this->_foreach['sln'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sln']['total'] > 0):
    foreach ($_from AS $this->_var['sl']):
        $this->_foreach['sln']['iteration']++;
?>
                                                        <li><a href="javascript:;" data-value="<?php echo $this->_var['sl']['suppliers_id']; ?>" class="ftx-01"><?php echo $this->_var['sl']['suppliers_name']; ?></a></li>
                                                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                                    </ul>
                                                    <input name="suppliers_id" type="hidden" value="-1" id="">
                                                </div>
                                                <?php endif; ?>
                                                <!-- 转移供货商 end -->
                
                                                <?php if ($this->_var['code'] != 'real_goods'): ?>
                                                <input type="hidden" name="extension_code" value="<?php echo $this->_var['code']; ?>" />
                                                <?php endif; ?>
                                                <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" id="btnSubmit" name="btnSubmit" class="btn btn_disabled" disabled="true" ectype="btnSubmit" />				
                                            </div>
                                            <div class="list-page">
                                               <?php echo $this->fetch('library/page.lbi'); ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                        <?php if ($this->_var['full_page']): ?>
                    </div>
					</form>
                </div>
                <!--商品列表end-->
            </div>
		</div>
	</div>

	<!--高级搜索 start-->
	<?php echo $this->fetch('library/goods_search.lbi'); ?>
	<!--高级搜索 end-->
	<?php echo $this->fetch('library/pagefooter.lbi'); ?>
    
    <?php echo $this->smarty_insert_scripts(array('files'=>'jquery.purebox.js')); ?>
    
    
	<script type="text/javascript">
	listTable.recordCount = <?php echo empty($this->_var['record_count']) ? '0' : $this->_var['record_count']; ?>;
	listTable.pageCount = <?php echo empty($this->_var['page_count']) ? '1' : $this->_var['page_count']; ?>;
	
	<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	/* 起始页通过商品一览点击进入自营/商家商品判断条件 */
	listTable.filter.self = '<?php echo $this->_var['self']; ?>';
	listTable.filter.merchants = '<?php echo $this->_var['merchants']; ?>';
	
	function movecatList(val, level)
	{
		var cat_id = val;
		document.getElementById('target_cat').value = cat_id;
		Ajax.call('goods.php?is_ajax=1&act=sel_cat_goodslist', 'cat_id='+cat_id+'&cat_level='+level, movecatListResponse, 'GET', 'JSON');
	}

	function movecatListResponse(result)
	{
		if (result.error == '1' && result.message != '')
		{
			alert(result.message);
			return;
		}
		
		var response = result.content;
		var cat_level = result.cat_level;
		
		for(var i=cat_level;i<10;i++)
		{
			$("#move_cat_list"+Number(i+1)).remove();
		}
		
		if(response)
		{
			$("#move_cat_list"+cat_level).after(response);
		}
		
		return;
	}

	onload = function()
	{
		document.forms['listForm'].reset();
	}

	/**
	* @param: bool ext 其他条件：用于转移分类
	*/
	function confirmSubmit(frm, ext)
	{
		if (frm.elements['type'].value == 'trash')
		{
			return confirm(batch_trash_confirm);
		}
		else if (frm.elements['type'].value == 'not_on_sale')
		{
			return confirm(batch_no_on_sale);
		}
		else if (frm.elements['type'].value == 'move_to')
		{
			ext = (ext == undefined) ? true : ext;
			return ext && document.getElementById('target_cat').value != 0;
		}
		else if (frm.elements['type'].value == '')
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function changeAction()
	{
		var frm = document.forms['listForm'];
	
		// 切换分类列表的显示
		$("#move_cat_list").css({'display':frm.elements['type'].value == 'move_to' ? '' : 'none'});
	
		// 切换商品审核列表的显示
		$("#review_status").css({'display':frm.elements['type'].value == 'review_to' ? '' : 'none'});
		
		// 商品运费模板
		$("#goods_transport").css({'display':frm.elements['type'].value == 'goods_transport' ? '' : 'none'});
	
		if(frm.elements['type'].value != 'review_to'){
			frm.elements['review_content'].style.display = 'none';
		}
	
		// 供应商列表的显示
		<?php if ($this->_var['suppliers_list'] > 0): ?>
			$("#suppliers_id").css({'display':frm.elements['type'].value == 'suppliers_move_to' ? '' : 'none'});
		<?php endif; ?>
	}
	  
	//ecmoban模板堂 --zhuo  start
	function get_review_status(){
		var frm = document.forms['listForm'];
		
		if(frm.elements['type'].value == 'review_to'){
			if(frm.elements['review_status'].value == 2){
				frm.elements['review_content'].style.display = '';
			}else{
				frm.elements['review_content'].style.display = 'none';
			}
		}else{
			frm.elements['review_content'].style.display = 'none';
		}
	}
	//ecmoban模板堂 --zhuo  end
	
	//展开其他属性
	function trigger(obj){
		var _this = $(obj);
		var parenttr = _this.parents('tr');
		var tip = parenttr.siblings().find('.tip');
		if(_this.hasClass('icon-down')){
			_this.removeClass('icon-down');
			parenttr.next().hide();
		}else{
			_this.addClass('icon-down');
			parenttr.next().show();
			tip.removeClass('icon-down');
			tip.parents('tr').next().hide();
		}
	}
	  
	//仓库库存修改弹出框
	$(document).on('click',"*[ectype='dialog']",function(){
		var url =$(this).data('url');
		var title = $(this).attr('title');
		Ajax.call(url,'',dsc_warehouse, 'POST', 'JSON');
		function dsc_warehouse(result){
			pb({
				id:"tipDialog",
				title:title,
				content:result.content,
				drag:false,
				ok_title:"确定",
				cl_title:"取消"
			});
		}
	});
	
	//单选勾选
	function get_ajax_act(t, goods_id, act, FileName){
		
		if(t.checked == false){
			t.value = 0;
		}
		
		Ajax.call(FileName + '.php?act=' + act, 'id=' + goods_id + '&val=' + t.value, act_response, 'POST', 'JSON');
	}
	
	function act_response(result){}
	
	function dropWarehouse(w_id)
	{
		Ajax.call('goods.php?is_ajax=1&act=drop_warehouse', "w_id="+w_id, dropWarehouseResponse, "GET", "JSON");
	}
	
	function dropWarehouseResponse(result)
	{
		if (result.error == 0)
		{
		  document.getElementById('warehouse_' + result.content).style.display = 'none';
		}
	}
	
	function dropWarehouseArea(a_id)
	{
		Ajax.call('goods.php?is_ajax=1&act=drop_warehouse_area', "a_id="+a_id, dropWarehouseAreaResponse, "GET", "JSON");
	}
	
	function dropWarehouseAreaResponse(result)
	{
		if (result.error == 0)
		{
		  document.getElementById('warehouse_area_' + result.content).style.display = 'none';
		}
	}
	
	//仓库/地区价格 start
	$(document).on("click","input[name='goods_model_price']",function(){
		var goods_id = $(this).data("goodsid");
		
		$.jqueryAjax('dialog.php', 'act=add_goods_model_price' + '&goods_id=' + goods_id, function(data){
			var content = data.content;
			pb({
				id:"categroy_dialog",
				title:"仓库/地区价格",
				width:864,
				content:content,
				ok_title:"确定",
				cl_title:"取消",
				drag:true,
				foot:false
			});
		});
	});
	//仓库/地区价格 end
	
	//SKU/库存 start
	$(document).on("click","a[ectype='add_sku']",function(){
		
		var goods_id = $(this).data('goodsid');
		var user_id = $(this).data('userid');
		
		$.jqueryAjax('dialog.php', 'act=add_sku' + '&goods_id=' + goods_id + '&user_id=' + user_id, function(data){
			var content = data.content;
			pb({
				id:"categroy_dialog",
				title:"编辑商品货品信息",
				width:863,
				content:content,
				ok_title:"确定",
				cl_title:"取消",
				drag:true,
				foot:false
			});
		});
	});
	
	//SKU/库存 start
	$(document).on("click","a[ectype='add_attr_sku']",function(){
		
		var goods_id = $(this).data('goodsid');
		var product_id = $(this).data('product');
		
		$.jqueryAjax('dialog.php', 'act=add_attr_sku' + '&goods_id=' + goods_id + '&product_id=' + product_id, function(data){
			var content = data.content;
			pb({
				id:"attr_sku_dialog",
				title:"编辑商品货品价格",
				width:563,
				content:content,
				ok_title:"确定",
				cl_title:"取消",
				drag:true,
				foot:true,
				onOk:function(){
					if(data.method){
						insert_attr_warehouse_area_price(data.method);
					}
				}
			});
		});
	});
	
	function insert_attr_warehouse_area_price(method){
		var actionUrl = "dialog.php?act=" + method;  
		$("#warehouseForm").ajaxSubmit({
				type: "POST",
				dataType: "JSON",
				url: actionUrl,
				data: {"action": "TemporaryImage"},
				success: function (data) {
				},
				async: true  
		 });
	}
	
	//商品审核 start
	$(document).on("click","a[ectype='review_status']",function(){
		
		var goods_name = $(this).data('goodsname');
		var goods_id = $(this).data('goodsid');
		var type = $(this).data('type');
		
		var content  = 	'<form id="reviewForm" enctype="multipart/form-data" method="post" action="dialog.php?act=update_review_status">' +
						'<div class="item fl" style="padding:20px 0px 10px; width:333px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' +
							'商品名称：<em title="' + goods_name + '">' + goods_name + '</em>' +
						'</div>' +
						'<div class="item fl" style="width:333px">' +
							'<div class="fl" style="padding-top:9px">商品审核：</div>' +
							'<div class="checkbox_items" style="padding-top:10px; width:80%">' +
								'<div class="checkbox_item">' + 
									'<input name="review_status" class="ui-radio review_status" id="pro_no" value="1" checked="checked" type="radio" onclick="handleReviewStatus(this);">' +
									'<label for="pro_no" class="ui-radio-label">未审核</label>' +
								'</div>' +
								'<div class="checkbox_item">' + 
									'<input name="review_status" class="ui-radio review_status" id="pro_no" value="3" checked="checked" type="radio" onclick="handleReviewStatus(this);">' +
									'<label for="pro_no" class="ui-radio-label">审核通过</label>' +
								'</div>' +
								'<div class="checkbox_item mr15">' +
									'<input name="review_status" class="ui-radio review_status" id="pro_yes" value="2" type="radio" onclick="handleReviewStatus(this);">' + 
									'<label for="pro_yes" class="ui-radio-label">审核未通过</label> ' +
								'</div>' +
							'</div>' +
						'</div>' +
						'<div class="item fl hide" id="review_content" style="padding:20px 0px; width:333px">' +
							'<textarea name="review_content" value="" cols="60" rows="4" class="textarea"></textarea>' +
						'</div>' +
						'<input name="goods_id" type="hidden" value="' + goods_id + '">' + 
						'<input name="type" type="hidden" value="' + type + '">' + 
						'</form>';
		pb({
			id:"review_status_dialog",
			title:"商品审核",
			width:403,
			content:content,
			ok_title:"确定",
			cl_title:"取消",
			drag:true,
			foot:true,
			onOk:function(){
				insert_review_status();
			}
		});
	});
	
	function insert_review_status(){
		var actionUrl = "dialog.php?act=update_review_status";  
		$("#reviewForm").ajaxSubmit({
				type: "POST",
				dataType: "JSON",
				url: actionUrl,
				data: {"action": "TemporaryImage"},
				success: function (data) {
					location.href = "goods.php?act=review_status&type=" + data.type;
				},
				async: true  
		 });
	}
	
	function handleReviewStatus(t){
		if(t.value == 2){
			$("#review_content").show();
		}else{
			$("#review_content").hide();
			$(":input[name='review_content']").val('');
		}
	}
	//商品审核 end
	</script>
    
</body>
</html>
<?php endif; ?>
