/**
 * mim_action_panel
mim_message_panel

mim-friend-list
mim-user
mim-search-list
mim-search-input
mim-search-btn
mim-search-btn-add

mim-dialog
mim-dialog-title
mim-dialog-btn-minimize
mim-dialog-btn-close
mim-dialog-content
mim-dialog-btn-post
mim-dialog-post
mim-dialog-info
mim-dialog-person-name
mim-dialog-group-name
mim-dialog-group-content
mim-dialog-group-member
mim-dialog-btn-search
mim-dialog-btn-send-require

mim-dialog-chat-from
mim-dialog-chat
mim-dialog-chat-list
 */

var MIM = {};
MIM.Run = function(host, port){							//运行
	MIM.IO.Connect.Open(host, port);
	return true;
};

MIM.GetData = function(key){
	return MIM.Data[key];
};

/**
 * 对外开放接口
 * 登录
 * @param uid
 * @param password
 * @returns {Boolean}
 */
MIM.Login = function(uid, password){					//登录
	MIM.IO.Connect.Send('1', '1', {'uid':uid, 'password':password});
	return true;
};

/**
 * 对外开放接口
 * 使用token登录
 * @param token
 * @returns {Boolean}
 */
MIM.TokenLogin = function(token){						//使用token登录
	MIM.IO.Connect.Send('1', '7', {'token':token});
	return true;
};

/**
 * 对外开放接口
 * @returns {Boolean}
 */
MIM.Logout = function(){
	if(MIM.Data.token=='') return false;
	MIM.IO.Connect.Send('1', '2', {});
	return true;
};

/**
 * 对外开放接口
 * 修改密码
 * @param new_password
 * @returns {Boolean}
 */
MIM.ModifyPassword = function(new_password){				//修改密码
	if(MIM.Data.token=='' || new_password=='') return false;
	MIM.IO.Connect.Send('1', '4', {'password': new_password});
	return true;
};

/**
 * 对外开放接口
 * 修改资料
 * @param profile_data
 * @returns {Boolean}
 */
MIM.ModifyProfile = function(profile_data){					//修改资料
	if(MIM.Data.token=='' || !profile_data) return false;
	var profile = {};
	if(profile_data.name) profile.name = profile_data.name;
	if(profile_data.birthday) profile.birthday = profile_data.birthday;
	if(typeof profile_data.sex != 'undefined') profile.sex = profile_data.sex;
	if(typeof profile_data.content != 'undefined') profile.content = profile_data.content;
	if(typeof profile_data.phone != 'undefined') profile.phone = profile_data.phone;
	if(typeof profile_data.mail != 'undefined') profile.mail = profile_data.mail;
	if(profile_data.avatar) profile.name = profile_data.avatar;
	if($.isEmptyObject(profile)) return false;			//未找到修改的属性
	MIM.IO.Connect.Send('1', '3', unpacked_data);
	return true;
}

/**
 * 对外开放接口
 * 切换场景
 * @param scene_type
 * @param scene_id
 * @param mode
 * @returns {Boolean}
 */
MIM.SwitchScene = function(scene_type, scene_id, mode){
	if(MIM.Data.token=='') return false;
	MIM.IO.Connect.Send('1', '6', {'scene_type':scene_type, 'scene_id':scene_id, 'mode':!mode?false:true});
	return true;
};

/**
 * 对外开放接口
 * 客户端加载完成
 * @returns {Boolean}
 */
MIM.ClientReady = function(){
	if(MIM.Data.token=='') return false;
	MIM.IO.Connect.Send('1', '5', {});
	return true;
};

/**
 * 对外开放接口
 * 查找用户
 * @param search
 * @returns {Boolean}
 */
MIM.SearchUser = function(search){
	if(MIM.Data.token=='' || !search) return false;
	MIM.IO.Connect.Send('2', '1', {'search':search});
	return true;
};

/**
 * 对外开放接口
 * 请求添加好友
 * @param user_id
 * @returns {Boolean}
 */
MIM.SendFriendRequest = function(user_id){
	if(MIM.Data.token=='' || user_id=='') return false;
	MIM.IO.Connect.Send('2', '2', {'uid':user_id});
	return true;
};

/**
 * 对外开放接口
 * 批复添加好友
 * @param user_id
 * @param agree
 * @returns {Boolean}
 */
MIM.SendFriendResponse = function(user_id, agree){
	if(MIM.Data.token=='' || user_id=='') return false;
	MIM.IO.Connect.Send('2', '3', {'uid':user_id, 'confirm':!agree?false:true});
	return true;
};

/**
 * 对外开放接口
 * 获取好友列表
 * @returns {Boolean}
 */
MIM.GetMyFriends = function(){
	if(MIM.Data.token=='') return false;
	MIM.IO.Connect.Send('2', '4', {});
	return true;
};

/**
 * 对外开放接口
 * 获取指定好友的详情
 * @param friend_id
 * @returns {Boolean}
 */
MIM.GetFriendInfo = function(friend_id){
	if(MIM.Data.token=='' || friend_id=='') return false;
	MIM.IO.Connect.Send('2', '5', {'uid': friend_id});
	return true;
}

/**
 * 对外开放接口
 * 删除好友
 * @param user_id
 * @param forbidden
 * @returns {Boolean}
 */
MIM.DeleteFriend = function(user_id, forbidden){
	if(MIM.Data.token=='' || user_id=='' || user_id == MIM.Data.user_data.sid) return false;
	MIM.IO.Connect.Send('2', '6', {'uid':user_id, 'type':!forbidden?'0':'1'});
	return true;
};

/**
 * 对外开放接口
 * 查询群组
 * @param search
 * @returns {Boolean}
 */
MIM.SearchGroup = function(search){
	if(MIM.Data.token=='' || !search) return false;
	MIM.IO.Connect.Send('3', '1', {'search':search});
	return true;
};

/**
 * 对外开放接口
 * 请求加入群组
 * @param group_id
 * @returns {Boolean}
 */
MIM.SendGroupRequest = function(group_id){
	if(MIM.Data.token=='' || group_id=='') return false;
	MIM.IO.Connect.Send('3', '2', {'gid':group_id});
	return true;
};

/**
 * 对外开放接口
 * 批复加入群组
 * @param group_id
 * @param user_id
 * @param agree
 * @returns {Boolean}
 */
MIM.SendGroupResponse = function(group_id, user_id, agree){
	if(MIM.Data.token=='' || group_id=='' || user_id=='') return false;
	MIM.IO.Connect.Send('3', '3', {'gid':group_id, 'uid':user_id, 'confirm':!agree?false:true});
	return true;
};

/**
 * 对外开放接口
 * 获取群组列表
 * @returns {Boolean}
 */
MIM.GetMyGroups = function(){
	if(MIM.Data.token=='') return false;
	MIM.IO.Connect.Send('3', '4', {});
}

/**
 * 对外开放接口
 * 获取指定群组详情
 * @param group_id
 * @returns {Boolean}
 */
MIM.GetGroupInfo = function(group_id){
	if(MIM.Data.token=='' || group_id=='') return false;
	MIM.IO.Connect.Send('3', '5', {'gid':group_id});
	return true;
}

/**
 * 对外开放接口
 * 创建群组
 * @param group_name
 * @param member_id_list
 * @param group_content
 * @param max_member_count
 * @returns {Boolean}
 */
MIM.CreateGroup = function(group_name,member_id_list, group_content, max_member_count){
	if(MIM.Data.token=='' || group_name=='') return false;
	if(!group_content) group_content='';
	if(max_member_count == null) max_member_count = 0;
	if(!MIM.Utils.IsArray(member_id_list)) member_id_list = [];
	MIM.IO.Connect.Send('3', '9', {'group_name': group_name, 'group_content':group_content, 'max_count':max_member_count, 'member':member_id_list});
	return true;
};

/**
 * 对外开放接口
 * 退出群组
 * @param group_id
 * @returns {Boolean}
 */
MIM.QuitGroup = function(group_id){
	if(MIM.Data.token=='' || group_id=='') return false;
	MIM.IO.Connect.Send('3', '6', {'gid':group_id});
	return true;
};

/**
 * 对外开放接口
 * 解散群组
 * @param group_id
 * @returns {Boolean}
 */
MIM.DisbandGroup = function(group_id){
	if(MIM.Data.token=='' || group_id=='') return false;
	MIM.IO.Connect.Send('3', '7', {'gid':group_id});
	return true;
};

/**
 * 对外开放接口
 * 发送用户聊天
 * @param uid
 * @param message
 * @param type
 * @returns {Boolean}
 */
MIM.SendUserChat = function(uid, message, type){			//发送用户聊天消息
	if(MIM.Data.token=='' || message=='' || uid=='') return false;
	if(type == null) type=MIM.Utils.content_type.text;    //默认文本类型消息
	MIM.IO.Connect.Send('4', '1', {'uid':uid, 'content':message, 'content_type':type});
};

/**
 * 对外开放接口
 * 发送群组消息
 * @param group_id
 * @param message
 * @param type
 */
MIM.SendGroupChat = function(group_id, message, type){
	if(MIM.Data.token=='' || !group_id || !message) return false;
	if(type == null) type=MIM.Utils.content_type.text;    //默认文本类型消息
	MIM.IO.Connect.Send('4', '2', {'gid':group_id, 'content':message, 'content_type':type});
	return true;
};

/**
 * 对外开放接口
 * 好友聊天标记已读
 * @param chat_id_list
 * @returns {Boolean}
 */
MIM.DoneUserChat = function(chat_id_list){
	if(MIM.Data.token=='') return false;
	var data = {'list':[]};
	if(MIM.Utils.IsArray(chat_id_list)) data.list = chat_id_list;
	else data.list = [chat_id_list];
	if(data.list.length==0) return false;
	MIM.IO.Connect.Send('4', '12', data);
	return true;
};


/*
MIM.OpenGroupChat = function(group_id){			//打开群组对话框
	$dialog = MIM.Container.Core.Action.Get_Group_Dialog(group_id);
	if($dialog == null) MIM.Container.Core.Action.Create_Group_Dialog(group_id);
};
MIM.OpenUserChat = function(uid){					//打开用户对话框
	$dialog = MIM.Container.Core.Action.Get_User_Dialog(uid);
	if($dialog == null) MIM.Container.Core.Action.Create_User_Dialog(uid);
};
*/


/**
 * 添加事件侦听函数
 * @param event_id 事件id
 * @param fnCallback 回调函数
 * @param blnInput 是否服务器输入事件
 */
MIM.AddListen = function(event_id, fnCallback, blnIntput){
	if(blnIntput==null) blnIntput = true;
	if(event_id && (MIM.Utils.event_id_list.indexOf(event_id)>-1)){
		if(MIM.Utils.IsFunction(fnCallback)){
			if(blnIntput){
				//input event
				!MIM.Utils.IsArray(MIM.IO.Input.EventCallbackFunctionList[event_id])?MIM.IO.Input.EventCallbackFunctionList[event_id] = []:'';
				MIM.IO.Input.EventCallbackFunctionList[event_id].push(fnCallback);
			}else{
				//output event
				!MIM.Utils.IsArray(MIM.IO.Output.EventCallbackFunctionList[event_id])?MIM.IO.Output.EventCallbackFunctionList[event_id] = []:'';
				MIM.IO.Output.EventCallbackFunctionList[event_id].push(fnCallback);
			}
			return true;
		}else return false;
	}else return false;
}
/*---------------------------------------------------Utils------------------------------------------------------------------*/
MIM.Utils = {};				//工具函数
MIM.Utils.api_map = {				//接口api列表
	'1':{'1':'login', '2':'logout', '3':'user_info_modify', '4':'user_password_modify', '6':'switch_scene', '7':'token_login'},
	'2':{'1':'friend_search', '2':'friend_add_require', '3':'friend_add_response', '4':'my_friend_list', '5':'my_friend_info', '6':'friend_delete', '7':'friend_status'},
	'3':{'1':'group_search', '2':'group_add_require', '3':'group_add_response', '4':'my_group_list', '5':'my_group_info', '6':'group_quit', '7':'group_disband', '8':'group_member_status', '9':'group_create'},
	'4':{'1':'user_chat', '2':'group_chat', '3':'notice_list', '4':'notice_done', '5':'user_chat_log_by_date', '6':'user_chat_log_by_count', '7':'user_chat_log_search', '8':'group_chat_log_by_date', '9':'group_chat_log_by_count', '10':'group_chat_log_search', '11':'all_unread_chat', '12':'chat_done'}
};
MIM.Utils.separator = 's';				//分隔符
MIM.Utils.friend_scene_type = '3';					//好友场景类型
MIM.Utils.group_scene_type = '2';					//群组场景类型
MIM.Utils.IsArray = function(obj){
	return Object.prototype.toString.call(obj) === '[object Array]'; 
};
MIM.Utils.IsFunction = function(obj){
	return Object.prototype.toString.call(obj)==='[object Function]';
};
MIM.Utils.content_type = {'text':1, 'image':2, 'file':3};

/*
MIM.Utils.dialog_position = 'fixed';				//对话框
MIM.Utils.dialog_position_left = '30%';
MIM.Utils.dialog_position_top = '100px';
MIM.Utils.search_user_scene_key = 'search_user';
MIM.Utils.search_group_scene_key = 'search_group';
MIM.Utils.add_group_scene_key = 'add_group';
*/
MIM.Utils.event_id_list = [					//系统内置事件id列表
	'login', 'logout', 'user_info_modify', 'user_password_modify', 'switch_scene', 'token_login',
	'friend_search', 'friend_add_require', 'friend_add_response', 'my_friend_list', 'my_friend_info', 'friend_delete', 'friend_status',
	'group_search', 'group_add_require', 'group_add_response', 'my_group_list', 'my_group_info', 'group_quit', 'group_disband', 'group_member_status', 'group_create',
	'user_chat', 'group_chat', 'all_unread_chat', 'chat_done', 'notice_list', 'notice_done',
	'user_chat_log_by_date', 'user_chat_log_by_count', 'user_chat_log_by_search',
	'group_chat_log_by_date', 'group_chat_log_by_count', 'group_chat_log_by_search'
];
MIM.Utils.search_type = {'friend':'1', 'group':'2'};				//搜索内容类型
MIM.Utils.Get_Friend_Scene_Key = function(id){				//获取好友场景key
	return MIM.Utils.friend_scene_type+MIM.Utils.separator+id;
};
MIM.Utils.Get_Group_Scene_Key = function(id){				//获取群组场景key
	return MIM.Utils.group_scene_type+MIM.Utils.separator+id;
};

MIM.Utils.language = {};				//语言包
MIM.Utils.language['zh-cn'] = {				//简体中文
	'mim-btn-search-add' : '添加',
	'mim-btn-search' : '查询',
	'mim-label-search-key' : '关键字',
	'mim-btn-open-search-user' : '查询用户',
	'mim-btn-open-search-group' : '查询群组',
	'mim-txt-still-searching' : '正在查询...',
	'mim-txt-no-search-result' : '未搜索到信息',
	'mim-txt-message-already-send' : '消息已经发送成功',
	'mim-label-add-group' : '创建群组',
	'group_name' : '群组名称',
	'max_count_of_group_member' : '成员上限',
	'group_content' : '群组描述',
	'group_member' : '群组成员',
	'clear_all' : '全部移除',
	'clear' : '移除',
	'my_friend_list' : '我的好友',
	'add_to_group' : '添加',
	'create_group' : '创建'
};
/**/
/*---------------------------------------------------Data------------------------------------------------------------------*/
MIM.Data = {};				//内置数据
MIM.Data.token ='';				//用户登录会话
MIM.Data.temporary_uid = '';				//临时uid
MIM.Data.temporary_gid = '';				//临时群组id
MIM.Data.user_data = {};				//当前用户的个人数据
MIM.Data.friend_list = {};				//当前用户的好友列表
MIM.Data.group_list = {};				//当前用户的群组列表
MIM.Data.scene_list = {};				//当前用户已经开启的场景列表
MIM.Data.user_chat_list = {};				//当前用户的未读消息列表
MIM.Data.init = function(){				//初始化当前用户数据
	this.friend_list = {};
	this.group_list = {};
	MIM.Data.notice_list = {};				//当前用户的提醒消息列表
	MIM.Data.notice_list[MIM.Utils.search_type.friend] = {};
	MIM.Data.notice_list[MIM.Utils.search_type.group] = {};
	this.scene_list = {};
	this.user_chat_list = {};
	return true;
};
MIM.Data.language = 'zh-cn';				//当前用户的语言包设置
/*---------------------------------------------------IO------------------------------------------------------------------*/
MIM.IO = {};				//IO函数

//IO连接
MIM.IO.Connect = {
	'ws':null,
	'Open':function(host, port){				//连接
		this.ws = new WebSocket('ws://'+host+':'+port);
		this.ws.onopen = function(){
			if(MIM.Utils.IsFunction(MIM.OnOpen)) MIM.OnOpen();
		},
		this.ws.onmessage = function(e){				//接收到服务器输入消息
			var unpacked_message = MIM.IO.Input.MessageParser(e.data);				//解密消息
			if(!unpacked_message) return false;
			var api_name = MIM.Utils.api_map[unpacked_message['mod']][unpacked_message['action']];				//获取消息id
			//匹配到与消息id对应的系统内置函数,并运行
			if(MIM.Utils.IsFunction(MIM.IO.Input.Listen[api_name]) && MIM.IO.Input.Listen[api_name](unpacked_message.data, unpacked_message.error) == true){
				//尝试查找用户绑定与消息id对应的处理函数,并运行
				if(MIM.Utils.IsArray(MIM.IO.Input.EventCallbackFunctionList[api_name])){				//自定义函数数组
					for(var i=0; i<MIM.IO.Input.EventCallbackFunctionList[api_name].length; i++){
						MIM.IO.Input.EventCallbackFunctionList[api_name][i](unpacked_message.data, unpacked_message.error);				//依次运行自定义函数
					}
				}
			}
		}
		this.ws.onclose = function(){				//关闭连接
			//MIM_Container_Action.logout();
		};
	},
	'Send':function(mod_id, action_id, unpacked_data){				//向服务器发送消息
		var packed_message = MIM.IO.Output.MessageParser(mod_id, action_id, unpacked_data);				//加密消息
		this.ws.send(packed_message);				//发送
		var api_name = MIM.Utils.api_map[mod_id][action_id];				//获取消息id
		//匹配到与消息id对应的系统内置函数,并运行
		if(MIM.Utils.IsFunction(MIM.IO.Output.Listen[api_name])){
			//尝试查找用户绑定与消息id对应的处理函数,并运行
			
		}
		if(MIM.Utils.IsArray(MIM.IO.Output.EventCallbackFunctionList[api_name])){				//自定义函数数组
			for(var i=0; i<MIM.IO.Output.EventCallbackFunctionList[api_name].length; i++){
				MIM.IO.Output.EventCallbackFunctionList[api_name][i](unpacked_data);				//依次运行自定义函数
			}
		}
		return true;
	}
};

MIM.IO.Input = {};			//服务器输入
MIM.IO.Input.MessageParser = function(server_data){				//输入消息解析器
	//console.log(server_data);
	var oData = $.parseJSON(server_data);
	if(oData) return {'version':oData.v, 'client_id':oData.c, 'date_time':oData.dt, 'mod':oData.m.m, 'action':oData.m.a, 'error':oData.m.e, 'data':oData.m.d};
	else return false;
};
MIM.IO.Input.Listen = {};				//系统内置的输入事件
MIM.IO.Input.EventCallbackFunctionList = {};				//外部绑定的监听事件回调函数列表

/**
 * 服务器反馈
 * 登录验证事件
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.login = function(data, error){
	if(error && error!='') return false;
	MIM.Data.user_data = data.user;
	MIM.Data.token = data.token;
	MIM.Data.init();
	return true;
};

/**
 * 服务器反馈
 * 注销会话
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.logout = function(data, error){
	if(error && error!='') return false;
	MIM.Data.user_data = {};
	MIM.Data.token = '';
	MIM.Data.init();
	return true;
};

/**
 * 服务器反馈
 * 修改用户信息
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.user_info_modify = function(data, error){
	if(error && error!='') return false;
	MIM.Data.user_data = data.user;
	return true;
};

/**
 * 服务器反馈
 * 修改用户密码
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.user_password_modify = function(data, error){
	if(error && error!='') return false;
	else return true;
};

/**
 * 服务器反馈
 * 场景切换
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.switch_scene = function(data, error){
	if(error && error!='') return false;
	if(data.status == false) delete MIM.Data.scene_list[data.scene_type+MIM.Utils.separator+data.scene_id];
	else MIM.Data.scene_list[data.scene_type+MIM.Utils.separator+data.scene_id] = {'create_time':'', 'message_count':0};
	return true;
};

/**
 * 服务器反馈
 * 搜索好友
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.friend_search = function(data, error){
	if(error && error!='') return false;
	return true;
};

/**
 * 服务器反馈
 * 添加好友请求
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.friend_add_require = function(data, error){
	if(error && error!='') return false;
	if(data.status=='1'){
		MIM.Data.friend_list[data.user.sid] = data.user;
	}
	return true;
};

/**
 * 服务器反馈
 * 好友添加回复
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.friend_add_response = function(data, error){
	if(error && error!='') return false;
	MIM.Data.notice_list[MIM.Utils.search_type.friend][data.faid] = data;
	return true;
};

/**
 * 服务器反馈
 * 我的好友列表
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.my_friend_list = function(data, error){
	if(error && error!='') return false;
	MIM.Data.friend_list = {};
	$.each(data.list, function(i, e){MIM.Data.friend_list[e.sid] = e;});
	return true;
};

/**
 * 服务器反馈
 * 我的好友详情
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.my_friend_info = function(data, error){
	if(error && error!='') return false;
	MIM.Data.friend_list[data.user.sid] = data.user;
	return true;
};

/**
 * 服务器反馈
 * 删除好友
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.friend_delete = function(data, error){
	if(error && error!='') return false;
	delete  MIM.Data.friend_list[data.uid];
	return true;
};

/**
 * 服务器反馈
 * 好友在线状态
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.friend_status = function(data, error){
	if(error && error!='') return false;
	MIM.Data.friend_list[data.uid].status = data.status;
	return true;
};

/**
 * 服务器反馈
 * 群组搜索 
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_search = function(data, error){
	if(error && error!='') return false;
	return true;
};

/**
 * 服务器反馈
 * 加入群组申请
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_add_require = function(data, error){
	if(error && error!='') return false;
	if(data.status=='1'){
		if(MIM.Data.group_list[data.group.id] != null && MIM.Data.group_list[data.group.id]['user_list']) MIM.Data.group_list[data.group.id]['user_list'][data.user.sid] = data.user;
		else MIM.Data.group_list[data.group.id] = data.group;
	}
	return true;
};

/**
 * 服务器反馈
 * 加入群组反馈
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_add_response = function(data, error){
	if(error && error!='') return false;
	MIM.Data.notice_list[MIM.Utils.search_type.group][data.gaid] = data;
	return true;
};

/**
 * 服务器反馈
 * 我的群组列表
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.my_group_list = function(data, error){
	if(error && error!='') return false;
	MIM.Data.group_list = {};
	$.each(data.list, function(i, e){
		MIM.Data.group_list[e.id] = e
		MIM.Data.group_list[e.id]['load'] = false;
	});
	return true;
};

/**
 * 服务器反馈
 * 群组详情
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.my_group_info = function(data, error){
	if(error && error!='') return false;
	MIM.Data.group_list[data.group.id] = {};
	$.each(data.group, function(key, val){
		if(key=='user_list'){
			MIM.Data.group_list[data.group.id][key] = {};
			$.each(val, function(i, e){
				MIM.Data.group_list[data.group.id][key][e.sid] = e;
			});
		}else MIM.Data.group_list[data.group.id][key] = val;
	});
	MIM.Data.group_list[data.group.id].load = true;
	return true;
};

/**
 * 服务器反馈
 * 退出群组
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_quit = function(data, error){
	if(error && error!='') return false;
	if(data.uid == MIM.Data.user_data.sid){
		delete MIM.Data.group_list[data.gid];
	}else{
		delete MIM.Data.group_list[data.gid]['user_list'][data.user.sid];
	}
	return true;
};

/**
 * 服务器反馈
 * 解散群组
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_disband = function(data, error){
	if(error && error!='') return false;
	delete MIM.Data.group_list[data.gid];
	return true;
};

/**
 * 服务器反馈
 * 群组成员状态
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_member_status = function(data, error){
	if(error && error!='') return false;
	if(MIM.Data.group_list[data.gid]['user_list']) MIM.Data.group_list[data.gid]['user_list'][data.uid]['status'] = data.status;
	return true;
};

/**
 * 服务器反馈
 * 创建群组
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_create = function(data, error){
	if(error && error!='') return false;
	MIM.Data.group_list[data.group.id] = {};
	$.each(data.group, function(key, val){
		if(key=='user_list'){
			MIM.Data.group_list[data.group.id][key] = {};
			$.each(val, function(i, e){
				MIM.Data.group_list[data.group.id][key][e.sid] = e;
			});
		}else MIM.Data.group_list[data.group.id][key] = val;
	});
	MIM.Data.group_list[data.group.id].load = true;
	return true;
};

/**
 * 服务器反馈
 * 发送用户聊天
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.user_chat = function(data, error){
	if(error && error!='') return false;
	var key;
	if(data.from == MIM.Data.user_data.sid) key = data.to;
	else if(data.to == MIM.Data.user_data.sid) key = data.from;
	var D = data;
	D.read = '0';
	if(!MIM.Data.user_chat_list[key]) MIM.Data.user_chat_list[key] = [D];
	else MIM.Data.user_chat_list[key].push(D);
	return true;
};

/**
 * 服务器反馈
 * 发送群组聊天
 * @param data
 * @param error
 * @returns {Boolean}
 */
MIM.IO.Input.Listen.group_chat = function(data, error){
	if(error && error!='') return false;
	return true;
};


MIM.IO.Output = {};			//客户端输出
MIM.IO.Output.MessageParser = function(mod, action, param){			//输出消息解析器
	return JSON.stringify({'v':'1.0.0', 'c':'001', 'dt':'', 't':MIM.Data.token, 'm':{'m':mod, 'a':action, 'd':param}});
};
MIM.IO.Output.Listen ={};				//系统内置的输出事件
MIM.IO.Output.EventCallbackFunctionList = {};				//外部绑定的监听事件回调函数列表

//===========================jquery扩展插件,用于处理剪切板粘贴图片================================
;(function($){
	$.fn.extend({
		'clipboard_paste_img':function(oSettings){
			this[0].addEventListener('paste', function(e){
				var clipboard = e.clipboardData;
				var img_blobs = [];
				if(clipboard){
					for(var i=0; i<clipboard.items.length; i++){
						var item = clipboard.items[i];
						if(item.type.match(/image/)){
							img_blobs.push(item.getAsFile());
						}
					}
					var img_sources = [];
					for(var i=0; i<img_blobs.length; i++){
						var file = new FileReader();
						file.addEventListener('loadend', function(e){
							console.log(e);
							img_sources.push(e.target.result);
							if(i>=img_blobs.length){
								//粘贴图片全部获取完毕,触发回调
								if($.isFunction(oSettings.callback)){
									console.log(11);
									oSettings.callback(img_sources);
								}
							}
						});
						file.readAsDataURL(img_blobs[i]);
					}
				}
			});
		}
	});
})(jQuery,this);