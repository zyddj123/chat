<?php
/**
 * MIM消息类
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
class MIM_Chat_Record{
	
	/**
	 * 添加聊天内容
	 * @param	from_usid string 发送者id
	 * @param	content string 内容
	 * @param	scene_type string 场景类型 个人/群组
	 * @param	scene_id string 场景id
	 * @param	content_type int 内容类型
	 * @return	boolean
	 */
	static function Add($from_usid, $content, $scene_type, $scene_id, $content_type=null){
		try {
			$db = GetDb();
		} catch (Exception $e) {
			return false;
		}
		if(is_null($content_type)) $content_type = MIMConfig::_type_content_text;    //默认文本内容
		
		return $db->Insert(MIMConfig::_table_mim_chat_record, array(
				'USID_FROM' => $from_usid,
				'SCENE_TYPE' => $scene_type,
				'SCENE_ID' => $scene_id,
				'STATUS' => $scene_type=='3'?'0':'1',					//私聊有未读标记
				'CONTENT' => $content,
				'CONTENT_TYPE' => $content_type,
				'CREATE_TIME' => date('Y-m-d H:i:s')
				));
	}
	
	/**
	 * 标记消息已读
	 * @param	cid string 消息id
	 * @return	boolean
	 */
	static function Read($cid){
		try {
			$db = GetDb();
		} catch (Exception $e) {
			return false;
		}
		if(is_array($cid)){
			return $db->Query('Update '.MIMConfig::_table_mim_chat_record.' SET STATUS=? WHERE SID IN ('.implode(',', $cid).')', array('1'));
		}else {
			return $db->Update(MIMConfig::_table_mim_chat_record, array('SID'=>$cid), array('STATUS'=>'1'));
		}
	}
	
	/**
	 * 获取未读消息
	 * @param	uid string 消息接收者
	 * @return	array
	 */
	static function UnRead($uid){
		$arrRet = array();
		try{
			$db = GetDb();
		} catch (Exception $e) {
			return $arrRet;
		}
		$query_list = $db->Select(
				MIMConfig::_table_mim_chat_record,
				array('STATUS'=>'0', 'SCENE_TYPE'=>'3', 'SCENE_ID'=>$uid)
				);
		if($query_list){
			foreach($query_list as $query){
				array_push($arrRet, array(
						'content' => $query['CONTENT'],
						'content_type' => $query['CONTENT_TYPE'],
						'time' => $query['CREATE_TIME'],
						'from' => $query['USID_FROM'],
						'cid' => $query['SID']
						));
			}
		}
		return $arrRet;
	}
}
?>