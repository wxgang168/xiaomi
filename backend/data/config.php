<?php
// database host
// $db_host   = "127.0.0.1";
// // database name
// $db_name   = "xmshangcheng";
// // database username
// $db_user   = "root";
// // database password
// $db_pass   = "root";
// // table prefix
// $prefix    = "ecs_";
// $timezone    = "PRC";
// $cookie_path    = "/";
// $cookie_domain    = "";
// $session = "1440";
// define('EC_CHARSET', 'utf-8');
define('ADMIN_PATH','admin');
// define('SELLER_PATH','seller');
// define('STORES_PATH','stores');
// define('CACHE_MEMCACHED',0);
// define('AUTH_KEY', 'this is a key');
// define('OLD_AUTH_KEY', '');
// define('API_TIME', '');
// define('EC_TEMPLATE', 'xiaomi');
//define('FRONT_CONFIG', str_replace('\\', '/', str_replace('xiaomi_bak', '', __FILE__)));
require_once(str_replace('/backend', '', str_replace('\\', '/', __FILE__)));
?>