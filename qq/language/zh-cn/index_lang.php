<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

$lang['index_text_boy']='男';
$lang['index_text_girl']='女';
$lang['index_text_status_true']='启用';
$lang['index_test_status_false']='禁用';

$lang['index_label_user']='用户信息';
$lang['index_label_account']='账户';
$lang['index_label_title']='个人信息';
$lang['index_label_name']='姓名';
$lang['index_label_sex']='性别';
$lang['index_label_email']='邮箱';
$lang['index_label_birthdate']='出生日期';
$lang['index_label_phone']='联系方式';

$lang['index_label_uid']='UID';
$lang['index_label_pwd']='用户密码';
$lang['index_label_confirm_pwd']='密码确认';
$lang['index_label_username']='昵称';
$lang['index_label_img']='头像';
$lang['index_label_status']='状态';
$lang['index_label_status_1']='激活';
$lang['index_label_status_0']='冻结';
$lang['index_label_content']='介绍';
$lang['index_label_is_main']='主账户';
$lang['index_label_yes']='是';
$lang['index_label_no']='否';
$lang['index_label_is_use']='启用';
$lang['index_label_editpwd']='修改密码';

$lang['index_btn_confirm']='确定';
$lang['index_btn_cancel']='取消';
$lang['index_btn_edit']='编辑';
$lang['index_btn_del']='删除';
$lang['index_btn_edit_moo']='编辑用户';
$lang['index_btn_edit_pwd']='修改密码';
$lang['index_btn_add_account']='添加账户';
$lang['index_btn_ckeckin']='上班';
$lang['index_btn_checkout']='下班';
$lang['index_btn_select']='选择';
$lang['index_btn_change']='替换';
$lang['index_btn_use_account']='切换';

?>