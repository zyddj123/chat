<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA站内通知组件类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */
@include_once 'MOAConfig.inc.php';
class MOA_Notice{
	protected $_dataform = null;					//群组用户数据对象
	protected $_db = null;								//数据库对象
	
	public $sid;														//自增SID
	public $type;													//通知类型  1通知 2加班 3假期
	public $start_time;										//起始时间
	public $end_time;											//结束时间
	public $content;												//通知内容
	public $create_time;										//创建时间
	public $creator;												//创建人
	public $send_type;										//发送类型 0全体用户  1指定用户
	/**
	 * 构造函数
	 * @param unknown_type $sid
	 */
	function __construct($sid){
		$this->_db = GetDB();
		$this->sid = $sid;
		$this->_dataform = new MOA_Notice_Dataform($sid);
		$this->type = $this->_dataform->GetProp('TYPE');
		$this->start_time = $this->_dataform->GetProp('START_TIME');
		$this->end_time = $this->_dataform->GetProp('END_TIME');
		$this->content = $this->_dataform->GetProp('CONTENT');
		$this->create_time = $this->_dataform->GetProp('CREATE_TIME');
		$this->creator = $this->_dataform->GetProp('CREATOR');
		$this->send_type = $this->_dataform->GetProp('SEND_TYPE');
	}
	/**
	 * Add() 添加通知
	 * @param  $post array 提交的数据
	 */
	static function Add($post){
		$data=array();
		if(isset($post['type'])&&$post['type']!='') $data['TYPE'] = $post['type'];
		if(isset($post['start_time'])&&$post['start_time']!='') $data['START_TIME'] = $post['start_time'];
		if(isset($post['end_time'])&&$post['end_time']!='') $data['END_TIME'] = $post['end_time'];
		if(isset($post['content'])&&$post['content']!='') $data['CONTENT'] = $post['content'];
		if(isset($post['create_time'])&&$post['create_time']!='') $data['CREATE_TIME'] = $post['create_time'];
		if(isset($post['creator'])&&$post['creator']!='') $data['CREATOR'] = $post['creator'];
		if(isset($post['send_type'])&&$post['send_type']!='') $data['SEND_TYPE'] = $post['send_type'];
		if(!count($data)){
			return null;
		}
		try{
			$add = MOA_Notice_Dataform::Add($data);
			return new self($add);
		}catch(Exception $e){ return null;}
	}
	/**
	 * Update() 编辑通知
	 * @param  $post array 提交的数据
	 * @return NULL|boolean
	 */
	function Update($post){
		$data=array();
		if(isset($post['type'])&&$post['type']!='') $data['TYPE'] = $post['type'];
		if(isset($post['start_time'])&&$post['start_time']!='') $data['START_TIME'] = $post['start_time'];
		if(isset($post['end_time'])&&$post['end_time']!='') $data['END_TIME'] = $post['end_time'];
		if(isset($post['content'])&&$post['content']!='') $data['CONTENT'] = $post['content'];
		if(isset($post['create_time'])&&$post['create_time']!='') $data['CREATE_TIME'] = $post['create_time'];
		if(isset($post['creator'])&&$post['creator']!='') $data['CREATOR'] = $post['creator'];
		if(isset($post['send_type'])&&$post['send_type']!='') $data['SEND_TYPE'] = $post['send_type'];
		if(!count($data)){
			return null;
		}
		if($this->_dataform->update($data)){
			if(isset($post['type'])&&$post['type']!='') $this->type = $post['type'];
			if(isset($post['start_time'])&&$post['start_time']!='') $this->start_time = $post['start_time'];
			if(isset($post['end_time'])&&$post['end_time']!='') $this->end_time=$post['end_time'];
			if(isset($post['content'])&&$post['content']!='') $this->content = $post['content'];
			if(isset($post['create_time'])&&$post['create_time']!='') $this->create_time = $post['create_time'];
			if(isset($post['creator'])&&$post['creator']!='') $this->creator = $post['creator'];
			if(isset($post['send_type'])&&$post['send_type']!='') $this->send_type = $post['send_type'];
			return true;
		}else{
			return false;
		}
	}
	/**
	 * Del()删除任务
	 */
	function Del(){
		return $this->_dataform->Delete();
	}
	
	/**
	 * Noticeuser_add() 添加通知接收用户
	 * @param  sid int 通知SID
	 * @param  $user array 接收用户
	 */
	static function Noticeuser_add($sid,$user){
		if(!isset($sid) || $sid=='' || $user=='') return false;
		try{
			$db=GetDB();
			$user_array = explode(",", $user);
			foreach ($user_array as $uid){
				$db->Insert(MOAConfig::_table_moa_notice_user,array('NOTICE_SID'=>$sid,'UID'=>$uid));
			}
			return true;
		}catch(Exception $e){ return false;}
	}
	
	/**
	 * Noticeuser_del() 删除通知用户
	 * @param  $sid int 通知SID
	 * @param  $uid string 用户UID
	 */
	static function Noticeuser_del($sid){
		if(!isset($sid) || $sid=='') return false;
		try{
			$db=GetDB();
			$del = $db->Delete(MOAConfig::_table_moa_notice_user,array('NOTICE_SID'=>$sid));
			if($del){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){}
	}
	
	/**
	 * Noticeuser_info() 获取通知接收用户信息
	 * @param  $sid string 通知SID
	 */
	static function Noticeuser_info($sid){
		if(!isset($sid) || $sid=='') return false;
		try{
			$result=array();
			$db=GetDB();
			$sql="SELECT * FROM ".MOAConfig::_table_moa_notice_user." WHERE NOTICE_SID=?";
			$data = $db->GetAll($sql,array($sid));
			if($data){
				foreach ($data as $val){
					array_push($result,array('sid'=>$val['SID'],'notice_sid'=>$val['notice_sid'],'uid'=>$val['UID']));
				}
				return $result;
			}
		}catch(Exception $e){}
	}
	
	/**
	 * Notice_Calendar_data() 根据日历时间段获取通知信息
	 * @param  $date array 日历周期
	 */
	static function Notice_Calendar_data($date){
		if(!isset($date) || $date=='') return false;
		try{
			$result=array();
			$db=GetDB();
			$start = $date[0].' 00:00:00';
			$end = end($date).' 00:00:00';
			$sql="SELECT * FROM ".MOAConfig::_table_moa_notice." WHERE (START_TIME>=? OR END_TIME <=?) AND SEND_TYPE=?";
			$data = $db->GetAll($sql,array($start,$end,'0'));
			foreach ($data as $val){
				array_push($result,array(
						'sid'=>$val['SID'],
						'type'=>$val['TYPE'],
						'start_time'=>$val['START_TIME'],
						'end_time'=>$val['END_TIME'],
						'content'=>$val['CONTENT'],
						'create_time'=>$val['CREATE_TIME'],
						'creator'=>$val['CREATOR'],
						'send_type'=>$val['SEND_TYPE']
						));
			}			
			return $result;
		}catch(Exception $e){}
	}
	/**
	 * Notice_Calendar_user() 获取属于用户的通知信息
	 * @param  $uid string 用户UID
	 */
	static function Notice_Calendar_user($uid){
		if(!isset($uid) || $uid=='') return false;
		try{
			$result=array();
			$db=GetDB();
			$sql="SELECT * FROM ".MOAConfig::_table_moa_notice_user." WHERE UID=?";
			$data = $db->GetAll($sql,array($uid));
			foreach ($data as $val){
				array_push($result, array(
						'sid'=>$val['SID'],
						'notice_sid'=>$val['NOTICE_SID'],
						'uid'=>$val['UID']
						));
			}
			return $result;
		}catch(Exception $e){}
	}
}
/**
 * MOA通知dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MOA_Notice_Dataform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MOAConfig::_table_moa_notice;
	//数据字段名称
	protected static $_co_dataform_field = array(
			'SID',
			'TYPE',
			'START_TIME',
			'END_TIME',
			'CONTENT',
			'CREATE_TIME',
			'CREATOR',
			'SEND_TYPE'
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_notice_sid, MOAConfig::_err_code_invalid_notice_sid);
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_notice_sid, MOAConfig::_err_code_invalid_notice_sid);
		}
		return $ins;
	}
}
?>