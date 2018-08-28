<?php

abstract class Message{
	
	public $bln_logging_input = false;							//是否记录输入日志
	public $bln_logging_output = false;							//是否记录输出日志
	
	static $Mod_Key = 'mod';
	static $Action_Key = 'action';
	static $Logic_Param_Key = 'logic_param';
	
	/**
	 * 将未转化的原始数据转化为逻辑Logic可以理解的数据
	 * 需要从中解析出逻辑类型(mod_id)和逻辑方法(action_id)
	 * @param	packed_message mixed 未处理的消息内容
	 * @return	mixed 解析后的消息内容
	 */
	function input($packed_message){
		return $this->unpack_message($packed_message);
	}
	
	/**
	 * 向客户端发送数据
	 * @param	output_socket_ids array 目标输出的socket连接id
	 * @param	mod_id string 逻辑类型id
	 * @param	action_id string 逻辑方法id
	 * @param	logic_param mixed 输出逻辑参数数据
	 * @return	array 返回需要输出的数据和目标连接id
	 */
	function output($mod_id, $action_id, $logic_param){
		return $this->pack_message($mod_id, $action_id, $logic_param);
	}
	
	/**
	 * 加密消息
	 * @param	mod_id string 逻辑类型id
	 * @param	action_id string 逻辑方法id
	 * @param	logic_param mixed 未处理消息
	 * @return	mixed 已经处理的消息
	 */
	function pack_message($mod_id, $action_id, $logic_param){
		return $logic_param;
	}
	
	/**
	 * 解析消息
	 * @param	packed_message mixed 为解析消息
	 * @return	mixed 已解析消息
	 */
	function unpack_message($packed_message){
		return $packed_message;
	}
	
	/**
	 * 记录输入
	 */
	static function LoggingIn(){
	}
	
	/**
	 * 记录输出
	 */
	static function LoggingOut(){
	}
	
}
?>