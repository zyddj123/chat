var _window_type = false;
$(function() {
	$(window).resize(function() {
		if ($(window).width() < 991) {
            _window_type = true; //小窗
        } else {
            _window_type = false; //展开
        }
    });

	if (MIM) {
		MIM.AddListen('login', function(d, e) {
            //登录
            MIM.ClientReady();
            $("#own_name").html(d.user.name + '<img src="' + _THEMES_HOST + '/assets/images/icon/head.png" alt="" />');
            $(".own_img").attr('src', d.user.avatar).attr('title', d.user.name);
            // $("#own_numb").text(d.user.id);
            // $("#email").text(d.user.email);
        });

		MIM.AddListen('logout', function(d, e) {
            //退出
            window.location.href = _REQUEST_HOST + '/login';
        });

		MIM.AddListen('my_friend_list', function(d, e) {
            //好友列表
            _fnFriendsList();

        });

		MIM.AddListen('my_group_list', function(d, e) {
            //群组列表
            _fnGroupsList();
        });

		MIM.AddListen('my_friend_info', function(d, e) {
            //好友详情
            _fnActionUpdateFriendDialog(d.user.sid);
        });

		MIM.AddListen('my_group_info', function(d, e) {
            //群组详情
            _fnActionUpdateGroupDialog(d.group.id);
        });

		MIM.AddListen('user_chat', function(d, e) {
            //用户对话
            var friend_uid;
            if (d.from == MIM.GetData('user_data').sid) friend_uid = d.to;
            else if (d.to == MIM.GetData('user_data').sid) friend_uid = d.from;
            else return false;
            _fnActionReadUserChat(friend_uid);
        });

		MIM.AddListen('group_chat', function(d, e) {
            //群组对话
            _fnActionReadGroupChat(d);
        });

		MIM.AddListen('friend_status', function(d, e) {
            //好友上/下线
            _fnActionFirendStatus(d.uid, d.status)
        });

		MIM.AddListen('group_member_status', function(d, e) {
            //群组成员上/下线
            _fnActionGroupMemberStatus(d.gid, d.uid, d.status);
        });
	}
});

/**
 * 好友列表
 */
 var _fnFriendsList = function() {
 	$("mim_user_firends_list").empty();
 	$.each(MIM.GetData('friend_list'), function(i, e) {
        // var $li = $(_fnTemplateUser_List());
        // $li.attr('uid', e.sid);
        // $li.find('img').attr('src', e.avatar);
        // $li.find('.user_name').text(e.name);
        // // if(e.status){
        // // 	$li.find('i.ion').css("color","#a0d269");
        // // }else{
        // // 	$li.find('i.ion').css("color","#ddd");
        // // }
        // $li.find('.friends_box').click(function() {
        //     var $dialog = _fnActionGetUserDialog($li.attr('uid'));
        //     if ($dialog == null) $dialog = _fnCreateUserdialog($li.attr('uid'));
        //     _fnActionUnreadUserChat($li.attr('uid'));
        // });
        // $li.appendTo($('#mim_user_firends_list'));
        if(e.status){
        	var $li = $(_fnTemplateUser_List());
        	$li.attr('uid', e.sid);
        	$li.find('img').attr('src', e.avatar);
        	$li.find('.user_name').text(e.name);
	        // if(e.status){
	        // 	$li.find('i.ion').css("color","#a0d269");
	        // }else{
	        // 	$li.find('i.ion').css("color","#ddd");
	        // }
	        $li.find('.friends_box').click(function() {
	        	var $dialog = _fnActionGetUserDialog($li.attr('uid'));
	        	if ($dialog == null) $dialog = _fnCreateUserdialog($li.attr('uid'));
	        	_fnActionUnreadUserChat($li.attr('uid'));
	        });
	        $li.appendTo($('#mim_user_firends_list'));
	    }

	});
	$.each(MIM.GetData('friend_list'), function(i, e) {
        if(!e.status){
        	var $li = $(_fnTemplateUser_List());
        	$li.attr('uid', e.sid);
        	$li.find('img').attr('src', e.avatar);
        	$li.find('.user_name').text(e.name);
	        $li.find('.friends_box').click(function() {
	        	var $dialog = _fnActionGetUserDialog($li.attr('uid'));
	        	if ($dialog == null) $dialog = _fnCreateUserdialog($li.attr('uid'));
	        	_fnActionUnreadUserChat($li.attr('uid'));
	        });
	        $li.appendTo($('#mim_user_firends_list'));
	    }

	});
 }

/**
 * 绘制群组列表
 * @returns {Boolean}
 */
 var _fnGroupsList = function() {
 	$('#mim_user_groups_list').empty();
 	$.each(MIM.GetData('group_list'), function(i, e) {
 		var $li = $(_fnTemplateGroups_List());
 		var group_id = e.id;
 		$li.attr('gid', e.id);
 		$li.find('.mim-user-name').css("font-size", "20px").text(e.name).attr('title', e.name);
        // $li.find('.mim-chat-user-avatar img').attr('src', _THEMES_HOST+'/assets/images/avatar/group.png');
        $li.find('.count').css("font-size", "15px").text('(' + e.member_count + ')');
        $li.find('a').click(function() {
        	$('.overlay').removeClass('show');
        	$('.left-bar').removeClass('menu_appear');
        	var $dialog = _fnActionGetGroupDialog(group_id);
        	if ($dialog == null) $dialog = _fnActionCreateGroupDialog(group_id);
        });
        $li.appendTo($('#mim_user_groups_list'));
    });
 	return true;
 };

/**
 * 绘制好友聊天对话框
 */
 var _fnCreateUserdialog = function(friend_uid) {
 	var friend_info = MIM.GetData('friend_list')[friend_uid];
 	var scene_key = MIM.Utils.Get_Friend_Scene_Key(friend_uid);
 	$dialog = $(_fnTemplateUserdialog());
 	$("#mim_chat_dialog").html($dialog.attr('dialog_id', scene_key));
 	$dialog.find('.mim-dialog-title').css("font-size", "20px").text(friend_info.name);
    $dialog.find('.mim-dialog-btn-close').click(function() { //close dialog
    	_fnActionCloseDialog($dialog);
        _fnActionSwitchScene(scene_key, false); //close scene	
    });
    $dialog.find('.profile-right img').attr('src', friend_info.avatar);
    $dialog.find('.mim-dialog-title').css("font-size", "20px").text(friend_info.name);
    // $dialog.find('.mim-dialog-person-name').text(friend_info.name);

    // $dialog.find('.mim-dialog-btn-upload').click(function(){
    // 	$("#mim_upload_file_dropzone").attr('mim_chat_type', MIM.Utils.friend_scene_type).attr('mim_chat_to', friend_uid).click();
    // });

    // $dialog.find(".mim-dialog-btn-chatlog").click(function(){
    // 	window.location.href=_REQUEST_HOST+'/chat/chatlog/&uid='+friend_uid;
    // });

    $dialog.find('.mim-info-age').text(friend_info.age);
    $dialog.find('.mim-info-sex').text(friend_info.sex);
    $dialog.find('.mim-info-phone').text(friend_info.phone);
    $dialog.find('.mim-info-email').text(friend_info.email);
    $dialog.find('.mim-info-status').text(friend_info.status ? '在线' : '离线');
    $dialog.find(".mim-upload-file-buffer").attr("id", "mim-file-buffer-" + friend_uid);
    $dialog.find(".mim-upload-file-ul").attr("id", "mim-file-buffer-ul-" + friend_uid).css("display", "none");
    // $dialog.find('.mim-dialog-post').clipboard_paste_img({    //复制粘贴图片功能
    // 	callback:function(image_resource_list){
    // 		$.post(_REQUEST_HOST+'/chat/paste_image', {'img':image_resource_list}, function(data){
    // 			var d = JSON.parse(data);
    // 			$.each(d, function(i, e){
    // 				MIM.SendUserChat(friend_uid, e, MIM.Utils.content_type.image);
    // 			});
    // 		});
    // 	}
    // });
    $dialog.find('.mim-dialog-btn-post').click(function() { //send chat message to user
    	var post_content = $dialog.find('.mim-dialog-post').val();
    	if (post_content == '') return false;
    	MIM.SendUserChat(friend_uid, post_content);
    	$dialog.find('.mim-dialog-post').val('');
    	return true;
    });
    //键盘按下回车键发送消息
    document.onkeydown = function(event) {
    	e = event ? event : (window.event ? window.event : null);
    	var currKey = 0;
    	currKey = e.keyCode || e.which || e.charCode;
    	if (currKey == 13) {
            e.preventDefault(); //阻止enter键的默认行为
            var post_content = $dialog.find('.mim-dialog-post').val();
            if (post_content == '') return false;
            MIM.SendUserChat(friend_uid, post_content);
            $dialog.find('.mim-dialog-post').val('');
            console.log($('.office_text'));
            $('.office_text').scrollTop(473);
            return true;
        }
    };
    _fnActionSwitchScene(scene_key, true); //open scene
    if (MIM.Data.friend_list[friend_uid].content == null) {
        //not load friend complete info yet
        MIM.GetFriendInfo(friend_uid);
    }
}

/**
 * 创建群组聊天对话框
 * @param group_id
 * @returns
 */

 var _fnActionCreateGroupDialog = function(group_id) {
 	var group_info = MIM.GetData('group_list')[group_id];
 	var $dialog = _fnActionGetGroupDialog(group_id);
 	if ($dialog != null) return $dialog;
 	var scene_key = MIM.Utils.Get_Group_Scene_Key(group_id);
 	$dialog = $(_fnTemplateDialog());
 	$("#mim_chat_dialog").html($dialog.attr('dialog_id', scene_key));
 	$dialog.find('.mim-dialog-title').css("font-size", "20px").text(group_info.name);
    $dialog.find('.mim-dialog-btn-close').click(function() { //close dialog
    	_fnActionCloseDialog($dialog);
        _fnActionSwitchScene(scene_key, false); //close scene
    });


    $dialog.find('.mim-dialog-content').append($(_fnTemplateDialogSubGroup()));
    $dialog.find('.mim-dialog-title').css("font-size", "20px").text(group_info.name);
    $dialog.find('.mim-dialog-group-name').text(group_info.name);
    $dialog.find('.mim-dialog-group-content').text(group_info.name);
    //群组文件上传
    $dialog.find('.mim-dialog-btn-upload').click(function() {
    	$("#mim_upload_file_dropzone").attr('mim_chat_type', MIM.Utils.group_scene_type).attr('mim_chat_to', group_id).click();
    });
    $dialog.find(".mim-upload-file-buffer").attr("id", "mim-file-buffer-" + group_id);
    $dialog.find(".mim-upload-file-ul").attr("id", "mim-file-buffer-ul-" + group_id).css("display", "none");

    $dialog.find(".mim-dialog-btn-chatlog").click(function() {
    	window.location.href = _REQUEST_HOST + '/chat/chatlog/&group=' + group_id;
    });

    $dialog.find('.mim-dialog-post').clipboard_paste_img({ //复制粘贴图片功能
    	callback: function(image_resource_list) {
    		$.post(_REQUEST_HOST + '/chat/paste_image', { 'img': image_resource_list }, function(data) {
    			var d = JSON.parse(data);
    			$.each(d, function(i, e) {
    				MIM.SendGroupChat(group_id, e, MIM.Utils.content_type.image);
    			});
    		});
    	}
    });
    $dialog.find('.mim-dialog-btn-post').click(function() { //send chat message to group
    	var post_content = $dialog.find('.mim-dialog-post').val();
    	if (post_content == '') return false;
    	MIM.SendGroupChat(group_id, post_content);
    	$dialog.find('.mim-dialog-post').val('');
    	return true;
    });
    _fnActionSwitchScene(scene_key, true); //open scene
    if (MIM.Data.group_list[group_id].user_list == null) {
        //not load group complete info yet, get it
        MIM.GetGroupInfo(group_id);
    } else {
    	var $ul = $dialog.find('.mim-dialog-group-member').empty();
    	$.each(MIM.Data.group_list[group_id].user_list, function(i, e) {
    		var $li = $(_fnTemplateGroupUser_List());
    		$li.attr('uid', e.sid);
    		$li.find('img').attr('src', e.img);
    		$li.find('.name').text(e.name);
    		$li.find('i.ion').addClass(e.status ? 'online' : 'offline');
    		$li.appendTo($ul);
    	});
    }
    return $dialog;
};


/**
 * 更新群组对话框信息
 * @param group_id
 * @returns {Boolean}
 */
 var _fnActionUpdateGroupDialog = function(group_id) {
 	var $dialog = _fnActionGetGroupDialog(group_id);
 	if ($dialog == null) return false;
 	var group_info = MIM.GetData('group_list')[group_id];
 	$dialog.find('.mim-dialog-title').css("font-size", "20px").text(group_info.name);
 	$dialog.find('.mim-dialog-group-name').text(group_info.name);
 	$dialog.find('.mim-dialog-group-content').text(group_info.name);
 	var $ul = $dialog.find('.mim-dialog-group-member').empty();
 	if (group_info.user_list) {
 		$.each(group_info.user_list, function(i, e) {
 			var $li = $(_fnTemplateGroupUser_List(false));
 			$li.attr('uid', e.sid);
 			$li.find('img').attr('src', e.img);
 			$li.find('.name').text(e.name);
 			$li.find('i.ion').addClass(e.status ? 'online' : 'offline');
 			$li.appendTo($ul);
 		});
 	}
 	return true;
 };

/**
 * 读取群组聊天
 * @param friend_uid
 * @returns {Boolean}
 */
 var _fnActionReadGroupChat = function(chat_data) {
 	if (!chat_data) return false;
 	var $dialog = _fnActionGetGroupDialog(chat_data.gid);
 	if ($dialog == null) {
        //group dialog not open yet, ignore
        return false;
    }
    var $chat;
    if (chat_data.uid == MIM.GetData('user_data').sid) {
        //my words
        $chat = $(_fnTemplateMyChat());
        $chat.find('.mim-dialog-chat-from').css("font-size", "20px").text(MIM.GetData('user_data').name + ' ' + chat_data.time);
    } else {
        //other words
        $chat = $(_fnTemplateOthersChat());
        $chat.find('.mim-dialog-chat-from').css("font-size", "20px").text(MIM.GetData('group_list')[chat_data.gid]['user_list'][chat_data.uid].name + ' ' + chat_data.time);
    }
    if (chat_data.content_type == MIM.Utils.content_type.text) { //text
    	$chat.find('.mim-dialog-chat').text(chat_data.content);
    } else if (chat_data.content_type == MIM.Utils.content_type.image) { //image
    	var $img = $('<div><img src="' + chat_data.content.src + '" width="100%"><div><a href="javascript:MIMPreview(\'' + chat_data.content.src + '\')">查看原图</a> | <a href="javascript:MIMDump(' + chat_data.content.sid + ')">转存</a></div></div>');
    	$chat.find('.mim-dialog-chat').append($img);
    } else if (chat_data.content_type == MIM.Utils.content_type.file) { //file
    	var $file = $('<div>' + chat_data.content.name + '<div><a href="javascript:MIMFile(\'' + chat_data.content.src + '\');">查看文件</a> | <a href="javascript:MIMDump(' + chat_data.content.sid + ')">转存</a></div></div>');
    	$chat.find('.mim-dialog-chat').append($file);
    }
    $chat.appendTo($dialog.find('.mim-dialog-chat-list'));
    $dialog.find('.mim-dialog-chat-list').scrollTop($dialog.find('.mim-dialog-chat-list')[0].scrollHeight);
    return true;
};

/**
 * 群组成员在线变化状态
 * @param group_id
 * @param uid
 * @param status
 * @returns {Boolean}
 */
 var _fnActionGroupMemberStatus = function(group_id, uid, status) {
 	var $dialog = _fnActionGetGroupDialog(group_id);
 	if ($dialog == null) return false;
 	$dialog.find('.mim-dialog-group-member .mim-user[uid=' + uid + ']').find('i.ion').removeClass('online').removeClass('offline').addClass(status ? 'online' : 'offline');
 	return true;
 };

/**
 * 获取用户聊天对话框
 */
 var _fnActionGetUserDialog = function(friend_uid) {
 	var scene_key = MIM.Utils.Get_Friend_Scene_Key(friend_uid);
 	return _fnActionGetDialog(scene_key);
 }


/**
 * 获取群组聊天对话框
 * @param group_id
 * @returns
 */
 var _fnActionGetGroupDialog = function(group_id) {
 	var scene_key = MIM.Utils.Get_Group_Scene_Key(group_id);
 	return _fnActionGetDialog(scene_key);
 };



/**
 * 获取对话框
 */
 var _fnActionGetDialog = function(scene_key) {
 	var $dialog = $('.mim-dialog[dialog_id=' + scene_key + ']');
 	if ($dialog.length != 0) return $dialog;
 	else return null;
 }

/**
 * 打开对话框
 */
 var _fnActionOptionDialog = function($dialog) {
 	return $dialog.show();
 }
/**
 * 最小化对话框
 */
 var _fnActionMinDialog = function($dialog) {
 	return $dialog.hide();
 }

/**
 * 关闭对话框
 */
 var _fnActionCloseDialog = function($dialog) {
 	return $dialog.remove();
 }

/**
 * 场景切换
 */
 var _fnActionSwitchScene = function(scene_key, mode) {
 	var _tmp = scene_key.split(MIM.Utils.separator);
 	var scene_type = _tmp[0];
 	var scene_id = _tmp[1];
 	MIM.SwitchScene(scene_type, scene_id, !mode ? false : true);
 	return true;
 }


/**
 * 更新好友对话框信息
 * @param friend_uid
 * @returns {Boolean}
 */
 var _fnActionUpdateFriendDialog = function(friend_uid) {
 	var $dialog = _fnActionGetUserDialog(friend_uid);
 	if ($dialog == null) return false;
 	var friend_info = MIM.GetData('friend_list')[friend_uid];
 	$dialog.find('.profile-right img').attr('src', friend_info.avatar);
 	$dialog.find('.mim-dialog-title').css("font-size", "20px").text(friend_info.name);
 	$dialog.find('.mim-dialog-person-name').text(friend_info.name);
 	$dialog.find('.mim-info-age').text(friend_info.age);
 	$dialog.find('.mim-info-sex').text(friend_info.sex);
 	$dialog.find('.mim-info-phone').text(friend_info.phone);
 	$dialog.find('.mim-info-email').text(friend_info.email);
 	$dialog.find('.mim-info-status').text(friend_info.status ? '在线' : '离线');
 	return true;
 }


/**
 * 读取用户未读的好友聊天
 */
 var _fnActionReadUserChat = function(friend_uid) {
 	if (!MIM.GetData('user_chat_list')[friend_uid]) return false;
 	var $dialog = _fnActionGetUserDialog(friend_uid);
 	if ($dialog == null) {
        //person dialog not open yet, tips unread count
        var count = Object.keys(MIM.GetData('user_chat_list')[friend_uid]).length;
        if (count >= 0) {
            // $('#mim_user_firends_list .mim-user[uid='+friend_uid+']').find('span.badge').text(count);
            var _username = $('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').find('.user_name').text();
            var _img = $('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').find('div.user_head').html();
            $('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').find('span.count_num').text(count);
            $('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').click(function() {
            	$(this).find('span.count_num').text('');
            });
            // $.gritter.add({                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            //  title:_username,
            //  text:'给您有一条新的消息请及时查看！',
            //  image:'',
            //  sticky: false,
            //  time:''
            // });
            // $("#si_1").text('新');
        }
        return true;
    }
    var cid_list = [];
    $.each(MIM.GetData('user_chat_list')[friend_uid], function(i, chat_data) {
    	var $chat;
    	if (chat_data.to == MIM.GetData('user_data').sid) {
            //others words
            $chat = $(_fnTemplateOthersChat());
            $chat.find('img').attr('src', MIM.GetData('friend_list')[chat_data.from].avatar).attr('title', MIM.GetData('friend_list')[chat_data.from].name);
        } else {
            //my words
            $chat = $(_fnTemplateMyChat());
            $chat.find('img').attr('src', MIM.GetData('user_data').avatar).attr('title', MIM.GetData('user_data').name);
        }
        if (chat_data.content_type == MIM.Utils.content_type.text) { //text
        	$chat.find('.mim-dialog-chat').text(chat_data.content);
        } else if (chat_data.content_type == MIM.Utils.content_type.image) { //image
        	var $img = $('<div><img src="' + chat_data.content.src + '" width="100%"><div><a href="javascript:MIMPreview(\'' + chat_data.content.src + '\')">查看原图</a> | <a href="javascript:MIMDump(' + chat_data.content.sid + ')">转存</a></div></div>');
        	$chat.find('.mim-dialog-chat').append($img);
        } else if (chat_data.content_type == MIM.Utils.content_type.file) { //file
        	var $file = $('<div>' + chat_data.content.name + '<div><a href="javascript:MIMFile(\'' + chat_data.content.src + '\');">查看文件</a> | <a href="javascript:MIMDump(' + chat_data.content.sid + ')">转存</a></div></div>');
        	$chat.find('.mim-dialog-chat').append($file);
        }
        $chat.appendTo($dialog.find('.mim-dialog-chat-list'));
        if (chat_data.from != MIM.GetData('user_data').sid) cid_list.push(chat_data.cid); //already read chat id list
        $dialog.find('.mim-dialog-chat-list').scrollTop($dialog.find('.mim-dialog-chat-list')[0].scrollHeight);
    });
    MIM.DoneUserChat(cid_list);
    delete MIM.GetData('user_chat_list')[friend_uid] && $('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').find('span.badge').text(''); //clear chat cache

    return true;
}
/**
 * 读取用户未读的好友聊天内容
 */
 var _fnActionUnreadUserChat = function(friend_uid) {
 	var $dialog = _fnActionGetUserDialog(friend_uid);
    // console.log($dialog);
    var cid_list = [];
    var _user_length = $("#mim-user-news-list .mim-user-new-list-li[uid=" + friend_uid + "]").length;
    if (_user_length > 0) {
    	$("#mim-user-news-list .mim-user-new-list-li[uid=" + friend_uid + "]").remove();
    	$("#mim-user-news-num").text('');
    }
    if (MIM.GetData('user_chat_list')[friend_uid]) {
    	$.each(MIM.GetData('user_chat_list')[friend_uid], function(i, chat_data) {
    		var $chat;
    		if (chat_data.to == MIM.GetData('user_data').sid) {
                //others words
                $chat = $(_fnTemplateOthersChat());
                $chat.find('img').attr('src', MIM.GetData('friend_list')[chat_data.from].avatar).attr('title', MIM.GetData('friend_list')[chat_data.from].name);
            } else {
                //my words
                $chat = $(_fnTemplateMyChat());
                $chat.find('img').attr('src', MIM.GetData('user_data').avatar).attr('title', MIM.GetData('user_data').name);
            }
            if (chat_data.content_type == MIM.Utils.content_type.text) { //text
            	$chat.find('.mim-dialog-chat').text(chat_data.content);
            } else if (chat_data.content_type == MIM.Utils.content_type.image) { //image
            	var $img = $('<div><img src="' + chat_data.content.src + '" width="100%"><div><a href="javascript:MIMPreview(\'' + chat_data.content.src + '\')">查看原图</a> | <a href="javascript:MIMDump(' + chat_data.content.sid + ')">转存</a></div></div>');
            	$chat.find('.mim-dialog-chat').append($img);
            } else if (chat_data.content_type == MIM.Utils.content_type.file) { //file
            	var $file = $('<div>' + chat_data.content.name + '<div><a href="javascript:MIMFile(\'' + chat_data.content.src + '\');">查看文件</a> | <a href="javascript:MIMDump(' + chat_data.content.sid + ')">转存</a></div></div>');
            	$chat.find('.mim-dialog-chat').append($file);
            }
            // console.log($dialog);
            $chat.appendTo($dialog.find('.mim-dialog-chat-list'));
            if (chat_data.from != MIM.GetData('user_data').sid) cid_list.push(chat_data.cid); //already read chat id list
            $dialog.find('.mim-dialog-chat-list').scrollTop($dialog.find('.mim-dialog-chat-list')[0].scrollHeight);
        });
    	MIM.DoneUserChat(cid_list);
        delete MIM.GetData('user_chat_list')[friend_uid] && $('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').find('span.badge').text(''); //clear chat cache
        return true;
    } else {
    	return true;
    }

}

/**
 * 好友在线状态变化
 * @param friend_uid
 * @param status
 * @returns {Boolean}
 */
 var _fnActionFirendStatus = function(friend_uid, status) {
 	if (status) {
 		$('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').find('i.ion').css('color', '#a0d269');
 	} else {
 		$('#mim_user_firends_list .mim-user[uid=' + friend_uid + ']').find('i.ion').css('color', '#ddd');
 	}
 	return true;
 };


/**
 * 好友列表模版
 */
 var _fnTemplateUser_List = function() {
 	return '<li class="mim-user"><div class="friends_box"><div class="user_head"><img></div><div class="friends_text"><span class="user_name"></span><span class="count_num" style="float:right;"></span></div></div></li>';
 };
/**
 * 群组列表模版
 */
 var _fnTemplateGroups_List = function() {
 	return '<li style="padding-left: 0px;padding-bottom: 10px;" class="mim-group"><a href="javascript:void(0)" class="mim-chat-user-a"><div class="mim-chat-user-avatar"><img></div><span class="mim-user-name"></span><span class="count"></span></a></li>';
 }

/**
 * 聊天框模版
 */
 var _fnTemplateUserdialog = function() {
 	return '<div class = "window mim-dialog"><div class="windows_top"><div class="windows_top_box"><span class="mim-dialog-title"></span><span style="float:right;padding-right:30px;" class="mim-dialog-btn-close">X</span></div></div><div class="windows_body"><div class="office_text" style="height: 100%;"><ul class="mail_list mim-dialog-chat-list content" id="chatbox"></ul></div></div><div class="windows_input" id="talkbox"><div class="input_icon"><a href="javascript:;"></a><a href="javascript:;"></a><a href="javascript:;"></a><a href="javascript:;"></a><a href="javascript:;"></a><a href="javascript:;"></a></div><div class="input_box"><textarea class="mim-dialog-post" id="input_box"></textarea><button class="mim-dialog-btn-post" id="send">发送（S）</button></div></div></div>';
 }
/**
 * 其他人的发言消息模版
 * @returns {String}
 */
 var _fnTemplateOthersChat = function() {
 	return '<li class="other"><img src title><span class="mim-dialog-chat"></span></li>';
 };
/**
 * 我的发言消息模版
 * @returns {String}
 */
 var _fnTemplateMyChat = function() {
 	return '<li class="me"><img src title><span class="mim-dialog-chat"></span></li>';
 };

/**
 * 对话框dialog框架模版
 * @returns {String}
 */
 var _fnTemplateDialog = function() {
 	return '<div class="modal-dialog modal-lg mim-dialog ui-draggable" style="width:100%;margin:0px;"><div class="panel panel-piluku"><div class="panel-heading"><h3 class="panel-title"><span class="mim-dialog-title"></span><span class="panel-options"><!--<a href="javascript:;" class="panel-minimize mim-dialog-btn-minimize"><span class="icon ti-angle-up"></span></a>--><button type="button" class="close mim-dialog-btn-close"><span aria-hidden="true" class="icon ti-close"></span></button></span></h3></div><div class="panel-body"><div class="panel-body mail_widget"><div class="content-holder mim-dialog-content"></div><div class="row"><div class="col-lg-12 mim-dialog-tips"></div></div></div></div></div></div>';
 };

/**
 * 群组聊天对话框dialog内容模版
 * @returns {String}
 */
 var _fnTemplateDialogSubGroup = function() {
 	return '<div class="row"><div  class="col-md-8 no_padding"><div class="mail_list mim-dialog-chat-list" style="max-height:420px; height:400px; overflow-x:hidden; outline:none;"></div><div class="profile-left"><div class="form-group"><textarea class="form-control text-area mim-dialog-post" cols="30" rows="10" placeholder="..." id="mim-group-textarea"></textarea></div><ul class="list-unstyled list-inline profile-type"><li><i class="ion ion-image"></i></li><li class="pull-right"><a class="btn btn-primary mim-dialog-btn-post" href="javascript:;">发送</a></li></ul></div></div><div class="col-md-4"><div class="alert alert-info alert-dismissable mail_list" style="max-height:200px;"><h3 class="mim-dialog-group-name"></h3><p class="mim-dialog-group-content"></p></div><div class="mail_list well well-lg" style="overflow-y:auto; outline:none; padding:10px"><div class="contacts"><ul class="list-group contacts-list mim-dialog-group-member"></ul></div></div>' +

 	'<div class="profile-right">' +
 	'<div class="mail_list well well-lg mim-upload-file-ul" style="overflow-y:auto; outline:none; padding:10px">' +
 	'<div class="contacts"><ul class="list-group contacts-list mim-upload-file-buffer"></ul></div></div>' +
 	'<p id="mim-upload-prog-title"></p>' +
 	'<div class="progress progress-xs" id="mim-upload-progress" style="display:none;">' +
 	'<div class="progress-bar progress-bar-warning" style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" id="mim-upload-prog-div"><span id="mim-upload-prog-span">0</span>%</div></div>' +
 	'<button class="btn btn-primary btn-block mim-dialog-btn-upload">发送文件</button><button class="btn btn-primary btn-block mim-dialog-btn-chatlog">聊天记录</button></div></div>' +
 	'</div></div>';
 };

/**
 * 群组用户列表模版
 * @param bln_has_checkbox
 * @returns {String}
 */
 var _fnTemplateGroupUser_List = function(bln_has_checkbox) {
 	if (!bln_has_checkbox) return '<li class="list-group-item mim-user"><a href="javascript:;"><div class="avatar"><img></div><span class="name"></span><span class="badge bg-danger"></span><i class="ion ion-record"></i></a></li>';
 	else return '<li class="list-group-item mim-user"><div class="row"><div class="col-md-2"><ul class="list-inline checkboxes-radio"><li class="ms-hover"><input type="checkbox" class="mark-complete"><label><span></span></label></li></ul></div><div class="col-md-10"><div class="avatar"><img></div><span class="name"></span><i class="ion ion-record"></i></div></div></li>';
 };

 var MIMDump = function(sid) {
 	if (sid == '') return false;
 	$.post(_REQUEST_HOST + '/chat/dump_file', { "sid": sid }, function(e) {
 		if (e) {
 			alert('转存成功');
 		}
 	})
 }

 var MIMPreview = function(image_src) {
 	$('#lightbox').remove();
 	var lightbox =
 	'<div id="lightbox">' +
 	'<div class="lightbox-content">' +
 	'<img src="' + image_src + '" />' +
 	'</div>' +
 	'</div>';
 	$(lightbox).click(function(e) {
 		e.preventDefault();
 		$('#lightbox').hide();
 	}).appendTo($('body'));
 }

 var MIMFile = function(file_url) {
    //window.open(file_url, '_blank');
    //window.open(file_url, '_parent');
    window.open(_REQUEST_HOST + '/chat/download_file/&url=' + file_url, '_parent');
}