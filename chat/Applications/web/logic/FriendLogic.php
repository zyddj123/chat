<?php
/**
 * 好友逻辑
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

class FriendLogic extends Logic{
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
	 * 搜索好友
	 */
	public function friend_search(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$objUser = new MIM_User($this->_current_usid);
			$search = $this->_logic_data['search'];
			$list = array();
			if($search != '' ){
				$friends = $objUser->getFriends();
				foreach(MIM_User::SearchUser($search) as $objSearch){					//获取名称包含搜索关键字的用户
					if(count($friends)>0){
						foreach($friends as $objFriend){
							if($objFriend->sid != $objSearch->sid) array_push($list, MIM_Web_DTO::User_Simple($objSearch));		//过滤已经存在的好友
						}
					}else array_push($list, MIM_Web_DTO::User_Simple($objSearch));
				}
			}
			$this->setOutput($this->_retMessage(array('list' => $list)));
		} catch (Exception $e) {
			return false;						//用户会话非法,服务器忽略对其的反馈
		}
		return true;
	}
	
	/**
	 * 添加目标用户成为好友的请求
	 */
	public function friend_add_require(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
				
		try {
			$uid_target = $this->_logic_data['uid'];
			//if($uid_target == $this->_current_usid) return false;					//不能添加自己作为好友
			$objTarget = new MIM_User($uid_target);
			$objFrom = new MIM_User($this->_current_usid);
			//首先检测彼此是否已经是好友关系
			$undo_action = $objTarget->undoFriendAction($objFrom->sid);
			if(array_key_exists($objTarget->sid, $objFrom->getFriends()) || count($undo_action)>0) $this->setOutput($this->_retMessage(array('status'=>2, 'user'=>$uid_target)));			//目标用户已经是好友
			else{
				//创建请求
				$friend_action_id = $objFrom->friendAction($objTarget->sid, '1');
				//$this->setOutput($this->_retMessage(array('uid'=>$uid_target, 'status'=>1)));				//请求已发送
				if(count($objTarget->getSocket())>0){
					//目标好友在线,发送friend_add_response(m2a3)消息
					$this->setOutput(
							$this->_retMessage(array('user'=>MIM_Web_DTO::User_Simple($objFrom), 'faid'=>$friend_action_id)),
							array_keys($objTarget->getSocket()),
							'2',
							'3'
							);
				}
			}
		} catch (Exception $e) {
			$this->setOutput($this->_retMessage(array('status'=>0, 'user'=>$uid_target)));			//目标用户信息不存在
		}
		return true;
	}
	
	/**
	 * 处理好友请求,确认/拒绝
	 */
	public function friend_add_response(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$objUser = new MIM_User($this->_current_usid);
			$confirm = $this->_logic_data['confirm'];
			$objFrom = new MIM_User($this->_logic_data['uid']);
			if(!$objUser->friendAction($objFrom->sid, '1', $confirm?'1':'2')) return false;					//记录好友处理
			
			if($confirm && $objFrom->addFriend($objUser->sid)){
				//认证通过,添加好友
				$this->setOutput(
						$this->_retMessage(array('user'=>MIM_Web_DTO::User_Simple($objFrom), 'status'=>'1')),
						$this->getReqSocketId(),
						'2',
						'2'
						);				//向认证者推送发起人信息
				if(count($objFrom->getSocket())>0){
					//发起人在线,向发起人推送认证者信息
					$this->setOutput(
							$this->_retMessage(array('user'=>MIM_Web_DTO::User_Simple($objUser), 'status'=>'1')),
							array_keys($objFrom->getSocket()),
							'2',
							'2'
							);
				}
			}
		} catch (Exception $e) {
			return false;								//异常情况,服务器不输出
		}
		return true;
	}
	
	/**
	 * 获取当前用户的好友列表
	 */
	public function my_friend_list(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$arrRet = array();
			$objUser = new MIM_User($this->_current_usid);
			foreach($objUser->getFriends() as $objFriend){					//获取当前用户的好友
				array_push($arrRet, MIM_Web_DTO::User_Simple($objFriend));
			}
			$this->setOutput($this->_retMessage(array('list'=>$arrRet)));
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 获取好友详细信息
	 */
	public function my_friend_info(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$friend_usid = $this->_logic_data['uid'];
			$objFriend = new MIM_User($friend_usid);
			if(!array_key_exists($this->_current_usid, $objFriend->getFriends())) return false;					//非好友关系,不回应反馈
			$this->setOutput($this->_retMessage(array('user'=>MIM_Web_DTO::User_Complete($objFriend))));
		} catch (Exception $e) {
			return false;								//异常情况,服务器忽略输出
		}
		return true;
	}
	
	/**
	 * 删除好友关系
	 */
	public function friend_delete(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$friend_usid = $this->_logic_data['uid'];
			$type = $this->_logic_data['type'];						//删除模式, 0:一般删除 1:黑名单
			$objFriend = new MIM_User($friend_usid);
			$objUser = new MIM_User($this->_current_usid);
			if($objUser->delFriend($objFriend->sid)){
				if($type == '1'){
					//黑名单
				}
				$this->setOutput($this->_retMessage(array('uid'=>$friend_usid, 'type'=>$type)));
			}else{
				return false;
			}
		} catch (Exception $e) {
			return false;							//异常情况,服务器忽略输出
		}
		return true;
	}
	
	/**
	 * 好友状态
	 * 只在服务器推送,不需要校验会话
	 */
	public function friend_status(){
		$usid = $this->_logic_data['usid'];
		$status = $this->_logic_data['status'];
		try {
			$objUser = new MIM_User($usid);
			foreach($objUser->getFriends() as $objFriend){
				if(count($objFriend->getSocket())>0){
					//向在线好友发送上线/下线提醒
					$this->setOutput($this->_retMessage(array('uid'=>$objUser->sid, 'status'=>$status)), array_keys($objFriend->getSocket()));
				}
			}
		} catch (Exception $e) {
			return false;							//异常情况,服务器忽略输出
		}
		return true;
	}
	
}
?>