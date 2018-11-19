<?php
//牛模式采集插件:http://niumos.com/(淘宝店：new-modle.taobao.com QQ：303441162)
	$sql = "SELECT api_data FROM " . $ecs->table('sharegoods_module') . " WHERE class = 'taobao'";
	$vo = $db->getOne($sql);
	$vo = unserialize($vo);
	$code_tdj=$vo['code_tdj'];
	$smarty->assign('code_tdj',$code_tdj);
//牛模式采集插件:http://niumos.com/(淘宝店：new-modle.taobao.com QQ：303441162)-end

?>