<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA配置类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

class MOAConfig{
	
	/************数据库表**************/
	const _table_moa_user = 'T_MOA_USER';/*用户表*/
	const _table_moa_pwd = 'T_MOA_PWD';/*密码名文表*/
	const _table_moa_group = 'T_MOA_GROUP';/*研究组*/
	const _table_moa_group_user = 'T_MOA_GROUP_USER';/*组成员表*/
	const _table_moa_role = 'T_MOA_ROLE';/*角色*/
	
	const _table_moa_action='T_MOA_ACTION';/*操作*/
	const _table_session = 'T_MOA_SESSION';/*session表*/
	const _table_moa_topic='T_MOA_COMMENT_TOPIC';/*讨论帖表*/
	const _table_moa_mail_inbox='T_MOA_MAIL_INBOX';/*站内信收件箱表*/
	const _table_moa_mail_outbox='T_MOA_MAIL_OUTBOX';/*站内信发件箱表*/
	const _table_moa_mail_setting='T_MOA_MAIL_SETTING';/*站内信设置*/
	

	const _table_department = 'T_MOA_DEPARTMENT'; /*专业表*/
	const _table_category ='T_MOA_CATEGORY';/*所属类别表*/
	const _table_type = 'T_MOA_TYPE'; /*资源类型*/
	const _table_class='T_MOA_CLASS';/*班级配置表*/
	
	const _table_moa_attendance = 'T_MOA_ATTENDANCE'; /*考勤签到表*/
	
	const _table_moa_task = 'T_MOA_TASK';/*任务表*/
	const _table_moa_task_user = 'T_MOA_TASK_USER';/*任务人员表*/
	const _table_moa_task_milestone = 'T_MOA_TASK_MILESTONE';/*任务里程碑表*/
	const _table_moa_task_milestone_user = 'T_MOA_TASK_MILESTONE_USER';/*里程碑人员表*/
	
	const _table_chat_group = 'CHAT_GROUP';/*聊天组表*/
	const _table_chat_group_user = 'CHAT_USER_GROUP';/*聊天组用户表*/
	
	const _table_moa_task_chat = 'T_MOA_TASK_CHAT';						//任务(里程碑)与mim组件集成的聊天关联表
	const _table_moa_notice = 'T_MOA_NOTICE';//站内通知表
	const _table_moa_notice_user = 'T_MOA_NOTICE_USER';//通知接收用户表
	
	/****上传文件常量****/
	const _upload_user_path= '/user';
	const _upload_group_path = '/group';
	
	//文件上传路径
	const _path_upload = 'upload_file';
	
	//文件根路径
	//const _root_path = '/var/www/html/mf_upload';
	//const _root_host = '/mf_upload';
	
	const _root_path = ROOT_PATH;
	const _root_host = '..';
	
	/***权限设置****/
	/*
	static $action = array(
			'system'=>array('group_action'=>'研究组权限','user_action'=>'用户权限','information_action'=>'信息设置权限')
			);
	*/
	/***权限设置***/
	static $action = array(
			'group'=>array(
					'moa_action_group_add',
					'moa_action_group_edit',
					'moa_action_group_del',
					'moa_action_group_media',
					'moa_action_group_user'
					),
			'task'=>array(
					'moa_action_task_add',
					'moa_action_task_edit',
					'moa_action_task_del',
					'moa_action_task_media',
					'moa_action_task_chat',
					'moa_action_task_user'
					),
			'milestone'=>array(
					'moa_action_milestone_add',
					'moa_action_milestone_edit',
					'moa_action_milestone_del',
					'moa_action_milestone_chat',
					'moa_action_milestone_media',
					'moa_action_milestone_user'
					),
			'user'=>array(
					'moa_action_user_add',
					'moa_action_user_edit',
					'moa_action_user_del'
					)
			);
	
	static $notice = array(
			'1'=>'moa_notice_1',
			'2'=>'moa_notice_2',
			'3'=>'moa_notice_3');
	
	/*--------------常量路径-------------------*/
	const _path_teacher = 'teacher';
	const _path_student = 'student';
	const _path_group = 'group';
	
	//起始年级
	const _year_begin = 2010;
	
	//班级最大号
	const _class_max_num	= 10;
	
	
	/*------------------------------异常信息-------------------------------*/
	//非法文件sid
	/*研究组*/
	const _err_code_invalid_group_sid = 7001001;
	const _err_msg_invalid_group_sid = 'invalid group sid';
	
	/*讨论帖*/
	const _err_code_invalid_topic_sid = 7002001;
	const _err_msg_invalid_topic_sid = 'invalid topic sid';
	
	/*任务*/
	const _err_code_invalid_task_sid = 7003001;
	const _err_msg_invalid_task_sid = 'invalid task sid';
	
	/*站内信*/
	const _err_code_invalid_mail_id = 7004001;
	const _err_msg_invalid_mail_id = 'invalid mail id';
	
	/*用户*/
	const _err_code_invalid_user_id = 7005001;
	const _err_msg_invalid_user_id = 'invalid user sid';
	
	/*考勤*/
	const _err_code_invalid_attendance_sid = 7006001;
	const _err_msg_invalid_attendance_sid = 'invalid attendance sid';
		
	/*里程碑*/
	const _err_code_invalid_milestone_sid = 7007001;
	const _err_msg_invalid_milestone_sid ='invalid milestone sid';
	
	/*角色*/
	const _err_code_invalid_role_sid = 7008001;
	const _err_msg_invalid_role_sid='invalid role sid';
	
	/*通知*/
	const _err_code_invalid_notice_sid = 7009001;
	const _err_msg_invalid_notice_sid = 'invalid notice sid';
}
?>