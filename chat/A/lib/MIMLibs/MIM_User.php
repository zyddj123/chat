<?php
/**
 * MIM用户类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.0
 */

@include_once 'MIMConfig.inc.php';
@include_once 'MIM_Exception.php';
//--------------------------------------------------------------------------
class MIM_User{
	protected $_dataform = null;					//群组用户数据对象
	protected $_db = null;								//数据库对象
	
	public $sid;												//SID
	public $uid;												//登录UID
	public $password;									//密码
	public $name;											//姓名
	public $content;										//备注
	public $phone;											//联系方式
	public $email;											//邮箱理员
	public $sex;												//性别
	public $status;											//状态
	public $img;												//头像
	public $birthday;										//生日
	
	protected $_socket_list = null;					//相关的socket连接信息
	protected $_friend_list = null;					//好友列表
	protected $_group_list = null;					//所属群组列表
	
	/**
	 * 构造函数
	 * @param	usid string 用户id
	 */
	function __construct($usid){
		$this->_db = GetDB();
		$this->sid = $usid;
		$this->_dataform = new MIM_User_Dataform($usid);
		$this->uid = $this->_dataform->GetProp('UID');
		$this->password = $this->_dataform->GetProp('PASSWORD');
		$this->name = $this->_dataform->GetProp('NAME');
		$this->content = $this->_dataform->GetProp('CONTENT');
		$this->phone = $this->_dataform->GetProp('PHONE');
		$this->email = $this->_dataform->GetProp('EMAIL');
		$this->sex = $this->_dataform->GetProp('SEX');
		$this->status = $this->_dataform->GetProp('STATUS');
		$this->img = $this->_dataform->GetProp('IMG');
		$this->birthday = $this->_dataform->GetProp('BIRTHDAY');
	}
	
	/**
	 * 添加用户
	 * @param	post array 提交的信息
	 * @return 	object MIM_User对象
	 */
	static function Add($post){
		$data=array();
		if(isset($post['uid']) && $post['uid']!='') $data['UID']=$post['uid']; 
		if(isset($post['password']) && $post['password']!='') $data['PASSWORD']=$post['password'];
		if(isset($post['name']) && $post['name']!='') $data['NAME']=$post['name'];
		if(isset($post['content']) && $post['content']!='') $data['CONTENT']=$post['content'];
		if(isset($post['phone']) && $post['phone']!='') $data['PHONE']=$post['phone'];
		if(isset($post['email']) && $post['email']!='') $data['EMAIL']=$post['email'];
		if(isset($post['sex']) && $post['sex']!='') $data['SEX']=$post['sex'];
		if(isset($post['status']) && $post['status']!='') $data['STATUS']=$post['status'];
		if(isset($post['img']) && $post['img']!='') $data['IMG']=$post['img'];
		if(isset($post['birthday']) && $post['birthday']!='') $data['BIRTHDAY']=$post['birthday'];
		if(!count($data)){
			return null;
		}		
		try {
			$ins = MIM_User_Dataform::Add($data);
			return new self($ins);
		} catch (Exception $e) {
			return null;
		}
	}
	
	/**
	 * 编辑用户信息
	 * @param	post array 更新的数据数组
	 * @return	boolean
	 */
	function update($post){
		$data=array();
		if(isset($post['password']) && $post['password']!='') $data['PASSWORD']=$post['password'];
		if(isset($post['name']) && $post['name']!='') $data['NAME']=$post['name'];
		if(isset($post['content']) && $post['content']!='') $data['CONTENT']=$post['content'];
		if(isset($post['phone']) && $post['phone']!='') $data['PHONE']=$post['phone'];
		if(isset($post['email']) && $post['email']!='') $data['EMAIL']=$post['email'];
		if(isset($post['sex']) && $post['sex']!='') $data['SEX']=$post['sex'];
		if(isset($post['status']) && $post['status']!='') $data['STATUS']=$post['status'];
		if(isset($post['img']) && $post['img']!='') $data['IMG']=$post['img'];
		if(isset($post['birthday']) && $post['birthday']!='') $data['BIRTHDAY']=$post['birthday'];
		if(count($data) == 0){
			return false;
		}
		if($this->_dataform->update($data)){
			if(isset($data['PASSWORD'])) $this->password = $data['PASSWORD'];
			if(isset($data['NAME'])) $this->name = $data['NAME'];
			if(isset($data['CONTENT'])) $this->content = $data['CONTENT'];
			if(isset($data['PHONE'])) $this->phone = $data['PHONE'];
			if(isset($data['EMAIL'])) $this->mail = $data['EMAIL'];
			if(isset($data['SEX'])) $this->sex = $data['SEX'];
			if(isset($data['STATUS'])) $this->us = $data['STATUS'];
			if(isset($data['IMG'])) $this->img = $data['IMG'];
			if(isset($data['BIRTHDAY'])) $this->birthday = $data['BIRTHDAY'];
			return true;
		}else return false;
	}
	
	/**
	 * 获取图片
	 * @return string
	 */
	function getHeadImg(){
		return MIMConfig::_root_host.'/'.MIMConfig::_path_avatar.'/'.$this->img;
	}
	
	/**
	 * 删除用户信息
	 */
	function delete(){
		return $this->_dataform->delete();
	}
	
	/**
	 * 校验用户登录密码及用户状态
	 * 用户名和密码不一致则返回-1
	 * 用户被冻结返回 0
	 * 验证成功返回 1
	 * @param	uid string 用户id
	 * @param	pwd string 密码明文
	 * @return	int
	 */
	static function CheckUserPwd($uid="", $pwd=""){
		if($uid=="" || $pwd=="") return -1;
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return -1;
		}
		$query = $db->SelectOne(MIMConfig::_table_mim_user, array('UID'=>$uid, 'PASSWORD'=>static::Encrypt($pwd)), array('select'=>'STATUS'));
		if(!$query){
			//用户或密码不存在
			return -1;
		}
		if($query['STATUS'] == '0'){
			//用户被冻结
			return 0;
		}else return 1;			//验证成功
	}
	
	/**
	 * 上传账户头像
	 * @param	image_file_path string 源图片地址
	 * @param	bln_upload_from_web boolean 是否从web上上传
	 */
	function uploadHeadImg($image_file_path, $bln_upload_from_web=false, $origin_file_name=''){
		if(file_exists($image_file_path)){
			if($bln_upload_from_web){
				$suffix = substr($origin_file_name, strrpos($origin_file_name, '.'));
				$upload_file_path = MIMConfig::_root_path.'/'.MIMConfig::_path_upload.'/'.$this->sid.$suffix;
				copy($image_file_path, $upload_file_path);
				@unlink($image_file_path);
			}else{
				$suffix = substr($image_file_path, strrpos($image_file_path, '.'));
				$upload_file_path = MIMConfig::_root_path.'/'.MIMConfig::_path_upload.'/'.$this->sid.$suffix;
				move_uploaded_file($image_file_path, $upload_file_path);
			}
			return $this->sid.$suffix;
		}else return false;
	}
	
	/**
	 * 密码明文加密方式
	 * @param	pwd string 密码明文
	 * @return	string 密码密文
	 */
	static function Encrypt($pwd){
		return md5($pwd);
	}
	
	/**
	 * 获取用户正在使用的socket连接id列表
	 * @return	array socket连接数据
	 */
	function getSocket($bln_load_from_db=false){
		if(is_null($this->_socket_list) || $bln_load_from_db){
			$this->_socket_list = array();
			$data_list = $this->_db->Select(MIMConfig::_table_mim_user_client, array('USID'=>$this->sid));
			if($data_list){
				foreach($data_list as $data){
					$this->_socket_list[$data['SOCKET_ID']] = array(
							'scene_type'=>$data['SCENE_TYPE'],
							'scene_id'=>$data['SCENE_ID'],
							'create_time'=>$data['CREATE_TIME']
							);
				}
			}
		}
		return $this->_socket_list;
	}
	
	/**
	 * 删除用户socket连接id
	 * @param	socket_id string socket连接
	 * @return	boolean
	 */
	function delSocket($socket_id=''){
		$this->getSocket();
		$where = array('USID'=>$this->sid);
		if($socket_id==''){
			//删除所有socket
			if($this->_db->Delete(MIMConfig::_table_mim_user_client, $where)){
				$this->_socket_list = array();
				return true;
			}
		}elseif(isset($this->_socket_list[$socket_id])){
			//删除指定socket
			$where['SOCKET_ID']=$socket_id;
			if($this->_db->Delete(MIMConfig::_table_mim_user_client, $where)){
				unset($this->_socket_list[$socket_id]);
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 回收socket链接
	 * @param	socket_id string 链接id
	 * @return	mixed
	 */
	static function RecSocket($socket_id){
		try {
			$db = GetDb();
		} catch (Exception $e) {
			return false;
		}
		//查询socket_id对应的用户sid
		$query_list = $db->Select(MIMConfig::_table_mim_user_client, array('SOCKET_ID'=>$socket_id), array('select'=>'USID'));
		if($query_list === false) return false;			//无结果
		$usid = $query_list[0]['USID'];			//取第一个socket查询结果即可
		if($db->Delete(MIMConfig::_table_mim_user_client, array('SOCKET_ID'=>$socket_id))){
			//删除成功
			return $usid;
		}else return false;
	}
	
	/**
	 * 删除场景
	 * @param	scene_type string 场景类型
	 * @param	scene_id string 场景id
	 * @return	boolean
	 */
	function delScene($scene_type, $scene_id=''){
		$where = array('SCENE_TYPE'=>$scene_type);
		if($scene_id != '') $where['SCENE_ID'] = $scene_id;
		if($this->_db->Delete(MIMConfig::_table_mim_user_client, $where)){
			$this->getSocket(true);
			return true;
		}return false;
	}
	
	/**
	 * 获取好友列表
	 * @param	bln_load_from_db boolean 是否从数据库中加载
	 * @return	array 好友对象数组
	 */
	function getFriends($bln_load_from_db=false){
		if(is_null($this->_friend_list) || $bln_load_from_db){
			$this->_friend_list = array();
			$data_list_a = $this->_db->Select(MIMConfig::_table_mim_user_friend, array('USID_A'=>$this->sid), array('select'=>'USID_B'));
			$data_list_b = $this->_db->Select(MIMConfig::_table_mim_user_friend, array('USID_B'=>$this->sid), array('select'=>'USID_A'));
			if($data_list_a){
				foreach($data_list_a as $data){
					try {
						$this->_friend_list[$data['USID_B']] = new self($data['USID_B']);
					} catch (Exception $e) {
					}
				}
			}
			if($data_list_b){
				foreach($data_list_b as $data){
					try {
						if(!isset($this->_friend_list[$data['USID_A']])) $this->_friend_list[$data['USID_A']] = new self($data['USID_A']);
					} catch (Exception $e) {
					}
				}
			}
		}
		return $this->_friend_list;
	}
	
	/**
	 * 添加好友
	 */
	function addFriend($friend_usid){
		if($this->_db->Insert(MIMConfig::_table_mim_user_friend, array('USID_A'=>$this->sid, 'USID_B'=>$friend_usid))){
			$this->_friend_list[$friend_usid] = new self($friend_usid);
			return true;
		}else return false;
	}
	
	/**
	 * 删除好友
	 */
	function delFriend($friend_usid){
		if(
				$this->_db->Delete(MIMConfig::_table_mim_user_friend, array('USID_A'=>$this->sid, 'USID_B'=>$friend_usid)) &&
				$this->_db->Delete(MIMConfig::_table_mim_user_friend, array('USID_A'=>$friend_usid, 'USID_B'=>$this->sid))
				){
			unset($this->_friend_list[$friend_usid]);
			return true;
		}else return false;
	}
	
	/**
	 * 删除全部好友
	 */
	function delAllFirend(){
		if(
				$this->_db->Delete(MIMConfig::_table_mim_user_friend, array('USID_A'=>$this->sid)) &&
				$this->_db->Delete(MIMConfig::_table_mim_user_friend, array('USID_B'=>$this->sid))
		){
			return true;
		}else return false;
	}
	

	
	/**
	 * 获取聊天群组
	 * @param	bln_load_from_db boolean 是否从数据库中加载
	 * @return	array 群组对象数组
	 */
	function getGroups($bln_load_from_db=false){
		if(is_null($this->_group_list) || $bln_load_from_db){
			$this->_group_list = array();
			$data_list = $this->_db->Select(MIMConfig::_table_mim_group_user, array('UID'=>$this->sid), array('select'=>'GID'));
			if($data_list){
				foreach($data_list as $data){
					try {
						$this->_group_list[$data['GID']] = new MIM_Group($data['GID']);
					} catch (Exception $e) {
					}
				}
			}
		}
		return $this->_group_list;
	}
	
	/**
	 * 根据用户uid实例化
	 */
	static function GetInstanceByUID($uid){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return null;
		}
		$query = $db->SelectOne(MIMConfig::_table_mim_user, array('UID'=>$uid), array('select'=>array('SID')));
		if($query === false) return null;
		return new self($query['SID']);
	}
	
	/**
	 * 根据人物名称获取实例
	 * @param	name string 人物姓名
	 * @return	object
	 */
	static function GetInstanceByName($name){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return null;
		}
		$query = $db->SelectOne(MIMConfig::_table_mim_user, array('NAME'=>$name), array('select'=>array('SID')));
		if($query === false) return null;
		return new self($query['SID']);
	}
	
	/**
	 * 添加场景连接socket
	 * @param	socket_id string sock连接id
	 * @param	scene_type string 场景类型
	 * @param	scene_id string 场景id
	 * @return	boolean
	 */
	function addSocket($socket_id, $scene_type, $scene_id){
		return $this->_db->Insert(MIMConfig::_table_mim_user_client, array(
				'USID'=>$this->sid,
				'SCENE_TYPE'=>$scene_type,
				'SCENE_ID'=>$scene_id,
				'SOCKET_ID'=>$socket_id,
				'CREATE_TIME'=>date('Y-m-d H:i:s')
				));
	}
	
	/**
	 * 获取聊天记录
	 * @param	usid_to string 接收人
	 * @param	count int 分页单页情况下请求数量,默认20
	 * @param	date_begin string 开始时间
	 * @param	date_end string 结束时间
	 * @param	page int 页码数,默认1
	 * @return	array
	 */
	function getChatLog($usid_to, $count=20, $date_begin='', $date_end='', $page=1){
		$sql_where = 'SCENE_TYPE=? AND (SCENE_ID=? AND USID_FROM=? OR SCENE_ID=? AND USID_FROM=?)';
		$sql_value = array( '3', $usid_to, $this->sid, $this->sid,$usid_to);
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
		$sql = 'SELECT USID_FROM,SCENE_ID,CONTENT, CONTENT_TYPE, CREATE_TIME FROM '.MIMConfig::_table_mim_chat_record.' WHERE '.$sql_where.' ORDER BY CREATE_TIME ASC LIMIT '.$start.','.$count;

		$query_list = $this->_db->Query($sql, $sql_value);

		$arrRet = array();
		if($query_list){
			foreach($query_list as $query){
				array_push($arrRet, array(
						'content' => $query['CONTENT'],
						'content_type' => $query['CONTENT_TYPE'],
						'create_time' => $query['CREATE_TIME'],
						'from' => $query['USID_FROM'],
						'to' => $query['SCENE_ID']
						));
			}
		}
		return $arrRet;
	}
	
	/**
	 * 搜索用户
	 */
	static function SearchUser($search){
		$arrRet = array();
		if($search == '') return $arrRet;
		try {
			$db = GetDb();
		} catch (Exception $e) {
			return $arrRet;
		}
		$query_list = $db->Query('SELECT SID FROM '.MIMConfig::_table_mim_user.' WHERE NAME LIKE ?', array('%'.$search.'%'));
		foreach($query_list as $query){
			try {
				array_push($arrRet, new self($query['SID']));
			} catch (Exception $e) {
			}
		}
		return $arrRet;
	}
	
	/**
	 * 好友操作
	 */
	function friendAction($uid, $type, $status='0'){
		if($type=='0'){
			//创建删除好友记录
			return $this->_db->Insert(MIMConfig::_table_mim_friend_action, array(
					'USID_FROM'=>$this->sid,
					'USID_TO'=>$uid,
					'CREATE_TIME'=>date('Y-m-d H:i:s'),
					'DEAL_TIME'=>date('Y-m-d H:i:s'),
					'TYPE'=>$type,
					'STATUS'=>$status
					));
		}else{
			//添加好友
			if($status=='0'){
				//创建添加好友请求
				return $this->_db->Insert(MIMConfig::_table_mim_friend_action, array(
						'USID_FROM'=>$this->sid,
						'USID_TO'=>$uid,
						'CREATE_TIME'=>date('Y-m-d H:i:s'),
						'TYPE'=>$type,
						'STATUS'=>$status
						));
			}else{
				//更新好友请求结果(允许/拒绝)
				return $this->_db->Update(MIMConfig::_table_mim_friend_action,
						array('USID_FROM'=>$uid, 'USID_TO'=>$this->sid, 'TYPE'=>$type, 'DEAL_TIME'=>'0000-00-00 00:00:00'),
						array('DEAL_TIME'=>date('Y-m-d H:i:s'), 'STATUS'=>$status)
						);
			}
		}
	}
	
	/**
	 * 获取需要处理的好友添加请求
	 * @param	
	 */
	function undoFriendAction($from_id=''){
		if($from_id=='')
			$query_list = $this->_db->Select(MIMConfig::_table_mim_friend_action, array('USID_TO'=>$this->sid, 'STATUS'=>'0', 'TYPE'=>'1'), array('select'=>array('USID_FROM', 'CREATE_TIME', 'SID')));
		else
			$query_list = $this->_db->Select(MIMConfig::_table_mim_friend_action, array('USID_TO'=>$this->sid, 'STATUS'=>'0', 'TYPE'=>'1', 'USID_FROM'=>$from_id), array('select'=>array('USID_FROM', 'CREATE_TIME', 'SID')));
		$arrRet = array();
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
			
	/**
	 * 生成用户会话凭证
	 * @return	string
	 */
	function makeTokenValue(){
		return array('uid'=>$this->uid, 'usid'=>$this->sid);
	}
	
	/**
	 * 生成会话id
	 * @return	string
	 */
	function getTokenId(){
		return md5($this->sid);
	}
}

/**
 * MIM用户dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MIM_User_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MIMConfig::_table_mim_user;

	//数据字段名称
	protected static $_co_dataform_field = array(
			'SID',
			'UID',
			'PASSWORD',
			'NAME',
			'SEX',
			'IMG',
			'PHONE',
			'EMAIL',
			'STATUS',
			'CONTENT',
			'BIRTHDAY'
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
			throw new MIM_Exception(MIMConfig::_err_msg_invalid_user_sid, MIMConfig::_err_code_invalid_user_sid);
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
			throw new MIM_Exception(MIMConfig::_err_msg_invalid_user_id, MIMConfig::_err_code_invalid_user_id);
		}
		return $ins;
	}
}
?>