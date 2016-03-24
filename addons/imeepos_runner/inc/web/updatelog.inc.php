<?php
//更新日志
global $_W,$_GPC;
$return = array();
$return['status'] = 0;
if(empty($_W['isfounder'])) {
  $return['message'] = '您没有相应操作权限';
  die(json_encode($return));
}
$ip = gethostbyname($_SERVER['SERVER_ADDR']);
$domain = $_SERVER['HTTP_HOST'];
$setting = setting_load('site');
$id = isset($setting['site']['key'])? $setting['site']['key'] : '1';

$auth = getAuthSet($this->modulename);
load()->func('communication');

$resp =ihttp_post('http://meepo.com.cn/meepo/module/log.php',array('ip'=>$ip,'id'=>$id,'domain'=>$domain,'module'=>$this->modulename));

$content = object_to_array(json_decode($resp['content']));
$status = intval($content['status']);
$message = trim($content['message']);

$return['status'] = 1;
$return['message'] = $message;
$logs = object_to_array(json_decode($content['logs']));
$syslogs = object_to_array(json_decode($content['syslogs']));
ob_start();
include $this->template('updatelog');
$data = ob_get_contents();
ob_clean();
die($data);
?>
