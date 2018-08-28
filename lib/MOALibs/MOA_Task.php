<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA任务组件类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

@include_once 'MOAConfig.inc.php';
class MOA_Task{
	protected $_dataform = null;					//任务数据对象
	protected $_db = null;								//数据库对象
	protected $_objTaskusers = null;				//任务成员对象数组
	protected $_objTaskmilestone = null;	//任务下里程碑
	
	public $sid;														//任务主键SID
	public $title;													//任务名称
	public $creator;												//任务创建者兼任务管理者
	public $create_time;										//创建时间
	public $content;												//内容介绍
	public $file_type;											//任务下里程碑是否启用文件库
	public $chat_type;										//任务下里程碑是否启用聊天组
	public $mf_group_id;									//任务媒体库ID
	public $is_public;											//公开状态
	public $confirm;												//完成状态
	
	/**
	 * __construct() 构造函数
	 * @param  $sid string 任务SID
	 */
	function __construct($sid){
		$this->_db = GetDB();
		$this->sid = $sid;
		$this->_dataform = new MOA_Task_Dataform($sid);
		$this->title = $this->_dataform->GetProp('TITLE');
		$this->creator = $this->_dataform->GetProp('CREATOR');
		$this->create_time = $this->_dataform->GetProp('CREATE_TIME');
		$this->content = $this->_dataform->GetProp('CONTENT');
		$this->file_type = $this->_dataform->GetProp('FILE_TYPE');
		$this->chat_type = $this->_dataform->GetProp('CHAT_TYPE');
		$this->mf_group_id = $this->_dataform->GetProp('MF_GROUP_ID');
		$this->is_public = $this->_dataform->GetProp('IS_PUBLIC');
		$this->confirm = $this->_dataform->GetProp('CONFIRM');
	}
	
	/**
	 * Add()创建任务
	 * @param   $post array 提交的数据
	 */
	static  function Add($post){
		$data=array();
		if(isset($post['title'])&&$post['title']!='') $data['TITLE'] = $post['title'];
		if(isset($post['creator'])&&$post['creator']!='') $data['CREATOR'] = $post['creator'];
		if(isset($post['create_time'])&&$post['create_time']!='') $data['CREATE_TIME'] =$post['create_time'];
		if(isset($post['content'])&&$post['content']!='') $data['CONTENT'] = $post['content'];
		if(isset($post['file_type'])&&$post['file_type']!='') $data['FILE_TYPE'] = $post['file_type'];
		if(isset($post['chat_type'])&&$post['chat_type']!='') $data['CHAT_TYPE'] = $post['chat_type'];
		if(isset($post['mf_group_id'])&&$post['mf_group_id']!='') $data['MF_GROUP_ID'] = $post['mf_group_id'];
		if(isset($post['is_public'])&&$post['is_public']!='') $data['IS_PUBLIC'] = $post['is_public'];
		if(isset($post['confirm'])&&$post['confirm']!='') $data['CONFIRM'] = $post['confirm'];
		if(!count($data)){
			return null;
		}
		try{
			$add = MOA_Task_Dataform::Add($data);
			return new self($add);
		}catch(Exception $e){ return null;}
	}
	
	static function taskSId($sid){
		if($sid=='') return false;
		try{
			$db=GetDB();
			$sql="SELECT * FROM ".MOAConfig::_table_moa_task." WHERE SID=?";
			$data = $db->GetRow($sql,array($sid));
			if($data){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}
	/**
	 * Del()删除任务
	 */
	function Del(){
		return $this->_dataform->Delete();
	}
	/**
	 * Update()编辑任务
	 * @param  $post array 提交的数据
	 * @return boolean
	 */
	function Update($post){
		$data=array();
		if(isset($post['title'])&&$post['title']!='') $data['TITLE'] = $post['title'];
		if(isset($post['creator'])&&$post['creator']!='') $data['CREATOR'] = $post['creator'];
		if(isset($post['create_time'])&&$post['create_time']!='') $data['CREATE_TIME'] =$post['create_time'];
		if(isset($post['content'])&&$post['content']!='') $data['CONTENT'] = $post['content'];
		if(isset($post['file_type'])&&$post['file_type']!='') $data['FILE_TYPE'] = $post['file_type'];
		if(isset($post['chat_type'])&&$post['chat_type']!='') $data['CHAT_TYPE'] = $post['chat_type'];
		if(isset($post['mf_group_id'])&&$post['mf_group_id']!='') $data['MF_GROUP_ID'] = $post['mf_group_id'];
		if(isset($post['is_public'])&&$post['is_public']!='') $data['IS_PUBLIC'] = $post['is_public'];
		if(isset($post['confirm'])&&$post['confirm']!='') $data['CONFIRM'] = $post['confirm'];
		if($this->_dataform->Update($data)){
			if(isset($post['title'])&&$post['title']!='') $this->title = $post['title'];
			if(isset($post['creator'])&&$post['creator']!='') $this->creator = $post['creator'];
			if(isset($post['create_time'])&&$post['create_time']!='') $this->create_time = $post['create_time'];
			if(isset($post['content'])&&$post['content']!='') $this->content = $post['content'];
			if(isset($post['file_type'])&&$post['file_type']!='') $this->file_type = $post['file_type'];
			if(isset($post['chat_type'])&&$post['chat_type']!='') $this->chat_type = $post['chat_type'];
			if(isset($post['mf_group_id'])&&$post['mf_group_id']!='') $this->mf_group_id=$post['mf_group_id'];
			if(isset($post['is_public'])&&$post['is_public']!='') $this->is_public = $post['is_public'];
			if(isset($post['confirm'])&&$post['confirm']!='') $this->confirm = $post['confirm'];
			return true;
		}else{
			return false;
		}
	}
	/**
	 * getTaskMilestone()获取任务内里程碑
	 * @param  $uid string 里程碑SID
	 * @param  $bln_load_from_db boolean 是否从数据库读取
	 * @return boolean|NULL
	 */
	function getTaskMilestone($mid='', $bln_load_from_db=false){
		$arrRet = array();
		if(is_null($this->_objTaskmilestone) || $bln_load_from_db){
			$this->_objTaskmilestone = array();
			$data_list = $this->_db->Select(MOAConfig::_table_moa_task_milestone,array('T_SID'=>$this->sid));
			if($data_list){
				foreach ($data_list as $data){
					try{
						$this->_objTaskmilestone[$data['SID']] = new MOA_Taskmilestone($data['SID']);
					}catch(Exception $e){}
				}
			}
		}
		if($mid!=''){
			if(!isset($this->_objTaskmilestone[$mid])) return false;
			else return $this->_objTaskmilestone[$mid];
		}else{
			return $this->_objTaskmilestone;
		}
	}
	
	
	/**
	 * addTaskuser() 添加任务人员
	 * @param  $uid string 用户UID
	 * @return boolean
	 */
	function addTaskuser($uid,$type=false){
		if($uid=='') return false;
		if($this->getTaskuser($uid)!==false) return false;
		if($this->_db->Insert(MOAConfig::_table_moa_task_user,array('T_SID'=>$this->sid,'T_UID'=>$uid))){
			try{
				$this->_objTaskusers[$uid] = new MOA_User($uid);
				if($type){
					$chat = CHAT_GROUP::getGroupInfo($this->sid, '0');
					$chat_user = CHAT_GROUP::addMember($uid, $chat['SID']);
				}
				return true;
			}catch(Exception $e){ return false;}
		}else{ return false;}
	}
	
	/**
	 * updTaskuser()更新任务用户
	 * @param  $uid_list array 用户UID数组
	 * @return boolean
	 */
	function updTaskuser($uid_list){
		if(!is_array($uid_list) || count($uid_list)==0) return false;
		if($this->_db->Delete(MOAConfig::_table_moa_task_user,array('T_SID'=>$this->sid))){
			$this->_objTaskusers=array();
			foreach ($uid_list as $uid){
				if($this->_db->Insert(MOAConfig::_table_moa_task_user,array('T_SID'=>$this->sid,'T_UID'=>$uid))){
					//更新用户对象
					$this->_objTaskusers[$uid] = new MOA_User($uid);
				}
			}
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * delTaskuser()删除某个任务人员
	 * @param  $uid string 用户UID
	 * @return boolean
	 */
	function delTaskuser($uid){
		$this->getTaskuser();
		//从任务人员表中删除
		if(isset($this->_objTaskusers[$uid]) && $this->_db->Delete(MOAConfig::_table_moa_task_user,array('T_SID'=>$this->sid,'T_UID'=>$uid))){
			unset($this->_objTaskusers[$uid]);
			$chat = CHAT_GROUP::getGroupInfo($this->sid, '0');
			$this->_db->Delete(MOAConfig::_table_chat_group_user,array('GID'=>$chat['SID'],'UID'=>$uid));
			return true;
		}else return false;
	}
	/**
	 * delAllTaskuser()删除任务全部用户
	 * @return boolean
	 */
	function delAllTaskuser(){
		try{
			$del = $this->_db->Delete(MOAConfig::_table_moa_task_user,array('T_SID'=>$this->sid));
			if($del){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}
	
	
	/**
	 * delTaskmiluser()根据用户UID删除任务下里程碑人员
	 * @param  $uid string 用户UID
	 * @return boolean
	 */
	function delTaskmiluser($uid)
	{
		$mil = $this->getTaskMilestone();
		try{
			foreach ($mil as $mid=>$objMil){
				$this->_db->Delete(MOAConfig::_table_moa_task_milestone_user,array('M_SID'=>$objMil->sid,'M_UID'=>$uid));
				$chat = CHAT_GROUP::getGroupInfo($this->sid, $objMil->sid);
				$this->_db->Delete(MOAConfig::_table_chat_group_user,array('GID'=>$chat['SID'],'UID'=>$uid));
			}
			return true;
		}catch(Exception $e){ return false;}
	}
	

	
	
	
	/**
	 * getTaskuser()获取任务内人员
	 * @param  $uid string 人员UID
	 * @param  $bln_load_from_db boolean 是否从数据库读取
	 * @return boolean|NULL
	 */
	function getTaskuser($uid='', $bln_load_from_db=false){
		$arrRet = array();
		if(is_null($this->_objTaskusers) || $bln_load_from_db){
			$this->_objTaskusers=array();
			//从数据库中加载
			$data_list = $this->_db->Select(MOAConfig::_table_moa_task_user,array('T_SID'=>$this->sid),array('select'=>'T_UID'));
			if($data_list){
				foreach ($data_list as $data){
					try{
						$this->_objTaskusers[$data['T_UID']]= new MOA_User($data['T_UID']); 
					}catch(Exception $e){}
				}
			}
		}
		if($uid!=''){
			if(!isset($this->_objTaskusers[$uid])) return false;
			else return $this->_objTaskusers[$uid];
		}else{
			return $this->_objTaskusers;
		}
	}
	
	/**
	 * _getTaskuserinfo()获取任务用户信息
	 * @param  $arrUid array 任务用户UID数组
	 */
	public static function _getTaskuserinfo($arrUid){
		$arrRet=array();
		try{
			$db=GetDB();
			$where='';
			foreach ($arrUid as $uid){
				$sql=" SELECT * FROM ".MOA::config('_table_moa_user')." WHERE UID = ?";
				$query = $db->GetRow($sql,array($uid));
				array_push($arrRet,array(
						'sid'=>$query['SID'],
						'uid'=>$query['UID'],
						'password'=>$query['PASSWORD'],
						'name'=>$query['NAME'],
						'content'=>$query['CONTENT'],
						'phone'=>$query['PHONE'],
						'email'=>$query['EMAIL'],
						'is_admin'=>$query['IS_ADMIN'],
						'sex'=>$query['SEX'],
						'status'=>$query['STATUS'],
						'img'=>$query['IMG']
						));
			}
		}catch (Exception $e){}
		return $arrRet;
	}
	
	/**
	 * getNewMF_group_id()获取最新里程碑的文件库GOURP_ID
	 * @return number|boolean
	 */
	function getNewMF_group_id(){
		try{
			$db=GetDB();
			$sql="SELECT COUNT(*) FROM ".MOAConfig::_table_moa_task_milestone." WHERE T_SID = ?";
			$num = $db->GetRow($sql,array($this->sid));
			$newMF_group_id = intval($this->mf_group_id+$num['COUNT(*)']);
			return $newMF_group_id;
		}catch(Exception $e){ return false;}
	}
	
	function getChat(){
		$query = $this->_db->Select(MOAConfig::_table_moa_task_chat, array('TID'=>$this->sid, 'MID'=>'0'), array('select'=>'MIM_GROUP_ID'));
		if($query) return $query[0]['MIM_GROUP_ID'];
		else return '';
	}
	
	function createChat($mim_chat_id){
		return $this->_db->Insert(MOAConfig::_table_moa_task_chat, array('TID'=>$this->sid, 'MIM_GROUP_ID'=>$mim_chat_id));
	}
	
	/**
	 * _getTaskofmy() 根据用户UID获取属于该用户所管理的任务
	 * @param  $uid string 用户UID
	 * @param  $num string 显示条数
	 */
	static function _getTaskofmy($uid,$num){
		if(!isset($uid) || $uid=='') return false;
		try{
			if(!isset($num) || $num=='') $num='10';
			$result=array();
			$db=GetDB();
			$sql="SELECT SID FROM ".MOAConfig::_table_moa_task." WHERE CREATOR = ? ORDER BY CREATE_TIME DESC LIMIT 0,".$num;
			$data = $db->GetAll($sql,array($uid));
			if($data){
				foreach ($data as $val){
					array_push($result,$val['SID']);
				}
				return $result;
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}
	
}

/**
 * MOA任务dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MOA_Task_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MOAConfig::_table_moa_task;
	//数据字段名称
	protected static $_co_dataform_field = array(
			'SID',
			'TITLE',
			'CREATOR',
			'CREATE_TIME',
			'CONTENT',
			'FILE_TYPE',
			'CHAT_TYPE',
			'MF_GROUP_ID',
			'IS_PUBLIC',
			'CONFIRM'
	);
	
	//数据主键字段名称
	protected static $_co_dataform_main_key = array('SID');
	
	//数据库连接配置
	static $_co_dataform_db_name = '';
	
	/**
	 * 构造函数
	 * @param	sid string 目录sid
	 */
	function __construct($sid){
		$this->_co_dataform_main_key_value = array('SID'=>$sid);
		if(!$this->_CODataformLoad()){
			//数据加载失败
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_task_sid, MOAConfig::_err_code_invalid_task_sid);
		}
	}
	
	/**
	 * 更新数据
	 * @param	data array 更新的数组
	 * @return	boolean
	 */
	function Update($data){
		return parent::_CODataformUpdate($data);
	}
	
	/**
	 * 删除数据
	 * @return	boolean
	 */
	function Delete(){
		return $this->_CODataformDelete();
	}
	
	/**
	 * 增加数据
	 * @param	data array 数据数组
	 * @return	string 文件目录sid
	 */
	static function Add($data){
		$ins = parent::_CODataformAdd($data);
		if($ins === false){
			//数据有误
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_task_sid, MOAConfig::_err_code_invalid_task_sid);
		}
		return $ins;
	}
}
?>