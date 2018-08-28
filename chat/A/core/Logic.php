<?php
/**
 * socket逻辑
 */

//-------------------------------------------------------------

abstract class Logic{
	public $mod_id;													//逻辑类型id
	protected $_mod_name;										//逻辑类型名称
	public $action_id;													//逻辑方法id
	protected $_action_name;									//逻辑方法名称
	public $logic_param;											//逻辑参数
	
	protected $_no_output=false;									//服务器是否对逻辑进行输出,默认需要输出
	protected $_input_socket_id = '';								//逻辑输入的socket连接id
	public $language = array();								//语言包
	public $token = null;										//token加载器 
	
	protected $_subsequent_logic_queue = array();				//后续需要运行的逻辑队列
	public $subsequent_depend = false;		//后续逻辑是否运行取决于主逻辑运行成功,默认不需要
		
	/**
	 * 服务器对逻辑进行输出的相关变量
	 * 输出内容可能是多个,所以变量格式为数组Array
	 */
	protected $_output_mod=array();							//输出类型,数组
	protected $_output_action=array();							//输出方法,数组
	protected $_output_data=array();							//输出数据,数组
	protected $_output_socket_id=array();						//输出的目标socket连接id,数组
	
	/**
	 * 根据逻辑id获取对应的逻辑类和方法
	 * @param	mod_id string 逻辑类编号
	 * @param	action_id string 逻辑方法编号
	 * @return	mixed 对应的逻辑类名和方法名 array('mod'=>'', 'act'=>''),否则false
	 */
	static function MapLogic($mod_id, $action_id=''){
		if($mod_id=='') return false;
		if(isset(LogicMap::$map[$mod_id])){
			$mod=LogicMap::$map[$mod_id]['name'];
			$act=LogicMap::$map[$mod_id]['action'][$action_id]['name'];
		}else{
			return false;
		}
		return array('mod'=>$mod, 'act'=>$act);
	}
	
	/**
	 * 获取消息解析器对象
	 */
	function messageParser(){
		return A::GetInstance()->getMessageParser(APP_NAME);
	}
	
	/**
	 * 构造函数
	 * @param	mod_id string 逻辑类型
	 * @param	mod_name string 逻辑类型名称
	 * @param	action_id string 逻辑方法
	 * @param	action_name string 逻辑方法名称
	 * @param	unpacked_message_from_parser mixed 从消息解析器获取的解码消息
	 */
	function __construct($mod_id,	$mod_name, $action_id, $action_name, $unpacked_message_from_parser){
		$this->mod_id=$mod_id;
		$this->_mod_name = $mod_name;
		$this->action_id=$action_id;
		$this->_action_name = $action_name;
		if(!is_array($unpacked_message_from_parser)){
			//使用json_decode转化
			$this->logic_param = json_decode($unpacked_message_from_parser, true);
		}else $this->logic_param = $unpacked_message_from_parser;
		
		/**
		 * token加载器
		 */
		$this->token = A::GetInstance()->getToken(APP_NAME);
		
		$this->_init();			//初始化
	}

	/**
	 * 逻辑输出化
	 * @return	boolean 是否成功
	 */
	protected function _init(){
		return true;
	}
	
	/**
	 * 设置请求socket连接id
	 * @param	socket_id string socket连接id
	 */
	function setReqSocketId($socket_id){
		$this->_input_socket_id = $socket_id;
	}
	
	/**
	 * 获取请求socket连接id
	 * @return	string 连接id
	 */
	function getReqSocketId(){
		return $this->_input_socket_id;
	}
	
	/**
	 * 设置是否需要服务器返回
	 * @param	blnNoOutput boolean 此逻辑运行完毕后服务器是否需要不发送回馈,默认true
	 */
	function setNoResp($blnNoOutput=true){
		$this->_no_output=$blnNoOutput;
		return $this;
	}
	
	/**
	 * 设置逻辑输出
	 * @param	output_data mixed 输出数组
	 * @param	output_socket_id array 输出目的socket连接id列表
	 * @param	output_mod_id string 输出逻辑类型
	 * @param	output_action_id string 输出逻辑方法
	 * @return	boolean 是否设置成功
	 */
	public function setOutput($output_data, $output_socket_id=array(), $output_mod_id='', $output_action_id=''){
		if($this->_no_output) return false;				//不需要输出
		if(count($output_socket_id)==0){
			if($this->_input_socket_id=='') return false;				//输出socket空
			else $output_socket_id = $this->_input_socket_id;
		}
		if($output_mod_id == '') $output_mod_id = $this->mod_id;
		if($output_action_id == '') $output_action_id = $this->action_id;
		/*
		 * 添加输出参数
		 */
		array_push($this->_output_socket_id, $output_socket_id);
		array_push($this->_output_mod, $output_mod_id);
		array_push($this->_output_action, $output_action_id);
		array_push($this->_output_data, $output_data);
		return true;
	}
	
	/**
	 * 设置当前逻辑运行完成,后续还要触发的逻辑
	 * @param	logic_param_list array 逻辑参数
	 */
	public function setSubsequentLogic($mod_id, $action_id, $logic_param){
		array_push($this->_subsequent_logic_queue, array(
				Message::$Mod_Key => $mod_id,
				Message::$Action_Key => $action_id,
				Message::$Logic_Param_Key => $logic_param
				));
		return true;
	}
	
	public function getSubsequentLogic(){
		return $this->_subsequent_logic_queue;
	}
	
	/**
	 * 获取逻辑输出
	 * @return	mixed 数据数组 
	 */
	function getOutput(){
		$arrRet = array();
		if($this->_no_output) return $arrRet;			//不需要输出
		foreach($this->_output_socket_id as $key => $socket_id){
			array_push($arrRet, array(
					'output_socket_id' => $socket_id,
					'output_mod' => $this->_output_mod[$key],
					'output_action' => $this->_output_action[$key],
					'output_data' => $this->_output_data[$key]
					));
		}
		return $arrRet;
	}
	
	/**
	 * 运行逻辑,并返回结果
	 * @return	boolean 是否运行成功
	 */
	function doLogic(){
		if(!method_exists($this, $this->_action_name)) return false;			//函数不存在
		$action_name = $this->_action_name;
		$logic_action_value = $this->$action_name($this->logic_param);		//逻辑函数运行结果
		if(!is_null($logic_action_value) && $logic_action_value !== false){
			//逻辑运行成功
			return true;
		}else{
			//逻辑运行失败
			return false;
		}
	}
	
	/**
	 * 获取应用配置
	 * custom_config配置文件中的配置
	 * @return	mixed
	 */
	public function config(){
		return A::GetInstance()->config(APP_NAME);
	}
	
	/**
	 * 加载语言包
	 * @param	language_mod string 语言包模块
	 * @return	this
	 */
	public function getLang($language_mod){
		if($language_mod!=''){
			$language_file_name = $language_mod.'_lang.php';
			$language_file = APP_LANG_PATH.'/'.$this->config()->get('language').'/'.$language_file_name;
			if(file_exists($language_file)){
				include $language_file;
				//过滤html可运行脚本
    			$lang_filter=array();
		    	foreach ($lang as $key => $_lang){
		    		@$lang_filter[$key]=htmlspecialchars($_lang);
		    	}
		    	$this->language=array_merge($this->language, $lang_filter);
		    	unset($lang_filter);
		    	unset($lang);
			}
		}
		return $this;		
	}
}
?>