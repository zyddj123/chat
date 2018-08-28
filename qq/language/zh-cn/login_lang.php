<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

$lang['login_test_uid_null']='*用户UID不能为空';
$lang['login_test_pwd_null']='*密码不能为空';
$lang['login_test_uid_format']='*UID格式错误';
$lang['login_test_sql_error']='*用户名或密码错误，或者用户不存在';

$lang['login_label_title']='欢迎使用';
$lang['login_label_uid']='用户UID';
$lang['login_label_pwd']='密码';
$lang['login_label_prompt']='请输入您的信息';
$lang['login_button_login']='登　录';
?>