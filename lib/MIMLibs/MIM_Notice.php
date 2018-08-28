<?php
/**
 * MIM消息提醒
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
class MIM_Notice{
	
	/**
	 * 添加消息提醒
	* @param	usid string 被提醒人
	 * @param	content string 消息内容
	 * @param	scene_type string 场景类型
	 * @param	scene_id string 场景id
	 * @return	boolean
	 */
	static function Add($usid, $content, $scene_type, $scene_id, $status='0'){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return false;
		}
		$query = $db->SeleceOne(MIMConfig::_table_mim_notice, array('USID'=>$usid, 'SCENE_TYPE'=>$scene_type, 'SCENE_ID'=>$scene_id), array('select'=>'SID'));
		if($query === false){
			//如果提醒已经存在,则不用再次提醒
			return $db->Insert(MIMConfig::_table_mim_notice, array(
					'USID'=>$usid,
					'SCENE_TYPE'=>$scene_type,
					'SCENE_ID'=>$scene_id,
					'STATUS'=>$status,
					'CREATE_TIME'=>date('Y-m-d H:i:s'),
					'CONTENT'=>self::ContentEncode($content)
			));
		}else{
			//重写提醒时间
			return $db->Update(MIMConfig::_table_mim_notice, array('SID'=>$query['SID']), array('CREATE_TIME'=>date('Y-m-d H:i:s')));
		}
		return true;
	}
	
	/**
	 * 对聊天内容进行编码过滤
	 * @param	content string 聊天内容
	 * @return	string 编码过滤处理后的内容
	 */
	static function ContentEncode($content){
		return $content;
	}
	
	/**
	 * 内容已读标记
	 * @param	nid string 提醒id
	 * @return	boolean
	 */
	static function Read($nid){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return false;
		}
		return $db->Update(MIMConfig::_table_mim_notice, array('SID'=>$nid), array('STATUS'=>'1'));
	}
	
	/**
	 * 添加好友的请求提醒
	 * @param	usid_to string 被请求人sid
	 * @param	usid_from string 请求人sid
	 * @param	content string 提醒内容
	 * @param	status string 提醒状态
	 */
	static function RequestAddFriend($usid_to, $usid_from, $content, $status='0'){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return false;
		}
		$bln_exsit = $db->SelectOne(MIMConfig::_table_mim_notice, array('USID'=>$usid_to, 'SCENE_ID'=>$usid_from, 'SCENE_TYPE'=>'1', 'STATUS'=>'0'), array('select'=>'SID'));
		if($bln_exsit !== false) return false;		//已经存在未处理提醒
		return $db->Insert(MIMConfig::_table_mim_notice, array(
				'USID'=>$usid_to,
				'SCENE_TYPE'=>'1',
				'SCENE_ID'=>$usid_from,
				'STATUS'=>$status,
				'CREATE_TIME'=>date('Y-m-d H:i:s'),
				'CONTENT'=>self::ContentEncode($content)
				));
	}
	
	/**
	 * 添加好友的回复
	 * @param	usid_to string 被请求人sid
	 * @param	usid_from string 请求人sid
	 * @param	bln_confirm boolean 是否批准
	 */
	static function RespondAddFriend($usid_to, $usid_from, $bln_confirm=true){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return false;
		}
		$bln_exsit = $db->SelectOne(MIMConfig::_table_mim_notice, array('USID'=>$usid_to, 'SCENE_ID'=>$usid_from, 'SCENE_TYPE'=>'1', 'STATUS'=>'0'), array('select'=>'SID'));
		if($bln_exsit === false) return false;		//不存在未处理提醒
		return $db->Update(
				MIMConfig::_table_mim_notice,
				array(
						'USID'=>$usid_to,
						'SCENE_ID'=>$usid_from,
						'SCENE_TYPE'=>'1'
					),
				array(
						'STATUS'=>'1'
						)
				);
	}
	
	/**
	 * 加入群组的请求提醒
	 * @param	usid_to string 被请求人sid
	 * @param	usid_from string 请求人sid
	 * @param	content string 提醒内容
	 * @param	status string 提醒状态
	 */
	static function RequestAddGroup($usid_to, $usid_from, $content, $status='0'){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return false;
		}
		$bln_exsit = $db->SelectOne(MIMConfig::_table_mim_notice, array('USID'=>$usid_to, 'SCENE_ID'=>$usid_from, 'SCENE_TYPE'=>'2', 'STATUS'=>'0'), array('select'=>'SID'));
		if($bln_exsit !== false) return false;		//已经存在未处理提醒
		return $db->Insert(MIMConfig::_table_mim_notice, array(
				'USID'=>$usid_to,
				'SCENE_TYPE'=>'2',
				'SCENE_ID'=>$usid_from,
				'STATUS'=>$status,
				'CREATE_TIME'=>date('Y-m-d H:i:s'),
				'CONTENT'=>self::ContentEncode($content)
		));
	}
	
	/**
	 * 添加好友的回复
	 * @param	usid_to string 被请求人sid
	 * @param	usid_from string 请求人sid
	 * @param	bln_confirm boolean 是否批准
	 */
	static function RespondAddGroup($usid_to, $usid_from, $bln_confirm=true){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return false;
		}
		$bln_exsit = $db->SelectOne(MIMConfig::_table_mim_notice, array('USID'=>$usid_to, 'SCENE_ID'=>$usid_from, 'SCENE_TYPE'=>'2', 'STATUS'=>'0'), array('select'=>'SID'));
		if($bln_exsit === false) return false;		//不存在未处理提醒
		return $db->Update(
				MIMConfig::_table_mim_notice,
				array(
						'USID'=>$usid_to,
						'SCENE_ID'=>$usid_from,
						'SCENE_TYPE'=>'2'
				),
				array(
						'STATUS'=>'1'
				)
		);
	}
	
	/**
	 * 获取未读提醒
	 * @param	usid string 消息接收人
	 * @return	array
	 */
	static function GetUndone($usid){
		try {
			$db = GetDB();
		} catch (Exception $e) {
			return false;
		}
		$arrRet = array();
		$query_list = $db->Select(MIMConfig::_table_mim_notice, array('USID'=>$usid, 'STATUS'=>'0'));
		if($query_list){
			foreach($query_list as $query){
				$scene_type = $query['SCENE_TYPE'];
				$data = array('content'=>$query['CONTENT'], 'create_time'=>$query['CREATE_TIME'], 'scene_id'=>$query['SCENE_ID']);
				if(isset($arrRet[$scene_type])) array_push($arrRet[$scene_type], $data);
				else $arrRet[$scene_type][$scene_type] = $data;
			}
		}
		return $arrRet;
	}
}
?>