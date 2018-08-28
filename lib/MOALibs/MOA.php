<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

@include_once 'MOAConfig.inc.php';
//--------------------------------------------------------------------------
class MOA{
	
	/**
	 * 获取配置信息
	 * @param	cfg_name string 配置名称
	 * @return	string 
	 */
	static function config($cfg_name=''){
		if($cfg_name=='') return '';
		$commentconfig=new ReflectionClass('MOAConfig');
		return $commentconfig->getConstant($cfg_name);
	}	
	
	/**
	 *获取权限
	 *@param	name string 权限分类
	 *@return		array 权限id数组
	 */
	static function action($name=''){
		if($name=='') return '';
		$config=new ReflectionClass('MOAConfig');
		$action=$config->getStaticPropertyValue('action');
		return $action[$name];
	}
}
?>