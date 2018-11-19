<?php if ($this->_var['temp'] == 'addCategory'): ?>
<div class="dialog_addCategory">
	<dl>
    	<dt><?php echo $this->_var['lang']['category_name']; ?>：</dt>
        <dd><input type="text" class="text text_2" name="addedCategoryName" id="addedCategoryName" value="" autocomplete="off" /></dd>
    </dl>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'addBrand'): ?>
<div class="dialog_addBrand">
	<dl>
    	<dt><?php echo $this->_var['lang']['brand_name']; ?>：</dt>
        <dd><input type="text" class="text text_2" name="addBrandName" id="addBrandName" value="" autocomplete="off" /></dd>
    </dl>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'addWarehouse'): ?>
<div class="addWarehouse">
    <dl>
        <dt><?php echo $this->_var['lang']['warehouse_name']; ?>：</dt>
        <dd>
            <div class="imitate_select select_w140">
                <div class="cite"><?php echo $this->_var['lang']['select_please']; ?></div>
                <ul>
                	<?php $_from = $this->_var['warehouse_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'warehouse');$this->_foreach['nowarehouse'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nowarehouse']['total'] > 0):
    foreach ($_from AS $this->_var['warehouse']):
        $this->_foreach['nowarehouse']['iteration']++;
?>
                    <li><a href="javascript:;" data-value="<?php echo $this->_var['warehouse']['region_id']; ?>" class="ftx-01"><?php echo $this->_var['warehouse']['region_name']; ?></a></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                <input name="warehouse_name" type="hidden" value="" id="warehouse_name">
            </div>
        </dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['warehouse_number']; ?>：</dt>
        <dd><input name="warehouse_number" id="warehouse_number" value="0" type="text" size="10" class="text text_2" autocomplete="off" /></dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['warehouse_price']; ?>：</dt>
        <dd><input name="warehouse_price" id="warehouse_price" value="0" type="text" size="10" class="text text_2" autocomplete="off" /></dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['warehouse_promote_price']; ?>：</dt>
        <dd><input name="warehouse_promote_price" id="warehouse_promote_price" value="0" type="text" size="10" class="text text_2" autocomplete="off" /></dd>
    </dl>
    
    <dl>
        <dt><?php echo $this->_var['lang']['lab_give_integral']; ?></dt>
        <dd>
        	<input name="give_integral" id="warehouse_give_integral" value="0" type="text" size="10" class="text text_2" rev="give" autocomplete="off" />
            <?php if ($this->_var['user_id']): ?>
            &nbsp;<span class="color999" id="give_html">可设置<em id="give">0</em>消费积分</span>
            <?php endif; ?>
        </dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['lab_rank_integral']; ?></dt>
        <dd>
        	<input name="rank_integral" id="warehouse_rank_integral" value="0" type="text" size="10" class="text text_2" rev="rank" autocomplete="off" />
            <?php if ($this->_var['user_id']): ?>
            &nbsp;<span class="color999" id="rank_html">可设置<em id="rank">0</em>等级积分</span>
            <?php endif; ?>
        </dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['lab_integral']; ?></dt>
        <dd>
        	<input name="pay_integral" id="warehouse_pay_integral" value="0" type="text" size="10" class="text text_2" rev="pay" autocomplete="off" />
            <?php if ($this->_var['user_id']): ?>
            &nbsp;<span class="color999" id="pay_html">可设置积分购买<em id="pay">0</em>金额</span>
            <?php endif; ?>
        </dd>
    </dl>
</div>
<script type="text/javascript">
<?php if ($this->_var['user_id']): ?>
$(function(){
	$('#warehouse_price, #warehouse_promote_price').blur(function(){
		var warehouse_price = Number($("#warehouse_price").val());
		var warehouse_promote_price = Number($("#warehouse_promote_price").val());
		var shop_price;
		
		if(warehouse_price > warehouse_promote_price && warehouse_promote_price == 0){
			shop_price = warehouse_price;
		}else if(warehouse_price < warehouse_promote_price && warehouse_promote_price != 0){
			shop_price = warehouse_price;
		}else{
			shop_price = warehouse_promote_price;
		}
		
		var give_integral = Math.floor(shop_price * <?php echo $this->_var['grade_rank']['give_integral']; ?>);

		$("#give").html(give_integral);
		
		var rank_integral = Math.floor(shop_price * <?php echo $this->_var['grade_rank']['rank_integral']; ?>);
		$("#rank").html(rank_integral);
		
		var pay_integral = Math.floor(shop_price / 100 * <?php echo $this->_var['integral_scale']; ?> * <?php echo $this->_var['grade_rank']['pay_integral']; ?>);
		$("#pay").html(pay_integral);
		
		$("#warehouse_give_integral").val('');
		$("#warehouse_rank_integral").val('');
		$("#warehouse_pay_integral").val('');
	});
	
	$('#warehouse_give_integral, #warehouse_rank_integral, #warehouse_pay_integral').blur(function(){
		var give = $('#give').html();
		var rank = $('#rank').html();
		var pay = $('#pay').html();
		var val = $(this).val();
		var rev = $(this).attr('rev');
		var integral = $("#" + rev).html();
		if(val > integral){
			if(rev == 'give'){
				alert("可设置" + integral + "消费积分");
			}else if(rev == 'rank'){
				alert("可设置" + integral + "等级积分");
			}else{
				alert("可设置积分购买" + integral + "金额");
			}
			$(this).val(integral);
		}
	});
	
});
<?php endif; ?>
</script>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'addBatchWarehouse'): ?>
<div class="warehouse_warpper" id="batchWarehouelist">
	<div class="add_warehouse_list">
		<div class="warehouse_item">
			<span class="item">
				<span class="tit">仓库名称</span>
				
                <div class="imitate_select select_w140">
                    <div class="cite"><?php echo $this->_var['lang']['select_please']; ?></div>
                    <ul>
                        <?php $_from = $this->_var['warehouse_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'warehouse');$this->_foreach['nowarehouse'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nowarehouse']['total'] > 0):
    foreach ($_from AS $this->_var['warehouse']):
        $this->_foreach['nowarehouse']['iteration']++;
?>
                        <li><a href="javascript:;" data-value="<?php echo $this->_var['warehouse']['region_id']; ?>" class="ftx-01"><?php echo $this->_var['warehouse']['region_name']; ?></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                    <input name="warehouse_name" type="hidden" value="0" id="warehouse_name">
                </div>						
			</span>
			<span class="item"><span class="tit">仓库库存</span><input type="text" value="0" name="warehouse_number" class="text w65" autocomplete="off" /></span>
			<span class="item"><span class="tit">仓库价格</span><input type="text" value="0" name="warehouse_price" class="text w65" autocomplete="off" /></span>
			<span class="item last"><span class="tit">仓库促销价格</span><input type="text" value="0" name="warehouse_promote_price" class="text w65" autocomplete="off" /></span>
			<div class="hide">
				<span class="item"><span class="tit">赠送消费积分数</span><input type="text" value="0" name="give_integral" class="text w65" autocomplete="off" /></span>
				<span class="item"><span class="tit">赠送等级积分数</span><input type="text" value="0" name="rank_integral" class="text w65" autocomplete="off" /></span>
				<span class="item"><span class="tit">积分购买金额</span><input type="text" value="0" name="pay_integral" class="text w65" autocomplete="off" /></span>
			</div>
		</div>
		<a href="javascript:void(0);" class="addList"></a>
	</div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'addRegion'): ?>
<div class="addWarehouse">
    <dl>
        <dt><?php echo $this->_var['lang']['warehouse_region_name']; ?>：</dt>
        <dd>
            <select name="warehouse_area_name" onchange="get_warehouse_area_name(this.value, this.id, <?php echo $this->_var['goods_id']; ?>, <?php echo $this->_var['user_id']; ?>)" id="1" class="select" style=" margin:0 10px 0 0;">
                <option value="0" selected><?php echo $this->_var['lang']['select_please']; ?></option>
                <?php $_from = $this->_var['warehouse_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'warehouse');$this->_foreach['nowarehouse'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nowarehouse']['total'] > 0):
    foreach ($_from AS $this->_var['warehouse']):
        $this->_foreach['nowarehouse']['iteration']++;
?>
                <option value="<?php echo $this->_var['warehouse']['region_id']; ?>"><?php echo $this->_var['warehouse']['region_name']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select>
            <font style="font-size:12px; float:left;" id="warehouse_area_list_1" name="warehouse_area_list"></font>
        </dd>
    </dl>    
    <dl>
        <dt><?php echo $this->_var['lang']['region_number']; ?>：</dt>
        <dd><input name="region_number" id="region_number" value="0" type="text" size="10" class="text text_2" autocomplete="off" /></dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['region_price']; ?>：</dt>
        <dd><input name="region_price" id="region_price" value="0" type="text" size="10" class="text text_2" autocomplete="off" /></dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['region_promote_price']; ?>：</dt>
        <dd><input name="region_promote_price" id="region_promote_price" value="0" type="text" size="10" class="text text_2" autocomplete="off" /></dd>
    </dl>
    
    <dl>
        <dt><?php echo $this->_var['lang']['lab_give_integral']; ?></dt>
        <dd>
        	<input name="give_integral" id="region_give_integral" value="0" type="text" size="10" class="text text_2" rev="give" autocomplete="off" />
            <?php if ($this->_var['user_id']): ?>
        	&nbsp;<span class="color999" id="give_html">可设置<em id="give">0</em>消费积分</span>
            <?php endif; ?>
        </dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['lab_rank_integral']; ?></dt>
        <dd>
        	<input name="rank_integral" id="region_rank_integral" value="0" type="text" size="10" class="text text_2" rev="rank" autocomplete="off" />
        	<?php if ($this->_var['user_id']): ?>
            &nbsp;<span class="color999" id="rank_html">可设置<em id="rank">0</em>等级积分</span>
            <?php endif; ?>
        </dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['lab_integral']; ?></dt>
        <dd>
        	<input name="pay_integral" id="region_pay_integral" value="0" type="text" size="10" class="text text_2" rev="pay" autocomplete="off" />
        	<?php if ($this->_var['user_id']): ?>
        	&nbsp;<span class="color999" id="pay_html">可设置积分购买<em id="pay">0</em>金额</span>
            <?php endif; ?>
        </dd>
    </dl>
</div>
<script type="text/javascript">
<?php if ($this->_var['user_id']): ?>
$(function(){
	$('#region_price, #region_promote_price').blur(function(){
		var region_price = Number($('#region_price').val());
		var region_promote_price = Number($('#region_promote_price').val());
		var shop_price;
		
		if(region_price > region_promote_price && region_promote_price == 0){
			shop_price = region_price;
		}else if(region_price < region_promote_price && region_promote_price != 0){
			shop_price = region_price;
		}else{
			shop_price = region_promote_price;
		}
		
		var give_integral = Math.floor(shop_price * <?php echo $this->_var['grade_rank']['give_integral']; ?>);

		$("#give").html(give_integral);
		
		var rank_integral = Math.floor(shop_price * <?php echo $this->_var['grade_rank']['rank_integral']; ?>);
		$("#rank").html(rank_integral);
		
		var pay_integral = Math.floor(shop_price / 100 * <?php echo $this->_var['integral_scale']; ?> * <?php echo $this->_var['grade_rank']['pay_integral']; ?>);
		$("#pay").html(pay_integral);
		
		$("#warehouse_give_integral").val('');
		$("#warehouse_rank_integral").val('');
		$("#warehouse_pay_integral").val('');
	});
	
	$('#region_give_integral, #region_rank_integral, #region_pay_integral').blur(function(){
		var give = $('#give').html();
		var rank = $('#rank').html();
		var pay = $('#pay').html();
		var val = $(this).val();
		var rev = $(this).attr('rev');
		var integral = $("#" + rev).html();
		if(val > integral){
			if(rev == 'give'){
				alert("可设置" + integral + "消费积分");
			}else if(rev == 'rank'){
				alert("可设置" + integral + "等级积分");
			}else{
				alert("可设置积分购买" + integral + "金额");
			}
			$(this).val(integral);
		}
	});
	
});
<?php endif; ?>
</script>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'addBatchRegion'): ?>
<div class="warehouse_warpper" id="batchRegionlist">
	<div class="add_warehouse_list">
		<div class="warehouse_item" id="area_1">
			<span class="item">
				<span class="tit">地区名称</span>
                <div class="imitate_select select_w140 warehouse_area_name" data-key="1" data-goodsid="<?php echo $this->_var['goods_id']; ?>" data-userid="<?php echo $this->_var['user_id']; ?>" id="warehouse_area_name_1">
                    <div class="cite"><?php echo $this->_var['lang']['select_please']; ?></div>
                    <ul>
                        <?php $_from = $this->_var['warehouse_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'warehouse');$this->_foreach['nowarehouse'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nowarehouse']['total'] > 0):
    foreach ($_from AS $this->_var['warehouse']):
        $this->_foreach['nowarehouse']['iteration']++;
?>
                        <li><a href="javascript:;" data-value="<?php echo $this->_var['warehouse']['region_id']; ?>" class="ftx-01"><?php echo $this->_var['warehouse']['region_name']; ?></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                    <input name="warehouse_area_name" type="hidden" value="" id="warehouse_area_name_val_1">
                </div>
				<font style="font-size:12px;" id="warehouse_area_list_1" name="warehouse_area_list"></font>									
			</span>
			<span class="item"><span class="tit">地区库存</span><input type="text" value="0" name="region_number" class="text w65" autocomplete="off" /></span>
			<span class="item"><span class="tit">地区价格</span><input type="text" value="0" name="region_price" class="text w65" autocomplete="off" /></span>
			<span class="item"><span class="tit">地区促销价格</span><input type="text" value="0" name="region_promote_price" class="text w65" autocomplete="off" /></span>
			<div class="hide">
				<span class="item"><span class="tit">赠送消费积分数</span><input type="text" value="0" name="give_integral" class="text w65" autocomplete="off" /></span>
				<span class="item"><span class="tit">赠送等级积分数</span><input type="text" value="0" name="rank_integral" class="text w65" autocomplete="off" /></span>
				<span class="item last"><span class="tit">积分购买金额</span><input type="text" value="0" name="pay_integral" class="text w65" autocomplete="off" /></span>
			</div>
		</div>
		<a href="javascript:void(0);" class="addList"></a>
	</div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'addImg'): ?>
<form  action="goods.php?act=addImg" id="fileForm" method="post"  enctype="multipart/form-data"  runat="server" >
<div class="addImg" id="addImg">
	<dl>
        <dt><?php echo $this->_var['lang']['img_count']; ?>：</dt>
        <dd><input type="text" class="text_3 mr10"  name="img_desc[]" size="20" autocomplete="off" /></dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['img_url']; ?>：</dt>
        <dd><input type="file" name="img_url[]" id="img_url"  class="file mr10 mt5" autocomplete="off" /></dd>
    </dl>
    <dl>
        <dt><?php echo $this->_var['lang']['img_file']; ?>：</dt>
        <dd><input type="text" size="40" value="<?php echo $this->_var['lang']['img_file']; ?>" style="color:#aaa;" autocomplete="off" onfocus="if (this.value == '<?php echo $this->_var['lang']['img_file']; ?>'){this.value='http://';this.style.color='#000';}" name="img_file[]"/></dd>
    </dl>
    <input type="hidden"   value="<?php echo $this->_var['goods_id']; ?>" name="goods_id_img"/>
</div>
</form>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'addBatchImg'): ?>
<form  action="goods.php?act=addBatchImg" id="addBatchImg_from" method="post"  enctype="multipart/form-data"  runat="server" >
	<div class="img_item"  >
		<span class="red"><?php echo $this->_var['lang']['remind']; ?></span>
	</div>
	<div class="img_item">
    <a href="javascript:;" onclick="addImg(this)" class="up"></a>
    <?php echo $this->_var['lang']['img_count']; ?>：<input type="text" class="text_2 mr10" name="img_desc[]" size="20" autocomplete="off" />
    <?php echo $this->_var['lang']['img_url']; ?>：<input type="file" name="img_url[]" id="Batch_img_url" class="mr10" autocomplete="off" />
    <input type="text" size="40" value="<?php echo $this->_var['lang']['img_file']; ?>" style="color:#aaa;" autocomplete="off" onfocus="if (this.value == '<?php echo $this->_var['lang']['img_file']; ?>'){this.value='http://';this.style.color='#000';}" name="img_file[]"/>
    <input type="hidden"   value="<?php echo $this->_var['goods_id']; ?>" name="goods_id_img"/>
    </div>
</form>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'privilege'): ?>
<div class="dialog_privilege" id="dialog_privilege">
	<dl>
    	<dt><?php echo $this->_var['lang']['label_region']; ?>：</dt>
        <dd>
        	<select name="country" id="selCountries" onChange="region.changed(this, 1, 'selProvinces')" class="select">
              <?php $_from = $this->_var['countries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');$this->_foreach['fe_country'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_country']['total'] > 0):
    foreach ($_from AS $this->_var['country']):
        $this->_foreach['fe_country']['iteration']++;
?>
                <option value="<?php echo $this->_var['country']['region_id']; ?>" <?php if (($this->_foreach['fe_country']['iteration'] <= 1)): ?>selected<?php endif; ?>><?php echo htmlspecialchars($this->_var['country']['region_name']); ?></option>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select>
            <select name="province" id="selProvinces" onChange="region.changed(this, 2, 'selCities')" class="select mr10">
              <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
            </select>
            <select name="city" id="selCities" onChange="region.changed(this, 3, 'selDistricts')" class="select mr10">
              <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
            </select>
            <select name="district" id="selDistricts" class="select mr10">
              <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
            </select>
        </dd>
    </dl>
</div>
<script type="text/javascript">
	var selCountry = document.getElementById("selCountries");
	if (selCountry.selectedIndex >= 0)
	{
		region.loadProvinces(selCountry.options[selCountry.selectedIndex].value);
	}
</script>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'load_url'): ?>
<!doctype html>
<html>
<head><?php echo $this->fetch('library/admin_html_head.lbi'); ?></head>
<body>
	<div class="loadSpin">
		<i class="icon-spinner icon-spin"></i>
    </div>
</body>
</html>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'pic_album'): ?>
<div class="pic_album">
    <div class="items bor_bt_not">
        <div class="item album_Percent hide">
            <div class="label">上传进度：</div>
            <div class="label_value">
                <div class="text_div mr0 w120 pl0"><span class="Percent_pic" ></span></div><div class="Percent"></div>
            </div>
        </div>
        <div class="item">
            <div class="label">选择相册：</div>
            <div class="label_value">
                <div id="parent_cat" class="imitate_select select_w320">
                    <div class="cite"><?php if ($this->_var['album_mame']): ?><?php echo $this->_var['album_mame']; ?><?php else: ?><?php echo $this->_var['lang']['please_select']; ?><?php endif; ?></div>
                    <ul>
                        <?php $_from = $this->_var['cat_select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                        <li><a href="javascript:;" data-value="<?php echo $this->_var['item']['album_id']; ?>"  class="ftx-01"><?php echo $this->_var['item']['name']; ?></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                    <input name="album_id" type="hidden" id="album_number" value="<?php echo $this->_var['album_id']; ?>" >
                </div>
            </div>
        </div>
        <div class="item">
            <div class="label"><?php echo $this->_var['lang']['img_url']; ?>：</div>
            <div class="label_value">
                <div class="type-file-box">
                    <input type="button" name="button" id="button" class="type-file-button" value="" />
                    <span class="red ml10 lh30">按住ctrl可同时批量选择多张图片上传</span>
                </div>
                <div class="form_prompt"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<script type="text/javascript">
var uploader_gallery = new plupload.Uploader({//创建实例的构造方法
	runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
	browse_button: 'button', // 上传按钮
	url: "gallery_album.php?is_ajax=1&act=upload_pic", //远程上传地址
	filters: {
		max_file_size: '2mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
		mime_types: [//允许文件上传类型
			{title: "files", extensions: "jpg,png,gif"}
		]
	},
	multi_selection: true, //true:ctrl多文件上传, false 单文件上传
	init: {
		FilesAdded: function(up, files) { //文件上传前
			window.Percent = 0; //初始化进度
			var i = 0;
			plupload.each(files, function(file) { //遍历文件
				i ++;
			});
			
			window.Percentage = 1/i;//单个文件比例
			$(".album_Percent").show();
			album_submitBtn();
		},
		FileUploaded: function(up, file, info) { //文件上传成功的时候触发
			window.Percent = window.Percent + Percentage*100;
			
			$(".Percent_pic").css({"width": window.Percent + "%"});
			$(".Percent").html(Math.round(window.Percent) + "%");
		},
		UploadComplete:function(up,file){//所有文件上传成功时触发
			window.location.href="gallery_album.php?act=view&id=<?php echo $this->_var['album_id']; ?>"; 
		},
		Error: function(up, err) { //上传出错的时候触发
			alert(err.message);
		}
	}
});
uploader_gallery.init();
	function album_submitBtn(){
		var album_id = $("#album_number").val();
		var data = {
			album_id: album_id
		};
		uploader_gallery.setOption("multipart_params", data);
		uploader_gallery.start();
	};
	
</script>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'album_move'): ?>
<div class="switch_info">
    <div class="items">
        <div class="item">
            <div class="label">选择相册：</div>
            <div class="label_value">
                <div id="parent_cat" class="imitate_select select_w145">
                  <div class="cite"><?php if ($this->_var['album_mame']): ?><?php echo $this->_var['album_mame']; ?><?php else: ?><?php echo $this->_var['lang']['please_select']; ?><?php endif; ?></div>
                  <ul>
                    <?php $_from = $this->_var['cat_select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                    <?php if ($this->_var['list']['album_id'] != $this->_var['album_id']): ?><li><a href="javascript:;" data-value="<?php echo $this->_var['list']['album_id']; ?>" class="ftx-01"><?php echo $this->_var['list']['name']; ?></a></li><?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                  </ul>
                  <input name="album_id" type="hidden" value="0" >
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
	//select下拉默认值赋值
	$('.imitate_select').each(function()
	{
		var sel_this = $(this)
		var val = sel_this.children('input[type=hidden]').val();
		sel_this.find('a').each(function(){
			if($(this).attr('data-value') == val){
				sel_this.children('.cite').html($(this).html());
			}
		})
	});
})
</script>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'add_albun_pic'): ?>
<form id="add_albun_pic" method="post" enctype="multipart/form-data" runat="server" >
<div class="items">
    <div class="item">
        <div class="label"><em class="red">*</em>相册名称：</div>
        <div class="value">
            <input type="text" name='album_mame'  class="text" autocomplete="off" ectype="required" data-msg="请填写相册名称"/>
        </div>
    </div>
    <div class="item">
        <div class="label">封面：</div>
        <div class="value">
            <div class="type-file-box">
                <input type="button" name="button" id="button" class="type-file-button" value="">
                <input type="file" class="type-file-file" id="album_cover" name="album_cover" data-state="imgfile" size="30" hidefocus="true" value="">
                <input type="text" name="textfile" class="type-file-text" id="textfield" autocomplete="off" readonly>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="label">描述 ：</div>
        <div class="value">
            <textarea class="textarea" name="album_desc" id="role_describe"></textarea>
        </div>
    </div>
    <div class="item">
        <div class="label">排序 ：</div>
        <div class="value">
            <input type="text" name="sort_order" value="50" size="35" class="text w100" />
        </div>
    </div>
</div>
</form>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'img_list'): ?>
<?php $_from = $this->_var['img_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'img');if (count($_from)):
    foreach ($_from AS $this->_var['img']):
?>
	<?php if ($this->_var['mode'] == 'lunbo'): ?>
    <li style="background-image:url(<?php echo $this->_var['img']['pic_src']; ?>); background-position: center center;  background-repeat: no-repeat; background-color:<?php echo $this->_var['img']['bg_color']; ?>;"><div class="banner-width"><a href="<?php echo $this->_var['img']['link']; ?>" target="<?php echo $this->_var['attr']['target']; ?>" style="height:<?php echo $this->_var['attr']['picHeight']; ?>px;"></a></div></li>
    <?php elseif ($this->_var['mode'] == 'topBanner'): ?>
    <a href="<?php if ($this->_var['img']['link']): ?><?php echo $this->_var['img']['link']; ?><?php else: ?>#<?php endif; ?>" target="<?php echo $this->_var['attr']['target']; ?>"><img width="1200" height="80" src="<?php if ($this->_var['img']['pic_src']): ?><?php echo $this->_var['img']['pic_src']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_011.jpg<?php endif; ?>"></a>
    <i class="iconfont icon-cha" ectype="close"></i>
    <?php elseif ($this->_var['mode'] == 'h-streamer'): ?>
    <li><a href="<?php if ($this->_var['img']['link']): ?><?php echo $this->_var['img']['link']; ?><?php else: ?>#<?php endif; ?>" target="<?php echo $this->_var['attr']['target']; ?>"><img src="<?php if ($this->_var['img']['pic_src']): ?><?php echo $this->_var['img']['pic_src']; ?><?php else: ?>../data/gallery_album/visualDefault/ad_01_pic.jpg<?php endif; ?>"></a></li>
    <?php else: ?>
    <?php if ($this->_var['is_li'] == 1): ?><li style="height:<?php echo $this->_var['attr']['picHeight']; ?>px;"><?php endif; ?><a href="<?php if ($this->_var['img']['link']): ?><?php echo $this->_var['img']['link']; ?><?php else: ?>#<?php endif; ?>" target="<?php echo $this->_var['attr']['target']; ?>"><?php if ($this->_var['mode'] == 'advImg4'): ?><span class="btm"></span><?php endif; ?><img src="<?php echo $this->_var['img']['pic_src']; ?>" width="<?php if ($this->_var['mode'] == 'advImg2'): ?>1200<?php else: ?><?php echo $this->_var['width']; ?><?php endif; ?>" height="<?php echo $this->_var['height']; ?>"></a><?php if ($this->_var['is_li'] == 1): ?></li><?php endif; ?>
    <?php endif; ?>
<?php endforeach; else: ?>
	<?php if ($this->_var['mode'] == 'advImg1'): ?>
		<li><img src="images/default/ad_01_pic.jpg"></li>
    <?php elseif ($this->_var['mode'] == 'advImg2'): ?>
    	<li><img src="images/default/ad_02_a_pic.jpg" width="595" height="595"></li>
        <li><img src="images/default/ad_02_a_pic.jpg" width="595" height="595"></li>
    <?php elseif ($this->_var['mode'] == 'advImg3'): ?>
    	<?php if ($this->_var['attr']['itemsLayout'] == "left-right"): ?>
    	<li><a href="#"><img src="images/default/ad_02_c_pic.jpg"></a></li>
        <li><a href="#"><img src="images/default/ad_02_d_pic.jpg"></a></li>
        <?php else: ?>
        <li><a href="#"><img src="images/default/ad_02_d_pic.jpg"></a></li>
        <li><a href="#"><img src="images/default/ad_02_c_pic.jpg"></a></li>
        <?php endif; ?>
    <?php elseif ($this->_var['mode'] == 'advImg4'): ?>
    	<?php if ($this->_var['attr']['itemsLayout'] == "row3"): ?>
    	<li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_03.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_03.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_03.jpg"></a></li>
        <?php elseif ($this->_var['attr']['itemsLayout'] == "row4"): ?>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_04.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_04.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_04.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_04.jpg"></a></li>
        <?php elseif ($this->_var['attr']['itemsLayout'] == "row5"): ?>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_02.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_02.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_02.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_02.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic_02.jpg"></a></li>
        <?php else: ?>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic.jpg"></a></li>
        <li><a href="#"><span class="btm"></span><img src="images/default/ad_03_pic.jpg"></a></li>
        <?php endif; ?>
    <?php elseif ($this->_var['mode'] == 'lunbo'): ?>
    	<li><a href="#"><img src="images/default/shop_banner_pic.jpg"></a></li>
    <?php elseif ($this->_var['mode'] == 'topBanner'): ?>
    <a href="#"><img width="1200" height="80" src="../data/gallery_album/visualDefault/homeIndex_011.jpg"></a>
    <i class="iconfont icon-cha" ectype="close"></i>
    <?php elseif ($this->_var['mode'] == 'h-streamer'): ?>
    <li><a href=""><img src="../data/gallery_album/visualDefault/ad_01_pic.jpg"></a></li>
    <?php endif; ?>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'goods_list'): ?>
<div class="gallery_album" data-act="<?php if ($this->_var['action']): ?><?php echo $this->_var['action']; ?><?php else: ?>changedgoods<?php endif; ?>" data-goods='1' data-inid="goods_list" data-url='<?php if ($this->_var['action']): ?><?php echo $this->_var['url']; ?><?php else: ?>get_ajax_content.php<?php endif; ?>' data-where="cat_id=<?php echo $this->_var['filter']['cat_id']; ?>&sort_order=<?php echo $this->_var['filter']['sort_order']; ?>&keyword=<?php echo $this->_var['filter']['keyword']; ?>&search_type=<?php echo $this->_var['filter']['search_type']; ?>&goods_id=<?php echo $this->_var['filter']['goods_id']; ?>&ru_id=<?php echo $this->_var['filter']['ru_id']; ?>&type=1&PromotionType=<?php echo $this->_var['PromotionType']; ?>">
    <ul class="ga-goods-ul" id="goods_list">
        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['gl'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gl']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['gl']['iteration']++;
?>
        <li class="<?php if ($this->_var['goods']['is_selected'] == 1): ?>on<?php endif; ?>">
            <div class="img"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>"></div>
            <div class="name"><?php echo $this->_var['goods']['goods_name']; ?></div>
            <div class="price">
                <?php if ($this->_var['PromotionType'] == 'exchange'): ?>
                    <?php echo $this->_var['goods']['exchange_integral']; ?>
                <?php else: ?>
                    <?php if ($this->_var['goods']['promote_price'] != ''): ?>
                        <?php echo $this->_var['goods']['promote_price']; ?>
                    <?php else: ?>
                        <?php echo $this->_var['goods']['shop_price']; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="choose">
                <a href="javascript:void(0);" <?php if ($this->_var['goods']['is_selected'] == 1): ?>class="on"<?php endif; ?> onclick="selected_goods(this,'<?php echo $this->_var['goods']['goods_id']; ?>')"><i class="iconfont <?php if ($this->_var['goods']['is_selected'] == 1): ?>icon-gou<?php else: ?>icon-dsc-plus<?php endif; ?>"></i><?php if ($this->_var['goods']['is_selected'] == 1): ?>已选择<?php else: ?>选择<?php endif; ?></a>
                <?php if ($this->_var['PromotionType']): ?>
                <div class="checkbox_item"> 
                    <input name="recommend" type="radio" class="ui-radio" value="<?php echo $this->_var['goods']['goods_id']; ?>" id="recommend<?php echo $this->_var['goods']['goods_id']; ?>"<?php if ($this->_var['goods']['goods_id'] == $this->_var['recommend']): ?> checked="checked"<?php endif; ?>>
                    <label for="recommend<?php echo $this->_var['goods']['goods_id']; ?>" class="ui-radio-label-shou"><i class="iconfont icon-thumb"></i>主推</label>
                </div>
                <?php endif; ?>
            </div>
        </li>
        <?php endforeach; else: ?>
        <li class="notic">该分类下没有商品</li>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <div class="clear"></div>
    <?php echo $this->fetch('library/lib_page.lbi'); ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'replace'): ?>
<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <li>
        <div class="img"><a href="<?php echo $this->_var['goods']['url']; ?>"><img src="<?php echo $this->_var['goods']['original_img']; ?>"></a></div>
        <div class="info">
            <div class="name"><a href="<?php echo $this->_var['goods']['url']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></a></div>
                <div class="price">
                    <?php if ($this->_var['goods']['promote_price'] != ''): ?>
                        <?php echo $this->_var['goods']['promote_price']; ?>
                    <?php else: ?>
                        <?php echo $this->_var['goods']['shop_price']; ?>
                    <?php endif; ?>
                </div>
            <div class="btn_hover"><a href="<?php echo $this->_var['goods']['url']; ?>">立即购买</a></div>
        </div>
    </li>
<?php endforeach; else: ?>
	<?php if ($this->_var['attr']['itemsLayout'] == "row3"): ?>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <?php elseif ($this->_var['attr']['itemsLayout'] == "row4"): ?>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
	<?php else: ?>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <li>
        <div class="img"><a href="" title=""><img src="images/default/gd_pic_02.jpg"></a></div>
        <div class="info">
            <div class="name"><a href="">商品名称</a></div>
            <div class="price">￥65.00</div>
            <div class="btn_hover"><a href="">立即购买</a></div>
        </div>
    </li>
    <?php endif; ?>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'navigator_home'): ?>
    <li><a href="<?php if ($this->_var['index_url']): ?><?php echo $this->_var['index_url']; ?><?php else: ?>index.php<?php endif; ?>" class="curr">首页</a></li>
    <?php $_from = $this->_var['navigator']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'navigator');if (count($_from)):
    foreach ($_from AS $this->_var['navigator']):
?>
    <li><a href="<?php echo $this->_var['navigator']['url']; ?>" style="text-align:<?php echo $this->_var['attr']['align']; ?>" <?php if ($this->_var['navigator']['opennew'] == 1): ?>target="_blank"<?php endif; ?>><?php echo $this->_var['navigator']['name']; ?></a></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'navigator'): ?>
    <?php $_from = $this->_var['navigator']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'navigator');if (count($_from)):
    foreach ($_from AS $this->_var['navigator']):
?>
    <li><a href="<?php echo $this->_var['navigator']['url']; ?>" style="text-align:<?php echo $this->_var['attr']['align']; ?>" target="<?php echo $this->_var['attr']['target']; ?>"><?php echo $this->_var['navigator']['name']; ?></a></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'insertVipEdit'): ?>
<div class="userVip-info" ectype="user_info">
    <div class="avatar">
        <a href="user.php?act=profile"><img src="../themes/ecmoban_dsc2017/images/avatar.png"></a>
    </div>
    <div class="login-info">
        <span>Hi，欢迎来到大商创</span>
        <a href="user.php" class="login-button">请登录</a>
        <a href="merchants.php" target="_blank" class="register_button">我要开店</a>
    </div>
</div>
<?php if ($this->_var['index_article_cat']): ?>
<div class="vip-item">
    <div class="tit">
        <?php $_from = $this->_var['index_article_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'cat');$this->_foreach['cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['cat']):
        $this->_foreach['cat']['iteration']++;
?>
        <a href="javascript:void(0);" class="tab_head_item"><?php echo $this->_var['cat']['cat']['name']; ?></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <div class="con">
        <?php $_from = $this->_var['index_article_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['cat']['iteration']++;
?>
        <ul <?php if (! ($this->_foreach['cat']['iteration'] <= 1)): ?>style="display:none;"<?php endif; ?>>
            <?php $_from = $this->_var['cat']['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['article'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['article']['iteration']++;
?>
            <li><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank"><?php echo $this->_var['article']['title']; ?></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['name_count'] > 0): ?>
<div class="vip-item">
    <div class="tit">快捷入口</div>
    <div class="kj_con">
        <?php $_from = $this->_var['attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['attr']):
        $this->_foreach['name']['iteration']++;
?>
        <?php if ($this->_var['attr']['quick_name']): ?>
        <div class="item item_<?php echo $this->_foreach['name']['iteration']; ?>">
            <a href="<?php echo $this->_var['attr']['quick_url']; ?>" target="_blank">
                <i class="iconfont icon-<?php echo $this->_var['attr']['style_icon']; ?><?php if ($this->_var['attr']['style_icon'] == 'zan' || $this->_var['attr']['style_icon'] == 'password' || $this->_var['attr']['style_icon'] == 'share'): ?>-alt<?php endif; ?>"></i>
                <span><?php echo $this->_var['attr']['quick_name']; ?></span>
            </a>
        </div>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'h-need'): ?>
<?php $_from = $this->_var['spec_attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['attr']):
?>
<?php if ($this->_var['attr']['original_img']): ?>
<div class="channel-column" style="background:url(<?php if ($this->_var['attr']['homeAdvBg']): ?><?php echo $this->_var['attr']['homeAdvBg']; ?><?php else: ?>../data/gallery_album/visualDefault/ad_03_pic_02.jpg<?php endif; ?>) no-repeat;">
    <div class="column-title">
            <h3 <?php if ($this->_var['needColor']): ?>style="color: <?php echo $this->_var['needColor']; ?>"<?php endif; ?>><?php echo $this->_var['attr']['title']; ?></h3>
        <p <?php if ($this->_var['needColor']): ?>style="color: <?php echo $this->_var['needColor']; ?>"<?php endif; ?>><?php echo $this->_var['attr']['subtitle']; ?></p>
    </div>
    <div class="column-img"><img src="<?php if ($this->_var['attr']['original_img']): ?><?php echo $this->_var['attr']['original_img']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_009.png<?php endif; ?>"></div>
    <a href="<?php echo $this->_var['attr']['url']; ?>" target="_blank" class="column-btn">去看看</a>
</div>
<?php else: ?>
<div class="channel-column" style="background:url(../data/gallery_album/visualDefault/ad_03_pic_02.jpg) no-repeat;">
    <div class="column-title">
        <h3>主标题</h3>
        <p>次标题</p>
    </div>
    <div class="column-img"><img src="../data/gallery_album/visualDefault/homeIndex_008.png"></div>
    <a href="#" target="_blank" class="column-btn">去看看</a>
</div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'h-master'): ?>
<?php if ($this->_var['masterTitle']): ?>
<div class="ftit"><h3><?php echo $this->_var['masterTitle']; ?></h3></div>
<?php endif; ?>
<div class="master-con">
    <?php $_from = $this->_var['spec_attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');$this->_foreach['master'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['master']['total'] > 0):
    foreach ($_from AS $this->_var['attr']):
        $this->_foreach['master']['iteration']++;
?>
    <?php if ($this->_var['attr']['original_img']): ?>
    <div class="m-c-item m-c-i-<?php echo $this->_foreach['master']['iteration']; ?>" style="background:url(<?php if ($this->_var['attr']['homeAdvBg']): ?><?php echo $this->_var['attr']['homeAdvBg']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_003.jpg<?php endif; ?>) center center no-repeat;">
        <div class="m-c-main">
            <div class="title">
                <h3><?php if ($this->_var['attr']['title']): ?><?php echo $this->_var['attr']['title']; ?><?php else: ?>主标题<?php endif; ?></h3>
                <span><?php if ($this->_var['attr']['subtitle']): ?><?php echo $this->_var['attr']['subtitle']; ?><?php else: ?>次标题<?php endif; ?></span>
            </div>
            <a href="<?php echo $this->_var['attr']['url']; ?>" class="m-c-btn" target="_blank">去见识</a>
        </div>
        <div class="img"><a href="<?php echo $this->_var['attr']['url']; ?>" target="_blank"><img src="<?php if ($this->_var['attr']['original_img']): ?><?php echo $this->_var['attr']['original_img']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_009.png<?php endif; ?>"></a></div>
    </div>
    <?php else: ?>
    <div class="m-c-item m-c-i-<?php echo $this->_foreach['master']['iteration']; ?>" style="background:url(../data/gallery_album/visualDefault/homeIndex_003.jpg) center center no-repeat;">
        <div class="m-c-main">
            <div class="title">
                <h3>主标题</h3>
                <span>次标题</span>
            </div>
            <a href="http://" class="m-c-btn" target="_blank">去见识</a>
        </div>
        <div class="img"><a href="http://" target="_blank"><img src="../data/gallery_album/visualDefault/homeIndex_009.png"></a></div>
    </div>
    <?php endif; ?>
    <?php endforeach; else: ?>
    <div class="m-c-item m-c-i-1" style="background:url(../data/gallery_album/visualDefault/homeIndex_003.jpg) center center no-repeat;">
        <div class="m-c-main">
            <div class="title">
                <h3>主标题</h3>
                <span>次标题</span>
            </div>
            <a href="http://" class="m-c-btn" target="_blank">去见识</a>
        </div>
        <div class="img"><a href="http://" target="_blank"><img src="../data/gallery_album/visualDefault/homeIndex_009.png"></a></div>
    </div>
    <div class="m-c-item m-c-i-2" style="background:url(../data/gallery_album/visualDefault/homeIndex_003.jpg) center center no-repeat;">
        <div class="m-c-main">
            <div class="title">
                <h3>主标题</h3>
                <span>次标题</span>
            </div>
            <a href="http://" class="m-c-btn" target="_blank">去见识</a>
        </div>
        <div class="img"><a href="http://" target="_blank"><img src="../data/gallery_album/visualDefault/homeIndex_009.png"></a></div>
    </div>
    <div class="m-c-item m-c-i-3" style="background:url(../data/gallery_album/visualDefault/homeIndex_003.jpg) center center no-repeat;">
        <div class="m-c-main">
            <div class="title">
                <h3>主标题</h3>
                <span>次标题</span>
            </div>
            <a href="http://" class="m-c-btn" target="_blank">去见识</a>
        </div>
        <div class="img"><a href="http://" target="_blank"><img src="../data/gallery_album/visualDefault/homeIndex_009.png"></a></div>
    </div>
    <div class="m-c-item m-c-i-4" style="background:url(../data/afficheimg/1490914187412324261.jpg) center center no-repeat;">
        <div class="m-c-main">
            <div class="title">
                <h3>主标题</h3>
                <span>次标题</span>
            </div>
            <a href="http://" class="m-c-btn" target="_blank">去见识</a>
        </div>
        <div class="img"><a href="http://" target="_blank"><img src="../data/gallery_album/visualDefault/homeIndex_009.png"></a></div>
    </div>
    <div class="m-c-item m-c-i-5" style="background:url(../data/gallery_album/visualDefault/homeIndex_003.jpg) center center no-repeat;">
        <div class="m-c-main">
            <div class="title">
                <h3>主标题</h3>
                <span>次标题</span>
            </div>
            <a href="http://" class="m-c-btn" target="_blank">去见识</a>
        </div>
        <div class="img"><a href="http://" target="_blank"><img src="../data/gallery_album/visualDefault/homeIndex_009.png"></a></div>
    </div>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'h-storeRec'): ?>
<?php if ($this->_var['masterTitle']): ?><div class="ftit"><h3><?php echo $this->_var['masterTitle']; ?></h3></div><?php endif; ?>
<div class="rec-store-list">
    <?php $_from = $this->_var['spec_attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');if (count($_from)):
    foreach ($_from AS $this->_var['attr']):
?>
    <?php if ($this->_var['attr']['original_img']): ?>
    <div class="rec-store-item opacity_img">
        <a href="<?php echo $this->_var['attr']['url']; ?>" target="_blank">
            <div class="p-img"><img src="<?php if ($this->_var['attr']['original_img']): ?><?php echo $this->_var['attr']['original_img']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_005.jpg<?php endif; ?>"></div>
            <div class="info">
                <div class="s-logo"><div class="img"><img src="<?php if ($this->_var['attr']['homeAdvBg']): ?><?php echo $this->_var['attr']['homeAdvBg']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_001.jpg<?php endif; ?>"></div></div>
                <div class="s-title">
                    <div class="tit"><?php echo $this->_var['attr']['title']; ?></div>
                    <div class="ui-tit"><?php echo $this->_var['attr']['subtitle']; ?></div>
                </div>
            </div>
        </a>
    </div>
    <?php else: ?>
    <div class="rec-store-item opacity_img">
        <a href="#" target="_blank">
            <div class="p-img"><img src="../data/gallery_album/visualDefault/homeIndex_005.jpg"></div>
            <div class="info">
                <div class="s-logo"><div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_001.jpg"></div></div>
                <div class="s-title">
                    <div class="tit">主标题</div>
                    <div class="ui-tit">次标题</div>
                </div>
            </div>
        </a>
    </div>
    <?php endif; ?>
    <?php endforeach; else: ?>
    <div class="rec-store-item opacity_img">
        <a href="#" target="_blank">
            <div class="p-img"><img src="../data/gallery_album/visualDefault/homeIndex_005.jpg"></div>
            <div class="info">
                <div class="s-logo"><div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_001.jpg"></div></div>
                <div class="s-title">
                    <div class="tit">主标题</div>
                    <div class="ui-tit">次标题</div>
                </div>
            </div>
        </a>
    </div>
    <div class="rec-store-item opacity_img">
        <a href="#" target="_blank">
            <div class="p-img"><img src="../data/gallery_album/visualDefault/homeIndex_005.jpg"></div>
            <div class="info">
                <div class="s-logo"><div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_001.jpg"></div></div>
                <div class="s-title">
                    <div class="tit">主标题</div>
                    <div class="ui-tit">次标题</div>
                </div>
            </div>
        </a>
    </div>
    <div class="rec-store-item opacity_img">
        <a href="#" target="_blank">
            <div class="p-img"><img src="../data/gallery_album/visualDefault/homeIndex_005.jpg"></div>
            <div class="info">
                <div class="s-logo"><div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_001.jpg"></div></div>
                <div class="s-title">
                    <div class="tit">主标题</div>
                    <div class="ui-tit">次标题</div>
                </div>
            </div>
        </a>
    </div>
    <div class="rec-store-item opacity_img">
        <a href="#" target="_blank">
            <div class="p-img"><img src="../data/gallery_album/visualDefault/homeIndex_005.jpg"></div>
            <div class="info">
                <div class="s-logo"><div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_001.jpg"></div></div>
                <div class="s-title">
                    <div class="tit">主标题</div>
                    <div class="ui-tit">次标题</div>
                </div>
            </div>
        </a>
    </div>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloor'): ?>
<!-- 楼层一 -->
<div class="floor-line-con floorOne <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" id="floor_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
    <div class="floor-hd" ectype="floorTit">
    	<i class="box_hd_arrow"></i>
    	<i class="box_hd_dec"></i>
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="hd-tit"><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></div><?php endif; ?>
        <div class="hd-tags">
            <ul>
                <li class="first current">
                    <span>新品推荐</span>
                    <i class="arrowImg"></i>
                </li>
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="6" data-id="<?php echo $this->_var['cat']['cat_id']; ?>">
                    <span><?php echo $this->_var['cat']['cat_name']; ?></span>
                    <i class="arrowImg"></i>
                </li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="floor-bd bd-mode-0<?php echo $this->_var['spec_attr']['floorMode']; ?>">
        <div class="bd-left">
            <?php if ($this->_var['spec_attr']['floorMode'] == 1 || $this->_var['spec_attr']['floorMode'] == 2): ?>
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                        <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_002.jpg<?php endif; ?>"></a></li>
                        <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_006.jpg<?php endif; ?>"></a></li>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd"><ul></ul></div>
            </div>
            <?php endif; ?>
            
            <div class="floor-left-adv">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['spec_attr']['floorMode'] == 3): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_006.jpg<?php endif; ?>"></a>
                <?php else: ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_004.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            
            <?php if ($this->_var['spec_attr']['floorMode'] == 4): ?>
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                        <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_006.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd"><ul></ul></div>
            </div>
            <?php endif; ?>
        </div>
        <div class="bd-right">
            <div class="floor-tabs-content clearfix">
                <div class="f-r-main f-r-m-adv">
                    <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
                    <div class="f-r-m-item
                    <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                    	<?php if ($this->_foreach['name']['iteration'] == 5): ?> f-r-m-i-double<?php endif; ?>
                    <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
                    	<?php if ($this->_foreach['name']['iteration'] == 1): ?> f-r-m-i-double<?php endif; ?>
                    <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
                    	<?php if ($this->_foreach['name']['iteration'] == 2): ?> f-r-m-i-double<?php endif; ?>
                    <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
                    	<?php if ($this->_foreach['name']['iteration'] == 4): ?> f-r-m-i-double<?php endif; ?>
                    <?php endif; ?>">
                        <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                            <div class="title">
                                <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php endif; ?></h3>
                                <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php endif; ?></span>
                            </div>
                            <img src="
                            	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                                	<?php if ($this->_foreach['name']['iteration'] == 5): ?>
                            			<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_006.jpg<?php endif; ?>
                                    <?php else: ?>
                                        <?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_004.jpg<?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
                                	<?php if ($this->_foreach['name']['iteration'] == 1): ?>
                            			<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_006.jpg<?php endif; ?>
                                    <?php else: ?>
                                        <?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_004.jpg<?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
                                	<?php if ($this->_foreach['name']['iteration'] == 2): ?>
                            			<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_006.jpg<?php endif; ?>
                                    <?php else: ?>
                                        <?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_004.jpg<?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
                                	<?php if ($this->_foreach['name']['iteration'] == 4): ?>
                            			<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_006.jpg<?php endif; ?>
                                    <?php else: ?>
                                        <?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_004.jpg<?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            ">
                        </a>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                    <ul class="p-list"></ul>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>
    </div>
    <?php if ($this->_var['brand_list']): ?>
    <div class="floor-fd">
        <div class="floor-fd-brand clearfix">
            <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <div class="item">
                <a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">
                    <div class="link-l"></div>
                    <div class="img"><img src="<?php echo $this->_var['list']['brand_logo']; ?>" title="<?php echo $this->_var['list']['brand_name']; ?>"></div>
                    <div class="link"></div>
                </a>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php else: ?>
        <?php if ($this->_var['spec_attr']['cat_id'] == 0): ?>
        <div class="floor-fd">
            <div class="floor-fd-brand clearfix" ectype="defaultBrand">
                <div class="item">
                    <a href="#" target="_blank">
                        <div class="link-l"></div>
                        <div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                        <div class="link"></div>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorModule'): ?>
<!-- 楼层二 -->
<div class="floor-line-con floorTwo <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" <?php if ($this->_var['spec_attr']['hierarchy'] != 2): ?>id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>"<?php endif; ?> ectype="floorItem">
    <div class="floor-hd" ectype="floorTit">
    	<i class="box_hd_arrow"></i>
    	<i class="box_hd_dec"></i>
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="hd-tit"><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></div><?php endif; ?>
        <div class="hd-tags">
            <ul>
                <li class="first current">
                    <span>新品推荐</span>
                    <i class="arrowImg"></i>
                </li>
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" class="first" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="4" data-id="<?php echo $this->_var['cat']['cat_id']; ?>">
                    <span><?php echo $this->_var['cat']['cat_name']; ?></span>
                    <i class="arrowImg"></i>
                </li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="floor-bd">
        <div class="bd-left">
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                        <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_013.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd"><ul></ul></div>
            </div>
        </div>
        <div class="bd-right">
            <div class="floor-tabs-content clearfix">
                <div class="f-r-main f-r-m-adv">
                    <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
                    <?php if ($this->_foreach['name']['iteration'] < $this->_var['advNumber']): ?>
                        <div class="f-r-m-item<?php if ($this->_var['spec_attr']['floorMode'] == 2): ?><?php if ($this->_foreach['name']['iteration'] == 3): ?> f-r-m-i-double<?php endif; ?><?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?><?php if ($this->_foreach['name']['iteration'] == 1): ?> f-r-m-i-double<?php endif; ?><?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?> f-r-m-i-double<?php endif; ?>">
                            <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                <div class="title">
                                    <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php endif; ?></h3>
                                    <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php endif; ?></span>
                                </div>
                                <img src="<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                                	<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_012.jpg<?php endif; ?>
                                <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
                                    <?php if ($this->_foreach['name']['iteration'] == 3): ?>
                                    	<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_014.jpg<?php endif; ?>
                                    <?php else: ?>
                                    	<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_012.jpg<?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
                                	<?php if ($this->_foreach['name']['iteration'] == 1): ?>
                                    	<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_014.jpg<?php endif; ?>
                                    <?php else: ?>
                                    	<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_012.jpg<?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
                                	<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_014.jpg<?php endif; ?>    
                                <?php endif; ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                    <ul class="p-list"></ul>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>
    </div>
    <?php if ($this->_var['brand_list']): ?>
    <div class="floor-fd">
        <div class="floor-fd-brand clearfix">
            <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <div class="item">
                <a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">
                    <div class="link-l"></div>
                    <div class="img"><img src="<?php echo $this->_var['list']['brand_logo']; ?>" title="<?php echo $this->_var['list']['brand_name']; ?>"></div>
                    <div class="link"></div>
                </a>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php else: ?>
        <?php if ($this->_var['spec_attr']['cat_id'] == 0): ?>
        <div class="floor-fd">
            <div class="floor-fd-brand clearfix" ectype="defaultBrand">
                <div class="item">
                    <a href="#" target="_blank">
                        <div class="link-l"></div>
                        <div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                        <div class="link"></div>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorThree'): ?>
<!-- 楼层三 -->
<div class="floor-line-con floorThree <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
	<div class="floor-hd" ectype="floorTit">
		<?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="hd-tit"><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></div><?php endif; ?>
        <div class="hd-tags">
			<ul>
				<li class="first current">新品推荐</li>
				<?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>10<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>6<?php else: ?>8<?php endif; ?>" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="1"><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
			</ul>
		</div>
	</div>
    
    <div class="floor-bd FT-bd-more-0<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>1<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>2<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>3<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>4<?php endif; ?>">
    	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
        <div class="floor-tabs-content clearfix">
            <div class="f-r-main f-r-m-adv">
                <ul>
                     <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                     <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual232x590.jpg<?php endif; ?>"></a></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
            <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
            <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>"></div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
        <?php else: ?>
    	<div class="bd-left">
        	<?php if ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                    	<?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual232x590.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd"><ul></ul></div>
            </div>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
            	<div class="floor-left-adv">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual232x290.jpg<?php endif; ?>"></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="bd-right">
        	<div class="floor-tabs-content clearfix">
        	<div class="f-r-main f-r-m-adv">
            <?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <div class="floor-left-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual474x290.jpg<?php endif; ?>"></a></div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <?php endif; ?>
            
            <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
            <div class="f-r-m-item">
                <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                    <div class="title">
                        <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php endif; ?></h3>
                        <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php endif; ?></span>
                    </div>
                    <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual232x290.jpg<?php endif; ?>">
                </a>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
            <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
            	<?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <div class="floor-left-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual474x290.jpg<?php endif; ?>"></a></div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>    
    	<?php endif; ?>
    </div>
    <?php if ($this->_var['brand_list']): ?>
    <div class="floor-fd">
        <div class="floor-fd-brand clearfix">
            <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <div class="item">
                <a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">
                    <div class="link-l"></div>
                    <div class="img"><img src="<?php echo $this->_var['list']['brand_logo']; ?>" title="<?php echo $this->_var['list']['brand_name']; ?>"></div>
                    <div class="link"></div>
                </a>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php else: ?>
        <?php if ($this->_var['spec_attr']['cat_id'] == 0): ?>
        <div class="floor-fd">
            <div class="floor-fd-brand clearfix" ectype="defaultBrand">
                <div class="item">
                    <a href="#" target="_blank">
                        <div class="link-l"></div>
                        <div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                        <div class="link"></div>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorFour'): ?>
<!-- 楼层四 -->
<div class="floor-line-con floorFour <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
    <div class="floor-hd" ectype="floorTit">
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="hd-tit"><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></div><?php endif; ?>
        <div class="hd-tags">
            <ul>
                <li class="first current" data-catGoods="<?php echo $this->_var['spec_attr']['top_goods']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>8<?php elseif ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>10<?php else: ?>12<?php endif; ?>" data-id="<?php echo $this->_var['spec_attr']['cat_id']; ?>" data-floorcat="<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>2<?php else: ?>0<?php endif; ?>">新品推荐</li>
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>8<?php elseif ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>10<?php else: ?>12<?php endif; ?>" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>2<?php else: ?>0<?php endif; ?>"><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="floor-bd FF-bd-more-0<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>1<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>2<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>3<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>4<?php endif; ?>">
        <?php if ($this->_var['spec_attr']['floorMode'] != 4): ?>
        <div class="bd-left">
        	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
            <div class="floor-left-adv">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adc'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adc']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adc']['iteration']++;
?>
                <?php if ($this->_foreach['adc']['iteration'] == 1): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x520.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <ul class="p-list" ectype="pList">
                <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <?php if (($this->_foreach['goods']['iteration'] - 1) < 4): ?>
                <li class="li opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                        <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                        <div class="p-price">
                            <div class="shop-price">
                                <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                <?php echo $this->_var['list']['promote_price']; ?>
                                <?php else: ?>
                                <?php echo $this->_var['list']['shop_price']; ?>
                                <?php endif; ?>
                            </div>
                        </div>    
                    </div>
                </li>
                <?php endif; ?>
                <?php endforeach; else: ?>
                <!--<li class="li right-child opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">请选择您所需的商品</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>
                <li class="li right-child opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">请选择您所需的商品</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>
                <li class="li left-child opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">请选择您所需的商品</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>
                <li class="li right-child opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">请选择您所需的商品</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>-->
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                    	<?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x520.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd"><ul></ul></div>
            </div>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
            <div class="floor-left-adv">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adc'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adc']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adc']['iteration']++;
?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x260.jpg<?php endif; ?>"></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="bd-right">
            <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
            <div class="floor-left-adv">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adc'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adc']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adc']['iteration']++;
?>
                <?php if ($this->_foreach['adc']['iteration'] == 2): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x520.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <ul class="p-list" ectype="pList">
                <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <?php if (($this->_foreach['goods']['iteration'] - 1) > $this->_var['goods_num']): ?>
                <li class="li opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                        <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                        <div class="p-price">
                            <div class="shop-price">
                                <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                <?php echo $this->_var['list']['promote_price']; ?>
                                <?php else: ?>
                                <?php echo $this->_var['list']['shop_price']; ?>
                                <?php endif; ?>
                            </div>
                        </div>    
                    </div>
                </li>
                <?php endif; ?>
                <?php endforeach; else: ?>
                <!--<li class="li left-child opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>
                <li class="li opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>
                <li class="li left-child opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>
                <li class="li opacity_img">
                    <div class="product">
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                        <div class="p-price"><em>¥</em>370.50</div>
                    </div>
                </li>-->
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php else: ?>
            <div class="floor-tabs-content clearfix">
            	<div class="f-r-main f-r-m-adv" ectype="floor_cat_<?php echo $this->_var['spec_attr']['cat_id']; ?>">
                    <ul class="p-list">
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <?php if (($this->_foreach['goods']['iteration'] - 1) > $this->_var['goods_num']): ?>
                        <li class="<?php if ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?><?php if ($this->_foreach['goods']['iteration'] % 5 == 1): ?>left-child <?php endif; ?><?php else: ?><?php if ($this->_foreach['goods']['iteration'] % 6 == 1): ?>left-child <?php endif; ?><?php endif; ?>opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-price">
                                    <div class="shop-price">
                                        <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                        <?php echo $this->_var['list']['promote_price']; ?>
                                        <?php else: ?>
                                        <?php echo $this->_var['list']['shop_price']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>    
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; else: ?>
                        <!--<li class="left-child opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="<?php if ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>left-child <?php endif; ?>opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="<?php if ($this->_var['spec_attr']['floorMode'] == 4): ?>left-child <?php endif; ?>opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <?php if ($this->_var['spec_attr']['floorMode'] == 4): ?>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>-->
                    </ul>
                </div>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                    <ul class="p-list"></ul>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($this->_var['brand_list']): ?>
    <div class="floor-fd">
        <div class="floor-fd-brand clearfix">
            <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <div class="item">
                <a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">
                    <div class="link-l"></div>
                    <div class="img"><img src="<?php echo $this->_var['list']['brand_logo']; ?>" title="<?php echo $this->_var['list']['brand_name']; ?>"></div>
                    <div class="link"></div>
                </a>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php else: ?>
        <?php if ($this->_var['spec_attr']['cat_id'] == 0): ?>
        <div class="floor-fd">
            <div class="floor-fd-brand clearfix" ectype="defaultBrand">
                <div class="item">
                    <a href="#" target="_blank">
                        <div class="link-l"></div>
                        <div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                        <div class="link"></div>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorFive'): ?>
<!-- 楼层五 -->
<div class="floor-line-con floorFive <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
    <div class="floor-hd" ectype="floorTit">
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="hd-tit"><i class="iconfont icon-<?php echo $this->_var['spec_attr']['style_icon']; ?>"></i><em class="iconfont icon-spot"></em><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></div><?php endif; ?>
        <div class="hd-tags">
            <ul>
                <li class="first current">新品推荐</li>
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="10" data-id="<?php echo $this->_var['cat']['cat_id']; ?>"><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="floor-bd FFI-bd-more-0<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>1<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>2<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>3<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>4<?php elseif ($this->_var['spec_attr']['floorMode'] == 5): ?>5<?php endif; ?>">
        <div class="floor-tabs-content clearfix">
            <div class="f-r-main f-r-m-adv">
                <div class="bd-left">
                    <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                        <div class="floor-left-slide">
                            <div class="bd">
                                <ul>
                                    <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                    <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual477x450.jpg<?php endif; ?>"></a></li>
                                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </ul>
                            </div>
                            <div class="hd">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="floor-left-adv">
                            <ul>
                                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x450.jpg<?php endif; ?>"></a></li>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <?php if ($this->_var['spec_attr']['floorMode'] == 3 || $this->_var['spec_attr']['floorMode'] == 4 || $this->_var['spec_attr']['floorMode'] == 5): ?>
                        <div class="floor-left-adv">
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] == 1): ?>
                            <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x450.jpg<?php endif; ?>"></a>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div>
                        <?php endif; ?>
                    
                        <?php if ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>
                        <div class="floor-left-slide">
                            <div class="bd">
                                <ul>
                                    <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                    <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual477x450.jpg<?php endif; ?>"></a></li>
                                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </ul>
                            </div>
                            <div class="hd">
                                <ul></ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($this->_var['spec_attr']['floorMode'] == 4 || $this->_var['spec_attr']['floorMode'] == 5): ?>
                        <ul>
                            <li class="f-bd-item">
                                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                                <?php if ($this->_foreach['adv']['iteration'] == 2): ?>
                                <div class="floor-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x165.jpg<?php endif; ?>"></a></div>
                                <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                
                                <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                                <?php if ($this->_foreach['adv']['iteration'] == 1): ?>
                                <div class="fr-adv mt5">
                                    <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                        <div class="title">
                                            <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php else: ?>主标题<?php endif; ?></h3>
                                            <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php else: ?>次标题<?php endif; ?></span>
                                        </div>
                                        <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x280.jpg<?php endif; ?>">
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </li>
                            <?php if ($this->_var['spec_attr']['floorMode'] == 5): ?>
                            <li class="f-bd-item">
                                <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                                <?php if ($this->_foreach['adv']['iteration'] == 2): ?>
                                <div class="fr-adv">
                                    <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                        <div class="title">
                                            <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php else: ?>主标题<?php endif; ?></h3>
                                            <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php else: ?>次标题<?php endif; ?></span>
                                        </div>
                                        <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x280.jpg<?php endif; ?>">
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                
                                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                                <?php if ($this->_foreach['adv']['iteration'] == 3): ?>
                                <div class="floor-adv mt5"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x165.jpg<?php endif; ?>"></a></div>
                                <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </li>
                            <?php endif; ?>
                        </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            
                <?php if ($this->_var['spec_attr']['floorMode'] != 1): ?>
                <div class="bd-right">
                    <?php if ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>
                    <ul>
                        <?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>
                        <li class="f-bd-item">
                            <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] == 1): ?>
                            <div class="fr-adv">
                                <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                    <div class="title">
                                        <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php else: ?>主标题<?php endif; ?></h3>
                                        <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php else: ?>次标题<?php endif; ?></span>
                                    </div>
                                    <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x280.jpg<?php endif; ?>">
                                </a>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] == 1): ?>
                            <div class="floor-adv mt5"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x165.jpg<?php endif; ?>"></a></div>                    
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </li>
                        <?php endif; ?>
                        <li class="f-bd-item">
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] == 2): ?>
                            <div class="floor-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x165.jpg<?php endif; ?>"></a></div>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            
                            <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] == 2): ?>
                            <div class="fr-adv mt5">
                                <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                    <div class="title">
                                        <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php else: ?>主标题<?php endif; ?></h3>
                                        <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php else: ?>次标题<?php endif; ?></span>
                                    </div>
                                    <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x280.jpg<?php endif; ?>">
                                </a>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </li>
                        <li class="f-bd-item">
                            <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] == 3): ?>
                            <div class="fr-adv">
                                <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                    <div class="title">
                                        <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php else: ?>主标题<?php endif; ?></h3>
                                        <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php else: ?>次标题<?php endif; ?></span>
                                    </div>
                                    <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x280.jpg<?php endif; ?>">
                                </a>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] == 3): ?>
                            <div class="floor-adv mt5"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x165.jpg<?php endif; ?>"></a></div>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </li>
                    </ul>
                    <?php endif; ?>
                    
                    <?php if ($this->_var['spec_attr']['floorMode'] == 4 || $this->_var['spec_attr']['floorMode'] == 5): ?>
                    <div class="floor-left-slide">
                        <div class="bd">
                            <ul>
                                <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual477x450.jpg<?php endif; ?>"></a></li>
                               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </ul>
                        </div>
                        <div class="hd">
                            <ul></ul>
                        </div>
                    </div>
                    <?php if ($this->_var['spec_attr']['floorMode'] == 4): ?>
                    <div class="floor-left-adv">
                        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                        <?php if ($this->_foreach['adv']['iteration'] == 3): ?>
                        <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual236x450.jpg<?php endif; ?>"></a>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
            <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                <ul class="p-list"></ul>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <div class="floor-fd">
        <div class="floor-fd-slide">
            <div class="bd">
                <ul class="current" data-catGoods="<?php echo $this->_var['spec_attr']['top_goods']; ?>" ectype="identi_floorgoods" data-identi="1" data-flooreveval="0" data-visualhome="1" data-floornum="10" data-id="<?php echo $this->_var['spec_attr']['cat_id']; ?>" data-floorcat="2">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li>
                        <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                        <div class="p-info">
                            <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                            <div class="p-price">
                            	<div class="shop-price">
                                    <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                    <?php echo $this->_var['list']['promote_price']; ?>
                                    <?php else: ?>
                                    <?php echo $this->_var['list']['shop_price']; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; else: ?>
                    <!--<li>
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-info">
                            <div class="p-name"><a href="#" target="_blank">唐人基 灌汤鱼丸180g*4袋 福州鱼丸 贡丸冷冻肉丸海鲜</a></div>
                            <div class="p-price"><em>¥</em>370.50</div>
                        </div>
                    </li>
                    <li>
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-info">
                            <div class="p-name"><a href="#" target="_blank">唐人基 灌汤鱼丸180g*4袋 福州鱼丸 贡丸冷冻肉丸海鲜</a></div>
                            <div class="p-price"><em>¥</em>370.50</div>
                        </div>
                    </li>
                    <li>
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-info">
                            <div class="p-name"><a href="#" target="_blank">唐人基 灌汤鱼丸180g*4袋 福州鱼丸 贡丸冷冻肉丸海鲜</a></div>
                            <div class="p-price"><em>¥</em>370.50</div>
                        </div>
                    </li>
                    <li>
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-info">
                            <div class="p-name"><a href="#" target="_blank">唐人基 灌汤鱼丸180g*4袋 福州鱼丸 贡丸冷冻肉丸海鲜</a></div>
                            <div class="p-price"><em>¥</em>370.50</div>
                        </div>
                    </li>
                    <li>
                        <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                        <div class="p-info">
                            <div class="p-name"><a href="#" target="_blank">唐人基 灌汤鱼丸180g*4袋 福州鱼丸 贡丸冷冻肉丸海鲜</a></div>
                            <div class="p-price"><em>¥</em>370.50</div>
                        </div>
                    </li>-->
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
            <a href="javascript:void(0);" class="ff-prev"></a>
            <a href="javascript:void(0);" class="ff-next"></a>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorSix'): ?>
<!-- 楼层六 -->    
<div class="floor-line-con floorSix <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
    <div class="floor-hd" ectype="floorTit">
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="hd-tit"><i class="icon"></i><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></div><?php endif; ?>
        <div class="hd-tags">
            <ul>
                <li class="first current"data-catGoods="<?php echo $this->_var['spec_attr']['top_goods']; ?>" <?php if ($this->_var['spec_attr']['floorMode'] > 2): ?> ectype="floor_cat_content" <?php endif; ?>data-flooreveval="0" data-visualhome="1" data-floornum="<?php if ($this->_var['spec_attr']['floorMode'] == 3): ?>6<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>8<?php else: ?>0<?php endif; ?>" data-id="<?php echo $this->_var['spec_attr']['cat_id']; ?>" data-floorcat="<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>2<?php else: ?>0<?php endif; ?>">新品推荐</li>
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="10" data-id="<?php echo $this->_var['cat']['cat_id']; ?>"><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="floor-bd FS-bd-more-0<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>1<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>2<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>3<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>4<?php endif; ?>">
        <div class="bd-left">
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                        <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x480.jpg<?php endif; ?>"></a></li>
                       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd">
                    <ul></ul>
                </div>
            </div>
            <?php if ($this->_var['brand_list']): ?>
            <div class="floor-brand">
                <div class="fb-bd">
                    <ul>
                        <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank" title="<?php echo $this->_var['list']['brand_name']; ?>"><img src="<?php echo $this->_var['list']['brand_logo']; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <a href="javascript:void(0);" class="fs_prev"><i class="iconfont icon-left"></i></a>
                <a href="javascript:void(0);" class="fs_next"><i class="iconfont icon-right"></i></a>
            </div>
            <?php endif; ?>
        </div>
        <div class="bd-right">
        	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
            <div class="floor-tabs-content clearfix">
            	<div class="f-r-main f-r-m-adv">
                    <div class="floor-left-adv">
                        <ul>
                            <li class="f-bd-item child-double">
                                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x240.jpg<?php endif; ?>"></a>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </li>
                            
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                            <?php if ($this->_foreach['adv']['iteration'] > 2): ?>
                            <li class="f-bd-item"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x480.jpg<?php endif; ?>"></a></li>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                </div>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                    <ul class="p-list"></ul>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
            <div class="floor-left-adv">
            	<ul>
                    <li class="f-bd-item child-double">
                        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x240.jpg<?php endif; ?>"></a>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </li>
                </ul>
            </div>   
            <?php endif; ?>
            
            <?php if ($this->_var['spec_attr']['floorMode'] != 1): ?>
            <div class="floor-tabs-content">
                <div class="f-r-main f-r-curr" ectype="floor_cat_<?php echo $this->_var['spec_attr']['cat_id']; ?>">
                    <ul class="p-list">
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <li class="child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-price">
                                    <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                    <?php echo $this->_var['list']['promote_price']; ?>
                                    <?php else: ?>
                                    <?php echo $this->_var['list']['shop_price']; ?>
                                	<?php endif; ?>
                                </div>
                            </div>
                            <a href="<?php echo $this->_var['list']['url']; ?>" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <?php endforeach; else: ?>
                        <!--<li class="child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <li class="child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <?php if ($this->_var['spec_attr']['floorMode'] == 3 || $this->_var['spec_attr']['floorMode'] == 4): ?>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <?php if ($this->_var['spec_attr']['floorMode'] == 4): ?>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <li class="opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                            <a href="#" target="_blank" class="fr-btn">立即购买</a>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>-->
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                    <ul class="p-list"></ul>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php endif; ?>
            <?php if ($this->_var['spec_attr']['floorMode'] == 3): ?>
            <div class="floor-left-adv">
                <ul>
                    <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['adv']['iteration']++;
?>
                    <li class="f-bd-item"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x480.jpg<?php endif; ?>"></a></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorSeven'): ?>
<!-- 楼层七 -->
<div class="floor-line-con floorSeven <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
    <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="ftit"><h3><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h3></div><?php endif; ?>
    <div class="floor-bd FSE-bd-more-0<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>1<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>2<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>3<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>4<?php elseif ($this->_var['spec_attr']['floorMode'] == 5): ?>5<?php endif; ?>">
        <div class="bd-left">
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                        <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x440.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd">
                    <ul></ul>
                </div>
            </div>
            <div class="floor-nav">
                <ul>
                    <li class="current" data-catGoods="<?php echo $this->_var['spec_attr']['top_goods']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="10" data-id="<?php echo $this->_var['spec_attr']['cat_id']; ?>" data-floorcat="2">新品推荐<i></i></li>
                    <?php if ($this->_var['spec_attr']['cateValue']): ?>
                    <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                    <?php if ($this->_var['cat']['cat_name']): ?>
                    <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="10" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="2"><?php echo $this->_var['cat']['cat_name']; ?><i></i></li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="bd-right">
        	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
            <div class="floor-left-adv">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x440.jpg<?php endif; ?>"></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php endif; ?>
            <div class="floor-tabs-content">
            	<?php if ($this->_var['spec_attr']['floorMode'] == 1 || $this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 5): ?>
                <div class="f-r-main f-r-curr">
                    <ul class="p-list<?php if ($this->_var['spec_attr']['floorMode'] == 5): ?> p-list-six<?php endif; ?>" ectype="pList">
                    	<?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>
                        <li class="child-double opacity_img">
                        	<div class="floor-left-adv">
                            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x220.jpg<?php endif; ?>"></a>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </div>
                        </li>
                        <?php endif; ?>
                        
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <li class="li <?php if ($this->_var['spec_attr']['floorMode'] == 1 || $this->_var['spec_attr']['floorMode'] == 5): ?><?php if ($this->_foreach['goods']['iteration'] < 4): ?>child-curr <?php endif; ?><?php endif; ?>opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-price">
                                    <div class="shop-price">
                                        <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                        <?php echo $this->_var['list']['promote_price']; ?>
                                        <?php else: ?>
                                        <?php echo $this->_var['list']['shop_price']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; else: ?>
                        <!--<li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>-->
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                    <?php if ($this->_var['spec_attr']['floorMode'] == 5): ?>
                    <div class="floor-left-adv">
                        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x440.jpg<?php endif; ?>"></a>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
                <div class="f-r-main f-r-curr">
                	<ul class="p-list p-list-two" ectype="pList">
                    	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <?php if ($this->_foreach['goods']['iteration'] < 3): ?>
                        <li class="li <?php if ($this->_foreach['goods']['iteration'] == 1): ?>child-curr <?php endif; ?>opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-price">
                                    <div class="shop-price">
                                        <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                        <?php echo $this->_var['list']['promote_price']; ?>
                                        <?php else: ?>
                                        <?php echo $this->_var['list']['shop_price']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; else: ?>
                        <!--<li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>-->
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                    <div class="floor-left-adv">
                        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x440.jpg<?php endif; ?>"></a>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                    <ul class="p-list p-list-four" ectype="pList">
                    	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <?php if ($this->_foreach['goods']['iteration'] > 2 && $this->_foreach['goods']['iteration'] < 7): ?>
                        <li class="li <?php if ($this->_foreach['goods']['iteration'] < 3): ?>child-curr <?php endif; ?>opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-price">
                                    <div class="shop-price">
                                        <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                        <?php echo $this->_var['list']['promote_price']; ?>
                                        <?php else: ?>
                                        <?php echo $this->_var['list']['shop_price']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; else: ?>
                        <!--<li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>-->
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
                <div class="f-r-main f-r-curr">
                    <ul class="p-list" ectype="pList">
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <?php if ($this->_foreach['goods']['iteration'] < 6): ?>
                        <li class="li<?php if ($this->_foreach['goods']['iteration'] < 6): ?> child-curr <?php endif; ?>opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-price">
                                    <div class="shop-price">
                                        <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                        <?php echo $this->_var['list']['promote_price']; ?>
                                        <?php else: ?>
                                        <?php echo $this->_var['list']['shop_price']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; else: ?>
                        <!--<li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>-->
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <li class="child-double opacity_img">
                        	<div class="floor-left-adv">
                            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x220.jpg<?php endif; ?>"></a>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </div>
                        </li>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <?php if ($this->_foreach['goods']['iteration'] == 6): ?>
                        <li class="li opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-price">
                                    <div class="shop-price">
                                        <?php if ($this->_var['list']['promote_price'] != ''): ?>
                                        <?php echo $this->_var['list']['promote_price']; ?>
                                        <?php else: ?>
                                        <?php echo $this->_var['list']['shop_price']; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; else: ?>
                        <!--<li class="li child-curr opacity_img">
                            <div class="product">
                                <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
                                <div class="p-name"><a href="#" target="_blank">亿健家用彩屏多功能折叠</a></div>
                                <div class="p-price"><em>¥</em>370.50</div>
                            </div>
                        </li>-->
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($this->_var['brand_list']): ?>
    <div class="floor-fd">
        <div class="floor-fd-brand clearfix">
            <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <div class="item">
                <a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">
                    <div class="link-l"></div>
                    <div class="img"><img src="<?php echo $this->_var['list']['brand_logo']; ?>" title="<?php echo $this->_var['list']['brand_name']; ?>"></div>
                    <div class="link"></div>
                </a>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php else: ?>
    <?php if ($this->_var['spec_attr']['cat_id'] == 0): ?>
    <div class="floor-fd">
        <div class="floor-fd-brand clearfix" ectype="defaultBrand">
            <div class="item">
                <a href="#" target="_blank">
                    <div class="link-l"></div>
                    <div class="img"><img src="../data/gallery_album/visualDefault/homeIndex_010.jpg" title="esprit"></div>
                    <div class="link"></div>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorEight'): ?>
<!-- 楼层八 -->
<div class="floor-line-con floorEight <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
	<?php if ($this->_var['spec_attr']['floorMode'] != 1): ?>
    <div class="floor-hd" ectype="floorTit">
		<?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="hd-tit"><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></div><?php endif; ?>
        <div class="hd-tags">
			<ul>
				<li class="first current" data-catGoods="<?php echo $this->_var['spec_attr']['top_goods']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="<?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>6<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>8<?php else: ?>4<?php endif; ?>" data-id="<?php echo $this->_var['spec_attr']['cat_id']; ?>" data-floorcat="2">新品推荐</li>
				<?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="<?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>6<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>8<?php else: ?>4<?php endif; ?>" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="2"><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
			</ul>
		</div>
	</div>
    <?php endif; ?>
    
    <div class="floor-bd FE-bd-more-0<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>1<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>2<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>3<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>4<?php elseif ($this->_var['spec_attr']['floorMode'] == 5): ?>5<?php endif; ?>">
    	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
        <div class="bd-left">
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                    	<?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftbanner'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftbanner']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftbanner']['iteration']++;
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual393x280.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
        	</div>
        </div>            
        <?php else: ?>
        <div class="bd-left">
            <div class="floor_silder floor_silder1">
                <div class="bd">
                    <ul>
                    	<?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftbanner'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftbanner']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftbanner']['iteration']++;
?>
                        <li class="<?php if (($this->_foreach['leftbanner']['iteration'] - 1) == 0): ?>img_first<?php elseif (($this->_foreach['leftbanner']['iteration'] - 1) == 1): ?>img_second<?php elseif (($this->_foreach['leftbanner']['iteration'] - 1) == 2): ?>img_third<?php endif; ?>">
                            <a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank">
                                <div class="silder-img"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x220.jpg<?php endif; ?>"></div>
                                <div class="silder-title">
                                    <h3>开启品质生活1</h3>
                                    <span>爱上新家电</span>
                                </div>
                            </a>
                            <div class="color_mask"></div>
                        </li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd"><ul></ul></div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="bd-right">
            <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                <div class="floor-left-adv">
                    <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftadv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftadv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftadv']['iteration']++;
?>
                    <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual192x280.jpg<?php endif; ?>"></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</div>                
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 5): ?>  
            	<ul class="p-list" ectype="pList">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                    <?php if (($this->_foreach['goods']['iteration'] - 1) < 2): ?>
                    <li class="li opacity_img">
                        <div class="product">
                            <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                            <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                            <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>

                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftadv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftadv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftadv']['iteration']++;
?>
                <?php if (($this->_foreach['leftadv']['iteration'] - 1) == 0): ?>
                <div class="floor-left-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual486x430.jpg<?php endif; ?>"></a></div>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                <ul class="p-list" ectype="pList">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                    <?php if (($this->_foreach['goods']['iteration'] - 1) > 1): ?>
                    <li class="li opacity_img">
                        <div class="product">
                            <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                            <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                            <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftadv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftadv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftadv']['iteration']++;
?>
                <?php if (($this->_foreach['leftadv']['iteration'] - 1) == 1): ?>
                <div class="floor-left-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual486x430.jpg<?php endif; ?>"></a></div>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <?php else: ?>
                <ul class="p-list" ectype="pList">
                    <?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>
                    <li class="child-double opacity_img">
                        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <div class="floor-left-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual484x215.jpg<?php endif; ?>"></a></div>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </li>
                    <?php endif; ?>
                    
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                    <?php if (($this->_foreach['goods']['iteration'] - 1) > $this->_var['goods_num']): ?>
                    <li class="li opacity_img">
                        <div class="product">
                            <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                            <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                            <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                
                <?php if ($this->_var['spec_attr']['floorMode'] == 4): ?>
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <div class="floor-left-adv"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual486x430.jpg<?php endif; ?>"></a></div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            <?php endif; ?>
   		</div>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorNine'): ?>
<!-- 楼层九 -->
<div class="floor-line-con floorNine FN-bd-more-0<?php echo $this->_var['spec_attr']['floorMode']; ?>" data-title="主分类名称" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
    <i class="floor-tit-arrow"></i>
    <div class="floor-hd" ectype="floorTit">
        <div class="hd-tags">
            <ul>
                <li class="first current">新品推荐</li>
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="8" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="1"><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="floor-bd">
        <div class="bd-left">
            <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><div class="bd-left-title"><h3><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h3><i></i></div><?php endif; ?>
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                    	<?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual160x472.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd">
                    <ul></ul>
                </div>
            </div>
        </div>
        
        <div class="bd-right">
            <div class="floor-tabs-content">
                <div class="f-r-main f-r-m-adv">
                	<?php if ($this->_var['spec_attr']['floorMode'] == 1 || $this->_var['spec_attr']['floorMode'] == 2): ?>
                        <div class="f-r-m-items">
                            <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
                            <div class="f-r-m-item">
                                <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                    <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual245x255.jpg<?php endif; ?>">
                                    <div class="title">
                                        <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php endif; ?></h3>
                                        <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php endif; ?></span>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div>
                        <div class="floor-left-adv">
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftadv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftadv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftadv']['iteration']++;
?>
                            <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                            <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank" class="adv<?php if (($this->_foreach['leftadv']['iteration'] <= 1)): ?> adv-module<?php endif; ?>"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual245x255.jpg<?php endif; ?>"></a>
                            <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
                            <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank" class="adv-module"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual245x255.jpg<?php endif; ?>"></a>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div>
                    <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
                        <div class="floor-left-adv">
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftadv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftadv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftadv']['iteration']++;
?>
                            <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank" class="adv-module"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual245x255.jpg<?php endif; ?>"></a>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div>
                        <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
                        <div class="f-r-m-item">
                            <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual245x255.jpg<?php endif; ?>">
                                <div class="title">
                                    <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php endif; ?></h3>
                                    <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php endif; ?></span>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php else: ?>
                        <?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
                        <div class="f-r-m-item">
                            <a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank">
                                <img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual245x255.jpg<?php endif; ?>">
                                <div class="title">
                                    <h3><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php endif; ?></h3>
                                    <span><?php if ($this->_var['list']['rightAdvSubtitle']): ?><?php echo $this->_var['list']['rightAdvSubtitle']; ?><?php endif; ?></span>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php endif; ?>
                </div>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <div class="f-r-main" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                    <ul class="p-list"></ul>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeFloorTen'): ?>
<!-- 楼层十 -->
<div class="floor-line-con floorTen <?php echo $this->_var['spec_attr']['typeColor']; ?>" data-title="主分类名称" data-idx="1" id="floor_module_<?php echo $this->_var['spec_attr']['floorMode']; ?>" ectype="floorItem">
    <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?>
    <div class="floor-title">
        <div class="floor-title-con">
            <i class="left-arrow"></i>
            <h3><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h3>
            <i class="right-arrow"></i>
        </div>
    </div>
    <?php endif; ?>
    <div class="floor-bd FTEN-bd-more-0<?php echo $this->_var['spec_attr']['floorMode']; ?>">
        <div class="bd-left">
            <div class="floor-left-slide">
                <div class="bd">
                    <ul>
                    	<?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual200x472.jpg<?php endif; ?>"></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                <div class="hd">
                    <ul></ul>
                </div>
            </div>
            <div class="floor-nav">
                <ul>
                	<li class="first current" data-catGoods="<?php echo $this->_var['spec_attr']['top_goods']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="<?php if ($this->_var['spec_attr']['floorMode'] == 1 || $this->_var['spec_attr']['floorMode'] == 2): ?>8<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>6<?php else: ?>10<?php endif; ?>" data-id="<?php echo $this->_var['spec_attr']['cat_id']; ?>" data-floorcat="2">新品推荐</li>
                	<?php if ($this->_var['spec_attr']['cateValue']): ?>
                    <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                    <?php if ($this->_var['cat']['cat_name']): ?>
                    <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="8" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="2"><?php echo $this->_var['cat']['cat_name']; ?></li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="bd-right">
            <div class="floor-tabs-content">
                <div class="f-r-main f-r-m-adv">
                	<ul class="p-list" ectype="pList">
                    	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                            <?php if ($this->_foreach['goods']['iteration'] < 4): ?>
                            <li class="li opacity_img">
                                <div class="product">
                                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                            <li class="child-double opacity_img">
                                <div class="floor-left-adv">
                                    <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x236.jpg<?php endif; ?>"></a>
                                </div>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                            <?php if ($this->_foreach['goods']['iteration'] > 3): ?>
                            <li class="li opacity_img">
                                <div class="product">
                                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
                        	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        	<li class="child-double opacity_img">
                                <div class="floor-left-adv">
                                    <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x236.jpg<?php endif; ?>"></a>
                                </div>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                            <li class="li opacity_img">
                                <div class="product">
                                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                                </div>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                            <?php if ($this->_foreach['goods']['iteration'] < 7): ?>
                            <li class="li opacity_img">
                                <div class="product">
                                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            
                            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                            <li class="child-double opacity_img">
                                <div class="floor-left-adv"> 
                                    <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual400x236.jpg<?php endif; ?>"></a>
                                </div>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php else: ?>
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                            <li class="li opacity_img">
                                <div class="product">
                                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                                </div>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'storeOneFloor1'): ?>
<!-- 店铺模板一 楼层 -->
<div class="st-section<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?> st-section-one<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?> st-section-two<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?> st-section-three<?php else: ?> st-section-four<?php endif; ?> <?php echo $this->_var['spec_attr']['fontColor']; ?>">
    <?php if ($this->_var['spec_attr']['floorMode'] != 1): ?>
    <div class="title">
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h1><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主标题<?php endif; ?></h1><?php endif; ?>
        <?php if ($this->_var['spec_attr']['sub_title']): ?><span><?php echo $this->_var['spec_attr']['sub_title']; ?></span><?php endif; ?>
    </div>
    <?php endif; ?>
    
    <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
    <div class="st_item_slide">
    	<div class="bd">
            <ul>
                <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <li><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1100x273.jpg<?php endif; ?>"></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <div class="hd"><ul></ul></div>
    </div>
    <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
    <div class="st_item">
        <ul class="row4">
        	<?php $_from = $this->_var['spec_attr']['rightAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['name']['iteration']++;
?>
            <li>
                <div class="img"><a href="<?php echo $this->_var['list']['rightAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['rightAdv']): ?><?php echo $this->_var['list']['rightAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual262x360.jpg<?php endif; ?>"></a></div>
                <div class="tit"><?php if ($this->_var['list']['rightAdvTitle']): ?><?php echo $this->_var['list']['rightAdvTitle']; ?><?php else: ?>标题<?php endif; ?></div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <div class="st_item">
    	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 0): ?>
        <div class="row1"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1100x273.jpg<?php endif; ?>"></a></div>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <div class="st_item">
        <div class="row2">
        	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        	<?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 1): ?>
            <div class="row2-left"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual534x350.jpg<?php endif; ?>"></a></div>
            <?php endif; ?>
            <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 2): ?>
            <div class="row2-right"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual534x350.jpg<?php endif; ?>"></a></div>
            <?php endif; ?>
        	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
    <div class="st_item">
    	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        <div class="row1"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1100x458.jpg<?php endif; ?>"></a></div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <div class="st_item">
        <ul class="st_goods_list st_goods_row3">
        	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
            <li>
                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
    <div class="st_item">
        <ul class="st_goods_list st_goods_row4">
        	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
            <li>
                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                <div class="p-lie">
                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                    <div class="p-number">已售0件</div>
                </div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'storeTwoFloor1'): ?>
<!-- 店铺模板二 楼层 -->
<div class="st-section <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>st-section-one<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>st-section-two<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>st-section-sthree<?php else: ?>st-section-four<?php endif; ?> <?php echo $this->_var['spec_attr']['fontColor']; ?>">
    <?php if ($this->_var['spec_attr']['floorMode'] != 1): ?>
    <div class="title">
    	<?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h1><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h1><?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
    <ul class="st_item st_item_lr">
    	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 0 || ($this->_foreach['leftAdv']['iteration'] - 1) == 1): ?>
        <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?><?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 0): ?>../data/gallery_album/visualDefault/visual670x317.jpg<?php elseif (($this->_foreach['leftAdv']['iteration'] - 1) == 1): ?>../data/gallery_album/visualDefault/visual512x317.jpg<?php endif; ?><?php endif; ?>"></a></li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <ul class="st_item st_item_rl">
    	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 2 || ($this->_foreach['leftAdv']['iteration'] - 1) == 3): ?>
        <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?><?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 2): ?>../data/gallery_album/visualDefault/visual484x317.jpg<?php elseif (($this->_foreach['leftAdv']['iteration'] - 1) == 3): ?>../data/gallery_album/visualDefault/visual702x317.jpg<?php endif; ?><?php endif; ?>"></a></li>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
    <div class="st_item">
        <ul class="row3">
        	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual393x228.jpg<?php endif; ?>"></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <div class="st_item">
        <ul class="st_goods_list st_goods_row4">
        	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
            <li>
                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?><i class="arrow"></i></div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
    <div class="st_item">
    	<div class="sti_left">
        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 0): ?><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual562x562.jpg<?php endif; ?>"></a><?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
        <div class="sti_right">
        	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        	<?php if (($this->_foreach['leftAdv']['iteration'] - 1) > 0): ?>
        	<div class="item"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual615x270.jpg<?php endif; ?>"></a></div>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <div class="st_item">
    	<?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
        <a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1200x242.jpg<?php endif; ?>"></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <div class="st_item">
        <ul class="st_goods_list st_goods_row3">
        	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
            <li>
                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?><i class="arrow"></i></div>
                <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>">加入购物车</a></div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'storeThreeFloor1'): ?>
<!-- 店铺模板三 楼层 -->
<div class="st-section <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>st-section-one<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>st-section-three<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>st-section-four<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>st-section-two<?php endif; ?> <?php echo $this->_var['spec_attr']['fontColor']; ?>">
    <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['sub_title']): ?>
    <div class="title">
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h1><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h1><?php endif; ?>
        <?php if ($this->_var['spec_attr']['sub_title']): ?><span><?php echo $this->_var['spec_attr']['sub_title']; ?></span><?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="st_item">
        <div class="w w1200">
        	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
            <ul>
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual277x106.jpg<?php endif; ?>"></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
            <div class="movable-warp" ectype="floorItem">
                <ul class="tab">
                    <?php if ($this->_var['spec_attr']['cateValue']): ?>
                    <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                    <?php if ($this->_var['cat']['cat_name']): ?>
                    <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="8" data-id="<?php echo $this->_var['cat']['cat_id']; ?>"<?php if (($this->_foreach['name']['iteration'] <= 1)): ?> class="current"<?php endif; ?>><?php echo $this->_var['cat']['cat_name']; ?></li>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php endif; ?>
                </ul>
                <div class="floor-tabs-content clearfix">
                    <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                    <div class="f-r-main<?php if (($this->_foreach['name']['iteration'] <= 1)): ?> f-r-m-adv<?php endif; ?>" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                        <ul class="p-list">
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                            <li>
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-lie">
                                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                                    <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">立即抢购</a></div>
                                </div>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            </div>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>
            	<?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>
                    <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                    <div class="adv"><a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1200x375.jpg<?php endif; ?>"></a></div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>

				<?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>             
                <ul class="row3">
                    <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                    <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual393x113.jpg<?php endif; ?>"></a></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                <?php else: ?>
                <ul class="row3">
                    <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                    <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual390x447.jpg<?php endif; ?>"></a></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                <?php endif; ?>
                
                <ul class="st_goods_list">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                    <li>
                        <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                        <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                        <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">立即抢购</a></div>
                    </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'storeFourFloor1'): ?>
<!-- 店铺模板四 楼层 -->
<div class="st-section <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>st-section-one<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>st-section-two<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>st-section-three<?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>st-section-four<?php endif; ?> <?php echo $this->_var['spec_attr']['fontColor']; ?>">
    <div class="w w1200">
    	<?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['sub_title']): ?>
        <div class="title">
            <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h1><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h1><?php endif; ?>
            <?php if ($this->_var['spec_attr']['sub_title']): ?><span>/ <em><?php echo $this->_var['spec_attr']['sub_title']; ?></em> /</span><?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="st_item">
        	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
            <ul class="row3">
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1400x300.jpg<?php endif; ?>"></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
            <ul class="st_goods_list st_goods_row4">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                	<div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>" /></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-lie"><div class="fl">抢购价：</div><div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div></div>
                    <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">立即抢购</a></div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
                <div class="st_item_left">
                    <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>      
                    <a href="<?php echo $this->_var['list']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftBanner']): ?><?php echo $this->_var['list']['leftBanner']; ?><?php else: ?>../data/gallery_album/visualDefault/visual398x472.jpg<?php endif; ?>"></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
                <div class="st_item_right">
                    <div class="stir_adv">
                        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                        <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 0): ?>
                        <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual399x235.jpg<?php endif; ?>"></a>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                    <div class="stir_goods_item">
                        <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>" /></a></div>
                        <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                        <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
            <ul class="st_goods_list st_goods_row4">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>" /></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-lie">
                        <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        <a href="<?php echo $this->_var['list']['url']; ?>" target="_blank" class="p-btn"><i class="iconfont icon-carts"></i></a>
                    </div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>    
            <?php endif; ?>
        </div>
        <?php if ($this->_var['spec_attr']['floorMode'] == 3): ?>
        <div class="st_item mt20">
            <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
            <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 1): ?>
            <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1200x215.jpg<?php endif; ?>"></a>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'storeFiveFloor1'): ?>
<!-- 店铺模板五 楼层 -->
<div class="st-section <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>st-section-two<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>st-section-four<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>st-section-one<?php else: ?>st-section-five<?php endif; ?> <?php echo $this->_var['spec_attr']['fontColor']; ?>">
    <div class="w w1200">
    	<?php if ($this->_var['spec_attr']['floorMode'] != 3): ?>
        <div class="title">
            <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h1><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h1><?php endif; ?>
            <?php if ($this->_var['spec_attr']['sub_title']): ?><span><?php echo $this->_var['spec_attr']['sub_title']; ?></span><?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($this->_var['spec_attr']['floorMode'] == 1 || $this->_var['spec_attr']['floorMode'] == 2): ?>
        <div class="st_item">
            <ul class="st_goods_list <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>st_goods_row3<?php else: ?>st_goods_row4<?php endif; ?>">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>" alt=""/></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-lie">
                        <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">立即购买</a></div>
                    </div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
        <div class="st_item">
            <div class="st-one-left">
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 0 || ($this->_foreach['leftAdv']['iteration'] - 1) == 1): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual288x360.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <div class="st-one-con">
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 2 || ($this->_foreach['leftAdv']['iteration'] - 1) == 3): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?><?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 2): ?>../data/gallery_album/visualDefault/visual590x488.jpg<?php elseif (($this->_foreach['leftAdv']['iteration'] - 1) == 3): ?>../data/gallery_album/visualDefault/visual590x228.jpg<?php endif; ?><?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <div class="st-one-right">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 4 || ($this->_foreach['leftAdv']['iteration'] - 1) == 5): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual288x360.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>
        <?php elseif ($this->_var['spec_attr']['floorMode'] == 4): ?>
        <div class="st_item">
        <ul>
        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual393x260.jpg<?php endif; ?>"></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'topicOneFloor'): ?>
<!-- 专题模板一 楼层 -->
<div class="tt-section<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?> tt-section-one<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?> tt-section-two<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?> tt-section-three<?php endif; ?> <?php echo $this->_var['spec_attr']['fontColor']; ?>">
    <div class="w1000">
        <div class="title">
            <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h3><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h3><?php endif; ?>
            <?php if ($this->_var['spec_attr']['sub_title']): ?><h1><?php echo $this->_var['spec_attr']['sub_title']; ?></h1><?php endif; ?>
        </div>
        <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
        <?php if (($this->_foreach['leftAdv']['iteration'] - 1) == 0): ?>
        <div class="tt_item"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1000x305.jpg<?php endif; ?>"></a></div>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <div class="tt_item">
            <ul class="row3">
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if (($this->_foreach['leftAdv']['iteration'] - 1) > 0): ?>
                <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual326x384.jpg<?php endif; ?>"></a></li>
                <?php endif; ?>
        		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
        <div class="tt_item">
            <ul class="st_goods_list st_goods_row3">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-lie">
                        <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        <s>原价：¥14.9</s>
                    </div>
                    <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>">立即购买<i class="iconfont icon-right"></i></a></div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
        <div class="tt_item" ectype="floorItem">
            <ul class="tt_item_tab">
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="8" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="2"<?php if (($this->_foreach['name']['iteration'] <= 1)): ?> class="current"<?php endif; ?>><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
            <div class="tt_item_content">
            	<div class="floor-tabs-content clearfix">
                    <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                    <div class="f-r-main<?php if (($this->_foreach['name']['iteration'] <= 1)): ?> f-r-m-adv<?php endif; ?>" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                    <ul>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                        <li>
                            <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                            <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                            <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                            <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>">立即购买</a></div>
                        </li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            	</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'topicTwoFloor'): ?>
<!-- 专题模板二 楼层 -->
<div class="tt-section<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?> tt-section-one<?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?> tt-section-two<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?> tt-section-three<?php else: ?> tt-section-four<?php endif; ?> <?php echo $this->_var['spec_attr']['fontColor']; ?>">
	<?php if ($this->_var['spec_attr']['floorMode'] != 1): ?>
    <div class="title">
        <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h3><?php if ($this->_var['spec_attr']['floor_title']): ?># <?php echo $this->_var['spec_attr']['floor_title']; ?> #<?php elseif ($this->_var['spec_attr']['cat_name']): ?># <?php echo $this->_var['spec_attr']['cat_name']; ?> #<?php else: ?>主分类名称<?php endif; ?></h3><?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="w w1000">
    	<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
        <div class="tt_item">
            <ul class="row5">
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual190x290.jpg<?php endif; ?>"></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
        <div class="tt_item tt_item_1">
            <ul class="st_goods_list st_goods_row5">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                    <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><i class="iconfont icon-cart-alt"></i>立即购买</a></div>
                    <i class="i-icon icon-miao"></i>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
        <div class="tt_item mt30"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1000x200.jpg<?php endif; ?>"></a></div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?>
        <div class="tt_item tt_item_1">
            <ul class="st_goods_list st_goods_row5">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-lie">
                        <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                    </div>
                    <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><i class="iconfont icon-cart-alt"></i>立即购买</a></div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php else: ?>
        <div class="tt_item tt_item_1">
            <ul class="tt_item_tab">
                <?php if ($this->_var['spec_attr']['cateValue']): ?>
                <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_var['cat']['cat_name']): ?>
                <li data-catGoods="<?php echo $this->_var['cat']['goods_id']; ?>" ectype="floor_cat_content" data-flooreveval="0" data-visualhome="1" data-floornum="8" data-id="<?php echo $this->_var['cat']['cat_id']; ?>" data-floorcat="2"<?php if (($this->_foreach['name']['iteration'] <= 1)): ?> class="current"<?php endif; ?>><?php echo $this->_var['cat']['cat_name']; ?></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </ul>
            <div class="tt_item_content">
            	<div class="floor-tabs-content clearfix">
                    <?php $_from = $this->_var['spec_attr']['cateValue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
                    <div class="f-r-main<?php if (($this->_foreach['name']['iteration'] <= 1)): ?> f-r-m-adv<?php endif; ?>" ectype="floor_cat_<?php echo $this->_var['cat']['cat_id']; ?>">
                        <ul class="st_goods_list st_goods_row5">
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                            <li>
                                <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                                <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                                <div class="p-lie">
                                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                                </div>
                                <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><i class="iconfont icon-cart-alt"></i>立即购买</a></div>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                	</div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>    
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'topicThreeFloor'): ?>
<!-- 专题模板三 楼层 -->
<div class="tt-section <?php echo $this->_var['spec_attr']['fontColor']; ?>">
    <div class="w w1000">
        <div class="title">
            <?php if ($this->_var['spec_attr']['floor_title'] || $this->_var['spec_attr']['cat_name']): ?><h3><?php if ($this->_var['spec_attr']['floor_title']): ?><?php echo $this->_var['spec_attr']['floor_title']; ?><?php elseif ($this->_var['spec_attr']['cat_name']): ?><?php echo $this->_var['spec_attr']['cat_name']; ?><?php else: ?>主分类名称<?php endif; ?></h3><?php endif; ?>
        </div>
        <?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>
        <div class="tt_item">
            <ul class="st_goods_list st_goods_row4">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-lie">
                        <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                        <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">立即抢购</a></div>
                    </div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
        <div class="tt_item"><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual1000x150.jpg<?php endif; ?>"></a></div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php elseif ($this->_var['spec_attr']['floorMode'] == 2): ?>
        <div class="tt_item tt_item_1">
            <ul class="row5">
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if ($this->_foreach['leftAdv']['iteration'] < 6): ?>
                <li><a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual190x290.jpg<?php endif; ?>"></a></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <div class="tt_item">
            <div class="tt_item_left">
            	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if ($this->_foreach['leftAdv']['iteration'] > 5 && $this->_foreach['leftAdv']['iteration'] < 8): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual324x200.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <div class="tt_item_con">
                <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if ($this->_foreach['leftAdv']['iteration'] == 8): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual324x409.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <div class="tt_item_right">
               	<?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['leftAdv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['leftAdv']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['leftAdv']['iteration']++;
?>
                <?php if ($this->_foreach['leftAdv']['iteration'] > 8 && $this->_foreach['leftAdv']['iteration'] < 11): ?>
                <a href="<?php echo $this->_var['list']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['leftAdv']): ?><?php echo $this->_var['list']['leftAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/visual324x200.jpg<?php endif; ?>"></a>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="tt_item">
            <ul class="st_goods_list st_goods_row5">
            	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['goods']['iteration']++;
?>
                <li>
                    <div class="p-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['goods_thumb']; ?>"></a></div>
                    <div class="p-name"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['goods_name']; ?></a></div>
                    <div class="p-price"><?php if ($this->_var['list']['promote_price'] != ''): ?><?php echo $this->_var['list']['promote_price']; ?><?php else: ?><?php echo $this->_var['list']['shop_price']; ?><?php endif; ?></div>
                    <div class="p-btn"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">立即抢购</a></div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'guessYouLike'): ?>
<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
<li class="opacity_img">
    <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank">
        <div class="p-img"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>"></div>
        <div class="p-name" title="<?php echo $this->_var['goods']['goods_name']; ?>"><?php echo $this->_var['goods']['goods_name']; ?></div>
        <div class="p-price">
            <div class="shop-price">
                <?php if ($this->_var['goods']['promote_price'] != ''): ?>
                <?php echo $this->_var['goods']['promote_price']; ?>
                <?php else: ?>
                <?php echo $this->_var['goods']['shop_price']; ?>
                <?php endif; ?>
            </div>
            <div class="original-price"><?php echo $this->_var['goods']['market_price']; ?></div>
        </div>
    </a>
</li>
<?php endforeach; else: ?>
<!--<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>
<li class="opacity_img">
    <a href="#">
        <div class="p-img"><img src="../data/gallery_album/zhanwei.png"></div>
        <div class="p-name" title="">商品名称商品名称商品名称...</div>
        <div class="p-price">
            <div class="shop-price"><em>¥</em>0.00</div>
            <div class="original-price"></div>
        </div>
    </a>
</li>-->
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'brand_query'): ?>
<ul class="brand_list">
    <?php $_from = $this->_var['recommend_brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['brand']):
?>
    <li ectype='cliclkBrand' <?php if ($this->_var['brand']['selected'] == 1): ?> class="selected"<?php endif; ?> data-brand='<?php echo $this->_var['brand']['brand_id']; ?>' data-type="homeFloorBrand"><a href="JavaScript:void(0);"><img src="<?php echo $this->_var['brand']['brand_logo']; ?>" title="<?php echo $this->_var['brand']['brand_name']; ?>"></a><b></b></li>
    <?php endforeach; else: ?>
    <li class="notic">您选择的此分类下暂无品牌</li>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
<div class="clear"></div>
<?php echo $this->fetch('library/lib_page.lbi'); ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'h-brand'): ?>
<div class="home-brand-adv slide_lr_info">
    <?php $_from = $this->_var['barndAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'adv');if (count($_from)):
    foreach ($_from AS $this->_var['adv']):
?>
    <a href="<?php echo $this->_var['adv']['barndAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['adv']['barndAdv']): ?><?php echo $this->_var['adv']['barndAdv']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_007.jpg<?php endif; ?>" class="slide_lr_img"></a>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<div ectype="homeBrand">
    <div class="brand-list" id="recommend_brands"  data-value="<?php echo $this->_var['brand_ids']; ?>">
        <ul>
            <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
            <li>
                <div class="brand-img"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank"><img src="<?php if ($this->_var['list']['brand_logo']): ?><?php echo $this->_var['list']['brand_logo']; ?><?php else: ?>../data/gallery_album/visualDefault/homeIndex_010.jpg<?php endif; ?>"></a></div>
                <div class="brand-mash">
                    <div data-bid="<?php echo $this->_var['list']['brand_id']; ?>" ectype="coll_brand"><i class="iconfont icon-zan-alt"></i></div>
                    <div class="coupon"><a href="<?php echo $this->_var['list']['url']; ?>" target="_blank">关注人数<br><div id="collect_count_<?php echo $this->_var['list']['brand_id']; ?>"><?php echo empty($this->_var['list']['collect_count']) ? '0' : $this->_var['list']['collect_count']; ?></div></a></div>
                </div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        <a href="javascript:void(0);" ectype="changeBrand" class="refresh-btn"><i class="iconfont icon-rotate-alt"></i><span>换一批</span></a>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'backupTemplates'): ?>
<?php $_from = $this->_var['available_templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'template');$this->_foreach['template'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['template']['total'] > 0):
    foreach ($_from AS $this->_var['template']):
        $this->_foreach['template']['iteration']++;
?>
<li <?php if ($this->_var['default_tem'] == $this->_var['template']['code']): ?>class="curr"<?php endif; ?>>
    <div class="tit"><?php echo $this->_var['template']['name']; ?><a href="<?php if ($this->_var['template']['author_uri']): ?><?php echo $this->_var['template']['author_uri']; ?><?php else: ?>#<?php endif; ?>" target="_blank"/>-<?php echo $this->_var['template']['author']; ?></a></div>
    <div class="span"><?php echo $this->_var['template']['desc']; ?></div>
    <div class="img">
        <?php if ($this->_var['template']['screenshot']): ?><img width="263" height="338" src="<?php echo $this->_var['template']['screenshot']; ?>" data-src-wide="<?php echo $this->_var['template']['template']; ?>" border="0" id="<?php echo $this->_var['template']['code']; ?>" class="pic"/><?php endif; ?>
    </div>
    <div class="info">
        <p><a href="<?php echo $this->_var['template']['template']; ?>" class="btnSeeImg">查看大图</a></p>
        <p class="mt5">
            <a href="../index.php?suffix=<?php echo $this->_var['template']['code']; ?>" class="ml10" target="_blank" >预览模板</a>
            <a href="visual_editing.php?act=template_information&tem=<?php echo $this->_var['template']['code']; ?>&merchant_id=<?php echo $this->_var['ru_id']; ?>" class="ml10">编辑模板信息</a>
            <a href="javascript:removeTemplate('<?php echo $this->_var['template']['code']; ?>')" class="ml10">删除模板</a>
        </p>
    </div>
    <?php if ($this->_var['default_tem'] == $this->_var['template']['code']): ?>
    <i class="ing"></i>
    <?php endif; ?>
</li>								
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'ajaxPiclist'): ?>
	<?php if ($this->_var['is_vis'] == 1 || $this->_var['is_vis'] == 2): ?>
	<div class="gallery_album" data-act="get_albun_pic" data-vis="<?php echo $this->_var['is_vis']; ?>" data-inid="pic_list" data-url='get_ajax_content.php' data-where="sort_name=<?php echo $this->_var['filter']['sort_name']; ?>&album_id=<?php echo $this->_var['filter']['album_id']; ?>&is_vis=<?php echo $this->_var['is_vis']; ?>&inid=<?php echo $this->_var['inid']; ?>">
		<ul class="ga-images-ul" ectype="pic_replace" data-type="<?php if ($this->_var['is_vis'] == 1): ?>check<?php elseif ($this->_var['is_vis'] == 2): ?>radio<?php endif; ?>">
			<?php $_from = $this->_var['pic_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'pic_album');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['pic_album']):
?>
			<li data-url="<?php echo $this->_var['pic_album']['pic_file']; ?>" data-picid='<?php echo $this->_var['pic_album']['pic_id']; ?>'><div class="img-container"><img src="<?php echo $this->_var['pic_album']['pic_file']; ?>"></div><i class="checked"></i></li>
			<?php endforeach; else: ?>
			<li class="notic">暂无图片</li>
			<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
        <div class="clear"></div>
		<?php echo $this->fetch('library/lib_page.lbi'); ?>
	</div>
	<?php else: ?>
	<div class="gallery_album" data-act="get_albun_pic" data-inid="pic_list" data-url='get_ajax_content.php' data-where="sort_name=<?php echo $this->_var['filter']['sort_name']; ?>&album_id=<?php echo $this->_var['filter']['album_id']; ?>">
		<ul class="ga-images-ul">
			<?php $_from = $this->_var['pic_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pic_list');if (count($_from)):
    foreach ($_from AS $this->_var['pic_list']):
?>
			<li><a href="javascript:;" onclick="addpic('<?php echo $this->_var['pic_list']['pic_file']; ?>',this)"><img src="<?php echo $this->_var['pic_list']['pic_file']; ?>"><span class="pixel"><?php echo $this->_var['pic_list']['pic_spec']; ?></span></a></li>
			<?php endforeach; else: ?>
			<li class="notic">暂无图片</li>
			<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<div class="clear"></div>
		<?php echo $this->fetch('library/lib_page.lbi'); ?>
	</div>
	<?php endif; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'template_information'): ?>
<form  action="visualhome.php?act=edit_information" id="information" method="post"  enctype="multipart/form-data"  runat="server" >
<div class="items">
    <div class="item">
        <div class="label"><em class="require-field">*</em>模板名称：</div>
        <div class="value">
            <input type="text" class="text w300" name="name"  value="<?php echo htmlspecialchars($this->_var['template']['name']); ?>"  autocomplete="off" />
            <div class="form_prompt"></div>
        </div>
    </div>
    <div class="item">
        <div class="label">版本：</div>
        <div class="value">
            <input type="text" class="text w300" name="version"  value="<?php echo htmlspecialchars($this->_var['template']['version']); ?>"  autocomplete="off" />
        </div>
    </div>
    <div class="item">
        <div class="label">作者：</div>
        <div class="value">
            <input type="text" class="text w300" name="author"  value="<?php echo htmlspecialchars($this->_var['template']['author']); ?>"  autocomplete="off" />
        </div>
    </div>
    <div class="item">
        <div class="label">作者链接：</div>
        <div class="value">
            <input type="text" class="text w300" name="author_url"  value="<?php echo htmlspecialchars($this->_var['template']['author_uri']); ?>"  autocomplete="off" />
        </div>
    </div>
    <div class="item">
        <div class="label"><em class="require-field">*</em>模板封面：</div>
        <div class="value">
            <div class="type-file-box mb0">
                <input type="button" name="button" id="button" class="type-file-button" value="" />
                <input type="file" class="type-file-file" id="ten_file" name="ten_file" data-state="imgfile" size="30" hidefocus="true" value="" />
                <?php if ($this->_var['template']['screenshot']): ?>
                <span class="show">
                    <a href="<?php echo $this->_var['template']['screenshot']; ?>" ectype="see" target="_blank" class="nyroModal"><i class="iconfont icon-image" ectype="iconImage"></i></a>
                </span>
                <?php endif; ?>
                <input type="text" name="ten_file_textfile" class="type-file-text" id="textfield" autocomplete="off" value="<?php echo $this->_var['template']['screenshot']; ?>" readonly />
            </div>
            <div class="form_prompt"></div>
            <div class="notic lh30">请上传265*388的图片，防止图片变型</div>
        </div>
    </div>
    <div class="item">
        <div class="label"><em class="require-field">*</em>模板大图：</div>
        <div class="value">
            <div class="type-file-box mb0">
                <input type="button" name="button" id="button" class="type-file-button" value="" />
                <input type="file" class="type-file-file" id="big_file" name="big_file" data-state="imgfile" size="30" hidefocus="true" />
                <?php if ($this->_var['template']['template']): ?>
                <span class="show">
                    <a href="<?php echo $this->_var['template']['template']; ?>" target="_blank" ectype="see" class="nyroModal"><i class="iconfont icon-image" ectype="iconImage"></i></a>
                </span>
                <?php endif; ?>
                <input type="text" name="big_file_textfile" class="type-file-text" id="textfield" autocomplete="off" value="<?php echo $this->_var['template']['template']; ?>" readonly />
            </div>
            <div class="form_prompt"></div>
        </div>
    </div>
    <div class="item">
        <div class="label">描述：</div>
        <div class="value">
            <textarea class="textarea" name="description"><?php echo htmlspecialchars($this->_var['template']['desc']); ?></textarea>
        </div>
    </div>
    <?php if ($this->_var['template_type'] == 'seller'): ?>
        <div class="item">
            <div class="label">模板模式：</div>
            <div class="value lh30">
                <div class="checkbox_items">
                    <div class="checkbox_item">
                        <input type="radio" name="temp_mode" value="0" class="ui-radio" ectype='temp_mode' id="temp_mode1" <?php if ($this->_var['template_mall_info']['temp_mode'] == 0): ?>checked<?php endif; ?> >
                        <label class="ui-radio-label" for="temp_mode1">免费</label>
                    </div>
                    <div class="checkbox_item">
                        <input type="radio" name="temp_mode" value="1" class="ui-radio" ectype='temp_mode' id="temp_mode2" <?php if ($this->_var['template_mall_info']['temp_mode'] != 0): ?>checked<?php endif; ?>>
                        <label class="ui-radio-label" for="temp_mode2">付费</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="item hide" ectype='ecs_temp_cost'>
            <div class="label"><em class="require-field">*</em>模板费用：</div>
            <div class="value">
                <input type="text" class="text w300" name="temp_cost"  value="<?php echo htmlspecialchars($this->_var['template_mall_info']['temp_cost']); ?>"  autocomplete="off" />
                <div class="form_prompt"></div>
            </div>
        </div>
    <?php endif; ?>
    <input type="submit" class="hide" value="" ectype="submitBtn" />
    <input type="hidden" name="tem" value="<?php echo $this->_var['code']; ?>" />
    <input type="hidden" name="check" value="<?php echo $this->_var['check']; ?>" />
    <input type="hidden" name="temp_id" value="<?php echo $this->_var['temp_id']; ?>" />
    <input type="hidden" name="template_type" value="<?php echo $this->_var['template_type']; ?>" />
</div>
</form>
<script type="text/javascript">
$(function(){
	$(".nyroModal").nyroModal();
	resetHref();
	
	$("[ectype='iconImage']").mouseover(function(){
		var src = $(this).parents("[ectype='see']").attr("href");
		
		toolTip("<img src='"+src+"'>");
	});
	
	$("[ectype='iconImage']").mouseout(function(){
		toolTip();
	});
         checkmode()
         $("[ectype='temp_mode']").click(function(){
		checkmode()
	});
})
function checkmode(){
    var temp_mode = $("input[name='temp_mode']:checked").val();
    if(temp_mode == 0){
        $("*[ectype='ecs_temp_cost']").hide()
    }else if(temp_mode == 1){
        $("*[ectype='ecs_temp_cost']").show()
    }
}
</script>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'homeTemplates'): ?>
<?php $_from = $this->_var['available_templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'template');$this->_foreach['template'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['template']['total'] > 0):
    foreach ($_from AS $this->_var['template']):
        $this->_foreach['template']['iteration']++;
?>
<li <?php if ($this->_var['default_tem'] == $this->_var['template']['code']): ?>class="curr"<?php endif; ?>>
    <div class="checkbox_item">
        <input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['template']['code']; ?>" class="ui-checkbox" id="checkbox_<?php echo $this->_var['template']['code']; ?>" />
        <label for="checkbox_<?php echo $this->_var['template']['code']; ?>" class="ui-label"></label>
    </div>
    <div class="tit"><?php echo $this->_var['template']['name']; ?>-<a href="<?php if ($this->_var['template']['author_uri']): ?><?php echo $this->_var['template']['author_uri']; ?><?php else: ?>#<?php endif; ?>" target="_blank"/><?php echo $this->_var['template']['author']; ?></a></div>
    <div class="span"><?php echo $this->_var['template']['desc']; ?></div>
    <div class="img" ectype="setupTemplate" data-code="<?php echo $this->_var['template']['code']; ?>">
        <?php if ($this->_var['template']['screenshot']): ?><img width="263" height="338" src="<?php echo $this->_var['template']['screenshot']; ?>" data-src-wide="<?php echo $this->_var['template']['template']; ?>" border="0" id="<?php echo $this->_var['template']['code']; ?>" ectype="pic" class="pic"/><?php endif; ?>
        <div class="bg"></div>
    </div>
    <div class="box" ectype="setupTemplate" data-code="<?php echo $this->_var['template']['code']; ?>">
        <i class="icon icon-gou"></i>
        <span>使用该模版</span>
    </div>
    <div class="info">
        <div class="row">
            <a href="<?php echo $this->_var['template']['template']; ?>" class="mr10" target="_blank" ectype="see">查看大图</a>
            <a href="visualhome.php?act=visual&code=<?php echo $this->_var['template']['code']; ?>" target="_blank">装修</a>
        </div>
        <div class="row">
            <a href="../index.php?suffix=<?php echo $this->_var['template']['code']; ?>" class="mr10" target="_blank" >预览模板</a>
            <a href="javascript:void(0);" ectype='information' data-code="<?php echo $this->_var['template']['code']; ?>" class="mr10">编辑模板信息</a>
            <a href="javascript:removeTemplate('<?php echo $this->_var['template']['code']; ?>')">删除模板</a>
        </div>
    </div>
    <i<?php if ($this->_var['default_tem'] == $this->_var['template']['code']): ?> class="ing"<?php endif; ?> ectype="default"></i>
</li>							
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'h-promo'): ?>
<div class="tit" style="background-color:<?php echo $this->_var['spec_attr']['navColor']; ?>;">
    <h3><?php echo $this->_var['spec_attr']['title']; ?></h3>
    <span><?php echo $this->_var['spec_attr']['subtitle']; ?></span>
    <i class="titIcon"></i>
</div>
<ul>
    <?php if ($this->_var['spec_attr']['goods_list']): ?>
    <?php $_from = $this->_var['spec_attr']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <li class="opacity_img">
        <div class="p-img"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>"></a></div>
        <div class="info">
            <div class="price"><?php echo $this->_var['goods']['promote_price']; ?></div>
            <div class="name"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a></div>
            <div class="time" ectype="time" data-time="<?php echo $this->_var['goods']['formated_end_date']; ?>">
                <span class="label">剩余时间：</span>
                <span class="days">00</span>
                <em>：</em>
                <span class="hours">00</span>
                <em>：</em>
                <span class="minutes">00</span>
                <em>：</em>
                <span class="seconds">00</span>
            </div>
        </div>
    </li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php else: ?>
    <!--<li class="opacity_img">
        <div class="p-img"><img src="../data/gallery_album/visualDefault/zhanwei.png"></div>
        <div class="info">
            <div class="price">￥370.50</div>
            <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
            <div class="time" ectype="time">
                <span class="label">剩余时间：</span>
                <span class="days">00</span>
                <em>：</em>
                <span class="hours">00</span>
                <em>：</em>
                <span class="minutes">00</span>
                <em>：</em>
                <span class="seconds">00</span>
            </div>
        </div>
    </li>
    <li class="opacity_img">
        <div class="p-img"><img src="../data/gallery_album/visualDefault/zhanwei.png"></div>
        <div class="info">
            <div class="price">￥370.50</div>
            <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
            <div class="time" ectype="time">
                <span class="label">剩余时间：</span>
                <span class="days">00</span>
                <em>：</em>
                <span class="hours">00</span>
                <em>：</em>
                <span class="minutes">00</span>
                <em>：</em>
                <span class="seconds">00</span>
            </div>
        </div>
    </li>
    <li class="opacity_img">
        <div class="p-img"><img src="../data/gallery_album/visualDefault/zhanwei.png"></div>
        <div class="info">
            <div class="price">￥370.50</div>
            <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
            <div class="time" ectype="time">
                <span class="label">剩余时间：</span>
                <span class="days">00</span>
                <em>：</em>
                <span class="hours">00</span>
                <em>：</em>
                <span class="minutes">00</span>
                <em>：</em>
                <span class="seconds">00</span>
            </div>
        </div>
    </li>
    <li class="opacity_img">
        <div class="p-img"><img src="../data/gallery_album/visualDefault/zhanwei.png"></div>
        <div class="info">
            <div class="price">￥370.50</div>
            <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
            <div class="time" ectype="time">
                <span class="label">剩余时间：</span>
                <span class="days">00</span>
                <em>：</em>
                <span class="hours">00</span>
                <em>：</em>
                <span class="minutes">00</span>
                <em>：</em>
                <span class="seconds">00</span>
            </div>
        </div>
    </li>
    <li class="opacity_img">
        <div class="p-img"><img src="../data/gallery_album/visualDefault/zhanwei.png"></div>
        <div class="info">
            <div class="price">￥370.50</div>
            <div class="name"><a href="#" target="_blank">夏季短袖连衣裙新款打底裙碎</a></div>
            <div class="time" ectype="time">
                <span class="label">剩余时间：</span>
                <span class="days">00</span>
                <em>：</em>
                <span class="hours">00</span>
                <em>：</em>
                <span class="minutes">00</span>
                <em>：</em>
                <span class="seconds">00</span>
            </div>
        </div>
    </li>-->
    <?php endif; ?>
</ul>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'h-sepmodule'): ?>
<div class="sepmod-left" style="background-color:<?php echo $this->_var['spec_attr']['navColor']; ?>;">
    <div class="tit">
        <h3><?php if ($this->_var['spec_attr']['title']): ?><?php echo $this->_var['spec_attr']['title']; ?><?php else: ?>主标题<?php endif; ?></h3>
        <div class="subtit"><em style="background-color:<?php echo $this->_var['spec_attr']['navColor']; ?>;"><?php if ($this->_var['spec_attr']['subtitle']): ?><?php echo $this->_var['spec_attr']['subtitle']; ?><?php else: ?>次标题<?php endif; ?><i></i></em><span></span></div>
        <i class="tit_icon"></i>
    </div>
    <div class="opacity_img sepmod-goods">
        <div class="p-img"><a href="<?php echo $this->_var['recommend']['url']; ?>" target="_blank"><img src="<?php if ($this->_var['recommend']['goods_thumb']): ?><?php echo $this->_var['recommend']['goods_thumb']; ?><?php else: ?>../data/gallery_album/visualDefault/zhanwei.png<?php endif; ?>"></a></div>
        <div class="name"><a href="<?php echo $this->_var['recommend']['url']; ?>" target="_blank"><?php if ($this->_var['recommend']['goods_name']): ?><?php echo $this->_var['recommend']['goods_name']; ?><?php else: ?>请选择商品<?php endif; ?></a></div>
        <div class="price"><?php if ($this->_var['recommend']): ?><?php if ($this->_var['spec_attr']['PromotionType'] == 'exchange'): ?><?php echo $this->_var['recommend']['exchange_integral']; ?><?php else: ?><?php if ($this->_var['recommend']['promote_price'] != ''): ?><?php echo $this->_var['recommend']['promote_price']; ?><?php else: ?><?php echo $this->_var['recommend']['shop_price']; ?><?php endif; ?><?php endif; ?><?php else: ?>￥0.00<?php endif; ?></div>
    </div>
    <i class="titIcon"></i>
</div>
<div class="sepmod-right">
    <ul>
    <?php if ($this->_var['spec_attr']['goods_list']): ?>
        <?php $_from = $this->_var['spec_attr']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
        <li class="opacity_img sepmod-goods">
            <div class="p-img"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><img src="<?php if ($this->_var['goods']['goods_thumb']): ?><?php echo $this->_var['goods']['goods_thumb']; ?><?php else: ?>../data/gallery_album/visualDefault/zhanwei.png<?php endif; ?>"></a></div>
            <div class="name"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank"><?php if ($this->_var['goods']['goods_name']): ?><?php echo $this->_var['goods']['goods_name']; ?><?php else: ?>请选择商品<?php endif; ?></a></div>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php else: ?>
        <!--<li class="opacity_img sepmod-goods">
            <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
            <div class="name"><a href="#" target="_blank">请选择商品</a></div>
        </li>
        <li class="opacity_img sepmod-goods">
            <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
            <div class="name"><a href="#" target="_blank">请选择商品</a></div>
        </li>
        <li class="opacity_img sepmod-goods">
            <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
            <div class="name"><a href="#" target="_blank">请选择商品</a></div>
        </li>
        <li class="opacity_img sepmod-goods">
            <div class="p-img"><a href="#" target="_blank"><img src="../data/gallery_album/visualDefault/zhanwei.png"></a></div>
            <div class="name"><a href="#" target="_blank">请选择商品</a></div>
        </li>-->
    <?php endif; ?>
    </ul>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'getmap_html'): ?>
<div>
    <div id="mapcontainer" class="mapcontainer"></div>
    <div id="myPageTop" class="ml10 fl">
        <dl class="button_info">
            <dt>按关键字搜索：</dt>
            <dd>
                <input type="text" class="text text_2" placeholder="请输入关键字进行搜索" id="tipinput"><input type="button" value=" 搜索 " class="sc-btn btn30 sc-blueBg-btn ml10 auto-item" id="mapsubmit" >
            </dd>
        </dl>
        <br />
        <dl class="button_info">
            <dt>经纬度：</dt>
            <dd>
                <input type="text" class="text text_2" readonly id="lnglat" name="lnglat">
            </dd>
        </dl>
    </div>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'set_free_shipping'): ?>
<div class="switch_info business_info free_shipping_info">
    <?php $_from = $this->_var['region_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
    <div class="step">
        <div class="tit">
            <div class="checkbox_items">
                <div class="checkbox_item w120">
                    <input type="checkbox" name="ra_id" value="checkbox" class="ui-checkbox" id="ra_id_<?php echo $this->_var['list']['ra_id']; ?>" />
                    <label for="ra_id_<?php echo $this->_var['list']['ra_id']; ?>" class="ui-label blod"><?php echo $this->_var['list']['ra_name']; ?></label>
                </div>
            </div>
        </div>
        <div class="qx_items">
            <div class="qx_item">
                <div class="checkbox_items">
                    <?php $_from = $this->_var['list']['area_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
                    <div class="checkbox_item">
                        <input type="checkbox" value="<?php echo $this->_var['region']['region_id']; ?>" name="region_id[]" class="ui-checkbox" id="region_id<?php echo $this->_var['region']['region_id']; ?>" <?php if ($this->_var['region']['is_checked'] == 1): ?>checked="true"<?php endif; ?> title="<?php echo $this->_var['region']['region_name']; ?>"/>
                        <label for="region_id<?php echo $this->_var['region']['region_id']; ?>" class="ui-label"><?php echo $this->_var['region']['region_name']; ?></label>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <div class="steplast">
        <div class="checkbox_items">
            <div class="checkbox_item">
                <input type="checkbox" name="checkall" value="checkbox" class="ui-checkbox" id="checkall" />
                <label for="checkall" class="ui-label"><?php echo $this->_var['lang']['check_all']; ?></label>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
$("#checkall").click(function(){
	var checkbox = $(this).parents(".switch_info").find('input:checkbox[type="checkbox"]');
	if($(this).prop("checked") == true){
		checkbox.prop("checked",true);
	}else{
		checkbox.prop("checked",false);
	}
});

$("input[name='ra_id']").click(function(){
	var checkbox = $(this).parents(".tit").next(".qx_items").find('input:checkbox[type="checkbox"]');
	if($(this).prop("checked") == true){
			checkbox.prop("checked",true);
	}else{
			checkbox.prop("checked",false);
	}
});

$("input[name='region_id[]']").click(function(){    
	var qx_items = $(this).parents(".qx_items");
	var length = qx_items.find("input[name='region_id[]']").length;
	var length2 =  qx_items.find("input[name='region_id[]']:checked").length;
	if(length == length2){
		qx_items.prev().find("input[name='ra_id']").prop("checked",true);
	}else{
		qx_items.prev().find("input[name='ra_id']").prop("checked",false);
	}
});

$(".qx_items").each(function(index, element) {
	var length = $(this).find("input[name='region_id[]']").length;
	var length2 = $(this).find("input[name='region_id[]']:checked").length;
	
	if(length == length2){
		$(this).prev().find("input[name='ra_id']").prop("checked",true);
	}else{
		$(this).prev().find("input[name='ra_id']").prop("checked",false);
	}
});
</script>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'CMS_ADV'): ?>
<div class="banner-article<?php if ($this->_var['spec_attr']['floorMode'] == 1): ?> banner-article-one<?php elseif ($this->_var['spec_attr']['floorMode'] == 3): ?> banner-article-three<?php endif; ?>">
    <div class="banner-main">
        <div class="bd">
            <ul>
            <?php $_from = $this->_var['spec_attr']['leftBanner']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'leftBanner');if (count($_from)):
    foreach ($_from AS $this->_var['leftBanner']):
?>
            <li><a href="<?php echo $this->_var['leftBanner']['leftBannerLink']; ?>" target="_blank"><img src="<?php if ($this->_var['leftBanner']['leftBanner']): ?><?php echo $this->_var['leftBanner']['leftBanner']; ?><?php else: ?><?php if ($this->_var['spec_attr']['floorMode'] == 1): ?>../data/gallery_album/visualDefault/visual1200x310.jpg<?php else: ?>../data/gallery_album/visualDefault/visual800x310.jpg<?php endif; ?><?php endif; ?>" alt=""><?php if ($this->_var['leftBanner']['leftBannerTitle']): ?><p><?php echo $this->_var['leftBanner']['leftBannerTitle']; ?></p><?php endif; ?></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <div class="hd"><ul></ul></div>
    </div>
    <?php if ($this->_var['spec_attr']['floorMode'] == 2 || $this->_var['spec_attr']['floorMode'] == 3): ?>
    <div class="banner-second">
        <?php $_from = $this->_var['spec_attr']['leftAdv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'leftAdv');$this->_foreach['adv'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['adv']['total'] > 0):
    foreach ($_from AS $this->_var['leftAdv']):
        $this->_foreach['adv']['iteration']++;
?>
        <div class="s<?php if (($this->_foreach['adv']['iteration'] == $this->_foreach['adv']['total'])): ?> last<?php endif; ?>"><a href="<?php echo $this->_var['leftAdv']['leftAdvLink']; ?>" target="_blank"><img src="<?php if ($this->_var['leftAdv']['leftAdv']): ?><?php echo $this->_var['leftAdv']['leftAdv']; ?><?php else: ?><?php if ($this->_var['spec_attr']['floorMode'] == 2): ?>../data/gallery_album/visualDefault/visual390x150.jpg<?php else: ?>../data/gallery_album/visualDefault/visual390x310.jpg<?php endif; ?><?php endif; ?>" alt=""><?php if ($this->_var['leftAdv']['leftAdvTitle']): ?><p><?php echo $this->_var['leftAdv']['leftAdvTitle']; ?></p><?php endif; ?></a></div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<!--获取下级文章分类-->
<?php if ($this->_var['temp'] == 'get_childcat'): ?>
<?php if ($this->_var['cat_select']): ?>
<div class="imitate_select select_w220" id="cat_id" data-level='<?php echo $this->_var['level']; ?>'>
    <div class="cite">请选择文章分类...</div>		
    <ul style="display: none;" class="ps-container" ectype="articlecat">
        <li><a href="javascript:;" data-value="0" class="ftx-01">请选择文章分类...</a></li>
        <?php $_from = $this->_var['cat_select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_list');if (count($_from)):
    foreach ($_from AS $this->_var['cat_list']):
?>
        <li><a href="javascript:;" data-value="<?php echo $this->_var['cat_list']['cat_id']; ?>" class="ftx-01"><?php echo $this->_var['cat_list']['cat_name']; ?></a></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <input name="" type="hidden" value="" id="cat_id_val">
</div>
<?php endif; ?>
<?php endif; ?>

<?php if ($this->_var['temp'] == 'getcat_atr'): ?>
<?php if (! $this->_var['full_page']): ?>
<div class="cms_dialog_main">
    <div class="tishi">
        <div class="tishi_info">
            <p class="first">注意：1、弹出框鼠标移到头部可以拖动，以防笔记本小屏幕内容展示不全；</p>
            <i class="icon"></i>
        </div>
    </div>
    <div class="checkobx-item">
        <input type="checkbox" name="arti_selected" id="arti_selected" class="ui-checkbox" onclick="checkd_article(this)"/>
        <label class="ui-label" for="arti_selected">已选择文章</label>
    </div>
    <div class="modal-body">
        <div class="body_info" id="banner_info">
            <div class="table_list" ectype='atr_list'>
                <?php endif; ?>
                <div class="gallery_album" data-act="getcat_atr" data-inid="atr_list" data-url='get_ajax_content.php' data-where="cat_id=<?php echo $this->_var['cat_id']; ?>&old_article=<?php echo $this->_var['filter']['old_article']; ?>&def_article=<?php echo $this->_var['def_article']; ?>">
                    <div class="ps_table mt10">
                        <table id="addpictable" class="table">
                            <thead>
                                <tr>
                                    <th width="20%">文章ID</th>
                                    <th width="35%">文章名称</th>
                                    <th width="15%" class="tc">主推</th>
                                    <th width="25%" class="tc">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $_from = $this->_var['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                <tr>
                                    <td><?php echo $this->_var['list']['article_id']; ?></td>
                                    <td><?php echo $this->_var['list']['title']; ?></td>
                                    <td class="tc"><img src="<?php if ($this->_var['def_article'] == $this->_var['list']['article_id']): ?>images/yes.gif<?php else: ?>images/no.gif<?php endif; ?>" ectype="def_article" data-id="<?php echo $this->_var['list']['article_id']; ?>" <?php if ($this->_var['list']['selected'] != 1): ?>class="hide"<?php endif; ?>></td>
                                    <td class="tc"><div class="choose"><a href="javascript:;" onclick="addatr('<?php echo $this->_var['list']['article_id']; ?>',this)" <?php if ($this->_var['list']['selected'] == 1): ?> class="on"<?php endif; ?>><em><?php if ($this->_var['list']['selected'] == 1): ?><i class="iconfont icon-gou"></i>已选择<?php else: ?><i class="iconfont icon-dsc-plus"></i>选择<?php endif; ?></em></a></div></td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr class="notic"><td colspan="4">此分类下面无文章</td></tr>
                                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clear"></div>
                    <?php echo $this->fetch('library/lib_page.lbi'); ?>
                </div>
                <?php if (! $this->_var['full_page']): ?>
            </div>
        </div>
    </div>
</div>      
<input type='hidden' name='def_article' value='<?php echo $this->_var['def_article']; ?>'>
<input type='hidden' name='select_article_ids' value='<?php echo $this->_var['filter']['old_article']; ?>'>
<script type="text/javascript">
	$(".ps_table").perfectScrollbar("destroy");
	$(".ps_table").perfectScrollbar();
</script>
<?php endif; ?>
<?php endif; ?>

<?php if ($this->_var['temp'] == 'CMS_TWO_LIE'): ?>
<div class="article-col-2 clearfix">
    <?php $_from = $this->_var['spec_attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
    <div class="article-box">
        <div class="ab-hd"><h2><i class="iconfont icon-icon02"></i><?php echo $this->_var['list']['cat_name']; ?></h2><a href="../article_cat.php?id=<?php echo $this->_var['list']['cat_id']; ?>" class="more" target="_blank">more&gt;</a></div>
        <div class="ab-bd">
            <?php if ($this->_var['list']['first_article_list']): ?>
            <div class="focus">
                <div class="img"><a href="<?php echo $this->_var['list']['first_article_list']['url']; ?>" title="<?php echo $this->_var['list']['first_article_list']['title']; ?>"><img src="<?php echo $this->_var['list']['first_article_list']['file_url']; ?>" /></a></div>
                <div class="info">
                    <div class="info-name"><a href="<?php echo $this->_var['list']['first_article_list']['url']; ?>" title="<?php echo $this->_var['list']['first_article_list']['title']; ?>"><?php echo $this->_var['list']['first_article_list']['title']; ?></a></div>
                    <div class="info-intro"><?php echo $this->_var['list']['first_article_list']['description']; ?></div>
                    <div class="info-time"><?php echo $this->_var['list']['first_article_list']['add_time']; ?></div>
                </div>
            </div>
            <?php endif; ?>
            <ul class="list">
                <?php $_from = $this->_var['list']['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articles');$this->_foreach['article'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article']['total'] > 0):
    foreach ($_from AS $this->_var['articles']):
        $this->_foreach['article']['iteration']++;
?>
                <?php if (($this->_foreach['article']['iteration'] - 1) > 0 && ($this->_foreach['article']['iteration'] - 1) < 5): ?>
                <li><a href="<?php echo $this->_var['articles']['url']; ?>" target="_blank"><?php echo $this->_var['articles']['title']; ?></a><span class="time"><?php echo $this->_var['articles']['add_time']; ?></span></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                 
            </ul>
        </div>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'CMS_THREE_LIE'): ?>
<div class="article-col-3 clearfix">
    <?php $_from = $this->_var['spec_attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
    <div class="article-box">
        <div class="ab-hd"><h2><i class="iconfont icon-article"></i><?php echo $this->_var['list']['cat_name']; ?></h2><a href="../article_cat.php?id=<?php echo $this->_var['list']['cat_id']; ?>" class="more" target="_blank">more&gt;</a></div>
        <div class="ab-bd">
            <ul class="list">
                <?php if ($this->_var['list']['first_article_list']): ?>
                <li><a href="<?php echo $this->_var['list']['first_article_list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['first_article_list']['title']; ?></a><span class="time"><?php echo $this->_var['list']['first_article_list']['add_time']; ?></span></li>
                <?php endif; ?>
                <?php $_from = $this->_var['list']['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articles');$this->_foreach['article'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['article']['total'] > 0):
    foreach ($_from AS $this->_var['articles']):
        $this->_foreach['article']['iteration']++;
?>
                <li><a href="<?php echo $this->_var['articles']['url']; ?>" target="_blank"><?php echo $this->_var['articles']['title']; ?></a><span class="time"><?php echo $this->_var['articles']['add_time']; ?></span></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>    
        </div>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>   
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'CMS_FAST_LIE'): ?>
<div class="article-col-4 clearfix">
<?php $_from = $this->_var['spec_attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
<div class="article-box">
    <div class="ab-hd"><h2><i class="iconfont icon-article"></i><?php echo $this->_var['list']['cat_name']; ?></h2><a href="../article_cat.php?id=<?php echo $this->_var['list']['cat_id']; ?>" class="more" target="_blank">more&gt;</a></div>
    <div class="ab-bd">
        <ul class="quick clearfix">
            <?php if ($this->_var['list']['first_article_list']): ?>
            <li>
                <div class="q-img"><a href="<?php echo $this->_var['list']['first_article_list']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['list']['first_article_list']['file_url']; ?>" alt=""></a></div>
                <div class="q-name"><a href="<?php echo $this->_var['list']['first_article_list']['url']; ?>" target="_blank"><?php echo $this->_var['list']['first_article_list']['title']; ?></a></div>
                <div class="q-info"><?php echo $this->_var['list']['first_article_list']['description']; ?></div>
            </li>
            <?php endif; ?>
            <?php $_from = $this->_var['list']['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articles');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['articles']):
        $this->_foreach['no']['iteration']++;
?>
            <!-- <?php if ($this->_foreach['no']['iteration'] < 5): ?>-->
            <li>
                <div class="q-img"><a href="<?php echo $this->_var['articles']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['articles']['file_url']; ?>" alt=""></a></div>
                <div class="q-name"><a href="<?php echo $this->_var['articles']['url']; ?>" target="_blank"><?php echo $this->_var['articles']['title']; ?></a></div>
                <div class="q-info"><?php echo $this->_var['articles']['description']; ?></div>
            </li>
            <!-- <?php endif; ?> -->
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php endif; ?>
<?php if ($this->_var['temp'] == 'CMS_HEAT_LIE'): ?>
<div class="article-col-1-2 clearfix">
    <div class="article-box">
        <div class="ab-hd"><h2><i class="iconfont icon-article"></i><?php if ($this->_var['spec_attr']['article_title']): ?><?php echo $this->_var['spec_attr']['article_title']; ?><?php else: ?>近期热门<?php endif; ?></h2></div>
        <div class="ab-bd">
            <ul class="list">
                <?php if ($this->_var['def_article_list']): ?>
                <li><a href="<?php echo $this->_var['def_article_list']['url']; ?>"><?php echo $this->_var['def_article_list']['title']; ?></a><span class="time"><?php echo $this->_var['def_article_list']['add_time']; ?></span></li>
                <?php endif; ?>
                <?php $_from = $this->_var['article_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articles');if (count($_from)):
    foreach ($_from AS $this->_var['articles']):
?>
                <li><a href="<?php echo $this->_var['articles']['url']; ?>" target="_blank"><?php echo $this->_var['articles']['title']; ?></a><span class="time"><?php echo $this->_var['articles']['add_time']; ?></span></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
    <div class="article-box">
        <div class="ab-hd"><h2><i class="iconfont icon-article"></i><?php if ($this->_var['spec_attr']['goods_title']): ?><?php echo $this->_var['spec_attr']['goods_title']; ?><?php else: ?>精品推荐<?php endif; ?></h2><a href="../category.php?id=<?php echo $this->_var['spec_attr']['cat_id']; ?>" class="more">more&gt;</a></div>
        <div class="ab-bd">
            <ul class="g-list clearfix">
                <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                <li>
                    <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank">
                        <img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" alt="">
                        <p><?php echo $this->_var['goods']['goods_name']; ?></p>
                    </a>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
