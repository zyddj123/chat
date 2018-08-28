(function($){
	$.fn.CHAT=function(oSettings){
	    var all = "all";
	    var ws, timeid;
		var client_list={};
		var reconnect=false;
		var $chat=this;
		var select_client_id='all';
		
		var DefaultSettings={
			'WEB_SOCKET_SWF_LOCATION':'/js/chat/swf/WebSocketMain.swf',
			'WEB_SOCKET_DEBUG':true,
			'login_url':'/login',
			'ip':'192.168.1.181',
			'port':'1234',
			'name':'',
			'uid':'',
			'folder':'',
			'img':'',
			'img_url':'',
			'room_id':'0',
			'isadmin':'0',
			'scene':'1',
			'http_root':'',
			'url_root':'',
			'error_img':'default.jpg',
			'group':false,
			'text_online':' 上线了',
			'text_offline':' 下线了', 
			'text_level':' 离开了', 
			'text_back':' 回来了', 
		}
		DefaultSettings.tpl_info='<li><a href=""><div class="avatar_left"><img src="" alt=""></div><div class="info_right"><span class="text_head pull-left"></span><span class="time_info pull-right"></span><div class="text_info"></div></div></a></li>',
		DefaultSettings.tpl_onlinelist='<a href="" data-chat-online-link><div class="avatar"><img data-chat-online-img></div><span class="name" data-chat-online-name></span></a><a href="javascript:;" class="delfriend"><i class="ion ion-close"></i></a><i class="ion ion-record online">&nbsp;</i>',
		DefaultSettings.tpl_offlinelist='<a href="" data-chat-offline-link><div class="avatar"><img data-chat-offline-img></div><span class="name" data-chat-offline-name></span></a><a href="javascript:;" class="delfriend"><i class="ion ion-close"></i></a><i class="ion ion-record offline">&nbsp;</i>',
		DefaultSettings.tpl_grouplist='<a href="#"></a><div class="avatar"><a href="#"></a><a data-chat-grouplist-link><img data-chat-grouplist-img></a></div><span class="name" data-chat-grouplist-name></span>',
		DefaultSettings.tpl_delgroup='<a href="javascript:;" class="delgroup"><i class="ion ion-close"></i></a>',
		DefaultSettings.tpl_messagelist='<a data-chat-messagelist-link><div class="avatar_left"><img data-chat-messagelist-img></div><div class="info_right"><span class="text_head pull-left" data-chat-messagelist-name></span><span class="time_info pull-right" data-chat-messagelist-time><span class="badge info-number message" data-chat-messagelist-count></span></span><div class="text_info" data-chat-messagelist-content></div></div></a>',
		DefaultSettings.tpl_groupuser='<a data-chat-groupuser-link><img data-chat-groupuser-img></a>',
		DefaultSettings.tpl_groupuserdel='<span class="btn btn-danger delmember"><i class="ion-android-close"></i></span>',
		DefaultSettings.tpl_chat='<div class="wtime-icon"><i class="ion ion-paper-airplane"></i></div><div class="wtimeline-description"><div class="wshape"></div><div class="wtimeline-heading" data-chat-name></div><div class="wtimeline-time" data-chat-time></div><div class="wtimeline-content" data-chat-content></div></div>',
		DefaultSettings.tpl_addfriends='<div><div class="list-group message-list"><a href="javascript:;" class="list-group-item"><h4 class="list-group-item-heading" data-chat-addfriend-name></h4><p class="list-group-item-text">申请加您为好友</p></a></div><div class="heading no_border_bottom" data-chat-addfriend-time><div class="left"><a href="javascript:;" id="pass"><i class="fa fa-check"></i></a></div><div class="right"><a href="javascript:;" id="refuse"><i class="fa fa-times"></i></a></div></div></div>',
		//添加好友
		DefaultSettings.tpl_userhtml = '<div class="info-stats"><div class="right"><h3 class="flatBluec" data-chat-addfriend-name></h3><h4 data-chat-addfriend-label></h4></div><div class="left"><img data-chat-addfriend-img /></div></div>',
		DefaultSettings.tpl_onlinehtml = '<span class="label label-success"><i class="fa fa-check-circle">&nbsp;</i>在线</span>',
		DefaultSettings.tpl_offlinehtml = '<span class="label label-default"><i class="fa fa-times-circle">&nbsp;</i>离线</span>',
		DefaultSettings.tpl_addfriendhtml = '<a href="javascript:;"><span class="label label-info addfriend"><i class="fa fa-user-plus">&nbsp;</i>添加</span></a>';
		
		var _WEB_SOCKET_SWF_LOCATION=oSettings.WEB_SOCKET_SWF_LOCATION?oSettings.WEB_SOCKET_SWF_LOCATION:DefaultSettings.WEB_SOCKET_SWF_LOCATION;
		var _ip=oSettings.ip?oSettings.ip:DefaultSettings.ip;
		var _port=oSettings.port?oSettings.port:DefaultSettings.port;
		var _name=oSettings.name?oSettings.name:DefaultSettings.name;
		var _uid=oSettings.uid?oSettings.uid:DefaultSettings.uid;
		var _folder=oSettings.folder?oSettings.folder:DefaultSettings.folder;
		var _img=oSettings.img?oSettings.img:DefaultSettings.img;
		var _img_url=oSettings.img_url?oSettings.img_url:DefaultSettings.img_url;
		var _login_url=oSettings.login_url?oSettings.login_url:DefaultSettings.login_url;
		var _room_id=oSettings.room_id?oSettings.room_id:DefaultSettings.room_id;
		var _isadmin=oSettings.isadmin?oSettings.isadmin:DefaultSettings.isadmin;
		var _scene=oSettings.scene?oSettings.scene:DefaultSettings.scene;
		var _http_root=oSettings.http_root?oSettings.http_root:DefaultSettings.http_root;
		var _url_root=oSettings.url_root?oSettings.url_root:DefaultSettings.url_root;
		var _error_img=oSettings.error_img?oSettings.error_img:DefaultSettings.error_img;
		
		var _tpl_chat=oSettings.tpl_chat?oSettings.tpl_chat:DefaultSettings.tpl_chat;
		var _tpl_info=oSettings.tpl_info?oSettings.tpl_info:DefaultSettings.tpl_info;
		var _tpl_onlinelist=oSettings.tpl_onlinelist?oSettings.tpl_onlinelist:DefaultSettings.tpl_onlinelist;
		var _tpl_offlinelist=oSettings.tpl_offlinelist?oSettings.tpl_offlinelist:DefaultSettings.tpl_offlinelist;
		var _tpl_grouplist=oSettings.tpl_grouplist?oSettings.tpl_grouplist:DefaultSettings.tpl_grouplist;
		var _tpl_delgroup=oSettings.tpl_delgroup?oSettings.tpl_delgroup:DefaultSettings.tpl_delgroup;
		var _tpl_messagelist=oSettings.tpl_messagelist?oSettings.tpl_messagelist:DefaultSettings.tpl_messagelist;
		var _tpl_groupuser=oSettings.tpl_groupuser?oSettings.tpl_groupuser:DefaultSettings.tpl_groupuser;
		var _tpl_groupuserdel=oSettings.tpl_groupuserdel?oSettings.tpl_groupuserdel:DefaultSettings.tpl_groupuserdel;
		var _tpl_addfriends=oSettings.tpl_addfriends?oSettings.tpl_addfriends:DefaultSettings.tpl_addfriends;
		
		var _tpl_userhtml=oSettings.tpl_userhtml?oSettings.tpl_userhtml:DefaultSettings.tpl_userhtml;
		var _tpl_onlinehtml=oSettings.tpl_onlinehtml?oSettings.tpl_onlinehtml:DefaultSettings.tpl_onlinehtml;
		var _tpl_offlinehtml=oSettings.tpl_offlinehtml?oSettings.tpl_offlinehtml:DefaultSettings.tpl_offlinehtml;
		var _tpl_addfriendhtml=oSettings.tpl_addfriendhtml?oSettings.tpl_addfriendhtml:DefaultSettings.tpl_addfriendhtml;
		
		var _group=oSettings.group?oSettings.group:DefaultSettings.group;
		var _text_online=oSettings.text_online?oSettings.text_online:DefaultSettings.text_online;
		var _text_offline=oSettings.text_offline?oSettings.text_offline:DefaultSettings.text_offline;
		var _text_level=oSettings.text_level?oSettings.text_level:DefaultSettings.text_level;
		var _text_back=oSettings.text_back?oSettings.text_back:DefaultSettings.text_back;
		
		var _fnAjax=function(strUrl, oData, fnCallback){
			$.ajax({
				async:true,
				url:strUrl,
				type:'get',
				dataType:'json',
				data:oData,
				success:function(e){
					fnCallback(e, oData);
				}
			});
		};
		
		//滚动条自动滚动到最底
		var _scrollToBottom=function(name){
	        $("#"+name)[0].scrollTop=$("#"+name)[0].scrollHeight-$("#"+name)[0].clientHeight;
		}
		
		//socket连接打开,登录判断
		var _onopen=function(){
	    	  timeid && window.clearInterval(timeid);
	    	  if(!_uid)
	    	  {
	  		    //window.location.href=_login_url;
	    		$(".chat_btn").remove();
	    		return ws.close();
	   		  }
	    	  if(reconnect == false)
	    	  {
	        	  // 登录
	    		  var login_data = JSON.stringify({"type":"login","client_uid":_uid,"client_name":_name,"img":_img,"room_id":_room_id,"scene":_scene});
	    		  console.log("websocket握手成功，发送登录数据:"+login_data);
	  		      ws.send(login_data);
	    		  reconnect = true;
	    	  }
	    	  else
	    	  {
	        	  // 断线重连
	        	  var relogin_data = JSON.stringify({"type":"re_login","client_uid":_uid,"client_name":_name,"img":_img,"room_id":_room_id,"scene":_scene});
	    		  console.log("websocket握手成功，发送重连数据:"+relogin_data);
	    		  ws.send(relogin_data);
	    	  }
		};
		
		// 当有消息时根据消息类型显示不同信息
		var _onmessage=function(e) {
//	    	console.log(e.data);
	        var data = JSON.parse(e.data);
	        switch(data['type']){
	              // 服务端ping客户端
	              case 'ping':
	            	ws.send(JSON.stringify({"type":"pong","client_uid":_uid,"client_name":_name,"img":_img,"room_id":_room_id,"scene":_scene}));
	                break;
	              // 登录 更新好友及群组列表
	              case 'login':
	                  //刷新好友列表
	                  _flush_userlist(data['on_userlist'],data['off_userlist'],data['mode']);
	                  console.log(data['client_name']+"登录成功");
	                  break;
	              // 断线重连，只更新好友及群组列表
	              case 're_login':
	            	  //刷新好友列表
	              	  _flush_userlist(data['on_userlist'],data['off_userlist'],data['mode']);
	            	  console.log(data['client_name']+"重连成功");
	                  break;
	              //刷新群组成员列表
	              case 'group':
	              	  _flush_group_userlist(data['on_group_userlist'],data['off_group_userlist'],data['group_mode']);
	            	  break;
	              //退出操作 刷新群组成员列表
	              case 'group_logout':
	              	  _flush_group_userlist(data['on_groupuserlist'],data['off_groupuserlist'],data['group_mode']);
	            	  break;
	              case 'hide':
	            	  //隐藏功能区
	            	  //首页
	            	  if(_scene=='1'){
		            	  $("#dialog").hide();
		            	  $(".profile-right").hide();
	            	  }
	            	  //群组页面
	            	  if(_scene=='2'){
	            		  $(".profile-left").hide();
		            	  $(".profile-right").hide();
	            	  }
	            	  if(_scene=='3'){
	            		  $("#chatzone").hide();
	            	  }
	            	  break;
	              // 群聊
	              case 'group_say':
	            	  _say(data['from_client_uid'], data['from_client_name'], data['content'], data['time']);
	            	  break;
	              //私聊
	              case 'private_say':
	            	  _say(data['from_client_uid'], data['from_client_name'], data['content'], data['time'], data['path']);
	            	  //更改聊天记录状态为已读
	            	  if(data['sid']){
	            		  _fnAjax(_url_root+'/index/ChatRecordStatus', {"sid":data['sid'],"status":"1"});
	            	  }
	            	  break;
	              //推送最新消息
	              case 'private_message':
	            	  _pushinfo(data['from_client_uid'], data['from_client_name'], data['content'], data['time'], data['path']);
	            	  break;
	              //推送好友申请消息
	              case 'send_addfriend':
	            	  _pushaddfriend(data['from_client_uid'], data['from_client_name'], data['touid'], data['sendtime']);
	            	  break;
	              //好友申请通过
	              case 'send_addfriend_ok':
	            	  //刷新好友列表
	              	  _flush_userlist(data['on_userlist'],data['off_userlist'],data['mode']);
	              	  //所有页面删除提示信息
	              	  $("#test3").find("[uid='"+data['on_userlist'][0]['uid']+"']").remove();
	                  break;
	              //好友申请拒绝
	              case 'send_addfriend_refuse':
	            	  //所有页面删除提示信息
	            	  $("#test3").find("[uid='"+data['uid']+"']").remove();
	                  break;
	              //删除好友
	              case 'del_friend_ok':
	            	  _remove_user(data['uid']);
	            	  break;
	              //删除组员关闭群聊页面
	              case 'del_groupmember_ok':
	            	  //_fnAjax(_url_root+'/chatgroup/delMemberClientids', {"uid":_uid,"gid":_room_id,"scene":_scene});
	            	  alert("您已被管理员踢出该群组！");
	            	  location.href=_url_root+'/index';
	            	  break;
	              //删除组员成功更新群组列表
	              case 'remove_group':
	            	  _remove_group(data['gid']);
	            	  break;
	              //关闭其他在线客户端
	              case 'other_client_logout':
	            	  alert("该账号在其他客户端登录，您被强迫下线！");
	            	  location.href=_url_root+'/login/logout_client';
	            	  break;
	              case 'logout_url':
	            	  location.href=_url_root+'/login/logout&uid='+_uid;
	              	  break;
            	  // 用户退出 更新好友列表
	              case 'logout':
	          		  _flush_userlist(data['on_userlist'],data['off_userlist'],data['mode']);
	              	  break;
	        }
	      };
	      
	      var _onclose=function(){
	    	  console.log("连接关闭");
	      }
	      
	      var _onerror=function(){
	    	  $(".chat_btn").remove();
	    	  console.log("出现错误");
	      }
		
		//初始化
		var _init=function(){
			if (typeof console == "undefined") {    
				this.console = { 
						log: function (msg) {  } 
				};
			}
			_onloads();
			ws = new WebSocket("ws://"+_ip+":"+_port);
			ws.onopen=_onopen;
			ws.onmessage=_onmessage;
		    ws.onclose=_onclose;
		    ws.onerror=_onerror;
		    
		}
		
		//刷新群组成员列表
		var _flush_group_userlist=function(on_group_userlist,off_group_userlist,mode){
			if(mode=='1'){
				//推送给好友
				var uids='';
	    		if($("#on_group_userlist").find("li").length > 0){
		    		$("#on_group_userlist").find("li").each(function(){
		    		        uids = uids+','+$(this).attr("uid");
		    		});
	    		}
	    		var $ulon = $('#on_group_userlist');
	    		//在线好友列表不存在 则增加
	    		if(uids.indexOf(on_group_userlist[0]['uid'])<0){
	    			//更新群组在线成员列表
	    			var $lion=$('<li></li>');
	    			$lion.appendTo($ulon);
	    			$lion.append(_tpl_groupuser);
	    			$lion.attr('uid',on_group_userlist[0]['uid']);
	    			$lion.find('[data-chat-groupuser-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+on_group_userlist[0]['uid']);
	    			$lion.find('img[data-chat-groupuser-img]').attr('src',_img_url+on_group_userlist[0]['img']).attr('title', on_group_userlist[0]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lion.find('img[data-chat-groupuser-img]').text(on_group_userlist[0]['name']);
	    			//管理员删除权限
	    			if(_isadmin==1){
	    				$lion.append(_tpl_groupuserdel);
	    			}
		    		//更新群组离线成员列表
		    		$("#off_group_userlist").find("li").each(function(){
	    		        if($(this).attr("uid")==off_group_userlist[0]['uid']){
	    		        	$(this).remove();
	    		        }
		    		});
	    		}
			}else if(mode=='2'){
				//推送给自己
	    		//第一次加载在线组员列表
				var $ulon = $('#on_group_userlist');
	    		for(var p=0;p<on_group_userlist.length;p++){
	    			var $lion=$('<li></li>');
	    			$lion.appendTo($ulon);
	    			$lion.append(_tpl_groupuser);
	    			$lion.attr('uid',on_group_userlist[p]['uid']);
	    			$lion.find('[data-chat-groupuser-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+on_group_userlist[p]['uid']);
	    			$lion.find('img[data-chat-groupuser-img]').attr('src',_img_url+on_group_userlist[p]['img']).attr('title',on_group_userlist[p]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lion.find('img[data-chat-groupuser-img]').text(on_group_userlist[p]['name']);
	    			//管理员删除权限
	    			if(_isadmin==1){
	    				$lion.append(_tpl_groupuserdel);
	    			}
		    	}
	    		//第一次加载离线组员列表
	    		var $uloff = $('#off_group_userlist');
	    		for(var p=0;p<off_group_userlist.length;p++){
	    			var $lioff=$('<li></li>');
	    			$lioff.appendTo($uloff);
	    			$lioff.append(_tpl_groupuser);
	    			$lioff.attr('uid',off_group_userlist[p]['uid']);
	    			$lioff.find('[data-chat-groupuser-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+off_group_userlist[p]['uid']);
	    			$lioff.find('img[data-chat-groupuser-img]').attr('src',_img_url+off_group_userlist[p]['img']).attr('title',off_group_userlist[p]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lioff.find('img[data-chat-groupuser-img]').text(off_group_userlist[p]['name']);
	    			//管理员删除权限
	    			if(_isadmin==1){
	    				$lioff .append(_tpl_groupuserdel);
	    			}
	    		}
		    }else{
		    	//退出或关闭窗口操作
		    	//更新在线列表
	    		if($("#on_group_userlist").find("li").length > 0){
		    		$("#on_group_userlist").find("li").each(function(){
	    		       	if($(this).attr("uid")==off_group_userlist[0]['uid']) $(this).remove();
		    		});
		    	}
	    		//新增离线好友 先判断列表中是否已存在
	    		var offuids='';
	    		if($("#off_group_userlist").find("li").length > 0){
		    		$("#off_group_userlist").find("li").each(function(){
		    			offuids = offuids+','+$(this).attr("uid");
		    		});
	    		}
	    		var $uloff = $('#off_group_userlist');
	    		if(offuids.indexOf(off_group_userlist[0]['uid'])<0){
	    			var $lioff=$('<li></li>');
	    			$lioff.appendTo($uloff);
	    			$lioff.append(_tpl_groupuser);
	    			$lioff.attr('uid',off_group_userlist[0]['uid']);
	    			$lioff.find('[data-chat-groupuser-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+off_group_userlist[0]['uid']);
	    			$lioff.find('img[data-chat-groupuser-img]').attr('src',_img_url+off_group_userlist[0]['img']).attr('title',off_group_userlist[0]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lioff.find('img[data-chat-groupuser-img]').text(off_group_userlist[0]['name']);
	    			//管理员删除权限
	    			if(_isadmin==1){
	    				$lioff.append(_tpl_groupuserdel);
	    			}
	    		}
		    }
	    	//刷新实时人数
			_refreshgcount();
	    	//添加删除事件
	    	$("li").delegate(".delmember","click",function(){
	    		var uid = $(this).parent().attr("uid");
	    		_fnAjax(_url_root+'/chatgroup/delMember', {"uid":uid,"gid":_room_id}, _closeGroupwindow);
	    		$(this).parent().remove();
	    		_refreshgcount();
	    	})
		}
		
	    // 刷新好友列表 mode=1 登录 0 退出
	    var _flush_userlist=function(on_userlist,off_userlist,mode){
	    	if(mode=='1'){
		    	//新增上线好友 判断列表中是否已存在
	    		var uids='';
	    		if($("#online-userlist").find("li").length > 0){
		    		$("#online-userlist").find("li").each(function(){
		    		        uids = uids+','+$(this).attr("uid");
		    		});
	    		}
	    		var $ulon = $('<ul class="list-group contacts-list"></ul>');
	    		//在线好友列表不存在 则增加
	    		if(uids.indexOf(on_userlist[0]['uid'])<0){
		    		//更新top在线好友列表
	    			var $lion=$('<li></li>');
	    			$lion.appendTo($ulon);
	    			$lion.append(_tpl_onlinelist);
	    			$lion.attr('uid',on_userlist[0]['uid']).addClass('list-group-item');
	    			$lion.find('[data-chat-online-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+on_userlist[0]['uid']);
	    			$lion.find('img[data-chat-online-img]').attr('src',_img_url+on_userlist[0]['img']).attr('title', on_userlist[0]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lion.find('[data-chat-online-name]').text(on_userlist[0]['name']);
	    			//更新top离线好友列表
		    		$("#offline-userlist").find("li").each(function(){
	    		        if($(this).attr("uid")==off_userlist[0]['uid']){
	    		        	$(this).remove();
	    		        }
		    		});
	    		}
	    		$ulon.appendTo($("#online-userlist"));
		    }else if(mode=='2'){//推送给自己
	    		//第一次加载在线好友列表
		    	var $ulon = $('<ul class="list-group contacts-list"></ul>');
	    		for(var p=0;p<on_userlist.length;p++){
	    			var $lion=$('<li></li>');
	    			$lion.appendTo($ulon);
	    			$lion.append(_tpl_onlinelist);
	    			$lion.attr('uid',on_userlist[p]['uid']).addClass('list-group-item');
	    			$lion.find('[data-chat-online-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+on_userlist[p]['uid']);
	    			$lion.find('img[data-chat-online-img]').attr('src',_img_url+on_userlist[p]['img']).attr('title', on_userlist[p]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lion.find('[data-chat-online-name]').text(on_userlist[p]['name']);
	    			
	    		}
	    		$ulon.appendTo($("#online-userlist"));
	    		//第一次加载离线好友列表
	    		var $uloff = $('<ul class="list-group contacts-list"></ul>');
	    		for(var p=0;p<off_userlist.length;p++){
	    			var $lioff=$('<li data-chat-offline-uid></li>');
	    			$lioff.appendTo($uloff);
	    			$lioff.append(_tpl_offlinelist);
	    			$lioff.attr('uid',off_userlist[p]['uid']).addClass('list-group-item');
	    			$lioff.find('[data-chat-offline-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+off_userlist[p]['uid']);
	    			$lioff.find('img[data-chat-offline-img]').attr('src',_img_url+off_userlist[p]['img']).attr('title', off_userlist[p]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lioff.find('[data-chat-offline-name]').text(off_userlist[p]['name']);
	    		}
	    		$uloff.appendTo($("#offline-userlist"));
		    }else{//退出或关闭窗口操作
	    		//更新在线列表
	    		if($("#online-userlist").find("li").length > 0){
		    		//更新top在线好友列表
		    		$("#online-userlist").find("li").each(function(){
	    		        if($(this).attr("uid")==on_userlist[0]['uid']) $(this).remove();
		    		});
		    	}
	    		//更新top离线好友列表
	    		//新增离线好友 先判断列表中是否已存在
	    		var offuids='';
	    		if($("#offline-userlist").find("li").length > 0){
		    		$("#offline-userlist").find("li").each(function(){
		    			offuids = offuids+','+$(this).attr("uid");
		    		});
	    		}
	    		var $uloff = $('<ul class="list-group contacts-list"></ul>');
	    		if(offuids.indexOf(off_userlist[0]['uid'])<0){
	    			var $lioff=$('<li></li>');
	    			$lioff.appendTo($uloff);
	    			$lioff.append(_tpl_offlinelist);
	    			$lioff.attr('uid',off_userlist[0]['uid']).addClass('list-group-item');
	    			$lioff.find('[data-chat-offline-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+off_userlist[0]['uid']);
	    			$lioff.find('img[data-chat-offline-img]').attr('src',_img_url+off_userlist[0]['img']).attr('title', off_userlist[0]['name']).bind("error",function(){this.src=_img_url+_error_img;});
	    			$lioff.find('[data-chat-offline-name]').text(off_userlist[0]['name']);
		    	}
	    		$uloff.appendTo($("#offline-userlist"));
		    }
	    	//刷新实时人数
	    	_refreshfcount();
	    	
	    	//添加删除事件
	    	$("li").delegate(".delfriend","click",function(){
	    		var uid = $(this).parent().attr("uid");
	    		_fnAjax(_url_root+'/index/delFriend', {"uid":uid}, _delFriend);
	    		$(this).parent().remove();
	    		_refreshfcount();
	    	})
	    	
	    }

	    //删除好友推送 从在线好友列表中删除
	    var _remove_user=function(uid){
	    	if($("#online-userlist").find("li").length > 0){
	    		//更新top在线好友列表
	    		$("#online-userlist").find("li").each(function(){
    		        if($(this).attr("uid")==uid) $(this).remove();
    		        //刷新实时人数
    		    	_refreshfcount();
	    		});
	    	}
	    }
	    
	    //删除组员推送 删除CLIENT_ID 并从群组列表中删除
	    var _remove_group=function(gid){
	    	if($("#_grouplist").find("li").length > 0){
	    		//更新群组列表
	    		$("#_grouplist").find("li").each(function(){
    		        if($(this).attr("gid")==gid) $(this).remove();
    		        //刷新实时群组数量
    		        _refreshgroupcount();
	    		});
	    	}
	    }
	    
		//刷新实时人数（群组）
		var _refreshgcount=function(){
			$("#on_group_usercount").empty().append($("#on_group_userlist").find("li").length+"人在线");
	    	$("#off_group_usercount").empty().append($("#off_group_userlist").find("li").length+"人离线");
		}
	    
		//刷新实时人数（好友）
		var _refreshfcount=function(){
	    	$("#online-usercount").empty().append("在线（"+$("#online-userlist").find("li").length+"）");
	    	$("#offline-usercount").empty().append("离线（"+$("#offline-userlist").find("li").length+"）");
		}
		
		//刷新实时群组数量（群组）
		var _refreshgroupcount=function(){
	    	$("#group-count").empty().append("群组（"+$("#_grouplist").find("li").length+"）");
		}
		
	    // 发言
	    var _say=function(from_client_uid, from_client_name, content, time, path){
	    	var $dialog = $("#dialog");
	    	var $li=$('<li></li>');
	    	$li.addClass("wtimeline");
	    	$li.appendTo($dialog);
			$li.append(_tpl_chat);
			$li.find('[data-chat-name]').text(from_client_name);
			$li.find('[data-chat-time]').text(time);
			//发送文件
			if(path){
				$li.find('[data-chat-content]').html('发送了文件'+content+'<a href="'+_url_root+'/api/download/&path='+path+'&name='+content+'" class="btn btn-primary btn-round" target="_blank">点击下载</a>');
			}else{
				$li.find('[data-chat-content]').html(content);
			}
	        //聊天页面加入滚动机制
	        if(_scene=='2'||_scene=='3')
	        	_scrollToBottom("dialogall");
	    }
	    
	    //推送消息
	    var _pushinfo=function(from_client_uid, from_client_name, content, time, path){
	    	var allcounts = $("#infocount").text()*1+1*1;
	    	$("#infocount").text(allcounts);
	    	if($("#information").find("li").length > 0){
	    		var existinfo = false;
	    		$("#information").find("li").each(function(){
	    			if($(this).attr("uid")==from_client_uid){
	    				var count = $(this).find(".info-number").text()*1+1*1;
	    				var text = time+"&nbsp;&nbsp;<span class=\"badge info-number message\">"+count+"</span>";
	    				$(this).find(".time_info").html(text);
	    				if(path){
	    					$(this).find(".text_info").html("发送了文件"+content);
	    				}else{
		    				$(this).find(".text_info").html(content);
	    				}
	    				existinfo = true;
	    			}
	    		});
	    		
	    		if(!existinfo){
	    			$("#information").append(_tpl_info);
	    			$("#information li:last").find("li").attr('uid',from_client_uid);
	    			$("#information li:last").find("li a").attr('href',_url_root+'/chatgroup/privatechat&uid='+from_client_uid);
	    			$("#information li:last").find("img").attr('src',_http_root+'/assets/images/avatar.jpeg');
	    			$("#information li:last").find(".text_head").html(from_client_name);
	    			var text = time+"&nbsp;&nbsp;<span class=\"badge info-number message\">1</span>";
	    			$("#information li:last").find(".time_info").html(text);
	    			if(path){
	    				$("#information li:last").find(".text_info").html("发送了文件"+content);
	    			}else{
	    				$("#information li:last").find(".text_info").html(content);
	    			}
	    		}
    		}else{
    			$("#information").append(_tpl_info);
    			$("#information").find("li").attr('uid',from_client_uid);
    			$("#information").find("li a").attr('href',_url_root+'/chatgroup/privatechat&uid='+from_client_uid);
    			$("#information").find("img").attr('src',_http_root+'/assets/images/avatar.jpeg');
    			$("#information").find(".text_head").html(from_client_name);
    			var text = time+"&nbsp;&nbsp;<span class=\"badge info-number message\">1</span>";
    			$("#information").find(".time_info").html(text);
    			if(path){
					$("#information").find(".text_info").html("发送了文件"+content);
				}else{
					$("#information").find(".text_info").html(content);
				}
    		}
	    }
	    
	    //好友申请推送
	    var _pushaddfriend=function(from_client_uid, from_client_name, touid, sendtime){
	    	var $test3 = $("#test3");
	    	var $div=$('<div></div>');
			$div.prependTo($test3);
			$div.append(_tpl_addfriends);
			$div.attr('uid',from_client_uid).addClass('addfriend');
			$div.find('[data-chat-addfriend-name]').text(from_client_name);
			$div.find('[data-chat-addfriend-time]').prepend(sendtime);
			//申请通过
//	    	$("#test3").delegate("#pass","click",function(){
	    	$("#pass").bind("click",function(){	
	    		var uid = $(this).parents('.addfriend').attr("uid");
	    		_fnAjax(_url_root+'/index/addFriendOK', {"uid":uid}, _passaddfriend);
	    	})
	    	//申请未通过
//	    	$("#test3").bind("#refuse","click",function(){
	    	$("#refuse").bind("click",function(){
	    		var uid = $(this).parents('.addfriend').attr("uid");
	    		_fnAjax(_url_root+'/index/addFriendFail', {"uid":uid}, _refuseaddfriend);
	    	})
	    }
	    
	    //触发事件
		var _onloads=function(){
            $("#client_name").html(_name);
			//管理员删除群组
            $(".delgroup").click(function(){
				var gid = $(this).parent().attr("gid");
				_fnAjax(_url_root+'/chatgroup/delGroup', {"gid":gid});
	    		$(this).parent().remove();
			})
			
			$("#send").click(function(){
			      var content = $("#textarea").val();
			      //群聊
			      if(_scene=='2'){
			    	  ws.send(JSON.stringify({"type":"group_say","client_uid":_uid,"client_name":_name,"img":_img,"content":content,"room_id":_room_id,"scene":_scene}));
			    	  $("#textarea").val("");
			      }
			      //私聊
			      if(_scene=='3'){
			    	  //好友判断
			    	  _fnAjax(_url_root+'/index/checkFriend', {"fuid":_room_id}, _sendprivatesay);
//			    	  ws.send(JSON.stringify({"type":"private_say","client_uid":_uid,"client_name":_name,"img":_img,"content":content,"room_id":_room_id,"scene":_scene}));
				  }
//			      $("#textarea").val("");
			      $("#textarea").focus();
			})
			$("#textarea").keydown(function(event) {
		        if (event.keyCode == "13") {
				      var content = $("#textarea").val();
				      //群聊
				      if(_scene=='2'){
				    	  ws.send(JSON.stringify({"type":"group_say","client_uid":_uid,"client_name":_name,"img":_img,"content":content,"room_id":_room_id,"scene":_scene}));
				    	  $("#textarea").val("");
				      }
				      //私聊
				      if(_scene=='3'){
				    	  //好友判断
				    	  _fnAjax(_url_root+'/index/checkFriend', {"fuid":_room_id}, _sendprivatesay);
					  }
//				      $("#textarea").val("");
				      $("#textarea").focus();
		        }
		    });
			
			//添加好友-搜索
			$("#searchfriends").click(function(){
				var _searchname = $("input[name=username]").val();
				_fnAjax(_url_root+'/index/searchUsers', {"name":_searchname}, _showSearchFriends);
			});
            
            //群聊
            if(_scene=='2'){
            	//群组GID
            	var _gid = _GetQueryString("gid");
            	//加载群组信息
            	_fnAjax(_url_root+'/chatgroup/ajaxGroupinfo', {"gid":_gid}, _chatGroupinfo);
            }
            //私聊
            if(_scene=='3'){
            	//私聊对象的UID
            	var _touid = _GetQueryString("uid");
            	//加载私聊对象的信息
            	_fnAjax(_url_root+'/chatgroup/ajaxChatUserinfo', {"uid":_touid}, _chatUserinfo);
            	//加载与私聊对象所有未读的消息
            	_fnAjax(_url_root+'/chatgroup/ajaxUnreadMessage', {"uid":_touid}, _unreadmessageList);
            	//当前登录用户与该私聊对象的所有聊天记录都设为【已读】
            	_fnAjax(_url_root+'/chatgroup/ajaxSetread', {"uid":_touid}, _setRead);
                //上传并发送文件
                _uploadfile();
            }

			//加载群组列表
			_fnAjax(_url_root+'/index/ajaxGrouplist', {"uid":_uid}, _groupList);
            //加载留言信息（私聊）
			_fnAjax(_url_root+'/index/ajaxMessages', {"uid":_uid}, _messagesList);
            //加载消息列表（好友申请等）
            _fnAjax(_url_root+'/index/ajaxFriendMessage', {"uid":_uid}, _fmessagesList);
            
            //注销操作
            $(".logout_button").click(function(){
            	var loginout_data = JSON.stringify({"type":"logout","client_uid":_uid,"client_name":_name,"img":_img,"room_id":_room_id,"scene":_scene});
	    		ws.send(loginout_data);
            })
            
		}
		
		//取GET值
		var _GetQueryString=function(name)
		{
		     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		     var r = window.location.search.substr(1).match(reg);
		     if(r!=null)return  unescape(r[2]); return null;
		}
		
		//检索好友 数据回调
		var _showSearchFriends=function(e){
			if(!e.status){
				$("#searcharea").empty().text("该用户不存在！");
				return false;
			}
			$("#searcharea").empty();
			var $userlist = $('<div class="row"></div>');
			for(var p=0;p<e.data.length;p++){
				var $div=$('<div class="col-md-3 col-sm-6 col-xs-12"></div>');
				$div.appendTo($userlist);
				$div.append(_tpl_userhtml);
				$div.find('[data-chat-addfriend-name]').text(e.data[p].NAME);
				$div.find('img[data-chat-addfriend-img]').attr('src', _img_url+e.data[p].IMG).attr('title', e.data[p].NAME);
				$div.find('img[data-chat-addfriend-img]').css("height", "100").css("width", "100");
				$div.find('img[data-chat-addfriend-img]').bind("error",function(){this.src=_img_url+_error_img;});
				//在线状态
				if(e.data[p].online=='1'){
					$div.find('[data-chat-addfriend-label]').append(_tpl_onlinehtml);
				}else{
					$div.find('[data-chat-addfriend-label]').append(_tpl_offlinehtml);
				}
				//非好友
				if(e.data[p].isfriend!='1'){
					$div.find('[data-chat-addfriend-label]').append(_tpl_addfriendhtml);
					$div.find('.addfriend').attr('uid',e.data[p].UID);
				}
			}
			$userlist.appendTo($("#searcharea"));
			//好友申请触发事件
	    	$("#searcharea").delegate(".addfriend","click",function(){
	    		var _uid = $(this).attr("uid");
//	    		_ajaxSend(_uid);
	    		_fnAjax(_url_root+'/index/sendAddFriend', {"uid":_uid}, _addFriend);
	    	});
			return true;
		}
		
		//发送好友申请 数据回调
		var _addFriend=function(e){
			if(!e.status){
				alert("申请失败！");
				return false;
			}
			if(e.num==1){
				alert("已是好友，无须再次申请！");
				return false;
			}
			if(e.num==2){
				alert("好友请求已发送，请勿重复发送请求！");
				return false;
			}
			if(e.num==3){
				alert("发送成功，请等待！");
				//发送推送信息
				if(e.uid){
					ws.send(JSON.stringify({"type":"send_addfriend","client_uid":_uid,"client_name":_name,"img":_img,"touid":e.uid,"room_id":_room_id,"scene":_scene}));
				}
				return true;
			}
			alert("操作失败！");
			return false;
		}
		
		//删除好友 数据回调
		var _delFriend=function(e){
			if(!e.status){
				alert("删除失败！");
				return false;
			}
			if(e.status){
				//发送推送信息
				if(e.uid){
					ws.send(JSON.stringify({"type":"del_friend_ok","client_uid":_uid,"client_name":_name,"img":_img,"uid":e.uid,"room_id":_room_id,"scene":_scene}));
				}
				return true;
			}
			alert("删除失败！");
			return false;
		}
		
		//删除组员 数据回调 关闭群聊窗口
		var _closeGroupwindow=function(e){
			if(!e.status){
				return false;
			}
			if(e.status){
				//发送推送信息
				if(e.uid){
					ws.send(JSON.stringify({"type":"del_groupmember_ok","client_uid":_uid,"client_name":_name,"img":_img,"uid":e.uid,"gid":_room_id,"room_id":_room_id,"scene":_scene}));
				}
				return true;
			}
			return false;
		}
		
		//群组数据回调
		var _chatGroupinfo=function(e){
			if(!e.status){
				$("#chatgroup").empty();
				return false;
			}
			$("#chatgroup").prepend('群组聊天室【'+e.data.name+'】');
			return true;
		}
		
		//私聊对象数据回调
		var _chatUserinfo=function(e){
			if(!e.status){
				$("#chatuser").empty();
				return false;
			}
			$("#chatuser").prepend('与【'+e.data.NAME+'】聊天');
			return true;
		}
		
		//设为已读回调
		var _setRead=function(e){
			if(!e.status){
				return false;
			}
			return true;
		}
		
		//私聊未读消息回调
		var _unreadmessageList=function(e){
			if(!e.status){
				$("#dialog").empty();
				return false;
			}
			
			var $dialog = $("#dialog");
			for(var p=0;p<e.data.length;p++){
				var $li=$('<li></li>');
		    	$li.addClass("wtimeline");
		    	$li.appendTo($dialog);
				$li.append(_tpl_chat);
				$li.find('[data-chat-name]').text(e.data[p].FROMNAME);
				$li.find('[data-chat-time]').text(e.data[p].TIME);
				//发送的文件
				if(e.data[p].PATH!=''){
					$li.find('[data-chat-content]').html('发送了文件'+e.data[p].CONTENT+'<a href="'+_url_root+'/api/download/&path='+e.data[p].PATH+'&name='+e.data[p].CONTENT+'" class="btn btn-primary btn-round" target="_blank">点击下载</a>');
				}else{
					$li.find('[data-chat-content]').text(e.data[p].CONTENT);
				}
			}
			return true;
		}
		
		//发送私聊消息回调
		var _sendprivatesay=function(e){
			if(!e.status){
				alert('发送失败，对方不是您的好友！');
				return false;
			}
			if(e.status){
				var _content = $("#textarea").val();
				//发送私聊信息
				ws.send(JSON.stringify({"type":"private_say","client_uid":_uid,"client_name":_name,"img":_img,"content":_content,"room_id":e.uid,"scene":_scene}));
				$("#textarea").val("")
				return true;
			}
			alert("发送失败！");
			return false;
		}
		
		//好友申请列表回调
		var _fmessagesList=function(e){
			if(!e.status){
				$("#test3").empty();
				return false;
			}
			var $test3 = $("#test3");
			for(var p=0;p<e.data.length;p++){
				var $div=$('<div></div>');
				$div.appendTo($test3);
    			$div.append(_tpl_addfriends);
    			$div.attr('uid',e.data[p].UID).addClass('addfriend');
    			$div.find('[data-chat-addfriend-name]').text(e.data[p].NAME);
    			$div.find('[data-chat-addfriend-time]').prepend(e.data[p].SENDTIME);
			}
			//申请通过
	    	$("#test3").delegate("#pass","click",function(){
	    		var uid = $(this).parents('.addfriend').attr("uid");
	    		_fnAjax(_url_root+'/index/addFriendOK', {"uid":uid}, _passaddfriend);
	    	})
	    	//申请未通过
	    	$("#test3").delegate("#refuse","click",function(){
	    		var uid = $(this).parents('.addfriend').attr("uid");
	    		_fnAjax(_url_root+'/index/addFriendFail', {"uid":uid}, _refuseaddfriend);
	    	})
			return true;
		}
		
		//好友申请通过回调
		var _passaddfriend=function(e){
			if(e.status){
//				$("#test3").find("[uid='"+e.uid+"']").remove();
				ws.send(JSON.stringify({"type":"send_addfriend_ok","client_uid":_uid,"client_name":_name,"img":_img,"touid":e.uid,"toname":e.name,"toimg":e.img,"room_id":_room_id,"scene":_scene}));
				return true;
			}
			alert("操作失败");
		}
		
		//好友申请拒绝回调
		var _refuseaddfriend=function(e){
			if(e.status){
//				$("#test3").find("[uid='"+e.uid+"']").remove();
				ws.send(JSON.stringify({"type":"send_addfriend_refuse","client_uid":_uid,"client_name":_name,"img":_img,"touid":e.uid,"room_id":_room_id,"scene":_scene}));
				return true;
			}
			alert("操作失败");
		}
		
		//未读留言列表回调
		var _messagesList=function(e){
			if(!e.status){
				$("#grouplist").empty();
				$("#infocount").empty().append('0');
				return false;
			}
			var $message = $('#information');
			for(var p=0;p<e.data.length;p++){
				var $li=$('<li></li>');
				$li.appendTo($message);
    			$li.append(_tpl_messagelist);
    			$li.attr('uid',e.data[p].FROMUID);
    			$li.find('[data-chat-messagelist-link]').attr('href',_url_root+'/chatgroup/privatechat&uid='+e.data[p].FROMUID);
    			$li.find('img[data-chat-messagelist-img]').attr('src',_img_url+e.data[p].FROMIMG).bind("error",function(){this.src=_img_url+_error_img;});
    			$li.find('[data-chat-messagelist-name]').text(e.data[p].FROMNAME);
    			$li.find('[data-chat-messagelist-count]').text(e.data[p].COUNT);
    			$li.find('[data-chat-messagelist-time]').prepend(e.data[p].TIME+'&nbsp;&nbsp;');
    			if(e.data[p].PATH!=''){
    				$li.find('[data-chat-messagelist-content]').text('发送了文件'+e.data[p].CONTENT);
    			}else{
        			$li.find('[data-chat-messagelist-content]').text(e.data[p].CONTENT);
    			}
    		}
			$("#infocount").empty().append(e.total);
			return true;
		}
		
		//群组列表回调
		var _groupList=function(e){
			if(!e.status){
				$("#_grouplist").empty();
				$("#group-count").empty().append("群组（0）");
				return false;
			}
			var $ul = $('<ul class="list-group contacts-list">');
    		for(var p=0;p<e.data.length;p++){
    			var $li=$('<li></li>');
    			$li.appendTo($ul);
    			$li.append(_tpl_grouplist);
    			$li.attr('gid',e.data[p].GID).addClass('list-group-item');
    			$li.find('[data-chat-grouplist-link]').attr('href',_url_root+'/chatgroup/&gid='+e.data[p].GID);
    			$li.find('img[data-chat-grouplist-img]').attr('src',_http_root+'/assets/images/avatar/group.png').attr('title', e.data[p].NAME);
    			$li.find('[data-chat-grouplist-name]').text(e.data[p].NAME);
    			if(e.data[p].ADMIN=='1'){
    				$li.append(_tpl_delgroup);
    			}
	    	}
    		$ul.appendTo($("#_grouplist"));
    		$("#group-count").empty().append("群组（"+e.data.length+"）");

	    	//添加删除事件
	    	$("li").delegate(".delgroup","click",function(){
	    		var gid = $(this).parent().attr("gid");
	    		_fnAjax(_url_root+'/chatgroup/delGroup', {"gid":gid});
	    		$(this).parent().remove();
	    		_refreshgroupcount();
	    	})
			return true;
		}
		
		//上传并发送文件
		var _uploadfile=function(){
			$('#fname').uploadify({
				'formData'     : {
					'folder'	: _folder
				},
				'buttonText':'选择文件',
				'fileObjName':'file',
				'fileSizeLimit':'40MB',//上传大小限制
				//'fileTypeExts':'*.mp4;',
				//'fileTypeDesc':'请选择mp4文件上传',
				'removeCompleted':false,//是否自动将已完成任务从队列中删除
				'swf'      : _http_root+'/js/uploadify/uploadify.swf',
				'uploader' : _url_root+'/api/file_upload',
				'onSWFReady' : function() {//Flash文件载入成功后触发
		            uploadifyQueueData = this.queueData;
		        },
				onUploadSuccess(file, data, response){//上传成功
					ws.send(JSON.stringify({"type":"private_say","client_uid":_uid,"client_name":_name,"img":_img,"content":file.name,"path":data,"room_id":_room_id,"scene":_scene}));
					return true;
					$(".cancel").on("click", function(){
				        //取得本次取消的上传文件ID号
						var fileId = $(this).parents(".uploadify-queue-item").attr("id");
						//将已经上传的文件从上传文件队列中清除（不然取消该已上传的文件后，再选择相同的文件上传将会提示“文件已存在！”
						delete uploadifyQueueData.files[fileId];
				        //将垃圾文件从后台服务器中清除
				        /*
						$.ajax({
				              type: "POST",
				              url: _url_root+"/api/file_destroy",
				              dataType: "json",
				              data: {'data':data,'folder':_folder},
				              success:function(e){
								},
				              error: function(e) {
				              }
				         });
				         */
					});
				}
			});
		}
		
		_init();
	}
})(jQuery);