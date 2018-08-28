<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

$lang['moouser']='用户信息';
$lang['moouser_label_uid']='用户UID';
$lang['moouser_label_pwd']='用户密码';
$lang['moouser_label_confirm_pwd']='密码确认';
$lang['moouser_label_name']='姓名';
$lang['moouser_label_sex']='性别';
$lang['moouser_label_sex_boy']='男';
$lang['moouser_label_sex_girl']='女';
$lang['moouser_label_img']='头像';
$lang['moouser_label_status']='状态';
$lang['moouser_label_status_1']='激活';
$lang['moouser_label_status_0']='冻结';
$lang['moouser_label_status_true']='激活';
$lang['moouser_label_status_false']='冻结';
$lang['moouser_label_birthdate']='出生日期';
$lang['moouser_label_email']='邮箱';
$lang['moouser_label_phone']='联系方式';
$lang['moouser_label_content']='备注';
$lang['moouser_label_action']='操作';
$lang['moouser_label_is_main']='主账户';
$lang['moouser_label_yes']='是';
$lang['moouser_label_no']='否';

$lang['moouser_btn_confirm']='确定';
$lang['moouser_btn_cancel']='取消';
$lang['moouser_btn_add']='创建';
$lang['moouser_btn_edit']='编辑';
$lang['moouser_btn_del']='删除';
$lang['moouser_btn_return']='返回';
?>