<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);
require(ROOT_PATH . 'includes/lib_order.php');
include_once(ROOT_PATH .'includes/lib_payment.php');
include_once(ROOT_PATH . 'includes/lib_clips.php');
/*初始化数据交换对象 */
$exc   = new exchange($ecs->table("seller_grade"), $db, 'id', 'grade_name');
$adminru = get_admin_ru_id();
$smarty->assign('menu_select',array('action' => '19_merchants_store', 'current' => '09_merchants_upgrade'));
get_invalid_apply();//过期申请失效处理  
$smarty->assign('primary_cat',     $_LANG['19_merchants_store']);

if($_REQUEST['act'] == 'list'){
    admin_priv('seller_store_other');
    $smarty->assign('ur_here',      $_LANG['09_merchants_upgrade']);
    if($adminru['ru_id'] > 0){
        $smarty->assign('action_link',  array('text' => $_LANG['seller_upgrade_list'], 'href' => 'seller_apply.php?act=list&ru_id='.$adminru['ru_id'], 'class' => 'icon-book'));
    }
    /*获取商家当前等级*/
    $seller_grader = get_seller_grade($adminru['ru_id']);
    $smarty->assign("grade_id",$seller_grader['grade_id']);
    
    $seller_garde = get_pzd_list();
    $smarty->assign('garde_list', $seller_garde['pzd_list']);
    $smarty->assign('filter', $seller_garde['filter']);
    $smarty->assign('record_count', $seller_garde['record_count']);
    $smarty->assign('page_count', $seller_garde['page_count']);
    $smarty->assign('full_page', 1);
    $smarty->display("merchants_upgrade.dwt");
}elseif($_REQUEST['act'] == 'query'){
    admin_priv('seller_store_other');
    /*获取商家当前等级*/
    $seller_grader = get_seller_grade($adminru['ru_id']);
    $smarty->assign("grade_id",$seller_grader['grade_id']);
    
    $seller_garde = get_pzd_list();
    $smarty->assign('garde_list', $seller_garde['pzd_list']);
    $smarty->assign('filter', $seller_garde['filter']);
    $smarty->assign('record_count', $seller_garde['record_count']);
    $smarty->assign('page_count', $seller_garde['page_count']);
//跳转页面  
    make_json_result($smarty->fetch('merchants_upgrade.dwt'), '', array('filter' => $seller_garde['filter'], 'page_count' => $seller_garde['page_count']));
}
elseif($_REQUEST['act'] == 'application_grade' || $_REQUEST['act'] == 'edit'){
    admin_priv('seller_store_other');
    $smarty->assign('ur_here',      $_LANG['application_grade']);
    $smarty->assign('action_link',  array('text' =>$_LANG['09_merchants_upgrade'], 'href' => 'merchants_upgrade.php?act=list'));
    $grade_id = !empty($_REQUEST['grade_id'])    ?   intval($_REQUEST['grade_id']):0;
    $smarty->assign('grade_id',$grade_id);
    $smarty->assign('act',$_REQUEST['act']);
    
    if($_REQUEST['act'] == 'edit'){
        $apply_id = !empty($_REQUEST['apply_id'])     ? intval($_REQUEST['apply_id']) : 0;
        
         /*获取申请信息*/
        $seller_apply_info=$db->getRow("SELECT * FROM".$ecs->table('seller_apply_info')." WHERE apply_id = '$apply_id' LIMIT 1");
        $apply_criteria = unserialize($seller_apply_info['entry_criteria']);
        if($seller_apply_info['pay_id'] > 0 && $seller_apply_info['is_paid'] == 0 && $seller_apply_info['pay_status'] == 0) {
            include_once(ROOT_PATH .'includes/lib_payment.php');
            include_once(ROOT_PATH . 'includes/lib_clips.php');
            
            /*在线支付按钮*/
            
           //支付方式信息
           $payment_info = array();
           $payment_info = payment_info($seller_apply_info['pay_id']);

           //无效支付方式
           if ($payment_info === false)
           {
               $seller_apply_info['pay_online'] = '';
           }
           else
           {
               //pc端如果使用的是app的支付方式，也不生成支付按钮
               if (substr($payment_info['pay_code'], 0 , 4) == 'pay_') {
                   $seller_apply_info['pay_online'] = '';                              
               } else {
                       //取得支付信息，生成支付代码
                       $payment = unserialize_config($payment_info['pay_config']);
                       
                       //获取需要支付的log_id

                       $apply['log_id']    = get_paylog_id($seller_apply_info['allpy_id'], $pay_type = PAY_APPLYGRADE);
                       $amount = $seller_apply_info['total_amount'];
                       $apply['order_sn']       =$seller_apply_info['apply_sn'];
                       $apply['user_id']      = $seller_apply_info['ru_id'];
                       $apply['surplus_amount'] = $amount;
                                   //计算支付手续费用
                       $payment_info['pay_fee'] = pay_fee($pay_id, $apply['surplus_amount'], 0);
                       //计算此次预付款需要支付的总金额
                      $apply['order_amount']   = $amount + $payment_info['pay_fee'];
                       /* 调用相应的支付方式文件 */
                       include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');

                       /* 取得在线支付方式的支付按钮 */
                       $pay_obj    = new $payment_info['pay_code'];
                       $seller_apply_info['pay_online'] = $pay_obj->get_code($apply, $payment);
               }
           }
        }
        $smarty->assign('apply_criteria',$apply_criteria);
        $smarty->assign('seller_apply_info',$seller_apply_info);
    }else{
        /*判断是否存在未支付未失效申请*/
        $sql="SELECT apply_id FROM ".$ecs->table('seller_apply_info')." WHERE ru_id = '".$adminru['ru_id']."' AND apply_status = 0 AND is_paid = 0 LIMIT 1";
        if($db->getRow($sql)){
            sys_msg($_LANG['invalid_apply']);
        }
    }
    
    $seller_grade = get_seller_grade($adminru['ru_id']);    //获取商家等级
    if($seller_grade){
        $seller_grade['end_time'] =date('Y',$seller_grade['add_time']) + $seller_grade['year_num'] . '-' . date('m-d H:i:s',$seller_grade['add_time']);
        $seller_grade['addtime'] = date('Y-m-d H:i:s',$seller_grade['add_time']);
        
        /*如果是付费等级，根据剩余时间计算剩余价钱*/
        if($seller_grade['amount'] > 0){
            $rest = (gmtime() - $seller_grade['add_time'])/(strtotime($seller_grade['end_time'])-$seller_grade['add_time']);//换算剩余时间比例
            $seller_grade['refund_price'] = round($seller_grade['amount'] - $seller_grade['amount']*$rest ,2);//按比例计算剩余金额
        }
        $smarty->assign('seller_grade',$seller_grade);
    }
	$grade_info = $db->getRow("SELECT entry_criteria,grade_name FROM ".$ecs->table('seller_grade')." WHERE id = '$grade_id'");
    $entry_criteriat_info = get_entry_criteria($grade_info['entry_criteria']);//获取等级入驻标准
    $smarty->assign('entry_criteriat_info',$entry_criteriat_info);
    $smarty->assign("grade_name",$grade_info['grade_name']);
   
    $pay=available_payment_list(0);//获取支付方式
    $smarty->assign("pay",$pay);
	$smarty->assign("action",$_REQUEST['act']);
        
        //防止重复提交
    unset($_SESSION['grade_reload'][$_SESSION['user_id']]);
     set_prevent_token("grade_cookie");
        
    $smarty->display("merchants_application_grade.dwt");
    
}elseif($_REQUEST['act'] == 'insert_submit' || $_REQUEST['act'] == 'update_submit'){
    admin_priv('seller_store_other');
    
    //防止重复提交
    if(get_prevent_token("grade_cookie") == 1){
        header("Location:merchants_upgrade.php?act=grade_load\n");
        exit;
    }
    
    $grade_id = !empty($_REQUEST['grade_id'])    ?   intval($_REQUEST['grade_id']):0;
    $pay_id = !empty($_REQUEST['pay_id'])        ?   intval($_REQUEST['pay_id']):0;
    $entry_criteria=!empty($_REQUEST['value'])   ?   $_REQUEST['value'] : array();
    $file_id=!empty($_REQUEST['file_id'])        ?   $_REQUEST['file_id']  :  array();
    $fee_num=!empty($_REQUEST['fee_num'])        ?   intval($_REQUEST['fee_num']) : 1;
    $all_count_charge=!empty($_REQUEST['all_count_charge'])  ?  round($_REQUEST['all_count_charge'],2) : 0.00;
    $refund_price = !empty($_REQUEST['refund_price'])  ? $_REQUEST['refund_price']:0.00;
    $file_url=!empty($_REQUEST['file_url'])   ?  $_REQUEST['file_url'] : array();
   
    $apply_info = array();
    $back_price = 0.00;
    $payable_amount = 0.00;
    //计算此次预付款需要支付的总金额
  
    if($refund_price > 0){
        if($_CFG['apply_options'] == 1 ){
            if($refund_price > $all_count_charge){
                $payable_amount = 0.00;
                $back_price = $refund_price - $all_count_charge;
            }else{
                $payable_amount = $all_count_charge - $refund_price;
            }
        }elseif($_CFG['apply_options'] == 2){
            if($refund_price > $all_count_charge){
                $payable_amount = 0.00;
                $back_price = 0.00;
            }else{
                $payable_amount = $all_count_charge - $refund_price;
            }
        }
    }else{
        $payable_amount = $all_count_charge;
    }
    
    
    /*获取支付信息*/
    $payment_info = array();
    $payment_info = payment_info($pay_id);
    //计算支付手续费用
    $payment_info['pay_fee'] = pay_fee($pay_id, $payable_amount, 0);
    $apply_info['order_amount'] = $payable_amount + $payment_info['pay_fee'];
    
    /*图片上传处理*/
    $php_maxsize = ini_get('upload_max_filesize');
    $htm_maxsize = '2M';
    $img_url =array();
    /*验证图片*/
    if($_FILES['value']){
        foreach ($_FILES['value']['error'] AS $key => $value) {
            if ($value == 0) {
                if (!$image->check_img_type($_FILES['value']['type'][$key])) {
                    sys_msg(sprintf($_LANG['invalid_img_val'], $key + 1),1);
                } else {
                    $goods_pre = 1;
                }
            } elseif ($value == 1) {
                sys_msg(sprintf($_LANG['img_url_too_big'], $key + 1, $php_maxsize),1);
            } elseif ($_FILES['img_url']['error'] == 2) {
                sys_msg(sprintf($_LANG['img_url_too_big'], $key + 1, $htm_maxsize),1);
            }
        }
        if($goods_pre == 1){
            $res = upload_apply_file($_FILES['value'],$file_id,$file_url);
            if($res != false){
                $img_url = $res;
            }
        }else{
            $img_url = $file_url;
        }
    }
    if($img_url){
        $valus=serialize($entry_criteria + $img_url);
    }else{
        $valus=serialize($entry_criteria);
    }
    
    if($_REQUEST['act']  == 'insert_submit'){
        $apply_sn = get_order_sn(); //获取新订单号
        $time=gmtime();
 
        $key = "(`ru_id`,`grade_id`,`apply_sn`,`total_amount`,`pay_fee`,`fee_num`,`entry_criteria`,`add_time`,`pay_id`,`refund_price`,`back_price`,`payable_amount`)";
        $value = "('".$adminru['ru_id']."','".$grade_id."','".$apply_sn."','".$all_count_charge."','".$payment_info['pay_fee']."','".$fee_num."','".$valus."','".$time."','".$pay_id."','".$refund_price."','$back_price','$payable_amount')";
        $sql='INSERT INTO'.$ecs->table("seller_apply_info").$key." VALUES".$value;
        $db->query($sql);
        $apply_id=$db->insert_id();
        $apply_info['log_id'] = insert_pay_log( $apply_id, $apply_info['order_amount'], $type=PAY_APPLYGRADE, 0);
    }else{
        $apply_sn = !empty($_REQUEST['apply_sn'])   ? $_REQUEST['apply_sn'] : 0;
        $apply_id = !empty($_REQUEST['apply_id'])   ? intval($_REQUEST['apply_id']) : 0;
        
         //判断订单是否已支付
        if($action == 'update_submit') {
            $sql = "SELECT pay_status FROM".$ecs->table("seller_apply_info")."WHERE apply_id = '$apply_id' limit 1";
            if($db->getOne($sql) == 1){
                show_message("该申请已完成支付，不能进行此操作！");
            }
        }
        
        $sql="UPDATE".$ecs->table('seller_apply_info')." SET payable_amount = '$payable_amount', back_price = '$back_price', total_amount = '$all_count_charge',pay_fee='$payment_info[pay_fee]',fee_num = '$fee_num',entry_criteria='$valus',pay_id='$pay_id' WHERE apply_id = '$apply_id' AND apply_sn = '$apply_sn'";
        $db->query($sql);
        
        $apply_info['log_id']    = get_paylog_id($apply_id, $pay_type = PAY_APPLYGRADE);
    }
    /*支付按钮*/
    if($pay_id > 0 && $payable_amount > 0 ){
        $smarty->assign('ur_here',      $_LANG['grade_done']);
        $smarty->assign('action_link',  array('text' =>$_LANG['application_grade'], 'href' => 'merchants_upgrade.php?act=list'));
        $smarty->assign('pay_fee', price_format($payment_info['pay_fee'], false));
        $smarty->assign('amount',  price_format($payable_amount, false));
        $payment = unserialize_config($payment_info['pay_config']);
        $apply_info['order_sn']       =$apply_sn;
        $apply_info['user_id']      = $adminru['ru_id'];
        $apply_info['surplus_amount'] = $payable_amount;
        if($payment_info['pay_code'] == 'balance'){
            //查询出当前用户的剩余余额;
            $user_money=$db->getOne("SELECT user_money FROM ".$ecs->table('users')." WHERE user_id='".$adminru['ru_id']."'");
            //如果用户余额足够支付订单;
            if($user_money > $payable_amount){
                /*修改申请的支付状态 */
                $sql=" UPDATE ".$ecs->table('seller_apply_info')." SET is_paid = 1 ,pay_time = '".gmtime()."' ,pay_status = 1 WHERE apply_id= '".$apply_id."'";
                $db->query($sql);

                //记录支付log
                $sql="UPDATE ".$ecs->table('pay_log')."SET is_paid = 1 WHERE order_id = '".$apply_id."' AND order_type = '".PAY_APPLYGRADE."'";
                $db->query($sql);
                log_account_change($adminru['ru_id'], $payable_amount * (-1), 0, 0,0, "编号".$apply_sn."商家等级申请付款");
            }else{
                sys_msg('您的余额已不足,请选择其他付款方式!');
            }
        }else{
             /* 调用相应的支付方式文件 */
            include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');
             /* 取得在线支付方式的支付按钮 */
            $pay_obj = new $payment_info['pay_code'];
            $payment_info['pay_button'] = $pay_obj->get_code($apply_info, $payment);
        }
        $smarty->assign('payment', $payment_info);
        $smarty->assign('order',   $apply_info);
        
        $grade_reload['apply_id'] = $apply_id;
        $_SESSION['grade_reload'][$adminru['ru_id']] = $grade_reload;
        set_prevent_token("grade_cookie");
        
        $smarty->display('seller_done.dwt');
        
    }else{
	$links[] = array('text' => '返回申请列表', 'href' => 'merchants_upgrade.php?act=list');
            
        sys_msg($_LANG['success'],'',$links); 
    }
}
//会员等级刷新重复提交
elseif($_REQUEST['act'] == 'grade_load') {
    $smarty->assign('ur_here',      $_LANG['grade_done']);
        $smarty->assign('action_link',  array('text' =>$_LANG['application_grade'], 'href' => 'merchants_upgrade.php?act=list'));
    $apply_id = $_SESSION['grade_reload'][$adminru['ru_id']]['apply_id'];
    if ($apply_id > 0) {
        $sql = "SELECT apply_sn,pay_fee,pay_id,payable_amount FROM " . $ecs->table('seller_apply_info') 
                . " WHERE ru_id = '".$adminru['ru_id']."' AND apply_id = '$apply_id'";
        $seller_apply_info = $db->getRow($sql);
        if (!empty($seller_apply_info)) {
            if ($seller_apply_info['pay_id'] > 0 && $seller_apply_info['payable_amount'] > 0) {
                /* 获取支付信息 */
                $payment_info = array();
                $payment_info = payment_info($seller_apply_info['pay_id']);
                //计算支付手续费用
                $payment_info['pay_fee'] = $seller_apply_info['pay_fee'];
                $apply_info['order_amount'] = $seller_apply_info['payable_amount'] + $payment_info['pay_fee'];
                $apply_info['log_id'] = get_paylog_id($apply_id, $pay_type = PAY_APPLYGRADE);
                $payment = unserialize_config($payment_info['pay_config']);
                $apply_info['order_sn'] = $seller_apply_info['apply_sn'];
                $apply_info['user_id'] = $adminru['ru_id'];
                $apply_info['surplus_amount'] = $seller_apply_info['payable_amount'];
                if ($payment_info['pay_code'] == 'balance') {
                    //查询出当前用户的剩余余额;
                    $user_money = $db->getOne("SELECT user_money FROM " . $ecs->table('users') . " WHERE user_id='" . $adminru['ru_id'] . "'");
                    //如果用户余额足够支付订单;
                    if ($user_money > $seller_apply_info['payable_amount']) {
                        /* 修改申请的支付状态 */
                        $sql = " UPDATE " . $ecs->table('seller_apply_info') . " SET is_paid = 1 ,pay_time = '" . gmtime() . "' ,pay_status = 1 WHERE apply_id= '" . $apply_id . "'";
                        $db->query($sql);

                        //记录支付log
                        $sql = "UPDATE " . $ecs->table('pay_log') . "SET is_paid = 1 WHERE order_id = '" . $apply_id . "' AND order_type = '" . PAY_APPLYGRADE . "'";
                        $db->query($sql);

                        log_account_change($adminru['ru_id'], $seller_apply_info['payable_amount'] * (-1), 0, 0, 0, sprintf($_LANG['seller_apply'], $seller_apply_info['apply_sn']));
                    } else {
                        $links[] = array('text' => '返回申请列表', 'href' => 'merchants_upgrade.php?act=list');
            
                        sys_msg($_LANG['balance_insufficient'],'',$links); 
                    }
                } else {
                    /* 调用相应的支付方式文件 */
                    include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');
                    /* 取得在线支付方式的支付按钮 */
                    $pay_obj = new $payment_info['pay_code'];
                    $payment_info['pay_button'] = $pay_obj->get_code($apply_info, $payment);
                }

                $smarty->assign('payment', $payment_info);
                $smarty->assign('pay_fee', price_format($payment_info['pay_fee'], false));
                $smarty->assign('amount', price_format($seller_apply_info['payable_amount'], false));
                $smarty->assign('order', $apply_info);

                $smarty->display('seller_done.dwt');
            } else {
               $links[] = array('text' => '返回申请列表', 'href' => 'merchants_upgrade.php?act=list');
            
                sys_msg($_LANG['success'],'',$links); 
            }
        } else {
            $links[] = array('text' => '返回申请列表', 'href' => 'merchants_upgrade.php?act=list');
            
            sys_msg("系统错误，稍后再试",'',$links); 
        }
    } else {
        $links[] = array('text' => '返回申请列表', 'href' => 'merchants_upgrade.php?act=list');
            
        sys_msg('系统错误，稍后再试','',$links); 
    }
}
/*分页*/
function get_pzd_list() {
    $result = get_filter();
    if ($result === false)
    {
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('seller_grade')." WHERE is_open = 1";
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);
        $filter = page_and_size($filter);
        /* 获活动数据 */
           $sql="SELECT * FROM".$GLOBALS['ecs']->table('seller_grade'). " WHERE is_open = 1  ORDER BY id ASC LIMIT " . $filter['start'] . "," . $filter['page_size'];
            $filter['keywords'] = stripslashes($filter['keywords']);
            set_filter($filter, $sql);
             }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
        $row = $GLOBALS['db']->getAll($sql);
        foreach($row as $k=>$v){
            if($v['entry_criteria']){
                $entry_criteria=unserialize($v['entry_criteria']);
                $criteria='';
                foreach ($entry_criteria as $key=>$val){
                    $sql="SELECT criteria_name FROM".$GLOBALS['ecs']->table('entry_criteria')." WHERE id = '".$val."'" ;
                    $criteria_name=$GLOBALS['db']->getOne($sql);
                    if($criteria_name){
                        $entry_criteria[$key]=$criteria_name;
                    }
                }
                $row[$k]['entry_criteria']=implode(" , ",$entry_criteria);
            }
        }
        $arr = array('pzd_list' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
        return $arr;
}


/*获取申请等级的入驻标准*/
function get_entry_criteria($entry_criteria = ''){
    
    $entry_criteria = unserialize($entry_criteria);//反序列化等级入驻标准
    $rel = array();
    if(!empty($entry_criteria)){
        $sql=" SELECT id,criteria_name FROM".$GLOBALS['ecs']->table('entry_criteria')." WHERE id ".  db_create_in($entry_criteria);
        $rel=$GLOBALS['db']->getAll($sql);
        foreach($rel as $k=>$v){
            $child=$GLOBALS['db']->getAll(" SELECT * FROM".$GLOBALS['ecs']->table("entry_criteria")." WHERE parent_id = '".$v['id']."'");
            foreach($child as $key => $val){
                if($val['type'] == 'select' && $val['option_value'] != ''){
                    $child[$key]['option_value'] = explode(',', $val['option_value']);
                }
                $rel['count_charge'] +=  $val['charge'];
                if($val['is_cumulative'] == 0){
                    $rel['no_cumulative_price'] +=  $val['charge'];
                }
            }
            $rel[$k]['child'] = $child;
        }
    }
    return $rel;
}

/**
 * 保存申请时的上传图片
 *
 * @access  public
 * @param   int     $image_files     上传图片数组
 * @param   int     $file_id   图片对应的id数组
 * @return  void
 */
function upload_apply_file($image_files=array(),$file_id=array(),$url=array())
{
   /* 是否成功上传 */
    foreach($file_id as $v){
        $flag = false;
        if (isset($image_files['error']))
        {
            if ($image_files['error'][$v] == 0)
            {
                $flag = true;
            }
        }
        else
        {
            if ($image_files['tmp_name'][$v] != 'none' && $image_files['tmp_name'][$v])
            {
                $flag = true;
            }
        }
        if($flag){
            /*生成上传信息的数组*/
            $upload = array(
                'name' => $image_files['name'][$v],
                'type' => $image_files['type'][$v],
                'tmp_name' => $image_files['tmp_name'][$v],
                'size' => $image_files['size'][$v],
            );
            if (isset($image_files['error']))
            {
                $upload['error'] = $image_files['error'][$v];
            }
            
            $img_original = $GLOBALS['image']->upload_image($upload);
            if ($img_original === false)
            {
                sys_msg($GLOBALS['image']->error_msg(), 1, array(), false);
            }
            $img_url[$v] = $img_original;
            /*删除原文件*/
            if(!empty($url[$v])){
                @unlink(ROOT_PATH . $url[$v]);
                unset($url[$v]);
            }
        }
    }
    $return_file = array();
    if(!empty($url) && !empty($img_url)){
        $return_file = $url+$img_url;
    }elseif(!empty($url)){
        $return_file = $url;
    }elseif(!empty($img_url)){
         $return_file = $img_url;
    }
    if(!empty($return_file)){
        return $return_file;
    }else{
        return false;
    }
}