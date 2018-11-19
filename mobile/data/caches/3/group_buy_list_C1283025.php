<?php exit;?>a:3:{s:8:"template";a:2:{i:0;s:83:"C:/phpStudy/PHPTutorial/WWW/xiaomi2016_bak/mobile/themes/miqinew/group_buy_list.dwt";i:1;s:88:"C:/phpStudy/PHPTutorial/WWW/xiaomi2016_bak/mobile/themes/miqinew/library/page_footer.lbi";}s:7:"expires";i:1541971163;s:8:"maketime";i:1541967563;}<!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta charset="utf-8" />
<title>团购商品_小米官网——小米手机、红米手机、小米电视官方正品专卖网站 触屏版</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<link href="themes/miqinew/images/touch-icon.png" rel="apple-touch-icon-precomposed" />
<link href="themes/miqinew/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<link href="themes/miqinew/ectouch.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page" style="right: 0px; left: 0px; display: block;">
  <header id="header" style="z-index:1">
    <div class="header_l"> <a class="ico_10" href="cat_all.php"> 返回 </a> </div>
    <h1> ecTouch 团购 </h1>
  </header>
  <div class="srp album flex-f-row" id="J_ItemList" style="opacity:1;">
    <div class="product flex_in single_item">
      <div class="pro-inner"></div>
    </div>
    <a href="javascript:;" class="get_more"></a> </div>
  <!--
    <div class="product flex_in single_item"style="width:48.9%">
      <div class="pro-inner">
        <div class="proImg-wrap"> <a href=""><img alt="" src="http://idashu.cc/"> </a> </div>
        <div class="proInfo-wrap">
          <div class="proTitle"> <a href=""></a> </div>
          <div class="proSKU"></div>
          <div class="proPrice"> <em></em> </div>
          <div class="proSales"><em>0</em>人已购买</div>
        </div>
      </div>
    </div>--> 
  
  <a href="javascript:;" class="get_more"></a> <div id="content" class="footer mr-t20">
  <div class="in">
    <div class="search_box">
      <form method="post" action="search.php" name="searchForm" id="searchForm_id">
        <input name="keywords" type="text" id="keywordfoot" />
        <button class="ico_07" type="submit" value="搜索" onclick="return check('keywordfoot')"> </button>
      </form>
    </div>
    <a href="./" class="homeBtn"> <span class="ico_05"> </span> </a> <a href="#top" class="gotop"> <span class="ico_06"> </span> <p> TOP </p>
    </a>
  </div>
  <p class="link region"> <a href="http://idashu.cc/?computer=1"> 电脑版 </a> <a href="./"> 触屏版 </a></p>
  <p class="region"> 
    &copy; 2005-2016 oeob.net 版权所有，并保留所有权利。 </p>
  <div class="favLink region"> 创资源oeob.net出品 </div>
</div>
<link href="themes/miqinew/css/global_nav.css?v=20140408" type="text/css" rel="stylesheet"/>
<div class="global-nav">
    <div class="global-nav__nav-wrap">
        <div class="global-nav__nav-item">
            <a href="./" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-index">&#xf0001;</i>
                <span class="global-nav__nav-tit">首页</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="cat_all.php" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-category">&#xf0002;</i>
                <span class="global-nav__nav-tit">分类</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="javascript:get_search_box();" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-search">&#xf0003;</i>
                <span class="global-nav__nav-tit">搜索</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="flow.php?step=cart" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-shop-cart">&#xf0004;</i>
                <span class="global-nav__nav-tit">购物车</span>
                <span class="global-nav__nav-shop-cart-num" id="carId">554fcae493e564ee0dc75bdf2ebf94cacart_info_number|a:1:{s:4:"name";s:16:"cart_info_number";}554fcae493e564ee0dc75bdf2ebf94ca</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="user.php?act=order_list" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-my-yhd">&#xf0005;</i>
                <span class="global-nav__nav-tit">我的订单</span>
            </a>
        </div>
    </div>
    <div class="global-nav__operate-wrap">
        <span class="global-nav__yhd-logo"></span>
        <span class="global-nav__operate-cart-num" id="globalId">554fcae493e564ee0dc75bdf2ebf94cacart_info_number|a:1:{s:4:"name";s:16:"cart_info_number";}554fcae493e564ee0dc75bdf2ebf94ca</span>
    </div>
</div>
<script type="text/javascript" src="themes/miqinew/js/zepto.min.js?v=20140408"></script>
<script type="text/javascript">
Zepto(function($){
   var $nav = $('.global-nav'), $btnLogo = $('.global-nav__operate-wrap');
   //点击箭头，显示隐藏导航
   $btnLogo.on('click',function(){
     if($btnLogo.parent().hasClass('global-nav--current')){
       navHide();
     }else{
       navShow();
     }
   });
   var navShow = function(){
     $nav.addClass('global-nav--current');
   }
   var navHide = function(){
     $nav.removeClass('global-nav--current');
   }
   
   $(window).on("scroll", function() {
		if($nav.hasClass('global-nav--current')){
			navHide();
		}
	});
})
function get_search_box(){
	try{
		document.getElementById('get_search_box').click();
	}catch(err){
		document.getElementById('keywordfoot').focus();
 	}
}
</script> </div>
</div>
<script type="text/javascript" src="themes/miqinew/js/jquery.min.js"></script> 
<script type="text/javascript" src="themes/miqinew/js/jquery.more.js"></script> 
<script type="text/javascript" src="themes/miqinew/js/ectouch.js"></script> 
<script type="text/javascript">
jQuery(function($){
	$('#J_ItemList').more({'address': 'group_buy.php?act=asynclist', 'spinner_code':'<div style="text-align:center; margin:10px;"><img src="themes/miqinew/images/loader.gif" /></div>'})
	$(window).scroll(function () {
		if ($(window).scrollTop() == $(document).height() - $(window).height()) {
			$('.get_more').click();
		}
	});
});
</script>
</body>
</html>