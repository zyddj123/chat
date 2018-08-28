<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

$lang['user']='用户信息';
$lang['user_label_uid']='用户UID';
$lang['user_label_pwd']='用户密码';
$lang['user_label_confirm_pwd']='密码确认';
$lang['user_label_name']='姓名';
$lang['user_label_sex']='性别';
$lang['user_label_sex_boy']='男';
$lang['user_label_sex_girl']='女';
$lang['user_label_img']='头像';
$lang['user_label_status']='状态';
$lang['user_label_status_true']='启用';
$lang['user_label_status_false']='禁用';
$lang['user_label_email']='邮箱';
$lang['user_label_phone']='联系方式';
$lang['user_label_content']='备注';
$lang['user_label_action']='操作';

$lang['user_btn_confirm']='确定';
$lang['user_btn_cancel']='取消';
$lang['user_btn_add']='创建';
$lang['user_btn_edit']='编辑';
$lang['user_btn_del']='删除';

?>