<?php
/**
 * token存储在文件系统中
 * @author B.I.T
 *
 */
class A_Socket_Token_To_File implements A_Socket_Token_Interface{
	
	protected $_save_path = SOCKET_TOKEN_SAVE_PATH;					//默认存储目录
	protected $_token_active = true;								//开启状态,默认开启
	static  $Token_File_Suffix = 'sose';							//文件扩展名
	protected $_expiry_time = 0;									//超时时间,默认不会超时(socket连接只要存在,就不会超时)
	
	function __construct($expiry_time=0){
		$this->_expiry_time = $expiry_time;			//超时时间
	}
	
	protected function _getFile($token_id){
		if(!file_exists($this->_save_path)) createDir($this->_save_path);
		return $this->_save_path.'/'.$token_id.'.'.static::$Token_File_Suffix;
	}
		
	protected function _isExpired($token_id){
		$token_file = $this->_getFile($token_id);
		if($this->_expiry_time != 0){
			$file_state = stat($token_file);
			$file_last_modify = $file_state['mtime'];				//文件最近的修改时间
			if(($file_last_modify + $this->_expiry_time) < time()){
				//访问超时
				return true;
			}
		}
		return false;
	}
	
	public function read($token_id){
		if($this->_token_active !== true) return null;					//未开启会话
		$token_file = $this->_getFile($token_id);
		if(!file_exists($token_file)) return null;
		if($this->_isExpired($token_file)) return null;				//超时
		$token_content = file_get_contents($token_file);
		if($token_content == '') return null;
		else return unserialize($token_content);
	}
	
	public function write($token_id, $value){
		if($this->_token_active !== true) return false;					//未开启会话
		$token_file = $this->_getFile($token_id);
		if($this->_isExpired($token_id)) return false;				//超时
		file_put_contents($token_file, serialize($value));
	}
	
	public function destroy($token_id){
		if($this->_token_active !== true) return false;					//未开启会话
		$token_file = $this->_getFile($token_id);
		if($this->_isExpired($token_id)) return false;				//超时
		@unlink($token_file);
	}
	
	public function setPath($save_path){
		$this->_save_path = $save_path;
		return $this;
	}
	
	static function CreateToken($params){
		return md5($params);
	}
}
?>