	//添加好友
	$("#btn_add_friends").click(function(){
		var _oSelected=[];
		fnSelectFriend(
				function(oJson){
					var _name="",_id="";
					$.each(oJson,function(i,e){
						_name==""?(_name=e.name):(_name+=","+e.name);
						_id==""?(_id=e.id):(_id+=","+e.id);
					});
					
					$("#name").val(_name);
					$("#uid").val(_id);
				},
				_oSelected,
				"添加好友"
			);
	});
	
	//选择组员
	$("#btn_sel_user").click(function(){
		//已选
		var _names = $("#name").val().split(",");
		var _ids = $("#uid").val().split(",");
		//组装已选内容
		var _oSelected=[];
		$.each(_ids,function(i,e){
			var _oTmp={"id":e,"name":_names[i]}
			_oSelected[i]=_oTmp;
		});
		fnSelectDoctor(
			function(oJson){
				var _name="",_id="";
				$.each(oJson,function(i,e){
					_name==""?(_name=e.name):(_name+=","+e.name);
					_id==""?(_id=e.id):(_id+=","+e.id);
				});
				
				$("#name").val(_name);
				$("#uid").val(_id);
			},
			_oSelected,
			true,
			"选择组员"
		);
	});
	
	
	//群组内添加组员
	$("#btn_add_user").click(function(){
		//已选
		var _names = $("#name").val().split(",");
		var _ids = $("#uid").val().split(",");
		var _gid = $("#gid").val();
		//组装已选内容
		var _oSelected=[];
		$.each(_ids,function(i,e){
			var _oTmp={"id":e,"name":_names[i]}
			_oSelected[i]=_oTmp;
		});
		fnSelectMember(
			function(oJson){
				var _name="",_id="";
				$.each(oJson,function(i,e){
					_name==""?(_name=e.name):(_name+=","+e.name);
					_id==""?(_id=e.id):(_id+=","+e.id);
				});
				
				$("#name").val(_name);
				$("#uid").val(_id);
				console.log(_name);
				console.log(_id);
				$.ajax({
						async: true, 
						url: _REQUEST_HOST+"/chatgroup/addMembers", 
						type:'get',
						data:  {"uid":_id,"gid":_gid}, 
						success: function(e){
							var e = JSON.parse(e);
							if(!e.status){
								alert(e.errtext);return false;
							}
							window.location.reload();
						}
					});
			},
			_oSelected,
			true,
			"选择组员",
			_gid
		);
	});