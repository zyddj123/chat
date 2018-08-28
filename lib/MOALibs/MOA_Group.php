<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA群组组件类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

@include_once 'MOAConfig.inc.php';
//--------------------------------------------------------------------------
class MOA_Group{
	protected $_dataform = null;					//群组数据对象
	protected $_db = null;								//数据库对象
	protected $_objMembers = null;				//组内成员对象数组
	
	public $sid;												//群组sid
	public $title;												//群组名称
	public $leader;											//群组管理者
	public $content;										//群组描述
	public $creator;										//群组创建者
	public $create_time;									//群组创建时间
	public $is_public;									//公开状态
	
	/**
	 * 构造函数
	 * @param	sid string 群组sid
	 */
	function __construct($sid){
		$this->_db = GetDB();
		$this->sid = $sid;
		$this->_dataform = new MOA_Group_Dataform($sid);
		$this->title = $this->_dataform->GetProp('TITLE');
		$this->leader = $this->_dataform->GetProp('LEADER');
		$this->content = $this->_dataform->GetProp('CONTENT');
		$this->creator = $this->_dataform->GetProp('CREATOR');
		$this->create_time = $this->_dataform->GetProp('CREATE_TIME');
		$this->is_public = $this->_dataform->GetProp('IS_PUBLIC');
	}
	
	/**
	 * 创建组
	 * @param	post array 提交的组数据
	 * @return 	object MOA_Group对象
	 */
	static function Add($post){
		$data=array();
		if(isset($post['title']) && $post['title']!='') $data['TITLE']=$post['title'];
		if(isset($post['leader']) && $post['leader']!='') {$data['LEADER']=$post['leader'];}else{$data['LEADER']='['.$post['creator'].']';}
		if(isset($post['content']) && $post['content']!='') $data['CONTENT']=$post['content'];
		if(isset($post['is_public']) && $post['is_public']!='') $data['IS_PUBLIC']=$post['is_public'];
		$data['CREATOR'] = $post['creator'];
		$data['CREATE_TIME'] = date('Y-m-d H:i:s');
		if(!count($data)){
			return null;
		}
		try {
			$ins = MOA_Group_Dataform::Add($data);
			return new static($ins);
		} catch (Exception $e) {
			return null;
		}
	}
	
	/**
	 * 删除组
	 * @return	boolean 
	 */
	function del(){
		return $this->_dataform->delete();
	}
	
	/**
	 * 更新数据
	 * @param	post array 更新用数据
	 * @return	boolean
	 */
	function update($post){
		$data=array();
		if(isset($post['title']) && $post['title']!='') $data['TITLE']=$post['title'];
		if(isset($post['leader']) && $post['leader']!='') $data['LEADER']=$post['leader'];
		if(isset($post['content']) && $post['content']!='') $data['CONTENT']=$post['content'];
		if(isset($post['is_public']) && $post['is_public']!='') $data['IS_PUBLIC']=$post['is_public'];
		if($this->_dataform->update($data)){
			//更新成功,修改属性
			if(isset($post['title']) && $post['title']!='') $this->title=$post['title'];
			if(isset($post['leader']) && $post['leader']!='') $this->leader=$post['leader'];
			if(isset($post['content']) && $post['content']!='') $this->content=$post['content'];
			if(isset($post['is_public'])&&$post['is_public']!='') $this->is_public = $post['is_public'];
			return true;
		}else return false;
	}
	
	/**
	 * 获取组内用户信息
	 * @param	$arrUid array 用户UID数组
	 * @return	array
	 */
	public static  function _getuserinfo($arrUid)
	{
		$arrRet=array();
		try{
			$db=GetDB();
			$where='';
			foreach ($arrUid as $_uid){
				$sql = "SELECT * FROM ".MOA::config('_table_moa_user')." WHERE `UID` = ?";
				$query = $db->GetRow($sql,array($_uid));
					array_push($arrRet, array(
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
	
	/**
	 * 获取组长信息
	 * @return	array 群组管理员信息数组
	 */
	function getLeaderInfo(){
		$arrRet = array();
		foreach($this->leader as $leader_id){
			try {
				$objMOAUser = new MOA_User($leader_id);
				array_push($arrRet, array(
						'sid'=>$objMOAUser->sid,
						'uid'=>$objMOAUser->uid,
						'password'=>$objMOAUser->password,
						'name'=>$objMOAUser->name,
						'content'=>$objMOAUser->content,
						'phone'=>$objMOAUser->phone,
						'email'=>$objMOAUser->email,
						'is_admin'=>$objMOAUser->is_admin,
						'sex'=>$objMOAUser->sex,
						'status'=>$objMOAUser->status,
						'img'=>$objMOAUser->img
						));
			} catch (Exception $e) {
			}
		}
		return $arrRet;
	}
	
	/**
	 * 获取组内成员
	 * @param	uid string 指定成员uid
	 * @param	bln_load_from_db boolean 是否从数据库读取
	 * @return	mixed	指定uid下返回用户对象,否则false; 未指定uid获取所有成员对象数组array
	 */
	public function getMembers($uid='', $bln_load_from_db=false){
		$arrRet = array();
		if(is_null($this->_objMembers) || $bln_load_from_db){
			$this->_objMembers = array();
			//从数据库中加载
			$data_list = $this->_db->Select(MOAConfig::_table_moa_group_user, array('GROUP'=>$this->sid), array('select'=>'UID'));
			if($data_list){
				foreach($data_list as $data){
					try {
						$this->_objMembers[$data['UID']] = new MOA_User($data['UID']);
					} catch (Exception $e) {
					}
				}
			}
		}
		if($uid!=''){
			//按指定用户id获取成员
			if(!isset($this->_objMembers[$uid])) return false;			//非组内成员
			else return $this->_objMembers[$uid];
		}else{
			//全体成员
			return $this->_objMembers;
		}
	}
	
	/**
	 * 更新群组成员
	 * 覆盖式
	 * @param	uid_list array 用户uid列表
	 * @return	boolean
	 */
	function setMembers($uid_list){
		if(!is_array($uid_list) || count($uid_list)==0) return false;
		if($this->_db->Delete(MOAConfig::_table_moa_group_user, array('GROUP'=>$this->sid))){
			$this->_objMembers = array();
			foreach($uid_list as $uid){
				if($this->_db->Insert(MOAConfig::_table_moa_group_user, array('GROUP'=>$this->sid, 'UID'=>$uid))){
					//更新对象
					$this->_objMembers[$uid] = new MOA_User($uid);
				}
			}
			return true;
		}else return false;
	}

	/**
	 * 按照uid移除某个成员
	 * @param	uid string 用户id
	 * @return	boolean
	 */
	function removeMember($uid){
		$this->getMembers();
		if(isset($this->_objMembers[$uid]) && $this->_db->delete(MOAConfig::_table_moa_group_user, array('GROUP'=>$this->sid, 'UID'=>$uid))){
			unset($this->_objMembers[$uid]);
			return true;
		}else return false;
	}
	
	/**
	 * 添加成员
	 * @param	uid string 用户id
	 * @return	boolean
	 */
	function addMember($uid){
		if($uid=='') return false;
		if($this->getMembers($uid)!==false) return false;				//已经存在
		if($this->_db->Insert(MOAConfig::_table_moa_group_user, array('GROUP'=>$this->sid, 'UID'=>$uid))){
			//更新对象
			try {
				$this->_objMembers[$uid] = new MOA_User($uid);
				return true;
			} catch (Exception $e) {
				return false;
			}
		}else return false;
	}
	
	/**
	 * _getGroupofmy() 根据用户UID获取属于该用户所管理的研究组
	 * @param  $uid string 用户UID
	 * @param  $num string 显示的条数
	 * @return boolean|multitype:
	 */
	static function _getGroupofmy($uid,$num){
		if(!isset($uid) || $uid=='') return false;
		try{
			if(!isset($num) || $num=='') $num='10';
			$result=array();
			$db=GetDB();
			$sql="SELECT SID FROM ".MOAConfig::_table_moa_group." WHERE LEADER = ? ORDER BY CREATE_TIME DESC LIMIT 0,".$num;
			$data = $db->GetAll($sql,array('['.$uid.']'));
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
 * MOA群组dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MOA_Group_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MOAConfig::_table_moa_group;

	//数据字段名称
	protected static $_co_dataform_field = array(
			'SID',
			'TITLE',
			'LEADER',
			'CONTENT',
			'CREATOR',
			'CREATE_TIME',
			'IS_PUBLIC'
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_group_sid, MOAConfig::_err_code_invalid_group_sid);
		}
	}

	/**
	 * 更新数据
	 * @param	data array 更新的数组
	 * @return	boolean
	 */
	function update($data){
		return parent::_CODataformUpdate($data);
	}

	/**
	 * 删除数据
	 * @return	boolean
	 */
	function delete(){
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_group_sid, MOAConfig::_err_code_invalid_group_sid);
		}
		return $ins;
	}
	
	/**
	 * 写入数据库时转化
	 * @param	undeal_var string 待转化数据
	 */
	protected function _co_dataform_dt_to_LEADER($undeal_var){
		//var_dump($undeal_var);die();
		//return implode(',', $undeal_var);
		return m_join(m_split($undeal_var));
	}
	
	/**
	 * 从数据库读取时转化
	 * @param	undeal_var string 待转化数据
	 */
	protected function _co_dataform_dt_from_LEADER($undeal_var){
		//return explode(',', $undeal_var);
		return m_split($undeal_var);
	}
}
?>