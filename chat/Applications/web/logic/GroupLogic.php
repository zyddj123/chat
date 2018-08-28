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

class GroupLogic extends Logic{
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
	 * 搜索群组
	 */
	public function group_search(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$search = $this->_logic_data['search'];
		try {
			$list = array();
			if($search!=''){
				foreach(MIM_Group::SearchGroup($search) as $objGroup){
					array_push($list, MIM_Web_DTO::Group_Simple($objGroup));
				}
			}
			$this->setOutput($this->_retMessage(array('list'=>$list)));
		} catch (Exception $e) {
			return false;							//发生异常,服务器忽略反馈
		}
		return true;
	}
	
	/**
	 * 申请进入群组的请求
	 */
	public function group_add_require(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$group_id = $this->_logic_data['gid'];
		if($group_id == '') return false;				//群组id非法
		try {
			$objUser = new MIM_User($this->_current_usid);
			$objGroup = new MIM_Group($group_id);
			if($objGroup->max <= count($objGroup->getMembers())) $this->setOutput($this->_retMessage(array('status'=>3, 'group'=>MIM_Web_DTO::Group_Simple($objGroup))));			//群组已满
			elseif(array_key_exists($objUser->sid, $objGroup->getMembers())) $this->setOutput($this->_retMessage(array('status'=>2, 'group'=>MIM_Web_DTO::Group_Simple($objGroup))));		//已经是成员,不能重复添加
			else{
				//创建待批准请求
				$group_action_id = $objGroup->group_action('1', '', $objUser->sid, '0');
				//$this->setOutput($this->_retMessage(array('gid'=>$group_id, 'status'=>1)));					//请求已发送
				if(!is_null($objGroup->getAdmin()) && count($objGroup->getAdmin()->getSocket())>0){
					//群组管理员在线,向其发送认证请求
					$this->setOutput(
							$this->_retMessage(array('group'=>MIM_Web_DTO::Group_Simple($objGroup), 'user'=>MIM_Web_DTO::User_Simple($objUser), 'gaid'=>$group_action_id)),
							array_keys($objGroup->getAdmin()->getSocket()),
							'3',
							'3'
							);
				}
			}
			
		} catch (Exception $e) {
			$this->setOutput($this->_retMessage(array('status'=>0, 'group'=>MIM_Web_DTO::Group_Simple($objGroup))));
		}
		return true;
	}
	
	/**
	 * 处理进入群组的请求
	 */
	public function group_add_response(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$group_id = $this->_logic_data['gid'];
		$usid_from = $this->_logic_data['uid'];
		$confirm = $this->_logic_data['confirm'];
		if($group_id=='' || $usid_from=='') return false;
		if($confirm =='') $confirm = false;
		try {
			$objGroup = new MIM_Group($group_id);
			$objUserFrom = new MIM_User($usid_from);
			$objAdmin = $objGroup->getAdmin();
			if(is_null($objAdmin)) return false;				//群无管理员
			if($this->_current_usid != $objAdmin->sid) return false;				//非管理员则无操作权限
			$objGroup->group_action('1', $objAdmin->sid, $usid_from, $confirm?'1':'2');					//记录操作
			if($confirm && $objGroup->addMember($objUserFrom->sid)){
				//批准
				foreach($objGroup->getMembers() as $objMember){
					//向群组内在线成员发送申请人信息
					if($objMember->sid !=$objUserFrom->sid && count($objMember->getSocket())>0)		//需剔除刚加进来的用户
						$this->setOutput(
								$this->_retMessage(array('status'=>'1', 'group'=>MIM_Web_DTO::Group_Simple($objGroup), 'user'=>MIM_Web_DTO::User_Simple($objUserFrom))),
								array_keys($objMember->getSocket()),
								'3',
								'2');
				}
				if(count($objUserFrom->getSocket())>0)
					//申请在线情况下,向其发送群组信息
					$this->setOutput(
							$this->_retMessage(array('status'=>'1', 'group'=>MIM_Web_DTO::Group_Simple($objGroup), 'user'=>MIM_Web_DTO::User_Simple($objUserFrom))),
							array_keys($objUserFrom->getSocket()),
							'3',
							'2');
			}
		} catch (Exception $e) {
			return false;							//发生异常,服务器忽略反馈
		}
		return true;
	}
	
	/**
	 * 我的群组列表
	 */
	public function my_group_list(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		try {
			$list = array();
			$objUser = new MIM_User($this->_current_usid);
			foreach($objUser->getGroups() as $objGroup){
				array_push($list, MIM_Web_DTO::Group_Simple($objGroup));
			}
			$this->setOutput($this->_retMessage(array('list'=>$list)));
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 群组详情
	 */
	public function my_group_info(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$group_id = $this->_logic_data['gid'];
		if($group_id=='') return false;
		try {
			$objGroup = new MIM_Group($group_id);
			$this->setOutput($this->_retMessage(array('group'=>MIM_Web_DTO::Group_Complex($objGroup))));
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 退出群组
	 */
	public function group_quit(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$group_id = $this->_logic_data['gid'];
		if($group_id=='') return false;
		try {
			$objGroup = new MIM_Group($group_id);
			$objUser = new MIM_User($this->_current_usid);
			if(!array_key_exists($objUser->sid, array_keys($objGroup->getMembers()))) return false;					//非群组内部用户
			if($objGroup->removeMember($objUser->sid) && $objGroup->group_action('0', $objUser->sid, $objUser->sid, '1')){
				$this->setOutput($this->_retMessage(array('gid'=>$group_id, 'uid'=>$objUser->sid)));
				foreach($objGroup->getMembers() as $objMember){
					if(count($objMember->getSocket())>0){
						//向群组内在线成员发送消息
						$this->setOutput($this->_retMessage(array('gid'=>$group_id, 'uid'=>$objUser->sid)), array_keys($objMember->getSocket()));
					}
				}
			}else return false;
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 解散群组
	 */
	public function group_disband(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$group_id = $this->_logic_data['gid'];
		if($group_id=='') return false;
		try {
			$objGroup = new MIM_Group($group_id);
			$objUser = new MIM_User($this->_current_usid);
			if(is_null($objGroup->getAdmin()) || $objGroup->getAdmin()->sid != $objUser->sid) return false;			//非管理员无权限
			$member_list = $objGroup->getMembers();
			if($objGroup->removeMember() && $objGroup->del()){
				foreach($member_list as $objMember){
					if(count($objMember->getSocket())>0){
						//向群组内在线成员发送消息
						$this->setOutput($this->_retMessage(array('gid'=>$group_id)), array_keys($objMember->getSocket()));
					}
				}
			}else return false;
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 群组成员状态,上线或下线
	 * 只通过服务器推送,不需要校验token
	 */
	public function group_member_status(){
		$usid = $this->_logic_data['usid'];
		$status = $this->_logic_data['status'];
		
		try {
			$objUser = new MIM_User($usid);
			foreach($objUser->getGroups() as $objGroup){
				foreach($objGroup->getMembers() as $objMember){
					if($objMember->sid != $usid && count($objMember->getSocket())>0){
						//向群组内在线成员发送消息
						$this->setOutput($this->_retMessage(array('gid'=>$objGroup->sid, 'uid'=>$objUser->sid, 'status'=>$status)), array_keys($objMember->getSocket()));
					}
				}
			}
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
	
	/**
	 * 创建群组
	 */
	public function group_create(){
		if($this->_checkToken() === false) return false;			//服务器忽略非法token请求,对其不输出反馈
		
		$group_name = $this->_logic_data['group_name'];
		$group_content = $this->_logic_data['group_content'];
		$max_count = $this->_logic_data['max_count'];
		$member = $this->_logic_data['member'];
		
		if($group_name=='') return false;
		if($max_count=='') $max_count=0;
		try {
			$objUser = new MIM_User($this->_current_usid);
			$objGroup = MIM_Group::Add(array('name'=>$group_name, 'max'=>$max_count, 'creator'=>$objUser->sid));
			if(is_null($objGroup)) return false;
			$objGroup->setAdmin($objUser->sid);						//设置管理员
			if(is_array($member)){
				$objGroup->setMembers($member);			//添加成员
			}
			//向所有在线的群组成员推送群组信息
			foreach($objGroup->getMembers() as $objMember){
				$socket_ids = $objMember->getSocket();
				if(count($socket_ids)>0){
					$this->setOutput($this->_retMessage(MIM_Web_DTO::Group_Complex($objGroup)), array_keys($socket_ids), $this->mod_id, $this->action_id);
				}
			}
		} catch (Exception $e) {
			return false;
		}
		return true;
	}
}
?>