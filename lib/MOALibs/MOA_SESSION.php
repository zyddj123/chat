<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA会话(session)管理类
 * 会话数据作用在$_SESSION['moa']范围内
 * 与其它系统插件会话不冲突
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

@include_once 'MOAConfig.inc.php';
@include_once 'MOA_Role.php';
//--------------------------------------------------------------------------
class MOA_SESSION extends CO_Session{
	
	public $uid;
	
	/**
	 * 构造函数
	 */
	function __construct(){
		parent::__construct();
		$this->uid=$this->_session['moa']['uid'];
	}
	
	/**
	 * 获取session值
	 * @return	mixed 数值
	 */
	function get($key){
		return $this->_session['moa'][$key];
	}
	
	/**
	 * 设置session值
	 * @param	key string 键
	 * @param	val string 值
	 * @return	object 当前对象
	 */
	function set($key, $val){
		$this->_session['moa'][$key]=$val;
		return $this;
	}
	
	/**
	 * 是否登录
	 */
	 function is_login(){
		if( !isset($this->_session) || !isset($this->_session['moa']['uid'])) return false;
		return true;
	}
	
	/**
	 * 登录验证,如果未登录则跳转到指定页面
	 * @param	redirect_url string 跳转页面
	 * @return	boolean
	 */
	function login_check($redirect_url){
		if(!$this->is_login()){
			header('location:'.$redirect_url);
			return false;
		}
		return true;
	}
	
	/**
	 * 登录重定向
	 * @param	redirect_path string 重定向路径
	 */
	function login_redirect($redirect_path=''){
		if($redirect_path=='') $redirect_path='/login';
		header('location:'.$redirect_path);
		exit;
	}
	
	/**
	 * 创建session
	 */
	function makeSession($uid){
		try {
			$user=new MOA_User($uid);
			if($user->role!='0'){
				$role = new MOA_Role($user->role);
				if($role){
					$this->set('role',json_decode($role->action,true));
				}else{
					$this->set('role',$user->role);
				}
			}else{
				$this->set('role',$user->role);
			}
			$this->uid = $uid;
			$this->Set('sid',$user->sid);
			$this->set('uid', $uid);
			$this->set('is_admin', $user->is_admin);
			$this->set('name', $user->name);
			$this->set('sex', $user->sex);
			$this->set('email', $user->email);
			$this->set('phone', $user->phone);
			$this->set('img',$user->img);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * 是否管理员
	 * @return	boolean
	 */
	function is_admin(){
		return $this->get('is_admin')=='1';
	}
	
	/**
	 * 销毁会话
	 * @see CO_Session::Destroy()
	 * @return	boolean
	 */
	function Destroy(){
		unset($this->_session['moa']);
		return true;
	}
	
	/**
	 * 是否拥有操作权限
	 * @param	action string 操作字符
	 * @return	boolean
	 */
	function hasAction($action=''){
		//if($this->is_admin()) return true;
		if($action=='') return false;
		//判断会话有效性
		if(!$this->is_login()) return false;
		$user_action=$this->_session['moa']['role'];
		//通配符'*'表示所有权限
		if($user_action=='*') return true;
		if(!is_array($user_action) || count($user_action)==0) return false;
		if(in_array($action, $user_action)) return true;
		else return false;
	}
}
?>