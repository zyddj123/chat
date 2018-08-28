<?php
/**
 * 断线处理类
 * @author B.I.T
 *
 */
class WebchatHandler implements A_Disconnet_Handler{
	
	/**
	 * 断线处理函数
	 * @see A_Disconnet_Handler::handler()
	 * @param	socket_id string 链接id
	 */
	public function handler($socket_id){
		$disconnect_usid = MIM_User::RecSocket($socket_id);		
		if($disconnect_usid === false) return false;
		try {
			$objUser = new MIM_User($disconnect_usid);
			if(count($objUser->getSocket())==0){
				//用户的连接不存在,认定下线
				A::RunLogic('2', '7', array('usid'=>$disconnect_usid, 'status'=>false));
				A::RunLogic('3', '8', array('usid'=>$disconnect_usid, 'status'=>false));
			}
		} catch (Exception $e) {
		}
		return true;
	}
}