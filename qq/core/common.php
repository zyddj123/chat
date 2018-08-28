<?php
/**
 * 应用公共函数文件
 * 
 * @package		comnide
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2015.
 * @license			
 * @link				
 * @since				Version 1.15
 */

// ------------------------------------------------------------------------

/**
 * 配合前台jquery datatable组件使用
 * @param	post_info string datatable组件post数据
 */
function getDataTable($post_info=array()){
	//每页显示条目数
	$countPerPage	= $post_info['iDisplayLength'];
	//数据起始条目数
	$startNum = $post_info['iDisplayStart'];
	//当前请求页码。$startNum从0开始，计算时候需要+1
	$startNum=intval($startNum)+1;
	if($startNum <= $countPerPage) $currentpage=1;
	else @$currentpage=($startNum-($startNum % $countPerPage))/$countPerPage+1;
	//列配置个数
	$colLen = $post_info['iColumns'];
	//将列依次放入$columns数组
	$colunms = array();
	for ($i = 0; $i < $colLen; $i++) {
		$colunms[$i]=$post_info['mDataProp_'.$i];
	}
	//去除空元素
	$colunms=array_filter($colunms);
	//搜索内容
	$search = $post_info['sSearch'];
	//-----获取搜索字段-----
	$col_search=array();
	foreach ($colunms as $key=>$val){
		if($post_info['bSearchable_'.$key]=='true'){
			array_push($col_search, $val);
		}
	}
	//排序方式
	$sortType = $post_info['sSortDir_0'];
	//-----获取排序字段-----
	$col_sort=array();
	foreach ($colunms as $key=>$val){
		if($post_info['bSortable_'.$key]=='true'){
			array_push($col_sort, $val);
		}
	}
	if(count($col_sort)>0) $sortField =$colunms[$post_info['iSortCol_0']];
	else $sortField="";
	//排序
	$where_sort="";
	if($sortField!="") $where_sort='`'.$sortField."` ".$sortType." ";

	return array(
			"cpp"=>$countPerPage,
			"start"=>$startNum,
			"current"=>$currentpage,
			"column"=>$colunms,
			"sortfield"=>$sortField,
			"sorttype"=>$sortType,
			"search"=>$search,
			"searchfield"=>$col_search,
			"order"=>$where_sort
	);
}

/**
 * 将包含[]的字符串拆分成数组
 * @param	string string 要拆分的字符串
 * @param	delimiter string 分隔符
 * @return	array 返回数组
 * @example 字符串[a],[b],[c],[d]拆分成数组array(a,b,c,d)
 */
function m_split($string, $delimiter=","){
	$retArray=array();
	if($string=="") return $retArray;
	foreach (explode($delimiter, $string) as $val){
		$val=str_replace('[', '', $val);
		$val=str_replace(']', '', $val);
		array_push($retArray, $val);
	}
	return $retArray;
}

/**
 * 将数组合并成包含[]的字符串
 * @param	array array 要合并的数组
 * @param	glue string 分隔符
 * @return	string 返回字符串
 * @example 数组array(a,b,c,d)合并成字符串[a],[b],[c],[d]
 */
function m_join($array, $glue=","){
	if($array==""|| !is_array($array) || count($array)==0) return "";
	$newArr=array();
	foreach ($array as $val){
		if($val!="") array_push($newArr, '['.$val.']');
	}
	return implode($glue, $newArr);
}

/**
 * upload_img() 图片上传
 * @param string $path 上传路径
 * @param string $file_name 上传图片原始名称
 * @param string $file_size		上传图片大小
 * @param string $file_tmp    上传图片临时路径
 * @param string $post_id     上传图片原所属的ID
 * @param string $post_name 上传图片原所属名称
 * @return string $pics 图片名称 false上传失败
 */
function upload_img($path,$file_name,$file_size,$file_tmp,$post_id="",$post_name="",$max_size=""){
	$img_name='';
	if($max_size==''){
		$max=ini_get("post_max_size")*1024000;
	}else{
		$max=$max_size*1024000;
	}
	
	if($post_id!=''){
		$img_name=$post_name;
	}
	$suffix= strtolower(strstr($file_name, '.'));
	if($suffix!='.gif'&&$suffix!='.jpg'&&$suffix!='.jpeg'&&$suffix!='.png'&&$suffix!='.bmp')
	{
		return false;    //图片格式错误
		exit();
	}
	if($file_size>$max){
		return false;  //图片超过上传最大值
		exit();
	}
	$upload_path=UPLOAD_PATH.'/'.$path;		//布局图片上传路径
	if(!file_exists($upload_path))
	{
		createDir($upload_path,0755);
	}
	
	$rand = rand(100, 999);	//随机数
	if($img_name!=''){
		$pics = $img_name;
	}else{
		$pics = date("YmdHis") . $rand .$suffix;
	}
	$pic_path=$upload_path.'/'.$pics;
	$upload=move_uploaded_file($file_tmp, $pic_path);
	if($upload){
		return $pics;
	}else{
		return false;  //上传失败
		exit();
	}
}


/**
 * 文件上传
 * @param string $path 上传路径
 * @param string $file_name 上传文件原始名称
 * @param string $file_size 上传文件大小
 * @param string $file_tmp 上传文件临时路径
 * @param string $post_name 上传文件原所属名称
 * @param string $max_size 上传文件最大大小限制
 * @param string $format 格式限制 true 限制 false 不限制
 */
function upload_file($path,$file_name,$file_size,$file_tmp,$post_name="",$max_size="",$format=false){
	$img_name='';
	if($max_size==''){
		$max=ini_get("post_max_size")*1024000;
	}else{
		$max=$max_size*1024000;
	}

	if($post_name!=''){
		$img_name=$post_name;
	}
	$suffix= strtolower(strstr($file_name, '.'));
	if($format){
		if($suffix!='.gif'&&$suffix!='.jpg'&&$suffix!='.jpeg'&&$suffix!='.png'&&$suffix!='.bmp')
		{
			return false;    //格式错误
			exit();
		}
	}
	if($file_size>$max){
		return false;  //文件超过上传最大值
		exit();
	}
	if(!file_exists($path))
	{
		createDir($path,0755);
	}

	$rand = rand(100, 999);	//随机数
	if($img_name!=''){
		$pics = $img_name.$suffix;
	}else{
		$pics = date("YmdHis") . $rand .$suffix;
	}
	$pic_path=$path.'/'.$pics;
	$upload=move_uploaded_file($file_tmp, $pic_path);
	if($upload){
		return $pics;
	}else{
		return false;  //上传失败
		exit();
	}
}

/**
 * deleteDir()删除非空目录
 * @param  $dirPath string
 * @throws InvalidArgumentException
 */
function deleteDir($dirPath) {
	if (! is_dir($dirPath)) {
		return false;
	}
	if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
		$dirPath .= '/';
	}
	$files = glob($dirPath . '*', GLOB_MARK);
	foreach ($files as $file) {
		if (is_dir($file)) {
			deleteDir($file);
		} else {
			unlink($file);
		}
	}
	rmdir($dirPath);
}

/**
 * delDir_cache()情况cache文件夹下的所有文件
 */
function delDir_cache()
{
	$dh=opendir(CACHE_PATH);
	while ($file=readdir($dh)){
		if($file!="." && $file!=".."){
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				delDir_cache($fullpath);
			}
		}
	}
	closedir($dh);
}
/**
 * delDir()依次删除文件夹下的素有文件
 * @param unknown_type $dir
 */
function delDir($dir){
	//先删除目录下的文件：
	if(!is_dir($dir)){
		return true;exit();
	}
	$dh=opendir($dir);
	while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				deldir($fullpath);
			}
		}
	}
	closedir($dh);
	//删除当前文件夹：
	if(rmdir($dir)) {
		return true;
	} else {
		return false;
	}
}
/**
 * createDir()依次创建文件夹
 * @param  $dir string
 */
function createDir($dir){
	if(!file_exists($dir)){
		createDir(dirname($dir));
		mkdir($dir,0777);
	}
}

/**
 * prDates()获取两日期间的所有日期
 * @param  $start string 起始日期
 * @param  $end string 结束日期
 */
function prDates($start,$end){
	$dt_start = strtotime($start);
	$dt_end  = strtotime($end);
	$date = array();
	do{
		$date[] = date('Y-m-d',$dt_start).PHP_EOL;
	}while (($dt_start += 86400) <= $dt_end);
	return $date;
}
?>
