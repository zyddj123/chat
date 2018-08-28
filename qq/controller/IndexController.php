<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * 系统首页控制器
 *
 * @package		MOA
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 *
 */

class IndexController extends Controller{
	protected $_index_model = null;
	protected $_session = null;
	/**
	 * 初始化
	 */
	protected function _init(){
		$this->_session = new MOA_SESSION();
		$this->_session->login_check(APP_URL_ROOT.'/Login/index');
		// $this->_index_model = $this->GetModel('Index');
		// 语言包
		// $this->GetLang('index')->GetLang('moouser');
	}
	
	/**
	 * 默认入口
	 */
	function run(){
		self::index();
	}
	
	/**
	 * 首页
	 */
	function index(){
		$this->Render('index/index');
	}


	/**
	 * 异步获取当前用户好友
	 */
	function ajax_mim_firends(){
		$friends = $this->_index_model->MIMuser_my_friends();
		echo json_encode($friends);
	}
	/**
	 * 异步获取当前用户聊天组
	 */
	function ajax_mim_groups(){
		$groups = $this->_index_model->MIMuser_my_groups();
		echo json_encode($groups);
	}
	
	/**
	 * 包含MOO组件的首页
	 * 显示MOO用户及账户信息
	 */
	protected function _MOO_index($info){
		$this->Render('appchat/appchat',array(
				'data'=>$info['user_data'],
				'account'=>$info['account_data']));				
	}
	
	/**
	 * 只有MOA组件的首页
	 * 显示MOA用户信息
	 */
	protected function _MOA_index($info){
		$this->Render('index/moa_index',array('data'=>$info['user_data']));		
	}
		
	/**
	 * 编辑用户信息
	 */
	function edit_user(){
		$mooPlugin = $this->_index_model->MoouserPlugin();//判断是否用MOO用户组件
		if(is_null($this->input->post())){
			if($mooPlugin){
				$this->_MOO_open_edit_user($this->_index_model->Moouserinfo());
			}else{
				$this->_MOA_open_edit_user($this->_index_model->Moauserinfo());
			}
		}else{
			//提交编辑数据
			if($mooPlugin) {
				$this->_MOO_edit_user();
			}else{
				$this->_MOA_edit_user();
			}	
		}
	}
	
	/**
	 * 打开MOO修改用户页面
	 */
	protected function _MOO_open_edit_user($userInfo){
		$this->Render(
				'appchat/moo_edit_user',array(
						'uid'=>$userInfo['uid'],
						'sid'=>$userInfo['sid'],
						'username'=>$userInfo['username'],
						'mail'=>$userInfo['mail'],
						'phone'=>$userInfo['phone'],
						'activation'=>$userInfo['activation'],
						'sex'=>$userInfo['sex'],
						'birthdate'=>$userInfo['birthdate'])
				);
	}
	
	/**
	 * 修改MOO用户
	 */
	protected function _MOO_edit_user(){
		$post_data = $this->_MOO_user_post_info();
		$edit = $this->_index_model->Moouser_submit_edit($post_data);
		if($edit){
			header('location:'.APP_URL_ROOT.'/appchat');
			return true;
		}else{
			header('location:'.APP_URL_ROOT.'/appchat/edit_user/&promp=4');
			return false;
		}
	}
	
	/**
	 * 过滤MOO修改用户提交数据字段
	 * 接收 用户名,邮箱,手机,出生日期,性别 等字段的修改
	 * @return	array 过滤后的修改字段数据
	 */
	protected function _MOO_user_post_info(){
		$data=array();
		if(!is_null($this->input->post('username')) && $this->input->post('username')!='') $data['username']=$this->input->post('username');
		if(!is_null($this->input->post('mail')) && $this->input->post('mail')!='') $data['mail']=$this->input->post('mail');
		if(!is_null($this->input->post('phone')) && $this->input->post('phone')!='') $data['phone']=$this->input->post('phone');
		if(!is_null($this->input->post('birthdate')) && $this->input->post('birthdate')!='') $data['birthdate']=$this->input->post('birthdate');
		if(!is_null($this->input->post('sex')) && $this->input->post('sex')!='') $data['sex']=$this->input->post('sex');
		return $data;
	}
	
	/**
	 * 打开MOA编辑用户页面
	 */
	protected function _MOA_open_edit_user($userInfo){
		$this->Render(
				'appchat/moa_edit_user',array(
						'sid'=>$userInfo['sid'],
						'uid'=>$userInfo['uid'],
						'name'=>$userInfo['name'],
						'head_img'=>$userInfo['head_img'],
						'status'=>$userInfo['status'],
						'phone'=>$userInfo['phone'],
						'email'=>$userInfo['email'],
						'sex'=>$userInfo['sex'],
						'content'=>$userInfo['content'])
		);
	}
	
	/**
	 * 修改MOA用户数据
	 */
	protected function _MOA_edit_user(){
		$post_data = $this->_MOA_user_post_info();		
		$edit = $this->_index_model->Moauser_submit_edit($post_data,$_FILES['head_img']);
		if($edit){
			header('location:'.APP_URL_ROOT.'/appchat');
			return true;
		}else{
			header('location:'.APP_URL_ROOT.'/appchat/edit_user/&promp=4');
			return false;
		}
	}
	
	/**
	 * 过滤MOA修改用户提交数据字段
	 * @return	array 过滤后的修改字段数据
	 */
	protected function _MOA_user_post_info(){
		$data=array();
		if(!is_null($this->input->post('name')) && $this->input->post('name')!='') $data['name']=$this->input->post('name');
		if(!is_null($this->input->post('sex')) && $this->input->post('sex')!='') $data['sex']=$this->input->post('sex');
		if(!is_null($this->input->post('email')) && $this->input->post('email')!='') $data['email']=$this->input->post('email');
		if(!is_null($this->input->post('phone')) && $this->input->post('phone')!='') $data['phone']=$this->input->post('phone');
		if(!is_null($this->input->post('content')) && $this->input->post('content')!='') $data['content']=$this->input->post('content');
		return $data;
	}
	
	/**
	 * 修改MOO账户
	 */
	function edit_account(){
		if(is_null($this->input->post())){
			//打开编辑
			$this->_MOO_open_edit_account();
		}else{
			//提交编辑
			$this->_MOO_edit_account();
		}
	}
	
	/**
	 * 判断MOO账户是否有权限修改
	 * @param	account_sid string 账户sid
	 * @return	mixed 如果有权限返回账户对象,否则false
	 */
	protected function _MOO_check_account_auth($account_sid){
		$bln_auth = false;
		if($this->_has_MOO && $account_sid!=''){
			try {
				$objMOOUser = new MOO_User($this->_moo_session->uid);
				foreach($objMOOUser->getAccount() as $objAccount){
					if($objAccount->sid == $account_sid){
						$bln_auth = true;
						return $objAccount;
					}
				}
			} catch (Exception $e) {
				$bln_auth = false;
			}
		}
		if(!$bln_auth) return null;
	}
	
	/**
	 * 打开修改MOO账户页面
	 */
	protected function  _MOO_open_edit_account(){
		$account_sid = $this->input->Get('sid');
		$account = $this->_index_model->Moouser_account_info($account_sid);
		if(is_null($account)){
			//错误页
			$this->Render('error/index');
			return false;
		}
		$this->Render('index/moo_edit_account',array(
						'account_full_id'=>$account['account_full_id'],
						'sid'=>$account['sid'],
						'account_name'=>$account['account_name'],
						'is_main'=>$account['is_main'],
						'head_img'=>$account['head_img'],
						'status'=>$account['status']));	
		return true;
	}
	
	/**
	 * 修改MOO账户
	 */
	protected function _MOO_edit_account(){
		$bln_bingo = false;				//是否修改成功
		$account_sid = $this->input->Post('sid');
		$post_data = $this->_MOO_account_post_info();
		$editAccount = $this->_index_model->Moouser_account_submit_edit($account_sid,$post_data,$_FILES['head_img']);
		if($editAccount){
			header('location:'.APP_URL_ROOT.'/index');
			return true;
		}else{
			header('location:'.APP_URL_ROOT.'/index/edit_account/&sid='.$account_sid);
			return false;
		}
	}
	
	/**
	 * 过滤MOO修改用户提交数据字段
	 * @return	array 过滤后的修改字段数据
	 */
	protected function _MOO_account_post_info(){
		$data=array();
		if(!is_null($this->input->post('account_name')) && $this->input->post('account_name')!='') $data['account_name']=$this->input->post('account_name');
		if(!is_null($this->input->post('is_main')) && $this->input->post('is_main')!='') $data['is_main']=$this->input->post('is_main');
		return $data;
	}
	
	/**
	 * 添加MOO账户
	 */
	function add_account(){
		$mooPlugin = $this->_index_model->MoouserPlugin();
		if(!$mooPlugin){
			$this->Render('error/index');
			return false;
		}
		if(is_null($this->input->post())){
			//打开添加页面
			$this->_MOO_open_add_account();
		}else{
			//提交添加数据
			$this->_MOO_add_account();
		}
	}
	
	/**
	 * 打开添加账户页面
	 */
	protected function _MOO_open_add_account(){
		try {
			$Moouser = $this->_index_model->Moouserinfo();
		} catch (Exception $e) {
		}
		$this->Render(
				'index/moo_add_account',
				array('sid'=>$Moouser['uid'])
				);
		return true;
	}
	
	/**
	 * 提交保存账户信息
	 * 
	 */
	protected function _MOO_add_account(){
		$moo_user_uid = $this->input->Post('sid');
		$account_name=$this->input->post('account_name');
		$add = $this->_index_model->Moouser_account_submit_add($moo_user_uid,$account_name,$_FILES['head_img']);
		if($add){
			header('location:'.APP_URL_ROOT.'/index/edit_account/&sid='.$add);
			return true;
		}else{
			header('location:'.APP_URL_ROOT.'/index');
			return true;
		}
	}
	
	/**
	 * 切换账户
	 * ajax调用
	 */
	function change_account(){
		$account_sid = $this->input->Post('sid');
		$change = $this->_index_model->Moouser_account_change($account_sid);
		if($change){
			echo json_encode(true); return true;
		}else{
			echo json_encode(false); return false;
		}
	}
	
	/**
	 * 删除账户
	 * ajax调用
	 */
	function del_account(){
		$account_sid = $this->input->Post('sid');
		$del = $this->_index_model->Moouser_account_delete($account_sid);
		if($del){
			echo json_encode(true); return true;
		}else{
			echo json_encode(false); return false;
		}
	}
	
	/**
	 * 修改密码
	 */
	function edit_pwd(){
		if(is_null($this->input->Post())){
			$this->Render('appchat/edit_pwd');
		}else{
			$password = $this->input->Post('password');
			$mooPlugin = $this->_index_model->MoouserPlugin();
			if($mooPlugin){
				$this->_MOO_pwd($password);
			}else{
				$this->_MOA_pwd($password);
			}
			header('location:'.APP_URL_ROOT.'/appchat');
		}
	}
	
	/**
	 * 修改moo密码
	 * @param	pwd string 密码明文
	 * @return	boolean
	 */
	protected function _MOO_pwd($pwd){
		$edit = $this->_index_model->Moouser_password_edit($pwd);
		if($edit){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 修改moa密码
	 * @param	pwd string 密码明文
	 * @return	boolean
	 */
	protected function _MOA_pwd($pwd){
		$edit = $this->_index_model->Moauser_password_edit($pwd);
		if($edit){
			return true;
		}else{
			return false;
		}
	}
}
?>