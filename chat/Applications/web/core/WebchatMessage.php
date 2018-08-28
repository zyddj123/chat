<?php
/**
 * 浏览器版消息解析器
 * 数据格式是json字符串
 * 消息格式如下:
 * {'v':'', 'c':'', 'dt':'', 't':'', 'm':{'m':'', 'a':'', 'd':''}, 'e':''}
 * |-- v=version 消息版本
 * |-- c=client_id 客户端设备id 
 * |-- dt=date_time 消息时间.客户端发送服务器时是客户端时间,服务器发送给客户端时是服务器时间.秒级时间戳
 * |-- t=token 会话id
 * |-- m=message 消息内容
 * |---- m=mod 逻辑id
 * |---- a=action 逻辑方法id
 * |---- d=data 逻辑参数
 * |---- e=error 错误号e与m一般情况下不会同时存在.只在服务器输出(server-output)是有效.
 * 
 * @author B.I.T
 *
 */
class WebchatMessage extends Message{
	
	static $Version = '1.0.0';
	
	static $Version_Key = 'version';
	static $Client_Key = 'client';
	static $Logic_Data_Key = 'logic_data';
	static $Logic_DT_Key = 'date_time';
	static $Logic_Error_Key = 'error';
	static $Token_key = 'token';
		
	/**
	 * 解码函数
	 * @see Message::unpack_message()
	 * @param	packed_message string json格式字符串
	 * @return	array
	 */
	function unpack_message($packed_message){
		$data = json_decode($packed_message, true);
		return array(
				static::$Mod_Key => $data['m']['m'],
				static::$Action_Key => $data['m']['a'],
				static::$Logic_Param_Key => array(
						static::$Client_Key => $data['c'],
						static::$Version_Key => $data['v'],
						static::$Logic_DT_Key => $data['dt'],
						static::$Token_key => $data['t'],
						static::$Logic_Data_Key => $data['m']['d']
						)
				);
	}
	
	/**
	 * 加密函数
	 * @param	mod_id string mod
	 * @param	action_id string action
	 * @param	logic_param array 逻辑参数数据
	 * @see Message::pack_message()
	 */
	function pack_message($mod_id, $action_id, $logic_param){
		return json_encode(array(
				'v' => $logic_param[static::$Version_Key],
				'c' => $logic_param[static::$Client_Key],
				'dt' => $logic_param[static::$Logic_DT_Key],
				'm' => array(
						'm' => $mod_id,
						'a' => $action_id,
						'd' => $logic_param[static::$Logic_Data_Key],
						'e' => $logic_param[static::$Logic_Error_Key]
						)
				));
	}
	
	static function MakeMessage($mod, $action, $data){
		return array(
				static::$Client_Key => '',
				static::$Version_Key => static::$Version,
				static::$Logic_DT_Key => time(),
				static::$Token_key => '',
				static::$Logic_Data_Key => $data
				);
	}
}
?>