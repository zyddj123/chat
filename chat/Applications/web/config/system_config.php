<?php
$basepath=str_replace("\\","/",realpath(dirname(__FILE__).'/../'));
$basename=substr($basepath, strrpos($basepath, '/')+1, strlen($basepath));
define('APP_ROOT_PATH', $basepath);
define('APP_LOGIC_PATH', APP_ROOT_PATH.'/'.LOGIC_PATH_NAME);
define('APP_CORE_PATH', APP_ROOT_PATH.'/'.CORE_PATH_NAME);
define('APP_LIB_PATH', APP_ROOT_PATH.'/'.LIB_PATH_NAME);
define('APP_LOG_PATH', APP_ROOT_PATH.'/'.LOG_PATH_NAME);
define('APP_CFG_PATH', APP_ROOT_PATH.'/'.CFG_PATH_NAME);
define('APP_LANG_PATH', APP_ROOT_PATH.'/'.LANG_PATH_NAME);
define('APP_NAME', $basename);
unset($basename);
unset($basepath);
?>
