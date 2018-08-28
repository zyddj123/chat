<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * 登录控制器
 *
 * @package		MOA
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 *
 */

class LoginController extends Controller{
	
	protected  $_login_model = null;						//登录model
	
	/**
	 * 初始化函数
	 */
	protected  function _init(){
		//加载model
		$this->_login_model = $this->GetModel('Login');
		//获取语言包
		$this->GetLang('login');
	}
	
	/**
	 * 默认入口
	 */
	function run(){
		self::index();
	}
	
	/**
	 * 登录首页
	 */
	function index(){
		$this->Render('login/index');
	}

	function do_login(){
		$username = $this->input->post('username');				//用户id
		$password = $this->input->post('password');		//密码明文
		$dologin = $this->_login_model->doLogin($username,$password);
		if($dologin){
			echo true;
		}else{
			echo false;
		}
	}
	
	/**
	 * 验证用户名密码
	 * 根据结果跳转页面
	 * @return	boolean
	 */
	protected function _doLogin(){
		$uid = $this->input->post('uid');				//用户id
		$password = $this->input->post('password');				//密码明文
		$dologin = $this->_login_model->doLogin($uid,$password);
		if($dologin['status']){
			header('location:'.APP_URL_ROOT);
		}else{
			header('location:'.APP_URL_ROOT.'/login/&err='.$dologin['value']);
		}
	}
		
	/**
	 * 注销会话
	 */
	function logout(){
		$this->_login_model->logout();
	}
}
?>