<?php
/**
 * MIM群组组件类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

@include_once 'MIMConfig.inc.php';
@include_once 'MIM_Exception.php';
//--------------------------------------------------------------------------
class MIM_Group{
	protected $_dataform = null;					//群组数据对象
	protected $_db = null;								//数据库对象
	protected $_objMembers = null;				//组内成员对象数组
	protected $_admin_id = '';						//群组管理员usid
	
	public $sid;												//群组sid
	public $name;											//群组名称
	public $max;											//群组成员最大数
	public $creator;										//群组创建者
	public $create_time;									//群组创建时间
	
	/**
	 * 构造函数
	 * @param	sid string 群组sid
	 */
	function __construct($sid){
		$this->_db = GetDB();
		$this->sid = $sid;
		$this->_dataform = new MIM_Group_Dataform($sid);
		$this->name = $this->_dataform->GetProp('NAME');
		$this->max = $this->_dataform->GetProp('MAX');
		$this->creator = $this->_dataform->GetProp('CREATOR');
		$this->create_time = $this->_dataform->GetProp('CREATE_TIME');
	}
	
	/**
	 * 根据群组名称获取实例
	 * @param	group_name string 群组名称
	 * @return	object
	 */
	static function GetInstanceByName($group_name){
		try {
			$db = GetDb();
			$query = $db->SelectOne(MIMConfig::_table_mim_group, array('NAME'=>$group_name), array('select'=>'SID'));
			if(!$query) return null;
			return new self($query['SID']);
		} catch (Exception $e) {
			return null;
		}			
	}
	
	/**
	 * 创建组
	 * @param	post array 提交的组数据
	 * @return 	object MIM_Group对象
	 */
	static function Add($post){
		$data=array();
		if(isset($post['name']) && $post['name']!='') $data['NAME']=$post['name'];
		if(isset($post['max']) && $post['max']!='') $data['MAX']=$post['max']; else $data['MAX'] = MIMConfig::_group_max_user;
		$data['CREATOR'] = $post['creator'];
		$data['CREATE_TIME'] = date('Y-m-d H:i:s');
		
		if(!count($data)){
			return null;
		}
		try {
			$ins = MIM_Group_Dataform::Add($data);
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
		if(isset($post['name']) && $post['name']!='') $data['NAME']=$post['name'];
		if(isset($post['max']) && $post['max']!='') $data['MAX']=$post['max'];
		if($this->_dataform->update($data)){
			//更新成功,修改属性
			if(isset($post['name']) && $post['name']!='') $this->name=$post['name'];
			if(isset($post['max']) && $post['max']!='') $this->max=$post['max'];
			return true;
		}else return false;
	}
		
	/**
	 * 获取群组管理员信息
	 * @return	object MIM_User对象
	 */
	function getAdmin(){
		$this->getMembers();
		if($this->_admin_id=='') return null;
		return $this->_objMembers[$this->_admin_id];
	}
	
	/**
	 * 设置群组管理员
	 * @param	usid string 用户sid
	 * @return	boolean
	 */
	function setAdmin($usid){
		if($this->_admin_id == $usid) return false;				//已经是管理员
		$bln_bingo = false;
		$this->getMembers();
		//清除已有管理员
		$this->_db->Delete(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid, 'IS_ADMIN'=>'1'));
		if($this->_admin_id != '') unset($this->_objMembers);
		$this->_admin_id =$usid;
		if(!isset($this->_objMembers[$usid])){
			//新添加用户
			if($this->_db->Insert(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid, 'IS_ADMIN'=>'1', 'UID'=>$usid))){
				$this->_objMembers[$usid] =  new MIM_User($usid);
				$bln_bingo = true;
			}
		}else{
			//将已有用户更新为管理员
			$bln_bingo = $this->_db->update(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid, 'UID'=>$usid), array('IS_ADMIN'=>'1'));
		}
		if($bln_bingo) $this->_admin_id = $usid;				//修改成功
		return $bln_bingo;
	}
	
	/**
	 * 获取组内成员
	 * @param	usid string 指定成员sid
	 * @param	bln_load_from_db boolean 是否从数据库读取
	 * @return	mixed	指定uid下返回用户对象,否则false; 未指定uid获取所有成员对象数组array
	 */
	public function getMembers($usid='', $bln_load_from_db=false){
		$arrRet = array();
		if(is_null($this->_objMembers) || $bln_load_from_db){
			$this->_objMembers = array();
			//从数据库中加载
			$data_list = $this->_db->Select(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid), array('select'=>array('UID', 'IS_ADMIN')));
			if($data_list){
				foreach($data_list as $data){
					try {
						$this->_objMembers[$data['UID']] = new MIM_User($data['UID']);
						if($data['IS_ADMIN'] == '1') $this->_admin_id = $data['UID'];
					} catch (Exception $e) {
					}
				}
			}
		}
		if($usid!=''){
			//按指定用户id获取成员
			if(!isset($this->_objMembers[$usid])) return false;			//非组内成员
			else return $this->_objMembers[$usid];
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
		$this->_db->Delete(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid));
		$this->_objMembers = array();
		foreach($uid_list as $uid){
			if($this->_db->Insert(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid, 'UID'=>$uid))){
				//更新对象
				$this->_objMembers[$uid] = new MIM_User($uid);
			}
		}
		return true;
	}
	
	/**
	 * 按照uid移除某个成员
	 * @param	usid string 用户sid
	 * @return	boolean
	 */
	function removeMember($usid=''){
		$this->getMembers();
		if($usid==''){
			//清除全部
			$this->_admin_id = '';
			$this->_objMembers = array();
			$this->_db->delete(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid));
			return true;
		}elseif(isset($this->_objMembers[$usid]) && $this->_db->delete(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid, 'UID'=>$usid))){
			unset($this->_objMembers[$usid]);
			if($this->_admin_id == $usid) $this->_admin_id = '';
			return true;
		}else return false;
	}
	
	/**
	 * 添加成员
	 * @param	usid string 用户sid
	 * @param	bln_is_admin boolean 是否管理员
	 * @return	boolean
	 */
	function addMember($usid, $bln_is_admin=false){
		if($usid=='') return false;
		if($this->getMembers($usid)!==false) return false;				//已经存在
		if($this->_db->Insert(MIMConfig::_table_mim_group_user, array('GID'=>$this->sid, 'UID'=>$usid, 'IS_ADMIN'=>$bln_is_admin?'1':'0'))){
			//更新对象
			try {
				$this->_objMembers[$usid] = new MIM_User($usid);
				if($bln_is_admin) $this->_admin_id = $usid;
				return true;
			} catch (Exception $e) {
				return false;
			}
		}else return false;
	}
	
	/**
	 * 群组聊天记录
	* @param	count int 分页单页情况下请求数量,默认20
	 * @param	date_begin string 开始时间
	 * @param	date_end string 结束时间
	 * @param	page int 页码数,默认1
	 * @return	array
	 */
	function getChatLog($count=20, $date_begin='', $date_end='', $page=1){
		$sql_where = 'SCENE_ID=? AND SCENE_TYPE=?';
		$sql_value = array($this->sid, '2');
		if($date_begin=='' && $date_end==''){
			$sql_date = 'CREATE_TIME<=?';
			array_push($sql_value, date('Y-m-d H:i:s'));
		}elseif($date_begin!='' && $date_end==''){
			$sql_date = 'CREATE_TIME<=? AND CREATE_TIME>=?';
			array_push($sql_value, date('Y-m-d H:i:s'));
			array_push($sql_value, $date_begin);
		}elseif($date_begin=='' && $date_end!=''){
			$sql_date = 'CREATE_TIME<=?';
			array_push($sql_value, $date_end);
		}else{
			$sql_date = 'CREATE_TIME<=? AND CREATE_TIME>=?';
			array_push($sql_value, $date_end);
			array_push($sql_value, $date_begin);
		}
		$sql_where .= ' AND '.$sql_date;
		$start=($page-1)*$count;
		$sql = 'SELECT CONTENT, CONTENT_TYPE, CREATE_TIME, USID_FROM FROM '.MIMConfig::_table_mim_chat_record.' WHERE '.$sql_where.' ORDER BY CREATE_TIME ASC LIMIT '.$start.','.$count;
		$query_list = $this->_db->Query($sql, $sql_value);
		$arrRet = array();
		if($query_list){
			foreach($query_list as $query){
				array_push($arrRet, array(
						'content' => $query['CONTENT'],
						'content_type' => $query['CONTENT_TYPE'], 
						'create_time' => $query['CREATE_TIME'],
						'from_usid' => $query['USID_FROM']
						));
			}
		}
		return $arrRet;
	}
	
	/**
	 * 搜索群组
	 * @param	search string 搜索内容
	 * @return	array MIM_Group对象数组
	 */
	static function SearchGroup($search){
		$arrRet = array();
		if($search=='') return $arrRet;
		try {
			$db = GetDb();
		} catch (Exception $e) {
			return $arrRet;
		}
		$query_list = $db->Query('SELECT SID FROM '.MIMConfig::_table_mim_group.' WHERE NAME LIKE ?', array('%'.$search.'%'));		
		if($query_list){
			foreach($query_list as $query){
				try {
					array_push($arrRet, new self($query['SID']));
				} catch (Exception $e) {}				
			}
		}
		return $arrRet;
	}
	
	/**
	 * 群组操作
	 * @param	type string 操作类型 0:将人从群组中删除 1:加入群组 2:解散群组
	 * @param	usid_a string 操作人id
	 * @param	usid_b string 被操作人id, type=='0'或type=='1'时有效
	 * @param	status string 状态 type=='1'有效 0:申请 1:已处理申请
	 * @return	boolean
	 */
	function group_action($type, $usid_a, $usid_b, $status){
		if($type=='0'){
			//将人从群组中删除
			return $this->_db->Insert(MIMConfig::_table_mim_group_action, array(
					'GID' => $this->sid,
					'USID_FROM' => $usid_b,							//被删除用户sid
					'CREATE_TIME' => date('Y-m-d H:i:s'),
					'USID_DEAL' => $usid_a,							//操作人
					'DEAL_TIME' => date('Y-m-d H:i:s'),
					'TYPE' => $type,
					'STATUS' => '1'
					));
		}elseif($type=='2'){
			//群组解散
			return $this->_db->Insert(MIMConfig::_table_mim_group_action, array(
					'GID' => $this->sid,
					'CREATE_TIME' => date('Y-m-d H:i:s'),
					'USID_DEAL' => $usid_a,							//操作人
					'DEAL_TIME' => date('Y-m-d H:i:s'),
					'TYPE' => $type,
					'STATUS' => '1'
			));
		}elseif($type=='1'){
			//加入群组
			if($status=='0'){
				//申请
				return $this->_db->Insert(MIMConfig::_table_mim_group_action, array(
						'GID' => $this->sid,
						'USID_FROM' => $usid_b,
						'CREATE_TIME' => date('Y-m-d H:i:s'),
						'TYPE' => $type,
						'STATUS' => $status
						));
			}else{
				//处理申请,批准或拒绝
				return $this->_db->Update(MIMConfig::_table_mim_group_action, 
						array(
								'GID' => $this->sid,
								'USID_FROM' => $usid_b,
								'USID_DEAL' =>'',
								'TYPE' => $type,
								'STATUS' => '0'
								), 
						array(
								'DEAL_TIME' => date('Y-m-d H:i:s'),
								'STATUS' => $status,
								'USID_DEAL' => $usid_a
								));
			}
		}else return false;
	}
	
	/**
	 * 获取群组未处理的请求
	 * @param	group_id string 群组id
	 * @return	array
	 */
	static function UndoGroupAction($group_id){
		$arrRet = array();
		try {
			$db = GetDb();
		} catch (Exception $e) {
			return $arrRet;
		}
		$query_list = $db->Select(
				MIMConfig::_table_mim_group_action,
				array('GID'=>$group_id, 'STATUS'=>'0', 'TYPE'=>'1'),
				array('select'=>array('USID_FROM', 'CREATE_TIME', 'SID'))
				);
		if($query_list){
			foreach($query_list as $query){
				array_push($arrRet, array(
						'from'=>$query['USID_FROM'],
						'date'=>$query['CREATE_TIME'],
						'sid'=>$query['SID']
				));
			}
		}
		return $arrRet;
	}
}

/**
 * MIM群组dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MIM_Group_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MIMConfig::_table_mim_group;

	//数据字段名称
	protected static $_co_dataform_field = array(
			'SID',
			'NAME',
			'MAX',
			'CREATOR',
			'CREATE_TIME'
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
			throw new MIM_Exception(MIMConfig::_err_msg_invalid_group_sid, MIMConfig::_err_code_invalid_group_sid);
		}
	}

	/**
	 * 更新数据
	 * @param	data array 更新的数组
	 * @return	boolean
	 */
	function update($data){
		return $this->_CODataformUpdate($data);
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
			throw new MIM_Exception(MIMConfig::_err_msg_invalid_group_sid, MIMConfig::_err_code_invalid_group_sid);
		}
		return $ins;
	}
}
?>