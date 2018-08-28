<?php

namespace  Workerman\Protocols;

class BitProtocol{
	static $head_length=4;
	public static function input($buffer){
		if(strlen($buffer)<4){
			//不够包头信息,继续等待
			//return 0;
		}
		//通过包头获取完整数据包的长度
		$unpack_data=unpack('H*', $buffer);
		$msg_len=static::getDecFromHex(substr($unpack_data[1], 0, static::$head_length*2));
		if(strlen($buffer)<$msg_len){
			//不是一条完整的数据包
			return 0;
		}
		return $msg_len;
	}
	
	public static function encode($buffer){
		return $buffer;
	}
	
	public static function decode($buffer){
		return $buffer;
	}
	
	/**
	 * 根据16进制数据转化10进制数据
	 * @param	hex string 16进制字符串
	 * @return	int
	 */
	static function getDecFromHex($hex){
		//高地位反转
		$hex_reverse='';
		for ($i = strlen($hex)-1; $i > 0; $i-=2) {
			$hex_reverse.=$hex[$i-1].$hex[$i];
		}
		return hexdec($hex_reverse);
	}
}
?>