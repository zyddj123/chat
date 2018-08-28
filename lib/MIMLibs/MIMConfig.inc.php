<?php
/**
 * MIM配置类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.0
 */

class MIMConfig{
	
	/************数据库表**************/
	const _table_mim_user = 'T_MIM_USER';						//用户表
	const _table_mim_group = 'T_MIM_GROUP';					//群组表
	const _table_mim_group_user = 'T_MIM_GROUP_USER';					//群组与用户关联表
	const _table_mim_user_friend = 'T_MIM_USER_FRIEND';					//用户好友表
	const _table_mim_user_client = 'T_MIM_USER_CLIENT';						//用户sock状态表
	const _table_mim_chat_record = 'T_MIM_CHAT_RECORD';				//聊天记录
	const _table_mim_notice = 'T_MIM_NOTICE';				//消息提醒表
	const _table_mim_friend_action = 'T_MIM_FRIEND_ACTION';			//好友添加删除操作表
	const _table_mim_group_action = 'T_MIM_GROUP_ACTION';			//群组操作表
	
	const _group_max_user = 20;				//群组内最大用户数量
	
	//文件上传路径
	const _path_upload = 'upload_file';
	
	//文件根路径
	const _root_path = ROOT_PATH;
	const _root_host = '../';
	
	const _token_file_path = '/var/www/html/chat/chat/Applications/web/token';
	
	const _path_avatar = 'upload_file';
	
	//消息类型
	const _type_content_text = 1;
	const _type_content_image = 2;
	const _type_content_file = 3;
	
	/*------------------------------异常信息-------------------------------*/
	const _err_code_invalid_group_sid = 8001001;
	const _err_msg_invalid_group_sid = 'invalid group sid';
	
	const _err_code_invalid_user_sid = 8001002;
	const _err_msg_invalid_user_sid = 'invalid user sid';
	
}
?>