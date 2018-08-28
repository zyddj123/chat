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
class MOA_User{
	protected $_dataform = null;					//群组用户数据对象
	protected $_db = null;								//数据库对象
	
	public $sid;												//SID
	public $uid;												//登录UID
	public $password;									//密码
	public $name;											//姓名
	public $content;										//备注
	public $phone;											//联系方式
	public $email;											//邮箱
	public $role;												//角色
	public $is_admin;										//总管理员
	public $sex;												//性别
	public $status;											//状态
	public $img;												//头像
	
	/**
	 * 构造函数
	 * @param	uid string 用户id
	 */
	function __construct($uid){
		$this->_db = GetDB();
		$this->uid = $uid;
		$this->_dataform = new MOA_User_Dataform($uid);
		$this->sid = $this->_dataform->GetProp('SID');
		$this->password = $this->_dataform->GetProp('PASSWORD');
		$this->name = $this->_dataform->GetProp('NAME');
		$this->content = $this->_dataform->GetProp('CONTENT');
		$this->phone = $this->_dataform->GetProp('PHONE');
		$this->email = $this->_dataform->GetProp('EMAIL');
		$this->role = $this->_dataform->GetProp('ROLE');
		$this->is_admin = $this->_dataform->GetProp('IS_ADMIN');
		$this->sex = $this->_dataform->GetProp('SEX');
		$this->status = $this->_dataform->GetProp('STATUS');
		$this->img = $this->_dataform->GetProp('IMG');
	}
	
	/**
	 * 添加用户
	 * @param	post array 提交的信息
	 * @return 	object MOA_User对象
	 */
	static function Add($post){
		$data=array();
		if(isset($post['uid']) && $post['uid']!='') $data['UID']=$post['uid']; 
		if(isset($post['password']) && $post['password']!='') $data['PASSWORD']=$post['password'];
		if(isset($post['name']) && $post['name']!='') $data['NAME']=$post['name'];
		if(isset($post['content']) && $post['content']!='') $data['CONTENT']=$post['content'];
		if(isset($post['phone']) && $post['phone']!='') $data['PHONE']=$post['phone'];
		if(isset($post['email']) && $post['email']!='') $data['EMAIL']=$post['email'];
		if(isset($post['role']) && $post['role']!='') $data['ROLE']=$post['role'];
		if(isset($post['sex']) && $post['sex']!='') $data['SEX']=$post['sex'];
		if(isset($post['status']) && $post['status']!='') $data['STATUS']=$post['status'];
		if(isset($post['img']) && $post['img']!='') $data['IMG']=$post['img'];
		if(isset($post['is_admin'])&& $post['is_admin']!='') $data['IS_ADMIN'] = $post['is_admin'];
		if(!count($data)){
			return null;
		}		
		try {
			$ins = MOA_User_Dataform::Add($data);
			return new self($post['uid']);
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
		if(isset($post['role']) && $post['role']!='') $data['ROLE']=$post['role'];
		if(isset($post['sex']) && $post['sex']!='') $data['SEX']=$post['sex'];
		if(isset($post['status']) && $post['status']!='') $data['STATUS']=$post['status'];
		if(isset($post['img']) && $post['img']!='') $data['IMG']=$post['img'];
		if(count($data) == 0){
			return false;
		}
		if($this->_dataform->update($data)){
			if(isset($data['PASSWORD'])) $this->password = $data['PASSWORD'];
			if(isset($data['NAME'])) $this->name = $data['NAME'];
			if(isset($data['CONTENT'])) $this->content = $data['CONTENT'];
			if(isset($data['PHONE'])) $this->phone = $data['PHONE'];
			if(isset($data['EMAIL'])) $this->mail = $data['EMAIL'];
			if(isset($data['ROLE'])) $this->role = $data['ROLE'];
			if(isset($data['SEX'])) $this->sex = $data['SEX'];
			if(isset($data['STATUS'])) $this->us = $data['STATUS'];
			if(isset($data['IMG'])) $this->img = $data['IMG'];
			return true;
		}else return false;
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
		$query = $db->SelectOne(MOAConfig::_table_moa_user, array('UID'=>$uid, 'PASSWORD'=>static::Encrypt($pwd)), array('select'=>'STATUS'));
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
	 * 验证UID是否存在
	 * @param	uid string 用户id
	 * @return	boolean
	 */
	static function Uid_exist($uid){
		if(!isset($uid) || $uid=='') return false;
		try{
			$db=GetDB();
		}catch(Exception $e){
			return false;
		}
		$data = $db->SelectOne(MOA::config('_table_moa_user'), array('UID'=>$uid), array('select'=>'UID'));
		if($data){
			return true;
		}else{
			return false;
		}
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
				$upload_file_path = MOAConfig::_root_path.'/'.MOAConfig::_path_upload.'/'.$this->sid.$suffix;
				copy($image_file_path, $upload_file_path);
				@unlink($image_file_path);
			}else{
				$suffix = substr($image_file_path, strrpos($image_file_path, '.'));
				$upload_file_path = MOAConfig::_root_path.'/'.MOAConfig::_path_upload.'/'.$this->sid.$suffix;
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
	 * 获取图片
	 * @return string
	 */
	function getHeadImg(){
		return MIMConfig::_root_host.'/'.MIMConfig::_path_avatar.'/'.$this->img;
	}
}

/**
 * MOA用户dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MOA_User_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MOAConfig::_table_moa_user;

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
			'ROLE',
			'STATUS',
			'IS_ADMIN',
			'CONTENT'
	);

	//数据主键字段名称
	protected static $_co_dataform_main_key = array('UID');

	//数据库连接配置
	static $_co_dataform_db_name = '';

	/**
	 * 构造函数
	 * @param	sid string 目录sid
	 */
	function __construct($uid){
		$this->_co_dataform_main_key_value = array('UID'=>$uid);
		if(!$this->_CODataformLoad()){
			//数据加载失败
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_user_id, MOAConfig::_err_code_invalid_user_id);
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_user_id, MOAConfig::_err_code_invalid_user_id);
		}
		return $ins;
	}
}
?>