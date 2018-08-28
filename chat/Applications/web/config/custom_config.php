<?php
/**
 * 应用个性化配置
 *
 * @package		comnide
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.17
 */

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * 本文件存放一些站点配置,但不适合作为系统常量存在的变量.
 * 原因是尽量减少系统运行中常驻内存中的常量数量和空间.
 * 如果需要获取配置,请使用_get_config('varname')来获取指定的站点配置
 * 
 * 站点配置方式如下,在数组$custom_system_configs中指定key值,并将其内容作为value值.
 * 例:$custom_system_configs['cfg_name']='cfg_value';
 * 
 * 站点配置获取方式.通过配置对象Config的get(cfg_name)方法即可获取
 * ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$custom_system_configs=array();

$custom_system_configs['message_type'] = 'Webchat';

$custom_system_configs['language'] = 'zh-cn';

$custom_system_configs['token_type'] = 'A_Socket_Token_To_File';
$custom_system_configs['token_save_path'] = APP_ROOT_PATH.'/'.SOCKET_TOKEN_SAVE_PATH_NAME;

$custom_system_configs['disconnect_handler'] = 'WebchatHandler';
?>
