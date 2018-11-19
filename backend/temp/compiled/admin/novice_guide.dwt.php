<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>

<body class="iframe_body">
	<div class="warpper">
    	<div class="title"><?php echo $this->_var['ur_here']; ?></div>
        <div class="content">
        	<div class="explanation" id="explanation">
            	<div class="ex_tit"><i class="sc_icon"></i><h4><?php echo $this->_var['lang']['operating_hints']; ?></h4><span id="explanationZoom" title="<?php echo $this->_var['lang']['fold_tips']; ?>"></span></div>
                <ul>
                	<li>引导新客户迅速上手使用基本功能设置。</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                	<div class="switch_info">
                        <div class="guide_content mian_guide_content" ectype="guide_content">
                            <div class="guide_step">
                                <div class="item current">
                                    <h2>基本信息配置</h2>
                                    <div class="spliy">••••••••••••••••<i class="gicon"></i></div>
                                </div>
                                <div class="item">
                                    <h2>清理数据</h2>
                                    <div class="spliy">••••••••••••••••<i class="gicon"></i></div>
                                </div>
                                <div class="item">
                                    <h2>维护基础数据</h2>
                                    <div class="spliy">••••••••••••••••<i class="gicon"></i></div>
                                </div>
                                <div class="item">
                                    <h2>可视化装修</h2>
                                </div>
                            </div>
                            <div class="guide_list">
                                <div class="guide_item guide_one"><a href="javascript:void(0);" data-url="shop_config.php?act=list_edit" data-param="menuplatform|01_shop_config" ectype="iframeHref"><img src="images/guide/guide_img_11.jpg" /></a></div>
                                <div class="guide_item guide_two" style="display:none;"><a href="index.php?act=clear_cache"><img src="images/guide/guide_img_22.jpg" /></a></div>
                                <div class="guide_item guide_three" style="display:none;"><a href="javascript:void(0);" data-url="goods.php?act=step_up" data-param="menushopping|001_goods_setting" ectype="iframeHref" class="a_left"></a><a href="javascript:void(0);" data-url="merchants_steps.php?act=step_up" data-param="menushopping|01_seller_stepup" ectype="iframeHref" class="a_right"></a><img src="images/guide/guide_img_33.jpg" /></div>
                                <div class="guide_item guide_four" style="display:none;"><a href="javascript:void(0);" data-url="visualhome.php?act=list" data-param="menuplatform|01_visualhome" ectype="iframeHref" class="a_top"></a><a href="javascript:void(0);" data-url="../mobile/index.php?r=admin/editor" data-param="ectouch|05_touch_dashboard" ectype="iframeHref" class="a_bot"></a><img src="images/guide/guide_img_44.jpg" /></div>
                            </div>
                            <div class="guide_btn" data-type="0">
                                <a href="javascript:void(0);" class="btn_next" ectype="btnNext">了解了，下一步</a>
                                <a href="javascript:void(0);" class="btn_prev btn_disabled" ectype="btnPrev">上一步</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    <script type="text/javascript">
    	$("*[ectype='btnNext']").on("click",function(){
			if(!$(this).hasClass("btn_disabled")){
				var type = $(this).parents(".guide_btn").data("type");
				var g_con = $(this).parents("*[ectype='guide_content']");
				
				g_con.find(".guide_step .item").eq(type+1).addClass("current").siblings().removeClass("current");
				g_con.find(".guide_list .guide_item").eq(type+1).show().siblings().hide();
				
				$(this).parents(".guide_btn").data("type",type+1);
				$(this).siblings("*[ectype='btnPrev']").removeClass("btn_disabled");

				if(type == 2){
					$(this).addClass("btn_disabled");
				}else{
					$(this).removeClass("btn_disabled");
				}
				
				$("#guide_dialog .guide_list").perfectScrollbar("destroy");
				$("#guide_dialog .guide_list").perfectScrollbar();
			}
		});
		
		$("*[ectype='btnPrev']").on("click",function(){
			if(!$(this).hasClass("btn_disabled")){
				var type = $(this).parents(".guide_btn").data("type");
				var g_con = $(this).parents("*[ectype='guide_content']");

				g_con.find(".guide_step .item").eq(type-1).addClass("current").siblings().removeClass("current");
				g_con.find(".guide_list .guide_item").eq(type-1).show().siblings().hide();
				
				$(this).parents(".guide_btn").data("type",type-1);
				$(this).siblings("*[ectype='btnNext']").removeClass("btn_disabled");

				if(type == 1){
					$(this).addClass("btn_disabled");
				}else{
					$(this).removeClass("btn_disabled");
				}
				
				$("#guide_dialog .guide_list").perfectScrollbar("destroy");
				$("#guide_dialog .guide_list").perfectScrollbar();
			}
		});
    </script>
	<?php echo $this->fetch('library/pagefooter.lbi'); ?>
</body>
</html>
