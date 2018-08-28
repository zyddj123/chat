<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}
/**
 * MOA用户签到组件类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */
@include_once 'MOAConfig.inc.php';
class MOA_Attendance{
	
	protected $_dataform = null;					//群组用户数据对象
	protected $_db = null;								//数据库对象
	
	public $sid;						//主键SID	
	public $uid;						//签到用户UID
	public $regtime;			//签到日期
	public $checktime;		//签到时间
	public $checkip;				//签到IP
	public $type;					//签到类型  1上班  2下班
	public $devse;					//备注
	
	function __construct($sid){
		$this->_db = GetDB();
		$this->sid = $sid;
		$this->_dataform = new MOA_Attendance_Dateform($sid);
		$this->uid = $this->_dataform->GetProp('UID');
		$this->regtime = $this->_dataform->GetProp('REGTIME');
		$this->checktime = $this->_dataform->GetProp('CHECKTIME');
		$this->checkip = $this->_dataform->GetProp('CHECKIP');
		$this->type = $this->_dataform->GetProp('TYPE');
		$this->devse = $this->_dataform->GetProp('DEVSE');
	}
	
	/**
	 * Add()添加签到
	 * @param  $post array 提交的数据
	 */
	static function Add($post){
		$data=array();
		if(isset($post['uid'])&&$post['uid']!='') $data['UID'] = $post['uid'];
		if(isset($post['regtime'])&&$post['regtime']!='') $data['REGTIME'] = $post['regtime'];
		if(isset($post['checktime'])&&$post['checktime']!='') $data['CHECKTIME'] = $post['checktime'];
		if(isset($post['checkip'])&&$post['checkip']!='') $data['CHECKIP'] = $post['checkip'];
		if(isset($post['type'])&&$post['type']!='') $data['TYPE'] = $post['type'];
		if(isset($post['devse'])&&$post['devse']!='') $data['DEVSE'] = $post['devse'];
		if(!count($data)){
			return false;
		}
		try{
			$add = MOA_Attendance_Dateform::Add($data);
			return new self($add);
		}catch(Exception $e){ return null;}
	}
	
	/**
	 * Update() 编辑签到
	 * @param  $post array 提交的数据
	 * @return boolean
	 */
	function Update($post){
		$data=array();
		if(isset($post['uid'])&&$post['uid']!='') $data['UID'] = $post['uid'];
		if(isset($post['regtime'])&&$post['regtime']!='') $data['REGTIME'] = $post['regtime'];
		if(isset($post['checktime'])&&$post['checktime']!='') $data['CHECKTIME'] = $post['checktime'];
		if(isset($post['checkip'])&&$post['checkip']!='') $data['CHECKIP'] = $post['checkip'];
		if(isset($post['type'])&&$post['type']!='') $data['TYPE'] = $post['type'];
		if(isset($post['devse'])&&$post['devse']!='') $data['DEVSE'] = $post['devse'];
		if(!count($data)){
			return false;
		}
		try{
			if($this->_dataform->update($post)){
				if(isset($data['UID'])) $this->uid = $data['UID'];
				if(isset($data['REGTIME'])) $this->regtime = $data['REGTIME'];
				if(isset($data['CHECKTIME'])) $this->checktime = $data['CHECKTIME'];
				if(isset($data['CHECKIP'])) $this->checkip = $data['CHECKIP'];
				if(isset($data['TYPE'])) $this->type = $data['TYPE'];
				if(isset($data['DEVSE'])) $this->devse = $data['DEVSE'];
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){ return false;}
	}
	
	/**
	 * 删除签到
	 */
	function Delete(){
		return $this->_dataform->delete();
	}
	
	/**
	 * Attendance_fulldate()签到次数列表
	 * @param  $date array 日期
	 */
	static function Attendance_fulldate($date){
		$result=array();
		if(!isset($date) || $date=='') return false;
		try{
			$db=GetDB();
			foreach ($date as $key=>$val){
				$sql = "SELECT COUNT(*) FROM ".MOAConfig::_table_moa_attendance." WHERE REGTIME = ?";
				$num = $db->GetRow($sql,array($val));
				if($num['COUNT(*)']>0){
					$result[]=array(
							'id'=>$key,
							'title'=>'签到次数：'.$num['COUNT(*)'],
							'start'=>date('Y-m-d',strtotime($val)),
							'end'=>date('Y-m-d',strtotime($val)),
							'url'=>APP_URL_ROOT.'/attendance/check_table/&date='.date('Y-m-d',strtotime($val))
							);
				}
			}	
		}catch(Exception $e){}
		return $result;
	}
	/**
	 * Attendance_fulldate_my()个人签到信息
	 * @param  $date array 时间段
	 * @param  $uid string 用户ID
	 */
	static function Attendance_fulldate_my($date,$uid){
		$result=array();
		if(!isset($date) || $date=='' || !isset($uid) || $uid=='') return false;
		try{
			$db=GetDB();
			foreach ($date as $key=>$val){
				$sql=" SELECT * FROM ".MOAConfig::_table_moa_attendance." WHERE REGTIME = ? AND UID = ?";
				$data = $db->GetAll($sql,array($val,$uid));
				foreach ($data as $ck=>$check){
					if($check['TYPE']=='1'){
						$type='上班';
					}else{
						$type='下班';
					}
					array_push($result, array(
							'id'=>$key.$ck,
							'title'=>$type.'签到',
							'start'=>date('Y-m-d H:i:s',strtotime($val.' '.$check['CHECKTIME'])),
							'end'=>date('Y-m-d H:i:s',strtotime($val.' '.$check['CHECKTIME'])),
							'allDay'=>false
							));
				}
			}
		}catch(Exception $e){}
		return $result;
	}
	
	
}
/**
 * MOA签到dataform类
 * 继承自CO_DataForm类
 * @author B.I.T
 *
 */
class MOA_Attendance_Dateform extends CO_DataForm{
	//数据表
	protected static $_co_dataform_table = MOAConfig::_table_moa_attendance;
	
	//数据字段名称
	protected static $_co_dataform_field = array(
			'SID',
			'UID',
			'REGTIME',
			'CHECKTIME',
			'CHECKIP',
			'TYPE',
			'DEVSE'
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_attendance_sid, MOAConfig::_err_code_invalid_attendance_sid);
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
			throw new MOA_Exception(MOAConfig::_err_msg_invalid_attendance_sid, MOAConfig::_err_code_invalid_attendance_sid);
		}
		return $ins;
	}
	
}
?>