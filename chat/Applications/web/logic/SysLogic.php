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

class SysLogic extends Logic{
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
	 * 用户登录
	 */
	public function login(){
		$uid = $this->_logic_data['uid'];					//用户id
		$password = $this->_logic_data['password'];				//登录密码
		if($uid=='' || $password==''){
			//用户名或密码为空
			$this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_LOGIN_FAILURE));
		}else{
			try {
				$status = MIM_User::CheckUserPwd($uid, $password);
				if($status != 1) {
					//登录失败
					$this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_LOGIN_FAILURE));
				}else{
					//登录成功
					try {
						$objUser = MIM_User::GetInstanceByUID($uid);
						//生成用户token并存储在服务器上
						$new_token_id = $objUser->getTokenId();
						$this->token->write($new_token_id, $objUser->makeTokenValue());
						$this->_login_success($objUser, $new_token_id);
					} catch (Exception $e) {}
				}
			} catch (Exception $e) {
				$this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_LOGIN_FAILURE));
			}
		}
		
		return true;
	}
	
	/**
	 * 登录成功后的操作
	 * @param	objUser object 用户对象
	 * @param	token_id string 会话id
	 * @return	boolean
	 */
	protected function _login_success($objUser, $token_id){
		$bln_first_login = true;				//是否第一次登录
		$objUser->addSocket($this->getReqSocketId(), '0', '1');				//创建场景socket
		if(count($objUser->getSocket())>0){
			//已经在其他设备上登录
			$bln_first_login = false;
		}
		$this->setOutput($this->_retMessage(
				array(
						'token' => $token_id,
						'user' => MIM_Web_DTO::User_Complete($objUser)
						)
				),
				$this->getReqSocketId(),
				'1',
				'1'
				);
		//if($bln_first_login){}
		return true;
	}
	
	/**
	 * 用户注销
	 * 多窗口多场景统一注销
	 */
	public function logout(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$objUser = new MIM_User($this->_current_usid);
			$this->token->destroy($this->_token_id);					//销毁token会话
			foreach ($objUser->getSocket() as $socket_id => $socket){
				//遍历当前用户所有在线连接,依次发送注销成功的消息
				$this->setOutput(
						$this->_retMessage(array('status' => true)),
						$socket_id
						);
			}
			$objUser->delSocket();					//注销当前用户所有在线的场景
			//向当前用户所有在线好友发送下线提醒
			$this->setSubsequentLogic('2', '7', $this->_retMessage(array('usid'=>$objUser->sid, 'status'=>false)));
			//向当前用户所在群组发送下线提醒
			$this->setSubsequentLogic('3', '8', $this->_retMessage(array('usid'=>$objUser->sid, 'status'=>true)));
		} catch (Exception $e) {
			$this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_INVALID));					//用户无效
		}
		return true;
	}
	
	/**
	 * 修改个人信息
	 */
	public function user_info_modify(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		try {
			$objUser = new MIM_User($this->_current_usid);
			$name = $this->_logic_data['name'];
			$birthday = $this->_logic_data['birthday'];
			$sex = $this->_logic_data['sex'];
			$content = $this->_logic_data['content'];
			$phone = $this->_logic_data['phone'];
			$mail = $this->_logic_data['mail'];
			$avatar = $this->_logic_data['avatar'];
			
			$update = array();
			if(isset($this->_logic_data['name']) && $this->_logic_data['name']!='') $update['name'] = $this->_logic_data['name'];
			if(isset($this->_logic_data['birthday']) && $this->_logic_data['birthday']!='') $update['birthday'] = $this->_logic_data['birthday'];
			if(isset($this->_logic_data['sex']) && $this->_logic_data['sex']!='') $update['sex'] = $this->_logic_data['sex'];
			if(isset($this->_logic_data['content'])) $update['content'] = $this->_logic_data['content'];
			if(isset($this->_logic_data['phone'])) $update['phone'] = $this->_logic_data['phone'];
			if(isset($this->_logic_data['mail'])) $update['email'] = $this->_logic_data['mail'];
			if(isset($this->_logic_data['avatar']) && $this->_logic_data['avatar']!='') $update['img'] = $this->_logic_data['avatar'];
			if($objUser->update($update) === false) $this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_INVALID));					//更新失败,数据有问题
			else{
				$this->setOutput($this->_retMessage(array('user'=>MIM_Web_DTO::User_Complete($objUser))));
			}
		} catch (Exception $e) {
			$this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_INVALID));					//用户无效
		}
		return true;
	}
	
	/**
	 * 修改个人密码
	 */
	public function user_password_modify(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$objUser = new MIM_User($this->_current_usid);
			$new_password = $this->_logic_data['password'];
			if($new_password != '' && $objUser->update(array('password'=>$objUser->Encrypt($new_password)))){
				$this->setOutput($this->_retMessage(array('status'=>true)));						//密码修改成功
			}else $this->setOutput($this->_retMessage(array('status'=>false)));					//密码修改失败
		} catch (Exception $e) {
			$this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_INVALID));					//用户无效
		}
		return true;
	}
	
	/**
	 * 客户端初始化加载完毕
	 */
	public function index_ready(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$objUser = new MIM_User($this->_current_usid);
			$this->subsequent_depend = false;						//主逻辑返回false不影响后续逻辑调用
			if(count($objUser->getSocket())==1){
				//首次登录,推送消息
				$this->setSubsequentLogic('2', '7', $this->_retMessage(array('usid'=>$objUser->sid, 'status'=>true)));				//好友上线提醒
				$this->setSubsequentLogic('3', '8', $this->_retMessage(array('usid'=>$objUser->sid, 'status'=>true)));				//群组成员上线提醒
			}
			$this->setSubsequentLogic('2', '4', $this->_retMessage(array()));				//获取好友列表
			$this->setSubsequentLogic('3', '4', $this->_retMessage(array()));				//获取群组列表
			
			//获取未处理的好友请求
			foreach($objUser->undoFriendAction() as $undo){
				try {
					$objFrom = new MIM_User($undo['from']);
					$this->setOutput($this->_retMessage(
							array('user'=>MIM_Web_DTO::User_Simple($objFrom), 'faid'=>$undo['sid'])),
							$this->getReqSocketId(),
							'2',
							'3'
							);
				} catch (Exception $e) {}
			}
			
			//获取未处理的群组请求
			foreach($objUser->getGroups() as $objGroup){
				if($objGroup->getAdmin()->sid == $objUser->sid){			//群组管理员
					foreach(MIM_Group::UndoGroupAction($objGroup->sid) as $undo){			//未处理群组请求
						try {
							$objFrom = new MIM_User($undo['from']);
							$this->setOutput($this->_retMessage(
									array('group'=>MIM_Web_DTO::Group_Simple($objGroup), 'user'=>MIM_Web_DTO::User_Simple($objFrom), 'gaid'=>$undo['sid'])),
									$this->getReqSocketId(),
									'3',
									'3'
							);
						} catch (Exception $e) {}
					}
				}
			}
			
			$this->setSubsequentLogic('4', '11', $this->_retMessage(array('usid'=>$objUser->sid)));				//获取当前用户所有未读消息
		} catch (Exception $e) {}
		return true;
	}
	
	/**
	 * 切换场景
	 */
	public function switch_scene(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$objUser = new MIM_User($this->_current_usid);
			$scene_id = $this->_logic_data['scene_id'];
			$scene_type = $this->_logic_data['scene_type'];
			$mode = !isset($this->_logic_data['mode'])?true:$this->_logic_data['mode'];
			
			if($mode){
				//开启场景
				$status = $objUser->addSocket($this->getReqSocketId(), $scene_type, $scene_id);
			}else{
				//关闭场景
				$status = $objUser->delScene($scene_type, $scene_id);
			}
			if($status) $this->setOutput($this->_retMessage(array('scene_type'=>$scene_type, 'scene_id'=>$scene_id, 'status'=>true)));				//切换成功
			else  $this->setOutput($this->_retMessage(array('scene_type'=>$scene_type, 'scene_id'=>$scene_id, 'status'=>false)));					//切换失败
		} catch (Exception $e) {
			$this->setOutput($this->_retError(MIM_Web_Error::ERR_USER_INVALID));			//用户无效
		}
		return true;
	}
	
	/**
	 * 通过token登录
	 */
	public function login_by_token(){
		$this->_token_id = $this->_logic_data['token'];
		if(!$this->_checkToken()){
			return false;
		}
		try {
			$objUser = new MIM_User($this->_current_usid);
			$this->_login_success($objUser, $this->_token_id);
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
}
?>