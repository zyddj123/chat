<?php
/**
 * 遍历目录中符合条件的文件列表
 *
 * @param  string $match 正则匹配条件（包括前后的'/'，必须带有至少一组括号以作为结果集索引）
 * @param  string $path  路径（由于匹配时使用绝对路径，如果索引需要相对路径的话可以在$path后加'/'，然后匹配'//'后面的字符，参见@example）
 * @return array         {file_index:file_absolute_path, ...}
 *
 * @example __listfile( '/\/\/(.+\.(?:css|js))$/', '/static/' )    {'dir/a.js':'/static/dir/a.js', 'b.css':'/static/b.css'}
 */
function __listfile($match, $path){
	$list=array();
	foreach(glob($path.'/*')as $item){
		if(is_dir($item)){
			$list+=__listfile($match,$item);
		}elseif(preg_match($match,$item,$matches)){
			$list[$matches[1]]=$item;
		}
	}
	return $list;
}

/**
 * 自动加载(__autoload)
 * 自动加载范围是外围根目录的lib,core
 * @param	classname string,需要加载的类名
 * @return
 */
function __autoload($classname) {
	static $lib_file_list = null;
	// 初始化库文件列表
	if ($lib_file_list === null) {
		$cache_file = CACHE_PATH . '/autoload_classes.json';
		if (file_exists ( $cache_file )) {
			// 库文件列表存在,从缓存文件载入
			$lib_file_list = @json_decode ( file_get_contents ( $cache_file ), true );
		}else{
			// 缓存文件不存在,重新生成,并且载入
			$match = '/\/([A-Z]\w*)\.php$/';
			$lib_file_list = __listfile ( $match, LIB_PATH ) + __listfile ( $match, CORE_PATH);
			//排除当前文件(Core.php)
			unset ( $lib_file_list ['Core'] );
			//并且将当前结果缓存到文件中
			file_put_contents ( $cache_file, json_encode ( $lib_file_list ) );
		}
	}
	// 只允许从库文件列表中加载
	if (isset ( $lib_file_list [$classname] )) {
		require_once $lib_file_list [$classname];
	}
}

/**
 * 获取数据库连接
 * @param	db_name string 数据库连接配置
 * @return	object 数据库连接对象
 */
function GetDb($db_name=''){
	return $a = A::GetInstance()->GetDb($db_name);
}

/**
 * 创建目录
 * @param	dir string 目录
 */
function createDir($dir){
	if(!file_exists($dir)){
		createDir(dirname($dir));
		mkdir($dir,0777);
	}
}
?>;