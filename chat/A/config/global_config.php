<?php
/**
 * 框架配置
 *
 * @package		comnide
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.17
 */

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * 框架配置
 * ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
//错误报告方式
error_reporting(E_ALL ^ E_NOTICE);

//是否将错误信息作为输出的一部分显示到屏幕，或者对用户隐藏而不显示。生产环境建议不开启
ini_set('display_errors','On');

//设置是否将脚本运行的错误信息记录到服务器错误日志或者error_log之中。生产环境建议开启
ini_set('log_errors','Off');

//网站根目录绝对路径(ROOT_PATH)
define('ROOT_PATH', str_replace("\\","/",realpath(dirname(__FILE__).'/../../')));

//系统根目录
define('SYS_ROOT_PATH', str_replace("\\","/",realpath(dirname(__FILE__).'/../')));

//系统日志目录
define('LOG_PATH_NAME', 'log');
define('LOG_PATH', SYS_ROOT_PATH."/".LOG_PATH_NAME);

//核心代码目录
define('CORE_PATH_NAME', 'core');
define('CORE_PATH', SYS_ROOT_PATH.'/'.CORE_PATH_NAME);

//lib目录
define('LIB_PATH_NAME', 'lib');
define('LIB_PATH', SYS_ROOT_PATH.'/'.LIB_PATH_NAME);

//常量及配置目录
define('CFG_PATH_NAME', 'config');
define('CFG_PATH', SYS_ROOT_PATH.'/'.CFG_PATH_NAME);

//会话Token存储目录
define('SOCKET_TOKEN_SAVE_PATH_NAME', 'token');
define('SOCKET_TOKEN_SAVE_PATH', SYS_ROOT_PATH.'/'.SOCKET_TOKEN_SAVE_PATH_NAME);

//逻辑目录
define('LOGIC_PATH_NAME', 'logic');

//语言包目录
define('LANG_PATH_NAME', 'language');

//缓存目录
define('CACHE_PATH', SYS_ROOT_PATH."/cache");

//设置时区
date_default_timezone_set('Asia/Shanghai');

//当前时间戳
define('NOW_TIMESTAMP', time());

//系统默认语言
define('LANG_DEFAULT', 'zh-cn');
?>