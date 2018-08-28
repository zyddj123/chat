<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * MOA会话Session控制类
 *
 * @package
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 */

class MOA_SESSION_HANDLER extends Session_Handler_To_DB{
	//会话生命周期
	protected $_lifetime='7200';
	
	//session table
	protected $_table='T_MOA_SESSION';
}
?>