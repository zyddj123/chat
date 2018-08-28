<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}
/**
 * moa用户登录_模型
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.17
 */
class LoginModel extends Model{
	
	protected $_has_MOO =  false;				//是否有MOO组件
	protected $_has_CHAT = false;				//是否有CHAT组件
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
			$this->_moa_session = new MOA_SESSION();
			if($this->_has_MOO) $this->_moo_session = new MOO_SESSION();
		}catch(Exception $e){}
	}
	
	
	/**
	 * doLogin()验证用户登录，并生成SESSION
	 * @param  $uid string 用户UID
	 * @param  $password string 密码
	 * @return boolean
	 */
	function doLogin($uid,$password){
		if($uid=='' || $password=='') return false;
		try{
			//验证用户名密码是否准确
			$login_check = MOA_User::CheckUserPwd($uid, $password);
			//创建会话
			if($login_check>0){
				$this->_moa_session->makeSession($uid);
				$objMIMUser = MIM_User::GetInstanceByUID($_SESSION['moa']['uid']);
				if($objMIMUser != null){
					$token_file = MIM::config('_token_file_path').'/'.$objMIMUser->getTokenId().'.sose';
					file_put_contents($token_file, serialize($objMIMUser->makeTokenValue()));
					$_SESSION['mim'] = $objMIMUser->getTokenId();
					return trues;
				}
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}

	/**
	 * logout()注销账户
	 */
	function logout(){
		$this->_moa_session->destroy();
		if($this->_has_MOO) $this->_moo_session->destroy();
		$this->_moa_session->login_redirect(APP_URL_ROOT.'/login');
	}
}
?>