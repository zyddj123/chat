<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA权限组件类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

@include_once 'MOAConfig.inc.php';
class MOA_Role{
	protected $_dataform = null;					//群组用户数据对象
	protected $_db = null;								//数据库对象
	
	public $sid;														//主键SID
	public $name;													//权限名
	public $action;												//内容
	
	
	function __construct($sid){
		$this->_db = GetDB();
		$this->sid = $sid;
		$this->_dataform = new MOA_Role_Dataform($sid);
		$this->name = $this->_dataform->GetProp('NAME');
		$this->action = $this->_dataform->GetProp('ACTION');
	}
	
	/**
	 * Add() 添加权限信息
	 * @param  $post array 提交的数据
	 */
	static function Add($post){
		$data=array();
		if(isset($post['name'])&&$post['name']!='') $data['NAME'] = $post['name'];
		if(isset($post['action'])&&$post['action']!='') $data['ACTION'] = $post['action'];
		if(!count($data)){
			return null;
		}
		try {
			$ins = MOA_Role_Dataform::Add($data);
			return new self($ins);
		} catch (Exception $e) {
			return null;
		}
	}
	/**
	 * Update() 编辑权限
	 * @param  $post array 提交的数据
	 * @return boolean
	 */
	function Update($post){
		$data=array();
		if(isset($post['name'])&&$post['name']!='') $data['NAME'] = $post['name'];
		if(isset($post['action'])&&$post['action']!='') $data['ACTION'] = $post['action'];
		if(count($data) == 0){
			return false;
		}
		if($this->_dataform->update($data)){
			if(isset($post['name'])&&$post['name']!='') $this->name = $post['name'];
			if(isset($post['action'])&&$post['action']!='') $this->action = $post['action'];
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Delete() 删除权限
	 */
	function Delete(){
		return $this->_dataform->delete();
	}
	
	static function _getRoleAll(){
		$result=array();
		try{
			$db=GetDB();
			$data =$db->Select(MOAConfig::_table_moa_role);
			if($data){
				foreach ($data as $val){
					array_push($result,array(
							'sid'=>$val['SID'],
							'name'=>$val['NAME'],
							'action'=>$val['ACTION']
							));
				}
			}
			return $result;
		}catch(Exception $e){}
	}
	
}
/**
 * MOA权限dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MOA_Role_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MOAConfig::_table_moa_role;
	//数据字段名称
	protected static $_co_dataform_field = array(
			'SID',
			'NAME',
			'ACTION'
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_role_sid, MOAConfig::_err_code_invalid_role_sid);
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_role_sid, MOAConfig::_err_code_invalid_role_sid);
		}
		return $ins;
	}
}
?>