<?php
/**
 * 逻辑映射
 */

$logic_map_config  = array();

/*
$logic_map_config['0'] = array(
		'name'=>'',							//mod类名称
		'action'=>array(
				'0'=>array(					//action编号			
						'name'=>'',			//action函数名称
						'run_in_background'=>false,			//此函数是否必须后台运行(即是否只能被action触发,不能通过request触发)
						'input_log'=>true,						//是否存储输入日志
						'output_log'=>true						//是否存储输出日志
						)
		);
*/

$logic_map_config['1'] = array(					//系统逻辑
		'name' => 'Sys',
		'action' => array(
				'1' => array(						//登录
						'name' => 'login',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'2' => array(						//注销
						'name' => 'logout',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'3' => array(						//修改个人信息
						'name' => 'user_info_modify',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'4' => array(						//修改密码
						'name' => 'user_password_modify',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'5' => array(						//客户端初始化加载完毕
						'name' => 'index_ready',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'6' => array(						//切换对话场景
						'name' => 'switch_scene',
						'run_in_background' => true,
						'input_log' => true,
						'output_log' => true
						),
				'7' => array(						//使用token登录
						'name' => 'login_by_token',
						'run_in_background' => true,
						'input_log' => true,
						'output_log' => true
						),
				)
		);

$logic_map_config['2'] = array(					//好友管理
		'name' => 'Friend',
		'action' => array(
				'1' => array(						//所搜好友
						'name' => 'friend_search',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'2' => array(						//请求添加对方为好友
						'name' => 'friend_add_require',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'3' => array(						//处理对方添加自己为好友的请求
						'name' => 'friend_add_response',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'4' => array(						//我的好友列表
						'name' => 'my_friend_list',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'5' => array(						//我的好友详情
						'name' => 'my_friend_info',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'6' => array(						//删除好友
						'name' => 'friend_delete',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'7' => array(						//好友状态改变
						'name' => 'friend_status',
						'run_in_background' => true,
						'input_log' => true,
						'output_log' => true
						)
				)
		);

$logic_map_config['3'] = array(					//群组管理
		'name' => 'Group',
		'action' => array(
				'1' => array(						//查询群组
						'name' => 'group_search',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'2' => array(						//请求加入群组
						'name' => 'group_add_require',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'3' => array(						//申请加入群组的批复
						'name' => 'group_add_response',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'4' => array(						//我的群组列表
						'name' => 'my_group_list',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'5' => array(						//群组详细信息
						'name' => 'my_group_info',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'6' => array(						//退出群组
						'name' => 'group_quit',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'7' => array(						//解散群组
						'name' => 'group_disband',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'8' => array(						//群组成员在线状态
						'name' => 'group_member_status',
						'run_in_background' => true,
						'input_log' => true,
						'output_log' => true
						),
				'9' => array(						//创建群组
						'name' => 'group_create',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						)
				)
		);

$logic_map_config['4'] = array(					//消息
		'name' => 'Chat',
		'action' => array(
				'1' => array(						//用户私聊
						'name' => 'user_chat',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'2' => array(						//群组聊天
						'name' => 'group_chat',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'3' => array(						//提醒列表
						'name' => 'notice_list',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'4' => array(						//提醒已处理
						'name' => 'notice_done',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'5' => array(						//按日期查询用户私聊记录
						'name' => 'user_chat_log_by_date',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'6' => array(						//按数量查询用户私聊记录
						'name' => 'user_chat_log_by_count',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'7' => array(						//关键字搜索私聊记录
						'name' => 'user_chat_log_search',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'8' => array(						//按日期查询群组聊天记录
						'name' => 'group_chat_log_by_date',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'9' => array(						//按数量查询群组聊天记录
						'name' => 'group_chat_log_by_count',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'10' => array(						//关键字搜索群组聊天记录
						'name' => 'group_chat_log_search',
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						),
				'11' => array(
						'name' => 'all_unread_chat',				//获取所有未读消息
						'run_in_background' => true,
						'input_log' => true,
						'output_log' => true
						),
				'12' => array(
						'name' => 'chat_done',				//消息已读
						'run_in_background' => false,
						'input_log' => true,
						'output_log' => true
						)
				)
		);
?>