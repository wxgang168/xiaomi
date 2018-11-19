<?php

/**
 * ECSHOP 前台公用文件
 * ============================================================================
 * * 版权所有2005-2006上海商创网络科技有限公司，并保留所有权利。！** 地址: http://lvruanjian.taobao.com ；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author:liubo$
 * $Id: init_api.php 17217 2018-07-19 06:29:08Z liubo$
*/
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

error_reporting(E_ALL);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}

/* 取得当前ecshop所在的根目录 */
define('ROOT_PATH', str_replace('includes/init_api.php', '', str_replace('\\', '/', __FILE__)));

// 记录开始运行时间
$GLOBALS['_beginTime'] = microtime(TRUE);
// 记录内存初始使用
define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));
if(MEMORY_LIMIT_ON) $GLOBALS['_startUseMems'] = memory_get_usage();

/* 初始化设置 */
@ini_set('memory_limit',          '512M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);
@ini_set('display_errors',        1);

if (DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path', '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path', '.:' . ROOT_PATH);
}

require(ROOT_PATH . 'data/config.php');

if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 0);
}

if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}

$php_self = isset($_SERVER['PHP_SELF']) && !empty($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);

require(ROOT_PATH . 'includes/Http.class.php'); 
require(ROOT_PATH . 'includes/cls_pinyin.php');
require(ROOT_PATH . 'includes/inc_constant.php');
require(ROOT_PATH . 'includes/cls_ecshop.php');
require(ROOT_PATH . 'includes/cls_error.php');
require(ROOT_PATH . 'includes/lib_time.php');
require(ROOT_PATH . 'includes/lib_base.php');
require(ROOT_PATH . 'includes/lib_common.php');
require(ROOT_PATH . 'includes/lib_main.php');
require(ROOT_PATH . 'includes/lib_insert.php');
require(ROOT_PATH . 'includes/lib_goods.php');
require(ROOT_PATH . 'includes/lib_article.php');

require(ROOT_PATH . '/includes/cls_captcha_verify.php'); //验证码的类 TP

//by guan start
require(ROOT_PATH . 'includes/lib_scws.php');
//by guan end

//ecmoban模板堂 --zhuo start
require(ROOT_PATH . 'includes/lib_ecmoban.php');
require(ROOT_PATH . 'includes/lib_ecmobanFunc.php');
require(ROOT_PATH . 'includes/lib_seller_store.php');
require(ROOT_PATH . 'includes/lib_ipCity.php'); 
require(ROOT_PATH . 'includes/cls_ecmac.php');
//ecmoban模板堂 --zhuo end


//安装 start
if(!file_exists(ROOT_PATH . 'data/install.lock.php') && !defined('NO_CHECK_INSTALL')){
	header("Location: ./install/index.php\n");
	exit;
}
//安装 end


/* 对用户传入的变量进行转义操作。*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}

/* 创建 ECSHOP 对象 */
$ecs = new ECS($db_name, $prefix);
define('DATA_DIR', $ecs->data_dir());
define('IMAGE_DIR', $ecs->image_dir());

/* 初始化数据库类 */
require(ROOT_PATH . 'includes/cls_mysql.php');
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db->set_disable_cache_tables(array($ecs->table('sessions'), $ecs->table('sessions_data'), $ecs->table('cart')));
$db_host = $db_user = $db_pass = $db_name = NULL;

/* 创建错误处理对象 */
$err = new ecs_error('message.dwt');

$sel_config = get_shop_config_val('open_memcached');
//ecmoban模板堂 --zhuo memcached start
if($sel_config['open_memcached'] == 1){
    require(ROOT_PATH . 'includes/cls_cache.php');
    require(ROOT_PATH . 'data/cache_config.php');
    $cache = new cls_cache($cache_config);
}
//ecmoban模板堂 --zhuo memcached end

/* 载入系统参数 */
$_CFG = load_config();

require(ROOT_PATH . 'data/sms_config.php'); //ecmoban模板堂 --zhuo 短信语言包模板

/* 载入语言文件 */
require(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/common.php');

/*载入前台模板文件  by kong haojlj*/
require(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/js_languages.php');
if (file_exists(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/' . basename(PHP_SELF)))
{
    include(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/' . basename(PHP_SELF));
}

if ($_CFG['shop_closed'] == 1)
{
    /* 商店关闭了，输出关闭的消息 */
    header('Content-type: text/html; charset='.EC_CHARSET);

    die($_CFG['close_comment']);
}

if (is_spider())
{
    $_SESSION = array();
    $_SESSION['user_id']     = 0;
    $_SESSION['user_name']   = '';
    $_SESSION['email']       = '';
    $_SESSION['user_rank']   = 0;
    $_SESSION['discount']    = 1.00;
}

if(isset($_SERVER['PHP_SELF']))
{
    $_SERVER['PHP_SELF']=htmlspecialchars($_SERVER['PHP_SELF']);
}
if (!defined('INIT_NO_SMARTY'))
{
    header('Cache-control: private');
    header('Content-type: text/html; charset='.EC_CHARSET);

    /* 创建 Smarty 对象。*/
    require(ROOT_PATH . 'includes/cls_template.php');
    $smarty = new cls_template;

    $smarty->cache_lifetime = $_CFG['cache_time'];
    $smarty->template_dir   = ROOT_PATH . 'themes/' . $_CFG['template'];
    $smarty->cache_dir      = ROOT_PATH . 'temp/caches';
    $smarty->compile_dir    = ROOT_PATH . 'temp/compiled';

    if ((DEBUG_MODE & 2) == 2)
    {
        $smarty->direct_output = true;
        $smarty->force_compile = true;
    }
    else
    {
        $smarty->direct_output = false;
        $smarty->force_compile = false;
    }

    $smarty->assign('lang', $_LANG);
    $smarty->assign('ecs_charset', EC_CHARSET);
    if (!empty($_CFG['stylename']))
    {
        $smarty->assign('ecs_css_path', 'themes/' . $_CFG['template'] . '/style_' . $_CFG['stylename'] . '.css');
    }
    else
    {
        $smarty->assign('ecs_css_path', 'themes/' . $_CFG['template'] . '/style.css');
    }
	
	$smarty->assign('ecs_css_suggest', 'themes/' . $_CFG['template'] . '/suggest.css'); //模糊搜索 buy guan

    /*  @author-bylu IM在线客服(用于判断平台是否开启IM在线客服功能) start  */
    $kf_im_switch = $GLOBALS['db']->getOne("SELECT kf_im_switch FROM ".$GLOBALS['ecs']->table('seller_shopinfo')."WHERE ru_id=0");
    $smarty->assign('kf_im_switch',$kf_im_switch);
    /*  @author-bylu  end  */

}

if (!defined('INIT_NO_USERS'))
{
    /* 会员信息 */
    $user =& init_users();

    if (!isset($_SESSION['user_id']))
    {
        /* 获取投放站点的名称 */
        $site_name = isset($_GET['from'])   ? htmlspecialchars($_GET['from']) : addslashes($_LANG['self_site']);
        $from_ad   = !empty($_GET['ad_id']) ? intval($_GET['ad_id']) : 0;

        $_SESSION['from_ad'] = $from_ad; // 用户点击的广告ID
        $_SESSION['referer'] = stripslashes($site_name); // 用户来源

        unset($site_name);

        if (!defined('INGORE_VISIT_STATS'))
        {
            visit_stats();
        }
    }

    if (empty($_SESSION['user_id']))
    {
        if ($user->get_cookie())
        {
            /* 如果会员已经登录并且还没有获得会员的帐户余额、积分以及优惠券 */
            if ($_SESSION['user_id'] > 0)
            {
                update_user_info();
            }
        }
        else
        {
            $_SESSION['user_id']     = 0;
            $_SESSION['user_name']   = '';
            $_SESSION['email']       = '';
            $_SESSION['user_rank']   = 0;
            $_SESSION['discount']    = 1.00;
            if (!isset($_SESSION['login_fail']))
            {
                $_SESSION['login_fail'] = 0;
            }
        }
    }

    /* 设置推荐会员 */
    if (isset($_GET['u']))
    {
        set_affiliate();
    }

    /* session 不存在，检查cookie */
    if (!empty($_COOKIE['ECS']['user_id']) && !empty($_COOKIE['ECS']['password']))
    {
        // 找到了cookie, 验证cookie信息
        $sql = 'SELECT user_id, user_name, password ' .
                ' FROM ' .$ecs->table('users') .
                " WHERE user_id = '" . intval($_COOKIE['ECS']['user_id']) . "' AND password = '" .$_COOKIE['ECS']['password']. "'";

        $row = $db->GetRow($sql);

        if (!$row)
        {
            // 没有找到这个记录
           $time = time() - 3600;
           setcookie("ECS[user_id]",  '', $time, '/', $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
           setcookie("ECS[password]", '', $time, '/', $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
        }
        else
        {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            update_user_info();
        }
    }

    if (isset($smarty))
    {
        $smarty->assign('ecs_session', $_SESSION);
    }
}

if ((DEBUG_MODE & 1) == 1)
{
    error_reporting(E_ALL);
}
else
{
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 
}
if ((DEBUG_MODE & 4) == 4)
{
    include(ROOT_PATH . 'includes/lib.debug.php');
}

/* 判断是否支持 Gzip 模式 */
/*if (!defined('INIT_NO_SMARTY') && gzip_enabled())
{
    ob_start('ob_gzhandler');
}
else
{
    ob_start();
}*/

/**
 * 通过类型与传入的ID获取广告内容
 *
 * @param string $type
 * @param int $id
 * @return string
 */					
function get_adv($type,$id)
{
	 $sql = "select ap.ad_width,ap.ad_height,ad.ad_name,ad.ad_code,ad.ad_link,ad.media_type from ".$GLOBALS['ecs']->table('ad_position')." as ap left join ".$GLOBALS['ecs']->table('ad')." as ad on ad.position_id = ap.position_id where ad.ad_name='".$type."_".$id."' and (ad.media_type=0 OR ad.media_type=3) and UNIX_TIMESTAMP()>ad.start_time and UNIX_TIMESTAMP()<ad.end_time and ad.enabled=1";
     $row = $GLOBALS['db']->getRow($sql);

     if($row)       
	 {      
	 	if($row['media_type'] == 0)
		{       
			$src = (strpos($row['ad_code'], 'http://') === false && strpos($row['ad_code'], 'https://') === false) ?
                        DATA_DIR . "/afficheimg/$row[ad_code]" : $row['ad_code'];
			
			
			return "<a href='" .$row["ad_link"]. "'
                target='_blank'><img src='$src' width='" .$row['ad_width']. "' height='$row[ad_height]'
                border='0' /></a>";				
			/*return "<a href='affiche.php?ad_id=$row[ad_id]&amp;uri=" .urlencode($row["ad_link"]). "'
                target='_blank'><img src='$src' width='" .$row['ad_width']. "' height='$row[ad_height]'
                border='0' /></a>";	*/
		}
		else
		{
		
				return "<a href='" .$row["ad_link"]. "'
                target='_blank'>" .htmlspecialchars($row['ad_code']). '</a>';
               /*return "<a href='affiche.php?ad_id=$row[ad_id]&amp;uri=" .urlencode($row["ad_link"]). "'
                target='_blank'>" .htmlspecialchars($row['ad_code']). '</a>';*/
		}
	 }
	 else
	 {
		return "";
	 }  
}

//require(ROOT_PATH . 'close.php'); //ecmoban模板堂 --zhuo

//加载模板补充文件 by wu start
if (isset($GLOBALS['_CFG']['template']) && in_array($GLOBALS['_CFG']['template'], $template_array)) {
    define('THEME_EXTENSION', true);
}
//加载模板补充文件 by wu end

//处理js
if (isset($smarty))
{
	$filename = str_replace('.php', '', basename(PHP_SELF));
	$file_languages = is_array($_LANG['js_languages'][$filename])? $_LANG['js_languages'][$filename]:array();
	$merge_js_languages = array_merge($_LANG['js_languages']['common'], $file_languages);
	$json_languages = json_encode($merge_js_languages);
	$smarty->assign('json_languages', $json_languages);
}
?>