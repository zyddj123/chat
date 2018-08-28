<?php
include_once str_replace("\\","/",realpath(dirname(__FILE__).'/../')).'/config/global_config.php';			//引入全局配置文件
include_once CORE_PATH.'/Core.php';						//核心Core类
include_once CORE_PATH.'/Message.php';				//消息Message类
include_once CORE_PATH.'/Logic.php';						//逻辑Logic类
include_once CORE_PATH.'/Config.php';					//配置Config类

use \GatewayWorker\Lib\Gateway;

spl_autoload_register("__autoload");			//注册自动加载autoload

class A{
	private static $_Instance = null;
	
	public $logicMap = null;				//逻辑映射配置
	protected $_messageParser = array();			//消息解析器
	protected $_disconnetHandler = array();			//链接断开处置对象
	protected $_db = array();				//数据库连接
	protected $_config = array();			//应用配置
	protected $_token = array();			//token配置
	
	/**
	 * 构造函数,单例模式
	 */
	private function __construct(){
		/*
		 * 加载逻辑Logic映射文件
		 */
		$logic_map_file = APP_CFG_PATH.'/logic_map.php';
		if(!file_exists($logic_map_file)) throw new A_Exception('', '');
		include_once $logic_map_file;
		$this->logicMap = $logic_map_config;
		unset($logic_map_config);
	}
	
	/**
	 * 获取实例对象
	 * 单例
	 */
	static public function GetInstance(){
		if(is_null(self::$_Instance)) {
			self::$_Instance = new self();
		}
		return self::$_Instance;
	}
	
	/**
	 * 获取数据库连接
	 * @param	db_config_name string 数据库连接配置名
	 * @return	mixed 数据库连接对象, 否则false
	 */
	public function GetDb($db_config_name='', $bln_reload=false){
		if($db_config_name=='') $db_config_name = 'default';
		if($bln_reload || !isset($this->_db[$db_config_name]) || !$this->_db[$db_config_name]){
			//重新加载
			$db_config = array();
			$db_config_file = APP_CFG_PATH.'/db_config.php';
			if(!file_exists($db_config_file)) return false;		//数据库配置文件不存在
			include APP_CFG_PATH.'/db_config.php';
			//加载类
			$db_api_class_file = $db_config[$db_config_name]['type'].'_api';
			$db_api_class = 'CO_DB_'.$db_config[$db_config_name]['type'].'_api';
			$db_api_file = realpath(__DIR__).'/db/'.$db_config[$db_config_name]['type'].'/'.$db_api_class_file.'.php';
			if(!file_exists($db_api_file)) return false;
			include_once $db_api_file;
			$objDb = new $db_api_class($db_config[$db_config_name]);
			//选择数据库实例
			$objDb->SelectDb($db_config[$db_config_name]['db_name']);
			//设置字符集
			$objDb->SetCharset($db_config[$db_config_name]['charset']);
			$this->_db[$db_config_name] = $objDb;
			unset($db_config);
		}
		return $this->_db[$db_config_name];
	}
	
	/**
	 * 监听接收消息字符
	 * 通过Message处理器解析出逻辑类型和方法
	 * 运行匹配的逻辑,并输出
	 * @param	message string 接收到的消息字符串
	 * @param	request_socket_id string 发送请求的socket连接id
	 * @return	mixed	逻辑输出数据数组,否则false
	 */
	function listen($message, $request_socket_id=''){
		$objMsgParser = $this->getMessageParser();					//获取消息处理器
		$unpacked_message_data = $objMsgParser->input($message);					//解析消息
		
		/*
		 * 从消息内解析出逻辑类型(mod_id)和逻辑方法(action_id)
		*/
		if(!isset($unpacked_message_data[Message::$Mod_Key]) || !isset($unpacked_message_data[Message::$Action_Key])) return false;
		$mod_id = $unpacked_message_data[Message::$Mod_Key];
		$action_id = $unpacked_message_data[Message::$Action_Key];
		
		return $this->_logic_run_and_output($mod_id, $action_id, $unpacked_message_data[Message::$Logic_Param_Key], $request_socket_id);
	}
	
	/**
	 * 获取应用配置
	 * @param	app_name string 应用名称
	 * @return	object Config对象
	 */
	function config($app_name){
		if($app_name == '') return false;					//必须指明应用id
		if(!isset($this->_config[$app_name]) || is_null($this->_config[$app_name])){
			//加载应用配置
			$custom_config_file = APP_ROOT_PATH.'/'.CFG_PATH_NAME.'/custom_config.php';			
			if(file_exists($custom_config_file)){
				include_once $custom_config_file;
				$this->_config[$app_name] = new Config($custom_system_configs);
				unset($custom_system_configs);
			}
		}
		return $this->_config[$app_name];
	}
	
	/**
	 * 运行逻辑并输出
	 * @param	mod_id string 逻辑类型id
	 * @param	action_id string 逻辑方法id
	 * @param	logic_param mixed 逻辑参数数据
	 * @param	request_socket_id string 请求socket连接的id
	 */
	protected function _logic_run_and_output($mod_id, $action_id, $logic_param, $request_socket_id=''){
		/*
		 * 根据逻辑类型(mod_id)和逻辑方法(action_id)匹配逻辑
		* 实例化逻辑对象
		* 运行逻辑,并输出
		*/
		$logic_config = $this->mapLogic($mod_id, $action_id);
		if($logic_config === false) return false;
		$logic_class_name = static::StrCamelize($logic_config['mod']).'Logic';
		$logic_file = APP_LOGIC_PATH.'/'.$logic_class_name.'.php';
		if(!file_exists($logic_file)) return false;
		include_once $logic_file;
		try {
			$arrRet = array();
			//实例化逻辑对象
			$objLogic = new $logic_class_name($mod_id, $logic_config['mod'], $action_id, $logic_config['action'], $logic_param);
			if($request_socket_id != '') $objLogic->setReqSocketId($request_socket_id);		//设置请求的socket连接id
			$bln_main_logic_bingo = $objLogic->doLogic();
			if($bln_main_logic_bingo !== false){
				foreach($objLogic->getOutput() as $output){
					array_push($arrRet, array(
							'socket_id' => $output['output_socket_id'],
							'message' => $this->getMessageParser()->output($output['output_mod'], $output['output_action'], $output['output_data'])
					));
				}
				//输出
				foreach ($arrRet as $output){
					static::Output($output['socket_id'], $output['message']);
				}
			}			
			//---------------获取后续需要运行的逻辑队列----------------
			if(count($objLogic->getSubsequentLogic())>0 && ($objLogic->subsequent_depend && $bln_main_logic_bingo || !$objLogic->subsequent_depend)){
				
				foreach($objLogic->getSubsequentLogic() as $logic_data){
					$this->_logic_run_and_output($logic_data[Message::$Mod_Key], $logic_data[Message::$Action_Key], $logic_data[Message::$Logic_Param_Key], $objLogic->getReqSocketId());
				}
			}				
			unset($objLogic);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * 获取消息解析器
	 * @param	app_name string 应用目录
	 * @param	message_type string 消息类型
	 * @return	object 消息解析器对象
	 */
	function getMessageParser($app_name='', $message_type=''){
		if($app_name=='') $app_name = APP_NAME;							//应用目录id
		if($message_type=='') $message_type = $this->config($app_name)->get('message_type');			//消息类型
		if(!isset($this->_messageParser[$app_name][$message_type]) || is_null($this->_messageParser[$app_name][$message_type])){
			$message_class_name = static::StrCamelize($message_type).'Message';				//消息类型类名
			$message_file = str_replace(APP_NAME, $app_name, APP_ROOT_PATH).'/'.CORE_PATH_NAME.'/'.$message_class_name.'.php';					//消息类文件名称
			if(file_exists($message_file)){
				include_once $message_file;
				$this->_messageParser[$app_name][$message_type] = new $message_class_name();
			}
		}
		return $this->_messageParser[$app_name][$message_type];
	}
	
	/**
	 * 获取token
	 */
	function getToken($app_name=''){
		if($app_name=='') $app_name = APP_NAME;
		if(is_null($this->_token[$app_name])){
			$token_class_name = $this->config($app_name)->get('token_type');
			if ($token_class_name != ''){
				$token_expiry_time = $this->config($app_name)->get('token_expiry_time');
				$this->_token[$app_name] = new $token_class_name(is_numeric($token_expiry_time)?$token_expiry_time:0);
				$token_save_path = $this->config($app_name)->get('token_save_path');
				if($token_save_path != '') $this->_token[$app_name]->setPath($token_save_path);
			}
		}
		return $this->_token[$app_name];
	}
		
	/**
	 * 将一个以下划线分隔的单词字符串更改为骆驼拼写法
	 * @param	str string 输入字符串
	 * @param	upper_case boolean 大驼峰还是小驼峰
	 * @return	string 转化后的字符串
	 */
	static function StrCamelize($str, $upper_case = true) {
		$str = strtolower ( $str );
		$arr = explode ( '_', $str );
		$arr = array_map ( "ucfirst", $arr );
		$new_str = implode ( '', $arr );
		return $upper_case ? $new_str : lcfirst ( $new_str );
	}
	
	/**
	 * 根据逻辑Logic的类型id(mod_id)和方法id(action_id)获取逻辑配置
	 * @param	mod_id string 逻辑类型id
	 * @param	action_id string 逻辑方法id
	 * @return	mixed 逻辑配置数组,否则false
	 */
	function mapLogic($mod_id, $action_id){
		if($mod_id=='') return false;
		$arrRet = array();
		if(isset($this->logicMap[$mod_id])){
			$arrRet['mod'] = $this->logicMap[$mod_id]['name'];
			$arrRet['action'] = $this->logicMap[$mod_id]['action'][$action_id]['name'];
		}else{
			return false;
		}
		if(!isset($this->logicMap[$mod_id]['action'][$action_id])) return false;
		foreach($this->logicMap[$mod_id]['action'][$action_id] as $key => $val){
			if($key != 'name') $arrRet[$key] = $val;
		}
		return $arrRet;
	}
	
	/**
	 * 运行逻辑
	 */
	static function RunLogic($mod_id, $action_id, $param, $request_socket_id=''){
		$object = static::GetInstance();
		$parser = $object->getMessageParser();
		return $object->_logic_run_and_output($mod_id, $action_id, $parser::MakeMessage($mod_id, $action_id, $param), $request_socket_id);
	}
	
	/**
	 * 调用workerman的网关Gateway发送消息
	 * @param	output_socket_id mixed 输出的socket连接id,可能是string也可能是array
	 * @param	ouput_data mixed 输出的内容
	 */
	static function Output($output_socket_id, $ouput_data){
		if(is_array($output_socket_id)){
			foreach($output_socket_id as $socket_id){
				Gateway::sendToClient($socket_id, $ouput_data);
			}
		}else Gateway::sendToClient($output_socket_id, $ouput_data);
	}
	
	/**
	 * 获取服务器断开时的处理类
	 */
	function disconnectHandler($app_name=''){
		if($app_name=='') $app_name = APP_NAME;							//应用目录id
		$handler = $this->config($app_name)->get('disconnect_handler');			//类配置
		if(!isset($this->_disconnetHandler[$app_name][$handler]) || is_null($this->_disconnetHandler[$app_name][$handler])){
			$class_name = $handler;				//类名
			$file = str_replace(APP_NAME, $app_name, APP_ROOT_PATH).'/'.CORE_PATH_NAME.'/'.$class_name.'.php';					//类文件名称
			if(file_exists($file)){
				include_once $file;
				$this->_disconnetHandler[$app_name][$handler] = new $class_name();
			}
		}
		return $this->_disconnetHandler[$app_name][$handler];
	}
}

class A_Exception extends Exception{
	
}

interface  A_Socket_Token_Interface{
	public function read($token_id);

	public function write($token_id, $value);

	public function destroy($token_id);
}

interface A_Disconnet_Handler{
	public function handler($socket_id);
}

class test{
	
}
?>