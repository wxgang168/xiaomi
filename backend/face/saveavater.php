<?php
//session_start();

$rs = array();

switch($_GET['action']){

	//�ϴ���ʱͼƬ
	case 'uploadtmp':
		$file = 'uploadtmp.jpg';
		@move_uploaded_file($_FILES['Filedata']['tmp_name'], $file);
		$rs['status'] = 1;
		$rs['url'] = './php/' . $file;
	break;

	//�ϴ���ͷ��
	case 'uploadavatar':
		$input = file_get_contents('php://input');
		$data = explode('--------------------', $input);
		@file_put_contents('./source_img/sorce_'.uniqid().'.jpg', $data[0]);
		@file_put_contents('./thumb_img/thumb_'.uniqid().'.jpg', $data[1]);
		$rs['status'] = 1;
	break;

	default:
		$rs['status'] = -1;
}

print json_encode($rs);

?>
