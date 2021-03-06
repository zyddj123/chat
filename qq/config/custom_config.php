<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}
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
 * 一般情况下,在控制器(controller)中使用$this->config->get('cfg_name')获取
 * ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$custom_system_configs=array();

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * 应用单元默认语言设置['language']
 * 语言包文件载入根据当前视图语言设置而定,系统默认语言设置为"zh-cn"。
 * 系统语言设置配置存放于每个应用单元的config目录下的system_config.php文件中。
 * 修改上述文件内配置$custom_system_configs['language']的值，并使其与您的语言包缩写对应即可启用。
 * 如：$custom_system_configs['language']='zh-cn'表示当前应用单元的语言包设置为"简体中文"。
 *
 * 本文件中的语言设置一般用于视图(view)或控制器(controller)中
 * 系统载入时并不会将所有语言设置下的语言包一次性加载，而是通过根据需要手动加载.具体引入及使用方法如下：
 * 1.在控制器(controller)中加载需要的语言包。例如:$controller->get_lang('standard');
 * 2.使用时，通过控制器对象的language方法即可访问。例如:$controller->language['hello_text'];
 *	
 * 使用建议：
 * 1.尽量根据功能模块划分语言设置文件，这样可以根据应用场景按需加载,避免导致不必要的开销。
 * 2.每个语言文件内的配置采用$lang数组的方式保存。在为每个语言设置分配key时，一定避免key重复.建议可以为相同功能模块划分内的所有语言设置增加功能缩写前缀。
 * 3.加载语言设置文件可以放在每个controller的初始化函数(_init)内。
 * ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$custom_system_configs['language'] = 'zh-cn';

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * 应用单元默认主题设置['themes']
 * 应用单元主题配置存放于每个应用单元的config目录下的system_config.php文件中
 * 修改上述文件内配置$custom_system_configs['themes']的值，并使其与您的主题文件根目录名一致即可启用
 * 如：$custom_system_configs['themes']='default'表示当前应用单元的主题设置使用'default'
 *
 * 主题目录主要影像应用单元内的视图部分。用户可以针对一个视图(view)定制多个主题.达到不同展现的目的。
 * 假设某应用单元内有两种用户类型A和B。两种用户在进行同一个操作时，操作页面需要不同。这时可以通过为其定制不同的用户主题来实现。
 *	
 * 使用建议:
 * 1.主题概念的引入是为了解决同一个操作功能点能够拥有不同展现的问题。所以各主题间的区别只存在于视图(view)层面上，如页面html，css，js等有所不同。
 * 而构造这些页面所需要的数据均来自于相同的控制器(controller)和模型(model)。
 * 2.可以在每个控制器(controller)的初始化函数(_init)内指定使用的主题。$controller->setThemes(themes_name);
 * ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$custom_system_configs['themes'] = 'default';

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------
 * 应用单元会话session设置
 * 此部分包含3个配置项，分别是
 * 是否开启会话['session_start']。'0'表示不开启，'1'表示开启。
 * 自定义会话存取类['session_custom']。此配置填写自定义session处理类名。
 * 会话有效时间['session_lifetime']。此配置填写会话session的有效时长，单位是秒(second)。
 * 
 * 只有开启会话(session_start='1')，后两个配置才会生效。
 * 
 * 使用建议：
 * 最常见的session定制方法，就是将session信息保存至数据库中。用户可按照如下思路实现：
 * 1.开启session。设定session_start＝'1'。
 * 2.创建session自定义处理类并实现。
 * 		a).新建php文件session_handler并保存在应用单元的lib目录中。
 * 		b).编写class session_handler并实现系统接口SessionHandlerInterface。实现接口中的open，close，read，write，destory，gc方法
 * 		c).修改自定义会话存取类配置session_lifetime值为session_handler。
 * ------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
$custom_system_configs['session_start'] = '1';
$custom_system_configs['session_custom'] = 'MOA_SESSION_HANDLER';
$custom_system_configs['session_lifetime'] = '';
