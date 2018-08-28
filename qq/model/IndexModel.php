<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}
/**
 * moa用户主页面_模型
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.17
 */
class IndexModel extends Model{
	
	protected $_has_MOO =  false;				//是否有MOO组件
	protected $_has_CHAT = false;				//是否有CHAT组件
	protected $_has_MF = false;						//是否有MF组件
	protected $_moo_session = null;				//MOO会话
	protected $_moa_session = null;				//MOA会话
	
	/**
	 * 构造函数
	 * @param unknown_type $controller
	 * @param unknown_type $param
	 */
	function __construct($controller, $param=array()){
		parent::__construct($controller, $param);
		try{
			$this->_has_MOO = $this->plugins->HasPlugin('MOO_User');
			$this->_has_CHAT=$this->plugins->HasPlugin('MIM');
			$this->_has_MF = $this->plugins->HasPlugin('MF');
			$this->_moa_session = new MOA_SESSION();
			if($this->_has_MOO){
				$this->_moo_session = new MOO_SESSION();
				$this->_moo_session->login_check(APP_URL_ROOT.'/login');					//校验登录会话
			}else{
				$this->_moa_session->login_check(APP_URL_ROOT.'/login');					//校验登录会话
			}
		}catch(Exception $e){
		}
	}
	
	/**
	 * MoouserPlugin()判断是否启用MOO用户组件
	 * @return boolean
	 */
	function MoouserPlugin(){
		if($this->_has_MOO){
			return  true;
		}else{
			return false;
		}
	}
	

	
	/**
	 * Mooindex()MOO用户个人中心信息
	 * @return $result array 
	 */
	 function Mooindex(){
		$result=array();
		$user_data = array();					//用户信息
		$account_data = array();			//账户信息
		try {
			$objMOOUser = new MOO_User($this->_moo_session->uid);
			$user_data['sid'] = $objMOOUser->sid;
			$user_data['uid'] = $objMOOUser->uid;
			$user_data['name'] = $objMOOUser->username;
			$user_data['phone'] = $objMOOUser->phone;
			$user_data['mail'] = $objMOOUser->mail;
			$user_data['sex'] = $objMOOUser->sex;
			$user_data['birthdate'] = $objMOOUser->birthdate;
			foreach($objMOOUser->getAccount() as $objAccount){
				array_push($account_data, array(
						'sid' => $objAccount->sid,
						'uid' => $objAccount->account_full_id,
						'name' => $objAccount->account_name,
						'status' => $objAccount->status,
						'is_main' => $objAccount->isMain(),
						'is_use' => $this->_moa_session->uid==$objAccount->account_full_id?true:false,
						'img' => MOO::config('_root_host').'/'.MOO::config('_path_upload').'/'.$objAccount->head_img,
				));
			}
		} catch (Exception $e) {}
		$result['user_data']=$user_data;
		$result['account_data']=$account_data;
		return $result;
	}

	/**
	 * Moaindex()MOA用户个人中心信息
	 * @return $result array 
	 */
	 function Moaindex(){
		$result=array();
		$user_data = array();					//用户信息
		try {
			$objMOAUser = new MOA_User($this->_moa_session->uid);
			$user_data['sid'] = $objMOAUser->sid;
			$user_data['uid'] = $objMOAUser->uid;
			$user_data['name'] = $objMOAUser->name;
			$user_data['phone'] = $objMOAUser->phone;
			$user_data['mail'] = $objMOAUser->email;
			$user_data['sex'] = $objMOAUser->sex;
			$user_data['img'] = MOA::config('_root_host').'/'.MOA::config('_path_upload').'/'.$objMOAUser->img;
		} catch (Exception $e) {}
		$result['user_data']=$user_data;
		return $result;
	}
	

	

	/**
	 * Moouserinfo()MOO用户信息
	 * @return $result array
	 */
	 function Moouserinfo(){
		$result=array();
		try{
			$objMOOUser = new MOO_User($this->_moo_session->uid);
		}catch(Exception $e){}
		$result['uid']=$objMOOUser->uid;
		$result['sid']=$objMOOUser->sid;
		$result['username']=$objMOOUser->username;
		$result['mail']=$objMOOUser->mail;
		$result['phone']=$objMOOUser->phone;
		$result['activation']=$objMOOUser->activation;
		$result['sex']=$objMOOUser->sex;
		$result['birthdate']=$objMOOUser->birthdate;
		return $result;
	}

	/**
	 *  Moauserinfo()MOA用户信息
	 * @return $result array
	 */
	 function Moauserinfo(){
		$result=array();
		try{
			$objMOAUser = new MOA_User($this->_moa_session->uid);
		}catch(Exception $e){}
		$result['sid']=$objMOAUser->sid;
		$result['uid']=$objMOAUser->uid;
		$result['name']=$objMOAUser->name;
		$result['head_img']=MOA::config('_root_host').'/'.MOA::config('_path_upload').'/'.$objMOAUser->img;
		$result['status']=$objMOAUser->status;
		$result['phone']=$objMOAUser->phone;
		$result['email']=$objMOAUser->email;
		$result['sex']=$objMOAUser->sex;
		$result['content']=$objMOAUser->content;
		return $result;
	}
	
	/**
	 * Moouser_submit_edit()提交修改MOO用户信息
	 * @param  $post_data array 提交的修改数据
	 * @return boolean
	 */
	function Moouser_submit_edit($post_data){
		if(!isset($post_data) || $post_data=='') return false;
		$bln_bingo = false;				//是否修改成功
		try{
			$objMOOUser = new MOO_User($this->_moo_session->uid);
			$bln_bingo = $objMOOUser->update($post_data);
			//同步MOA数据接口
			$objApi = new MOO_API($objMOOUser->uid);
			$objApi->SynchronizeMOAUser();
		}catch(Exception $e){}
		if($bln_bingo){
			//同步更新当前会话
			$this->_moo_session->makeSession($objMOOUser->uid);
			$this->_moa_session->makeSession($this->_moa_session->uid);
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Moauser_submit_edit()提交修改MOA用户信息
	 * @param  $post_data array 提交的修改数据
	 * @param  $files array 上传头像图片
	 * @return boolean
	 */
	function Moauser_submit_edit($post_data,$files=''){
		if(!isset($post_data) || $post_data=='') return false;
		$bln_bingo = false;				//是否修改成功
		try{
			$objMOAUser = new MOA_User($this->_moa_session->uid);
			//检测上传图片
			if($files['name']!=''){
				$head_img_file_path = $objMOAUser->uploadHeadImg($files['tmp_name'], true, $files['name']);
				if($head_img_file_path !== false) $post_data['img'] = $head_img_file_path;
			}
			$bln_bingo = $objMOAUser->update($post_data);
		}catch(Exception $e){}
		if($bln_bingo){
			//更新会话
			$this->_moa_session->makeSession($this->_moa_session->uid);
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Moouser_account_info()MOO子账户数据
	 * @param  $account_sid string moo子账户SID
	 * @return multitype:string NULL
	 */
	function Moouser_account_info($account_sid){
		$objAccount = $this->Moouser_account_obj($account_sid);
		$result=array(
				'account_full_id'=>$objAccount->account_full_id,
				'sid'=>$objAccount->sid,
				'account_name'=>$objAccount->account_name,
				'is_main'=>$objAccount->is_main,
				'head_img'=>MOOConfig::_root_host.'/'.MOOConfig::_path_upload.'/'.$objAccount->head_img,
				'status'=>$objAccount->status
		);
		return $result;
	}
	
	/**
	 * Moouser_account_obj()MOO子账户对象
	 * @param  $account_sid string moo子账户SID
	 * @return unknown|NULL
	 */
	function Moouser_account_obj($account_sid){
		$bln_auth = false;
		if($this->_has_MOO&&$account_sid!=''){
			try{
				$objMOOUser = new MOO_User($this->_moo_session->uid);
				foreach($objMOOUser->getAccount() as $objAccount){
					if($objAccount->sid == $account_sid){
						$bln_auth = true;
						return $objAccount;
					}
				}
			}catch(Exception $e){
				$bln_auth = false;
			}
		}
		if(!$bln_auth) return null;
	}
	
	/**
	 * Moouser_account_submit_edit()提交修改MOO子账户信息
	 * @param  $account_sid string moo子账户SID
	 * @param  $post_data array 提交修改的数据
	 * @param  $files array 上传头像图片
	 * @return boolean
	 */
	function Moouser_account_submit_edit($account_sid,$post_data,$files=''){
		if(!isset($account_sid) || $account_sid=='' || !isset($post_data) || $post_data=='') return false;
		$bln_bingo = false;				//是否修改成功
		try{
			$objAccount = $this->Moouser_account_obj($account_sid);
			if(is_null($objAccount)){
				return false;
			}
			//检测上传图片
			if($files['name']!=''){
				$heam_img_file_path = $objAccount->uploadHeadImg($files['tmp_name'], true, $files['name']);
				if($heam_img_file_path !== false) $post_data['head_img'] = $heam_img_file_path;
			}
			$bln_bingo = $objAccount->update($post_data);
			if($bln_bingo){
				//同步对应的MOA用户信息,并更新MOA会话
				$objApi = new MOO_API($objAccount->uid);
				$objApi->SynchronizeMOAUser($objAccount->account_id) && $this->_moa_session->makeSession($this->_moa_session->uid);
				//同步MIM用户
				if($this->_has_CHAT){
					try {
						$objMIMUser = MIM_User::GetInstanceByUID($objAccount->account_full_id);
						$objMIMUser->update(array('img'=>$heam_img_file_path, 'name'=>$post_data['account_name']));
					} catch (Exception $e) {
					}
				}
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}
	
	/**
	 * Moouser_account_submit_add()提交添加MOO子账户信息
	 * @param  $moo_user_uid string moo主账户UID
	 * @param  $account_name string moon子账户名称
	 * @param unknown_type $files array moon子账户头像图片
	 * @return boolean
	 */
	function Moouser_account_submit_add($moo_user_uid,$account_name,$files=''){
		if(!isset($moo_user_uid) || $moo_user_uid=='' || !isset($account_name) || $account_name=='') return false;
		$post_data = array();
		$bln_bingo = false;
		try{
			$objMOOUser = new MOO_User($moo_user_uid);
			$post_data['uid'] = $objMOOUser->uid;
			$post_data['account_name']=$account_name;
			$objAccount = MOO_Account::Add($post_data);
			//检测上传图片
			if($files['name']!=''){
				$head_img_file_path = $objAccount->uploadHeadImg($files['tmp_name'], true,$files['name']);
				if($head_img_file_path !== false) $objAccount->update(array('head_img'=>$head_img_file_path));
			}
			$bln_bingo = true;
			//通过Api创建MOA用户
			$objApi = new MOO_API($moo_user_uid);
			$objApi->MOAAddUser($objAccount->account_id);
			if($this->_has_CHAT){
				MIM_User::Add(array(
						'uid' => $objMOOUser->uid.'.'.$objAccount->account_id,
						'password' => $objMOOUser->password,
						'name' => $objAccount->account_name,
						'content' => $objAccount->account_name,
						'phone' => $objMOOUser->phone,
						'email' => $objMOOUser->mail,
						'sex' => $objMOOUser->sex,
						'status' => '1',
						'img' => $objAccount->head_img,
						'birthday' => $objMOOUser->birthdate
				));
			}
		}catch(Exception $e){}
		if($bln_bingo){
			return $objAccount->sid;
		}else{
			return false;
		}
	}
	
	/**
	 * Moouser_account_change()MOO子账户切换
	 * @param  $account_sid string 子账户sid
	 * @return boolean
	 */
	function Moouser_account_change($account_sid){
		if(!isset($account_sid) || $account_sid=='') return false;
		try{
			$objAccount = $this->Moouser_account_obj($account_sid);
			if(is_null($objAccount)){
				return false;
			}
			//切换会话
			$this->_moa_session->makeSession($objAccount->account_full_id);//moa用户
			if($this->_has_CHAT){
				$objMIMUser = MIM_User::GetInstanceByUID($objAccount->account_full_id);
				$token_file = MIM::config('_token_file_path').'/'.$objMIMUser->getTokenId().'.sose';
				file_put_contents($token_file, serialize($objMIMUser->makeTokenValue()));
				$_SESSION['mim'] = $objMIMUser->getTokenId();
			}
			return true;
		}catch(Exception $e){ return false;}
	}
	
	/**
	 * Moouser_account_delete()MOO子账户删除
	 * @param  $account_sid string moo子账户SID
	 * @return boolean
	 */
	function Moouser_account_delete($account_sid){
		if(!isset($account_sid) || $account_sid=='') return false;
		try{
			$objAccount = $this->Moouser_account_obj($account_sid);
			if(is_null($objAccount)){
				return false;
			}
			//接口删除MOA映射的账户
			$objApi = new MOO_API($objAccount->uid);
			$objApi->MOADelUser($objAccount->account_id);
			if($this->_has_CHAT){
				$objMIMUser = MIM_User::GetInstanceByUID($objAccount->account_full_id);
				$objMIMUser->delete();
			}
			//如果当前会话包含删除的账户,还要清除session
			if($this->_moa_session->uid == $objAccount->account_full_id) $this->_moa_session->Destroy();
			//删除MOO账户
			$objAccount->delete();
			return true;
		}catch(Exception $e){ return false;}
	}
	
	/**
	 * Moouser_password_edit()MOO用户密码修改
	 * @param  $password string 提交的新密码
	 * @return boolean
	 */
	function Moouser_password_edit($password){
		if(!isset($password) || $password=='') return false;
		try{
			$objMOOUser = new MOO_User($this->_moo_session->uid);
			$objMOOUser->update(array('password'=>MOO_User::Encrypt($password)));
			//通过Api修改MOA用户
			$objApi = new MOO_API($objMOOUser->uid);
			$objApi->SynchronizeMOAUser();
			return true;
		}catch(Exception $e){
			return false;
		}
	}
	
	/**
	 * Moauser_password_edit()MOA用户密码修改
	 * @param  $password strning 密码
	 * @return boolean
	 */
	function Moauser_password_edit($password){
		if(!isset($password) || $password=='') return false;
		try{
			$objMOAUser = new MOA_User($this->_moa_session->uid);
			$objMOAUser->update(array('password'=>MOA_User::Encrypt($password)));
			return true;
		}catch(Exception $e){
			return false;
		}
	}
	
	/**
	 * Moauser_checkin()用户签到
	 * @param  $type string 签到类型
	 * @return boolean
	 */
	function Moauser_checkin($type){
		if(!isset($type) || $type=='' || !isset($this->_moa_session->uid)) return false;
		try{
			$post=array(
					'uid'=>$this->_moa_session->uid,
					'regtime'=>date('Y-m-d'),
					'checktime'=>date('H:i:s'),
					'checkip'=>$_SERVER['REMOTE_ADDR'],
					'type'=>$type,
					'devse'=>$_SERVER['HTTP_USER_AGENT']
			);
			$checkin = MOA_Attendance::Add($post);
			if($checkin){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){return false;}
	}
	
	/**
	 * Moauser_my_task()获取当前用户最新的任务
	 * @param  $num string 显示条数
	 * @return boolean|multitype:
	 */
	function Moauser_my_task($num){
		if(!isset($this->_moa_session->uid)) return false;
		try{
			$result=array();
			$task_sid = MOA_Task::_getTaskofmy($this->_moa_session->uid,$num);
			if($task_sid){
				foreach ($task_sid as $sid){
					$objTask = new MOA_Task($sid);
					array_push($result,array(
							'sid'=>$objTask->sid,
							'title'=>$objTask->title,
							'content'=>$objTask->content,
							'create_time'=>$objTask->create_time
							));
				}
			}
			return $result;
		}catch(Exception $e){}
	}
	/**
	 * Moauser_my_group() 获取当前用户最新的研究组
	 * @param  $num string 显示条数
	 * @return boolean|multitype:
	 */
	function Moauser_my_group($num){
		if(!isset($this->_moa_session->uid)) return false;
		try{
			$result=array();
			$group_sid = MOA_Group::_getGroupofmy($this->_moa_session->uid, $num);
			if($group_sid){
				foreach ($group_sid as $sid){
					$objGroup = new MOA_Group($sid);
					array_push($result,array(
							'sid'=>$objGroup->sid,
							'title'=>$objGroup->title,
							'content'=>$objGroup->content,
							'create_time'=>$objGroup->create_time
							));
				}
			}
			return $result;
		}catch(Exception $e){ return false;}
	}
	
	/**
	 * MIMuser_my_friends() 获取当前用户的MIM好友
	 * @return multitype:
	 */
	function MIMuser_my_friends(){
		if(!$this->_has_CHAT) return false;
		try{
			$user = MIM_User::GetInstanceByUID($this->_moa_session->uid);
			$friends = array();
			foreach ($user->getFriends() as $objUser){
				array_push($friends,array(
						'sid'=>$objUser->sid,
						'uid'=>$objUser->uid,
						'name'=>$objUser->name,
						'img'=>$objUser->getHeadImg(),
						'status'=>$objUser->status
				));
			}
			return $friends;
		}catch(Exception $e){}
	}
	/**
	 * MIMuser_my_groups() 获取当前用户MIM聊天组
	 * @return multitype:
	 */
	function MIMuser_my_groups(){
		if(!$this->_has_CHAT) return false;
		try{
			$group=array();
			$user = MIM_User::GetInstanceByUID($this->_moa_session->uid);
			foreach ($user->getGroups() as $objGroup){
				array_push($group,array(
						'sid'=>$objGroup->sid,
						'name'=>$objGroup->name,
						));
			}
			return $group;
		}catch(Exception $e){}
	}
	/**
	 * MIMuser_my_record() 获取当前用户MIM所有未读信息
	 * @return multitype:
	 */
	function MIMuser_my_record(){
		if(!$this->_has_CHAT) return false;
		try{
			$result=array();
			$user = MIM_User::GetInstanceByUID($this->_moa_session->uid);
			$chat = MIM_Chat_Record::UnRead($user->sid);
			foreach ($chat as $val){
				$objUser = new MIM_User($val['from']);
				array_push($result,array(
						'cid'=>$val['cid'],
						'from'=>$val['from'],
						'user_img'=>$objUser->getHeadImg(),
						'user_name'=>$objUser->name,
						'user_id'=>$objUser->uid,
						'content'=>$val['content'],
						'time'=>$val['time']
						));
				unset($objUser);
			}	
		return $result;
		}catch(Exception $e){}
	}
	
	/**
	 * MFuser_my_files() 获取当前用户最新上传的媒体文件
	 * @param  $num string 显示条数
	 * @return multitype:
	 */
	function MFuser_my_files($num){
		if(!$this->_has_MF) return false;
		try{
			$result=array();
			$objFiles= MF_File::GetFilesByUser($this->_moa_session->uid,$num);
			foreach ($objFiles as $objfile){
				array_push($result, array(
						'sid'=>$objfile->sid,
						'name'=>$objfile->title,
						'src'=>MFConfig::_root_host.'/'.$objfile->getResources(),
						'size'=>MF_Utils::FormatBytes($objfile->size),
						'create_time'=>$objfile->create_time
						));
			}
			return $result;
		}catch(Exception $e){}
		
	}
	
}
?>