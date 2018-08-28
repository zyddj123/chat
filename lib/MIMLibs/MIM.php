<?php
/**
 * MIM类
 * 即时通讯基础类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.0
 */

@include_once 'MIMConfig.inc.php';
//--------------------------------------------------------------------------
class MIM{
	
	/**
	 * 获取配置信息
	 * @param	cfg_name string 配置名称
	 * @return	string 
	 */
	static function config($cfg_name=''){
		if($cfg_name=='') return '';
		$commentconfig=new ReflectionClass('MIMConfig');
		return $commentconfig->getConstant($cfg_name);
	}	
	
	/**
	 *获取权限
	 *@param	name string 权限分类
	 *@return		array 权限id数组
	 */
	static function action($name=''){
		if($name=='') return '';
		$config=new ReflectionClass('MIMConfig');
		$action=$config->getStaticPropertyValue('action');
		return $action[$name];
	}
}
?>