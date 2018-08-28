<?php
/**
 * web版聊天数据结构体
 * @author B.I.T
 *
 */
class MIM_Web_DTO{
	static function User_Simple($objMIMUser){
		return array(
				'sid' => $objMIMUser->sid,
				'id' => $objMIMUser->uid,
				'name' => $objMIMUser->name,
				'sex' => $objMIMUser->sex,
				'avatar' => $objMIMUser->getHeadImg(),
				'status' => count($objMIMUser->getSocket())>0?true:false
				);
	}
	
	static function User_Complete($objMIMUser){
		return array(
				'sid' => $objMIMUser->sid,
				'id' => $objMIMUser->uid,
				'name' => $objMIMUser->name,
				'sex' => $objMIMUser->sex,
				'avatar' => $objMIMUser->getHeadImg(),
				'age' => intval(date('Y')) - intval(date('Y', strtotime($objMIMUser->birthday))),
				'phone' => $objMIMUser->phone,
				'email' => $objMIMUser->email,
				'content' => $objMIMUser->content,
				'status' => count($objMIMUser->getSocket())>0?true:false
				);
	}
	
	static function Group_Simple($objGroup){
		return array(
				'id' => $objGroup->sid,
				'name' => $objGroup->name,
				'member_count' => count($objGroup->getMembers()),
				'content' => '',
				'admin' => $objGroup->getAdmin()->sid
				);
	}
	static function Group_Complex($objGroup){
		$member_list = array();
		foreach($objGroup->getMembers() as $objMember){
			array_push($member_list, static::User_Simple($objMember));
		}
		return array(
				'id' => $objGroup->sid,
				'name' => $objGroup->name,
				'content' => '',
				'admin' => $objGroup->getAdmin()->sid,
				'user_list' => $member_list
				);
	}
}
?>