<?php
class Config{
	protected $_var = null;
	
	function __construct($var){
		$this->_var = $var;
	}
	
	function get($key=''){
		if($key=='') return $this->_var;
		else{
			if(!isset($this->_var[$key])) return null;
			else return $this->_var[$key];
		}
	}
	
	
	function set($key, $val){
		if(isset($this->_var[$key])) $this->_var[$key] = $val;
		return $this;
	}
}