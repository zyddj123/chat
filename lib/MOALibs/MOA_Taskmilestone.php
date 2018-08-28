<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}
/**
 * MOA任务里程碑组件类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */
@include_once 'MOAConfig.inc.php';
class MOA_Taskmilestone{
	protected $_dataform = null;								//任务数据对象
	protected $_db = null;											//数据库对象
	protected $_objMilestoneusers = null;				//里程碑成员对象数组
	
	public $sid;							//主键SID
	public $t_sid;						//所属任务SID
	public $title;						//里程碑名称
	public $start_time;			//起始时间
	public $end_time;				//结束时间
	public $leader;					//里程碑组长
	public $create_time;			//创建时间
	public $content;					//说明备注
	public $status;					//里程碑状态 1开启 0关闭
	public $mf_group_id;		//媒体库ID
	public $progress;				//里程碑进度
	public $confirm;					//完成状态
	
	/**
	 * __construct() 构造函数
	 * @param  $sid string 里程碑SID
	 */
	function __construct($sid){
		$this->_db = GetDB();
		$this->sid = $sid;
		$this->_dataform = new MOA_Taskmilestone_Dataform($sid);
		$this->title =$this->_dataform->GetProp('TITLE');
		$this->t_sid = $this->_dataform->GetProp('T_SID');
		$this->start_time = $this->_dataform->GetProp('START_TIME');
		$this->end_time = $this->_dataform->GetProp('END_TIME');
		$this->leader = $this->_dataform->GetProp('LEADER');
		$this->create_time = $this->_dataform->GetProp('CREATE_TIME');
		$this->content = $this->_dataform->GetProp('CONTENT');
		$this->status = $this->_dataform->GetProp('STATUS');
		$this->mf_group_id = $this->_dataform->GetProp('MF_GROUP_ID');
		$this->progress = $this->_dataform->GetProp('PROGRESS');
		$this->confirm = $this->_dataform->GetProp('CONFIRM');
	}
	
	/**
	 * Add()创建里程碑
	 * @param  $post array 提交的数据
	 */
	static function Add($post){
		$data=array();
		if(isset($post['t_sid'])&&$post['t_sid']!='') $data['T_SID'] = $post['t_sid'];
		if(isset($post['title'])&&$post['title']!='') $data['TITLE'] = $post['title'];
		if(isset($post['start_time'])&&$post['start_time']!='') $data['START_TIME'] = $post['start_time'];
		if(isset($post['end_time'])&&$post['end_time']!='') $data['END_TIME'] = $post['end_time'];
		if(isset($post['leader'])&&$post['leader']!='') $data['LEADER'] = $post['leader'];
		if(isset($post['create_time'])&&$post['create_time']!='') $data['CREATE_TIME'] = $post['create_time'];
		if(isset($post['content'])&&$post['content']!='') $data['CONTENT'] = $post['content'];
		if(isset($post['status'])&&$post['status']!='') $data['STATUS'] = $post['status'];
		if(isset($post['mf_group_id'])&&$post['mf_group_id']!='') $data['MF_GROUP_ID'] = $post['mf_group_id'];
		if(isset($post['progress'])&&$post['progress']!='') $data['PROGRESS'] = $post['progress'];
		if(isset($post['confirm'])&&$post['confirm']!='') $data['CONFIRM'] = $post['confirm'];
		if(!count($data)){
			return null;
		}
		try{
			$add = MOA_Taskmilestone_Dataform::Add($data);
			return new self($add);
		}catch(Exception $e){ return null;}
	}
	
	static function milSid($sid){
		if($sid=='') return false;
		try{
			$db=GetDB();
			$sql="SELECT * FROM ".MOAConfig::_table_moa_task_milestone." WHERE SID=?";
			$data= $db->GetRow($sql,array($sid));
			if($data){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}
	
	/**
	 * Update()编辑里程碑
	 * @param  $post array 提交的数据
	 * @return boolean
	 */
	function Update($post){
		$data=array();
		if(isset($post['t_sid'])&&$post['t_sid']!='') $data['T_SID'] = $post['t_sid'];
		if(isset($post['title'])&&$post['title']!='')$data['TITLE'] = $post['title'];
		if(isset($post['start_time'])&&$post['start_time']!='') $data['START_TIME'] = $post['start_time'];
		if(isset($post['end_time'])&&$post['end_time']!='') $data['END_TIME'] = $post['end_time'];
		if(isset($post['leader'])&&$post['leader']!='') $data['LEADER'] = $post['leader'];
		if(isset($post['create_time'])&&$post['create_time']!='') $data['CREATE_TIME'] = $post['create_time'];
		if(isset($post['content'])&&$post['content']!='') $data['CONTENT'] = $post['content'];
		if(isset($post['status'])&&$post['status']!='') $data['STATUS'] = $post['status'];
		if(isset($post['mf_group_id'])&&$post['mf_group_id']!='') $data['MF_GROUP_ID'] = $post['mf_group_id'];
		if(isset($post['progress'])&&$post['progress']!='') $data['PROGRESS'] = $post['progress'];
		if(isset($post['confirm'])&&$post['confirm']!='') $data['CONFIRM'] = $post['confirm'];
		if($this->_dataform->Update($data)){
			if(isset($post['t_sid'])&&$post['t_sid']!='') $this->t_sid = $post['t_sid'];
			if(isset($post['title'])&&$post['title']!='') $this->title = $post['title'];
			if(isset($post['start_time'])&&$post['start_time']!='') $this->start_time = $post['start_time'];
			if(isset($post['end_time'])&&$post['end_time']!='') $this->end_time = $post['end_time'];
			if(isset($post['leader'])&&$post['leader']!='') $this->leader = $post['leader'];
			if(isset($post['create_time'])&&$post['create_time']!='') $this->leader = $post['create_time'];
			if(isset($post['content'])&&$post['content']!='') $this->content = $post['content'];
			if(isset($post['status'])&&$post['status']!='') $this->status = $post['status'];
			if(isset($post['mf_group_id'])&&$post['mf_group_id']!='') $this->mf_group_id = $post['mf_group_id'];
			if(isset($post['progress'])&&$post['progress']!='') $this->progress = $post['progress'];
			if(isset($post['confirm'])&&$post['confimr']!='') $this->confirm = $post['confirm'];
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Del()删除里程碑
	 */
	function Del(){
		return $this->_dataform->Del();
	}
	
	//**里程碑人员**//
	/**
	 * getMilestoneuser()获取里程碑内人员
	 * @param  $uid string 人员UID
	 * @param  $bln_load_from_db boolean 是否从数据库读取
	 * @return boolean|NULL
	 */
	function getMilestoneuser($uid='', $bln_load_from_db=false){
		$arrRet=array();
		if(is_null($this->_objMilestoneusers) || $bln_load_from_db){
			$this->_objMilestoneusers=array();
			$data_list = $this->_db->Select(MOAConfig::_table_moa_task_milestone_user,array('M_SID'=>$this->sid),array('M_UID'=>$uid));
			if($data_list){
				foreach ($data_list as $data){
					try{
						$this->_objMilestoneusers[$data['M_UID']] = new MOA_User($data['M_UID']);
					}catch(Exception $e){}
				}
			}
		}
		if($uid!=''){
			if(!isset($this->_objMilestoneusers[$uid])) return false;
			else return $this->_objMilestoneusers[$uid];
		}else{
			return $this->_objMilestoneusers;
		}
	}
	/**
	 * addMilestoneuser()添加里程碑人员
	 * @param   $uid string 用户UID
	 * @return boolean
	 */
	function addMilestoneuser($uid,$type=false){
		if($uid=='') return false;
		if($this->getMilestoneuser($uid)!==false) return false;
		if($this->_db->Insert(MOAConfig::_table_moa_task_milestone_user,array('M_SID'=>$this->sid,'M_UID'=>$uid))){
			try{
				$this->_objMilestoneusers[$uid] = new MOA_User($uid);
				if($type){
					$chat = CHAT_GROUP::getGroupInfo($this->t_sid,$this->sid);
					$chat_user = CHAT_GROUP::addMember($uid, $chat['SID']);
				}
				return true;
			}catch(Exception $e){ return false;}
		}else{ return false;}
	}
	/**
	 * updMilestoneuser()修改里程碑人员
	 * @param  $uid_list array 人员UID数组
	 * @return boolean
	 */
	function updMilestoneuser($uid_list){
		if(!is_array($uid_list) || count($uid_list)==0) return false;
		if($this->_db->Delete(MOAConfig::_table_moa_task_milestone_user,array('M_SID'=>$this->sid))){
			$this->_objMilestoneusers=array();
			foreach ($uid_list as $uid){
				if($this->_db->Insert(MOAConfig::_table_moa_task_milestone_user,array('M_SID'=>$this->sid,'M_UID'=>$uid))){
					//更新里程碑用户对象
					$this->_objMilestoneusers[$uid] = new MOA_User($uid);
				}
			}
			return true;
		}else{
			return false;
		}
	}
	/**
	 * delMilestoneuser()删除里程碑人员
	 * @param  $uid string 用户UID
	 * @return boolean
	 */
	function delMilestoneuser($uid){
		$this->getMilestoneuser();
		if(isset($this->_objMilestoneusers[$uid]) && $this->_db->Delete(MOAConfig::_table_moa_task_milestone_user,array('M_SID'=>$this->sid,'M_UID'=>$uid))){
			unset($this->_objMilestoneusers[$uid]);
			$chat = CHAT_GROUP::getGroupInfo($this->t_sid, $this->sid);
			$this->_db->Delete(MOAConfig::_table_chat_group_user,array('GID'=>$chat['SID'],'UID'=>$uid));
			return true;
			return true;
		}else return false;
	}
	/**
	 * delAllMilestoneuser()删除里程碑全部人员
	 * @return boolean
	 */
	function delAllMilestoneuser(){
		try{
			$del = $this->_db->Delete(MOAConfig::_table_moa_task_milestone_user,array('M_SID'=>$this->sid));
			if($del){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}
	
	function getChat(){
		$query = $this->_db->Select(MOAConfig::_table_moa_task_chat, array('TID'=>$this->t_sid, 'MID'=>$this->sid), array('select'=>'MIM_GROUP_ID'));
		if($query) return $query[0]['MIM_GROUP_ID'];
		else return '';
	}
	
	function createChat($mim_chat_id){
		return $this->_db->Insert(MOAConfig::_table_moa_task_chat, array('TID'=>$this->t_sid, 'MID'=>$this->sid, 'MIM_GROUP_ID'=>$mim_chat_id));
	}
	
	/**
	 * _getMilestoneuserinfo()里程碑用户详情
	 * @param  $arrUid array 用户UID数组
	 */
	public static function _getMilestoneuserinfo($arrUid){
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
		}catch (Exception $e){
		}
		return $arrRet;
	}
	
}

/**
 * MOA任务里程碑dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MOA_Taskmilestone_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MOAConfig::_table_moa_task_milestone;
	//数据字段名称
	protected static $_co_dataform_field =array(
			'SID',
			'T_SID',
			'TITLE',
			'START_TIME',
			'END_TIME',
			'LEADER',
			'CREATE_TIME',
			'CONTENT',
			'STATUS',
			'MF_GROUP_ID',
			'PROGRESS',
			'CONFIRM'
			);
	//数据主键字段名称
	protected static $_co_dataform_main_key = array('SID');
	
	//数据库连接配置
	static $_co_dataform_db_name = '';
	/**
	 * __construct()构造函数
	 * @param  $sid string 主键SID
	 * @throws MOA_Exception
	 */
	function __construct($sid){
		$this->_co_dataform_main_key_value = array('SID'=>$sid);
		if(!$this->_CODataformLoad()){
			//数据加载失败
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_milestone_sid, MOAConfig::_err_code_invalid_milestone_sid);
		}
	}
	/**
	 * Add()添加数据
	 * @param  $data array 提交的数据
	 * @throws MOA_Exception
	 */
	static function Add($data){
		$ins = parent::_CODataformAdd($data);
		if($ins === false){
			//数据有误
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_milestone_sid, MOAConfig::_err_code_invalid_milestone_sid);
		}
		return $ins;
	}
	/**
	 * Update()编辑数据
	 * @param  $data array 提交的数据
	 * @return boolean
	 */
	function Update($data){
		return parent::_CODataformUpdate($data);
	}
	/**
	 * Del()删除数据
	 * @return boolean
	 */
	function Del(){
		return $this->_CODataformDelete();
	}
}

?>