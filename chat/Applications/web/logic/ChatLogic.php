<?php
/**
 * 系统逻辑
 * @author B.I.T
 * 
 * $this->logic_param参数格式如下:
 * array(
 * 		'client' => <string>,
 * 		'version' => <string>,
 * 		'date_time' => <string>,
 * 		'token' => <string>,
 * 		'logic_data' => <mixed>
 * )
 * 
 * $this->setOutput()消息返回格式
 * array(
 * 		'client'=> <string>,
 * 		'version' => <string>,
 * 		'date_time' => <string>,
 * 		'error' => <string>,
 * 		'logic_data' => <mixed>
 * )
 */

@include_once APP_LIB_PATH.'/MIM_Web_Error.php';
@include_once APP_LIB_PATH.'/MIM_Web_DTO.php';

class ChatLogic extends Logic{
	static $PKey_version= '';					//版本key
	static $PKey_client_id = '';					//客户端key
	static $PKey_logic_data = '';				//逻辑数据key
	static $PKey_dt = '';							//时间戳key
	static $PKey_err = '';							//异常ke
	static $PKey_token = '';					//tokenkey
	
	protected $_logic_data;			//消息数据
	protected $_client_id;				//客户端id
	protected $_version;					//版本
	protected $_token_id;				//tokenid
	
	protected $_current_usid;				//当前会话用户sid
	protected $_current_uid;				//当前会话用户id

	/**
	 * 初始化
	 * @see Logic::_init()
	 * @return	boolean
	 *
	 */
	protected function _init(){
		$parser = $this->messageParser();						//消息解析器对象
		static::$PKey_version = $parser::$Version_Key;
		static::$PKey_client_id = $parser::$Client_Key;
		static::$PKey_logic_data = $parser::$Logic_Data_Key;
		static::$PKey_dt = $parser::$Logic_DT_Key;
		static::$PKey_err = $parser::$Logic_Error_Key;
		static::$PKey_token = $parser::$Token_key;
	
		$this->_logic_data = $this->logic_param[static::$PKey_logic_data];
		$this->_version = $this->logic_param[static::$PKey_version];
		$this->_client_id = $this->logic_param[static::$PKey_client_id];
		$this->_token_id = $this->logic_param[static::$PKey_token];
	
		return true;
	}
	
	/**
	 * 拼写错误消息回馈
	 * @param	error_code string 异常编码
	 * @return	array
	 */
	protected function _retError($error_code){
		return array(
				static::$PKey_client_id => $this->_client_id,
				static::$PKey_version => $this->_version,
				static::$PKey_dt => time(),
				static::$PKey_token => $this->_token_id,
				static::$PKey_logic_data => array(),
				static::$PKey_err => $error_code
		);
	}
	
	/**
	 * 拼写返回消息回馈
	 * @param	data mixed 消息内容
	 * @return	array
	 */
	protected function _retMessage($data){
		return array(
				static::$PKey_client_id => $this->_client_id,
				static::$PKey_version => $this->_version,
				static::$PKey_dt => time(),
				static::$PKey_token => $this->_token_id,
				static::$PKey_logic_data => $data,
				static::$PKey_err => ''
		);
	}
	
	/**
	 * 检测token会话是否有效
	 * @return	boolean
	 */
	protected function _checkToken(){
		if($this->_token_id == '') return false;
		$token_data = $this->token->read($this->_token_id);
		if($token_data == '') return false;
		$this->_current_uid = $token_data['uid'];
		$this->_current_usid = $token_data['usid'];
		return true;
	}
		
	/**
	 * 用户对话
	 */
	public function user_chat(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$usid_to = $this->_logic_data['uid'];
		$content = $this->_logic_data['content'];
		$content_type = $this->_logic_data['content_type'];
		if(is_null($content_type) || $content_type=='') $content_type = MIMConfig::_type_content_text;
		if($content_type != MIMConfig::_type_content_text) $content = json_encode($content);
		try {
			$objFrom = new MIM_User($this->_current_usid);
			$objTo = new MIM_User($usid_to);
			if(!array_key_exists($objFrom->sid, $objTo->getFriends())) return false;						//非好友
			$chat_id = MIM_Chat_Record::Add($objFrom->sid, $content, '3', $objTo->sid, $content_type);					//创建对话条目
			if($chat_id !== false){
				$chat_data = array(
						'from'=>$objFrom->sid,
						'to'=>$objTo->sid,
						'content'=>($content_type != MIMConfig::_type_content_text?json_decode($content, true):$content),
						'content_type'=>$content_type,
						'time'=>date('Y-m-d H:i:s'),
						'cid'=>$chat_id
						);
				$this->setOutput($this->_retMessage($chat_data));
				if(count($objTo->getSocket())>0){
					//对方在线
					$this->setOutput($this->_retMessage($chat_data), array_keys($objTo->getSocket()));
				}
			}else return false;
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 群组对话
	 */
	public function group_chat(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$group_id = $this->_logic_data['gid'];
		$content = $this->_logic_data['content'];
		$content_type = $this->_logic_data['content_type'];
		if(is_null($content_type) || $content_type=='') $content_type = MIMConfig::_type_content_text;
		if($content_type != MIMConfig::_type_content_text) $content = json_encode($content);
		
		if($group_id=='') return false;
		try {
			$objGroup = new MIM_Group($group_id);
			$objFrom = new MIM_User($this->_current_usid);
			if(!array_key_exists($objFrom->sid, $objGroup->getMembers())) return false;				//非组内成员
			$chat_id = MIM_Chat_Record::Add($objFrom->sid, $content, '2', $group_id, $content_type);					//创建对话条目
			if($chat_id !== false){
				$chat_data = array(
						'gid'=>$group_id,
						'uid'=>$objFrom->sid,
						'content'=>($content_type != MIMConfig::_type_content_text?json_decode($content, true):$content),
						'content_type'=>$content_type,
						'time'=>date('Y-m-d H:i:s'),
						'cid'=>$chat_id
						);
				foreach($objGroup->getMembers() as $objMember){
					if(count($objMember->getSocket())>0){
						$this->setOutput($this->_retMessage($chat_data), array_keys($objMember->getSocket()));
					}
				}
			}else return false;
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 获取提醒列表
	 * 只通过服务器推送,不用验证token
	 */
	public function notice_list(){
		$usid = $this->_logic_data['uid'];
		try {
			
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	public function notice_done(){
		
	}
	
	/**
	 * 获取所有未读消息
	 * 只包含私聊未读
	 * 只通过服务器推送,不用验证token
	 */
	public function all_unread_chat(){
		$usid = $this->_logic_data['usid'];
		try {
			$objUser = new MIM_User($usid);
			$unread_chat_list = MIM_Chat_Record::UnRead($objUser->sid);
			foreach($unread_chat_list as $unread_chat){
				$this->setOutput(					//输出用户聊天
						$this->_retMessage(array(
								'from'=>$unread_chat['from'],
								'to'=>$objUser->sid, 
								'content'=>($unread_chat['content_type'] == MIMConfig::_type_content_text)?$unread_chat['content']:json_decode($unread_chat['content'], true),
								'content_type' => $unread_chat['content_type'],
								'time'=>$unread_chat['time'],
								'cid'=>$unread_chat['cid']
						)),
						$this->getReqSocketId(),
						'4', '1');								
			}
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 消息标记已读
	 */
	public function chat_done(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		$cid_list = $this->_logic_data['list'];		
		MIM_Chat_Record::Read($cid_list);
		return false;				//不需要输出
	}
	
	
}
?>