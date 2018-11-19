<?php

/**
 * ECSHOP 提交用户评论
 * ============================================================================
 * * 旺旺：ecshop2012版权所有，并保留所有权利。* 网站地址: http://lvruanjian.taobao.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: comment.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_json.php');
if (!isset($_REQUEST['cmt']) && !isset($_REQUEST['act']))
{
    /* 只有在没有提交评论内容以及没有act的情况下才跳转 */
    ecs_header("Location: ./\n");
    exit;
}
$_REQUEST['cmt'] = isset($_REQUEST['cmt']) ? json_str_iconv($_REQUEST['cmt']) : '';

$json   = new JSON;
$result = array('error' => 0, 'message' => '', 'content' => '');

if (empty($_REQUEST['act']))
{
    /*
     * act 参数为空
     * 默认为添加评论内容
     */
    $cmt  = $json->decode($_REQUEST['cmt']);
    $cmt->page = 1;
    $cmt->id   = !empty($cmt->id)   ? intval($cmt->id) : 0;
    $cmt->type = !empty($cmt->type) ? intval($cmt->type) : 0;

    if (empty($cmt) || !isset($cmt->type) || !isset($cmt->id))
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['invalid_comments'];
    }
    elseif (!is_email($cmt->email))
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['error_email'];
    }
    else
    {
        if ((intval($_CFG['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
        {
            /* 检查验证码 */
            include_once('includes/cls_captcha.php');

            $validator = new captcha();
            if (!$validator->check_word($cmt->captcha))
            {
                $result['error']   = 1;
                $result['message'] = $_LANG['invalid_captcha'];
            }
            else
            {
                $factor = intval($_CFG['comment_factor']);
                if ($cmt->type == 0 && $factor > 0)
                {
                    /* 只有商品才检查评论条件 */
                    switch ($factor)
                    {
                        case COMMENT_LOGIN :
                            if ($_SESSION['user_id'] == 0)
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_login'];
                            }
                            break;

                        case COMMENT_CUSTOM :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id FROM " . $ecs->table('order_info') . " AS o ".
                                       " WHERE user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";


                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_custom'];
                                 }
                            }
                            else
                            {
                                $result['error'] = 1;
                                $result['message'] = $_LANG['comment_custom'];
                            }
                            break;
                        case COMMENT_BOUGHT :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id".
                                       " FROM " . $ecs->table('order_info'). " AS o, ".
                                       $ecs->table('order_goods') . " AS og ".
                                       " WHERE o.order_id = og.order_id".
                                       " AND o.user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND og.goods_id = '" . $cmt->id . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";
                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_brought'];
                                 }
                            }
                            else
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_brought'];
                            }
                    }
                }

                /* 无错误就保存留言 */
                if (empty($result['error']))
                {
                    add_comment($cmt);
                }
            }
        }
        else
        {
            /* 没有验证码时，用时间来限制机器人发帖或恶意发评论 */
            if (!isset($_SESSION['send_time']))
            {
                $_SESSION['send_time'] = 0;
            }

            $cur_time = gmtime();
            if (($cur_time - $_SESSION['send_time']) < 30) // 小于30秒禁止发评论
            {
                $result['error']   = 1;
                $result['message'] = $_LANG['cmt_spam_warning'];
            }
            else
            {
                $factor = intval($_CFG['comment_factor']);
                if ($cmt->type == 0 && $factor > 0)
                {
                    /* 只有商品才检查评论条件 */
                    switch ($factor)
                    {
                        case COMMENT_LOGIN :
                            if ($_SESSION['user_id'] == 0)
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_login'];
                            }
                            break;

                        case COMMENT_CUSTOM :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id FROM " . $ecs->table('order_info') . " AS o ".
                                       " WHERE user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";


                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_custom'];
                                 }
                            }
                            else
                            {
                                $result['error'] = 1;
                                $result['message'] = $_LANG['comment_custom'];
                            }
                            break;

                        case COMMENT_BOUGHT :
                            if ($_SESSION['user_id'] > 0)
                            {
                                $sql = "SELECT o.order_id".
                                       " FROM " . $ecs->table('order_info'). " AS o, ".
                                       $ecs->table('order_goods') . " AS og ".
                                       " WHERE o.order_id = og.order_id".
                                       " AND o.user_id = '" . $_SESSION['user_id'] . "'".
                                       " AND og.goods_id = '" . $cmt->id . "'".
                                       " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                                       " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                                       " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ".
                                       " LIMIT 1";
                                 $tmp = $db->getOne($sql);
                                 if (empty($tmp))
                                 {
                                    $result['error']   = 1;
                                    $result['message'] = $_LANG['comment_brought'];
                                 }
                            }
                            else
                            {
                                $result['error']   = 1;
                                $result['message'] = $_LANG['comment_brought'];
                            }
                    }
                }
                /* 无错误就保存留言 */
                if (empty($result['error']))
                {
                    add_comment($cmt);
                    $_SESSION['send_time'] = $cur_time;
                }
            }
        }
    }
}

/*------------------------------------------------------ */
//-- 无刷新上传图片ajax
/*------------------------------------------------------ */
elseif($_REQUEST['act']=='ajax_return_images'){

    $img_file = isset($_FILES['file']) ? $_FILES['file'] : array();
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
    $goods_id = isset($_GET['goods_id']) ? intval($_GET['goods_id']) : 0;
    $user_id = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
    $sessid = isset($_GET['sessid']) ? trim($_GET['sessid']) : '';
    
    $sql = "SELECT count(*) FROM ". $ecs->table('sessions') ." WHERE userid = '$user_id' AND sesskey='$sessid'";

    if (!empty($user_id) && $db->getOne($sql) > 0) {
        include_once(ROOT_PATH . '/includes/cls_image.php');
        $image = new cls_image($_CFG['bgcolor']);

        $img_file = $image->upload_image($img_file, 'cmt_img/'.date('Ym')); //原图
        if($img_file === false){
            $result['error'] = 1;
            $result['msg'] = $image->error_msg();
            die($json->encode($result));
        }

        $img_thumb = $image->make_thumb($img_file, $GLOBALS['_CFG']['single_thumb_width'], $GLOBALS['_CFG']['single_thumb_height'], DATA_DIR . '/cmt_img/'.date('Ym').'/thumb/'); //缩略图
        
        get_oss_add_file(array($img_file, $img_thumb));
        
        $return = array(
            'order_id' => $order_id,
            'rec_id' => $rec_id,
            'goods_id' => $goods_id,
            'user_id' => $user_id,
            'comment_img' => $img_file,
            'img_thumb' => $img_thumb
        );

        $sql = "SELECT count(*) FROM " . $ecs->table('comment_img') . " WHERE user_id = '$user_id' AND order_id = '$order_id' AND goods_id = '$goods_id'";
        $img_count = $db->getOne($sql);

        if ($img_count < 10 && $img_file) {
            $db->autoExecute($ecs->table('comment_img'), $return, 'INSERT');
        } else {
            $result['error'] = 1;
            $result['msg'] = $_LANG['comment_img_number'];
            die($json->encode($result));
        }
    } else {
        $result['error'] = 2;
        $result['msg'] = $_LANG['please_login'];
        die($json->encode($result));
    }

    $sql = "SELECT id, comment_img, img_thumb FROM " . $ecs->table('comment_img') . " WHERE user_id = '$user_id' AND order_id = '$order_id' AND goods_id = '$goods_id' AND comment_id = 0 ORDER BY  id DESC";
    $img_list = $db->getAll($sql);
    
    $result['imglist_count'] = count($img_list);
    $result['currentImg_path'] = $img_list[0]['comment_img'];
    $result['currentImg_id'] = $img_list[0]['id'];
    $smarty->assign('img_list', $img_list);
    $result['content'] = $smarty->fetch("library/comment_image.lbi");

    die($json->encode($result));
}
/*------------------------------------------------------ */
//-- 删除晒单照片
/*------------------------------------------------------ */
elseif($_REQUEST['act']=='del_pictures'){
    $img_id = isset($_REQUEST['cur_imgId']) ? intval($_REQUEST['cur_imgId']) : 0;
    $order_id = isset($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0;
    $goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
    
    if(empty($_SESSION['user_id']) || !$img_id){
        $result['error'] = 1;
    }
    $img_list = array();
    
    $sql = "select id, comment_img, img_thumb from " .$ecs->table('comment_img'). " where user_id = '" .$_SESSION['user_id']. "' and order_id = '$order_id' and goods_id = '$goods_id' order by id desc";
    $img_list = $db->getAll($sql);

    foreach($img_list as $key=>$val){
       
        if($img_id == $val['id']){
            $sql = "delete from " .$ecs->table('comment_img'). " where id = '$img_id'";
            $db->query($sql);
            unset($img_list[$key]);
            
            get_oss_del_file(array($val['comment_img'], $val['img_thumb']));
            
            @unlink(ROOT_PATH . $val['comment_img']);
            @unlink(ROOT_PATH . $val['img_thumb']);
        }
        
    }

    $smarty->assign('img_list',        $img_list);
    $result['content'] = $smarty->fetch("library/comment_image.lbi");

    die($json->encode($result));
}
/*------------------------------------------------------ */
//-- 晒单照片列表
/*------------------------------------------------------ */
elseif($_REQUEST['act']=='ajax_return_images_list'){
	
	$sql = "select id, comment_img, img_thumb from " .$ecs->table('comment_img'). " where user_id = '" .$_SESSION['user_id']. "' and order_id = '$order_id' and goods_id = '$goods_id' order by id desc";
	$img_list = $db->getAll($sql);
	
	if($img_list){
		$smarty->assign('img_list',        $img_list);
		$result['content'] = $smarty->fetch("library/comment_image.lbi");
	}else{
		$result['error'] = 1;
	}
	
	die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 晒单入库处理
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'comm_order_goods')
{
    
    $result = array('error' => 0, 'message' => '', 'content' => '');

    $_POST['cmt']=strip_tags(urldecode($_POST['cmt']));
    $_POST['cmt'] = json_str_iconv($_POST['cmt']);
    
    if (empty($_POST['cmt']))
    {
        $result['error'] = 1;
        die($json->encode($result));
    }

    $cmt = $json->decode($_POST['cmt']);
    
    $user_id = $_SESSION['user_id'];
    $comment_id = isset($cmt->comment_id) ? intval($cmt->comment_id) : 0;
    $rank = isset($cmt->comment_rank) ? intval($cmt->comment_rank) : 5;
    $rank_server = 5;
    $rank_delivery = 5;
    $content = isset($cmt->content) ? htmlspecialchars(trim($cmt->content)) : '';
    $order_id = isset($cmt->order_id) ? intval($cmt->order_id) : 0;
    $goods_id = isset($cmt->goods_id) ? intval($cmt->goods_id) : 0;
    $goods_tag = isset($cmt->impression) ? trim($cmt->impression) : '';
    $sign = isset($cmt->sign) ? trim($cmt->sign) : 0;
    $result['sign'] = $sign;
    $rec_id = isset($cmt->rec_id) ? intval($cmt->rec_id) : 0;
            
    $addtime = gmtime();
    $ip = real_ip();
    
    $captcha_str = isset($cmt->captcha) ? htmlspecialchars(trim($cmt->captcha)) : '';
    
    /* 验证码检查 */
    if ((intval($_CFG['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
    {
        $verify = new Verify();
        $captcha_code = $verify->check($captcha_str, 'user_comment', $rec_id);
        
        if(!$captcha_code){
            $result['error'] = 1;
            $result['message'] = $_LANG['invalid_captcha'];
            die($json->encode($result));
        }
    }
    
    $sql = "SELECT user_id FROM " .$ecs->table('goods'). " WHERE goods_id = '$goods_id'";
    $ru_id = $db->getOne($sql, true);
    
    if(!$comment_id){
        $status = 1 - $GLOBALS['_CFG']['comment_check'];
        $other = array(
            'comment_type' => 0,
            'id_value' => $goods_id,
            'email' => $_SESSION['email'],
            'user_name' => $_SESSION['user_name'],
            'content' => $content,
            'comment_rank' => $rank,
            'comment_server' => $rank_server,
            'comment_delivery' => $rank_delivery,
            'add_time' => $addtime,
            'ip_address' => $ip,
            'status' => $status,
            'parent_id' => 0,
            'user_id' => $_SESSION['user_id'],
            'single_id' => 0,
            'order_id' => $order_id,
            'rec_id' => $rec_id,
            'goods_tag' => $goods_tag,
            'ru_id' => $ru_id,
        );
        
        $db->autoExecute($ecs->table('comment'), $other, 'INSERT');
        $comment_id = $db->insert_id();
        
        if($comment_id)
        {
            //更新comment_img
            $sql = "UPDATE ". $ecs->table('comment_img') ." SET comment_id = '$comment_id' WHERE rec_id = '$rec_id' AND goods_id = '$goods_id' AND user_id = '$user_id'" ;
            $db->query($sql);
            
            //更新评论数量
            $sql = "UPDATE ". $ecs->table('goods') ." SET comments_number = comments_number + 1 WHERE goods_id = '$goods_id'";
            $db->query($sql);
            
            $result['message'] = $GLOBALS['_CFG']['comment_check'] ? $_LANG['cmt_submit_wait'] : $_LANG['cmt_submit_done'];
            $result['message_type'] = $_LANG['Review_information'];
        }
    }else{
        
        $sql = "UPDATE ". $ecs->table('comment_img') ." SET comment_id = '$comment_id' WHERE rec_id = '$rec_id' AND goods_id = '$goods_id' AND user_id = '$user_id' AND comment_id = 0" ;
        $db->query($sql);

        $result['message'] = $_LANG['single_success'];
        $result['message_type'] = $_LANG['single_information'];
    }
    
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 评论商家满意度
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'satisfaction_degree')
{
    
    $result = array('error' => 0, 'msg' => '', 'content' => '');
    
    $user_id = $_SESSION['user_id'];
    $_POST['rank']=strip_tags(urldecode($_POST['rank']));
    $_POST['rank'] = json_str_iconv($_POST['rank']);
    
    if (empty($_POST['rank']))
    {
        $result['error'] = 1;
        $result['msg'] = $_LANG['parameter_error'];
        die($json->encode($result));
    }
    if(empty($user_id)){
        $result['error'] = 1;
        $result['msg'] = $_LANG['please_login'];
        die($json->encode($result));
    }

    $cmt = $json->decode($_POST['rank']);
    
    $order_id = isset($cmt->order_id) ? intval($cmt->order_id) : 0;
    $desc_rank = isset($cmt->desc_rank) ? intval($cmt->desc_rank) : 5;
    $service_rank = isset($cmt->service_rank) ? intval($cmt->service_rank) : 5;
    $delivery_rank = isset($cmt->delivery_rank) ? intval($cmt->delivery_rank) : 5;
    $sender_rank = isset($cmt->sender_rank) ? trim($cmt->sender_rank) : '';
    $addtime = gmtime();
    //商家id
    $sql = "SELECT ru_id FROM ". $ecs->table('order_goods') ." WHERE order_id = '$order_id' LIMIT 1";
    $ru_id = $db->getOne($sql);
    
    $sql = "INSERT INTO " . $ecs->table('comment_seller') . "(user_id, ru_id, order_id, desc_rank, service_rank, delivery_rank, sender_rank, add_time )VALUES('$user_id', '$ru_id', '$order_id', ' $desc_rank', '$service_rank', '$delivery_rank', '$sender_rank', '$addtime')";
    $result = $db->query($sql);
	if($result){//插入店铺评分
		$store_score = sprintf("%.2f", ($desc_rank + $service_rank + $delivery_rank) / 3);
		$sql = "UPDATE " . $ecs->table('merchants_shop_information') . " SET store_score = '" . $store_score . "' WHERE user_id = $ru_id";
		$res = $db->query($sql);
	}
    if(!$result)
    {
        $result['error'] = 1;
        $result['msg'] = $_LANG['parameter_error'];
    }
    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- 商品评论列表
/*------------------------------------------------------ */
elseif($_REQUEST['act'] == 'comment_all' || $_REQUEST['act'] == 'comment_good' || $_REQUEST['act'] == 'comment_middle' || $_REQUEST['act'] == 'comment_short' || $_REQUEST['act'] == 'gotopage')
{    
    /*
     * act 参数不为空
     * 默认为评论内容列表
     * 根据 _GET 创建一个静态对象
     */
    $cmt = new stdClass();
    $cmt->id   = !empty($_GET['id'])   ? htmlspecialchars($_GET['id'])   : 0;
    $cmt->type = !empty($_GET['type']) ? intval($_GET['type']) : 0;
    $cmt->page = isset($_GET['page'])   && intval($_GET['page'])  > 0 ? intval($_GET['page'])  : 1;
    
    $id = explode("|", $cmt->id);
    
    $goods_id = $id[0];
    $cmtType = $id[1];
    
    $comments = assign_comment($goods_id, $cmt->type, $cmt->page, $cmtType);
    
    $smarty->assign('comment_type', $cmt->type);
    $smarty->assign('id',           $cmt->id);
    $smarty->assign('username',     $_SESSION['user_name']);
    $smarty->assign('email',        $_SESSION['email']);
    $smarty->assign('comments',     $comments['comments']);
    $smarty->assign('pager',        $comments['pager']);

    $smarty->assign('count',        $comments['count']);
    $smarty->assign('size',        $comments['size']);

    $result['content'] = $smarty->fetch("library/comments_list.lbi");
    echo $json->encode($result);
}

/*------------------------------------------------------ */
//-- 评论有用+1
/*------------------------------------------------------ */
 elseif ($_REQUEST['act'] == 'add_useful') {

    $res = array('err_msg' => '', 'content' => '', 'err_no' => 0);

    $id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
    $type = empty($_REQUEST['type']) ? 'comment' : $_REQUEST['type'];
    $goods_id = empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']);
    $ip = real_ip();
    if (!empty($id)) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
            $res['url'] = get_return_goods_url($goods_id);
            $res['err_no'] = 1;
        } else {

            $useful_user = '';
            $sql = 'SELECT useful_user, useful FROM ' . $ecs->table('comment') . " WHERE comment_id='$id'";
            $comment = $db->getRow($sql);

            if ($comment['useful_user']) {
                $useful_user = explode(',', $comment['useful_user']);
                if (in_array($_SESSION['user_id'], $useful_user)) {
                    $res['err_no'] = 2;
                    die($json->encode($res));
                } else {
                    array_push($useful_user, $_SESSION['user_id']);
                    $useful_user = implode(',', $useful_user);
                }
            } else {
                $useful_user = array(0);
                array_push($useful_user, $_SESSION['user_id']);
                $useful_user = implode(',', $useful_user);
            }

            $sql = 'SELECT COUNT(*) FROM ' . $ecs->table('comment') . " WHERE comment_id='$id'";
            $count = $db->getOne($sql);

            if ($count == 1) {
                $sql = "UPDATE " . $ecs->table('comment') . " SET useful = useful + 1, useful_user = '$useful_user' WHERE comment_id='$id'";
                if ($db->query($sql)) {
                    $res = array('option' => 'true', 'id' => $id, 'type' => $type, 'useful' => $comment['useful'] + 1, 'err_no' => 0);
                } else {
                    $res = array('error' => '', 'id' => $id, 'type' => $type, 'err_no' => 2);
                }
            } else {
                $res = array('option' => '', 'id' => $id, 'type' => $type, 'err_no' => 2);
            }
        }
    }

    die($json->encode($res));
}

/*------------------------------------------------------ */
//-- 商品评论回复
/*------------------------------------------------------ */
else if ($_REQUEST['act'] == 'comment_reply') {

    $result = array('err_msg' => '', 'err_no' => 0, 'content' => '');

    $comment_id = isset($_REQUEST['comment_id']) ? intval($_REQUEST['comment_id']) : 0;
    $reply_content = isset($_REQUEST['reply_content']) ? htmlspecialchars(trim($_REQUEST['reply_content'])) : 0;
    $goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
    $comment_user = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 0;
    $libType = isset($_REQUEST['libType']) ? intval($_REQUEST['libType']) : 0;
    $type = 0;
    $reply_page = 1;

    $add_time = gmtime();
    $real_ip = real_ip();

    $result['comment_id'] = $comment_id;
    $result['reply_content'] = $reply_content;

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
        //$result['err_no'] = 1;
    } elseif ($comment_user == $_SESSION['user_id']) {
        //$result['err_no'] = 2;
    } else {
        $comment_user_count = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('comment') . " WHERE id_value = '$goods_id' AND parent_id = '$comment_id' AND user_id = '" . $_SESSION['user_id'] . "'");
        if ($comment_user_count > 0) {
            $result['err_no'] = 2;
        } else {

            $comment_user_name = $GLOBALS['db']->getOne("SELECT user_name FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '" . $_SESSION['user_id'] . "'");
            $status = 1 - $GLOBALS['_CFG']['comment_check'];
            $sql = "INSERT INTO " . $GLOBALS['ecs']->table('comment') . "(`id_value`,`content`,`comment_type`,`user_name`,`comment_rank`,`comment_server`,`comment_delivery`, `add_time`, `parent_id`, `user_id`, `ip_address`, `status`)" .
                    "VALUES('$goods_id', '$reply_content', 2, '$comment_user_name', '5', '5', '5', '$add_time', '$comment_id', '" . $_SESSION['user_id'] . "', '$real_ip', '$status')";
            $GLOBALS['db']->query($sql);

            $result['message'] = $GLOBALS['_CFG']['comment_check'] ? $_LANG['cmt_submit_wait'] : $_LANG['cmt_submit_done'];
        }
    }

    if ($libType == 1) {
        $size = 10;
    } else {
        $size = 2;
    }

    if ($result['err_no'] != 1) {
        $reply = get_reply_list($goods_id, $comment_id, $type, $reply_page, $libType, $size);
          //var_dump($reply);
        $smarty->assign('reply_pager', $reply['reply_pager']);
        $smarty->assign('reply_count', $reply['reply_count']);
        $smarty->assign('reply_list', $reply['reply_list']);
        $smarty->assign('lang', $_LANG);
        
        $result['reply_count'] = $reply['reply_count'];

        if ($libType == 1) {
            $result['content'] = $smarty->fetch("library/comment_repay.lbi");
        } else {
            $result['content'] = $smarty->fetch("library/comment_reply.lbi");
        }
    }
    
    $result['url'] = get_return_goods_url($goods_id);

    die($json->encode($result));
}

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 添加评论内容
 *
 * @access  public
 * @param   object  $cmt
 * @return  void
 */
function add_comment($cmt)
{
    /* 评论是否需要审核 */
    $status = 1 - $GLOBALS['_CFG']['comment_check'];

    $user_id = empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
    $email = empty($cmt->email) ? $_SESSION['email'] : trim($cmt->email);
    $user_name = empty($cmt->username) ? $_SESSION['user_name'] : '';
    $email = addslashes($email);
    $user_name = addslashes($user_name);
	
    //旺旺ecshop2012--zuo start  商家ID
    $sql = "select user_id from " .$GLOBALS['ecs']->table('goods'). " where goods_id = '" .$cmt->id. "'";
    $ru_id = $GLOBALS['db']->getOne($sql);
    //旺旺ecshop2012--zuo end

    /* 保存评论内容 */
    $sql = "INSERT INTO " .$GLOBALS['ecs']->table('comment') .
           "(comment_type, id_value, email, user_name, content, comment_rank, comment_server, comment_delivery, add_time, ip_address, status, parent_id, user_id, ru_id) VALUES " .
           "('" .$cmt->type. "', '" .$cmt->id. "', '$email', '$user_name', '" .$cmt->content."', '".$cmt->rank."', '".$cmt->server."', '".$cmt->delivery."', ".gmtime().", '".real_ip()."', '$status', '0', '$user_id', '$ru_id')";

    $result = $GLOBALS['db']->query($sql);
    clear_cache_files('comments_list.lbi');

    return $result;
}

?>