<?php
//非法访问
if (!defined('BASECHECK')){
	header("HTTP/1.1 404 Not Found");
	header("Status: 404 Not Found");
	exit;
}

/**
 * 聊天相关控制器
 *
 * @package		MOA
 * @author			B.I.T
 * @copyright		Copyright (c) 2013 - 2016.
 * @license
 * @link
 * @since				Version 1.1
 *
 */

class ChatController extends Controller{
	protected $_has_MOO =  false;				//是否有MOO组件
	protected $_index_model=null;
	protected $_moo_session = null;				//MOO会话
	protected $_moa_session = null;				//MOA会话
	/**
	 * 初始化
	 */
	protected function _init(){
		if($this->plugins->HasPlugin('MOO')){
			$this->session = new MOO_SESSION();
		}else $this->session = new MOA_SESSION();
		
		$this->_moa_session = new MOA_SESSION();
		if($this->_has_MOO){
			$this->_moo_session = new MOO_SESSION();
			$this->_moo_session->login_check(APP_URL_ROOT.'/login');					//校验登录会话
		}else{
			$this->_moa_session->login_check(APP_URL_ROOT.'/login');					//校验登录会话
		}
		
		$this->_index_model = $this->GetModel('Index');
	}
	
	/**
	 * 默认入口
	 */
	function run(){
		
	}
	
	/**
	 * 粘贴图片
	 */
	function paste_image(){
		//参数
		$dirId=$this->input->post('fid');
		if(is_null($dirId) || $dirId=='') $dirId='0';    //默认根目录
		
		$input = $this->input->post('img');
		if(is_null($input) || $input == ''){
			echo json_encode(false);
			return false;
		}
		@include_once LIB_PATH.'/MF/MF_Image.php';    //引入文件
		$separator_b = ';base64,';
		$separator_a = 'data:image/';
		$arrRet=array();
		foreach($input as $in){
			if(strpos($in, $separator_b)===false){
				continue;
			}
			$img_code_64 = substr($in, strpos($in, $separator_b)+strlen($separator_b));
			$suffix = substr($in, strlen($separator_a), strpos($in, $separator_b)-strlen($separator_a));
			$image_file_name = rand(0, 999).'.'.$suffix;
			$image_file_path = CACHE_PATH.'/'.$image_file_name;
			file_put_contents($image_file_path, base64_decode($img_code_64));
			$media = $this->_MFAddFile(
					$dirId,
					$image_file_path,
					$image_file_name,
					false,
					$suffix
					);
			if($media) array_push($arrRet, $media);
			@unlink($image_file_path);
		}
		if(count($arrRet)<=0){
			echo json_encode(false);
		}else echo json_encode($arrRet);
		return true;
	}
	
	/**
	 * 上传文件
	 */
	function upload_file(){
		//参数
		$dirId=$this->input->get('fid');
		if(is_null($dirId) || $dirId=='') $dirId='0';    //默认根目录
		
		//文件
		$upload=$_FILES['mim_upload_file'];
		$arrRet=array();
		foreach($upload['name'] as $key => $name){
			//遍历上传文件
			$upload['type'][$key];
			$upload['tmp_name'][$key];
			$upload['error'][$key];
			$upload['size'][$key];
	
			$media=$this->_MFAddFile(
					$dirId,
					$upload['tmp_name'][$key],
					$name,
					true,
					$upload['type'][$key]
			);
			if($media) array_push($arrRet, $media);
		}
		if(count($arrRet)<=0){
			echo json_encode(false);
		}else echo json_encode($arrRet);
		return true;
	}
	
	function del_file(){
		$id=$this->input->post('id');
		if(is_null($id) || $id==''){
			echo json_encode(false);
			return false;
		}
		$objFile = new MF_File($id);
		echo json_encode($objFile->remove());
		return true;
	}
	
	/**
	 * 聊天文件转存
	 */
	function dump_file(){
		$file_sid = $this->input->post('sid');
		if($file_sid==''){
			echo json_encode(false);
			return false;
		}
		try {
			$objFile = new MF_File($file_sid);
			$file = MFConfig::_root_path.'/'.$objFile->getResources();
			$file_name =  $objFile->title;
			$type = $objFile->type;
			
			$bln_image = false;
			if (MF_Utils::IsImage($file_name)){
				//图片
				$objFile = MF_Image::Add($file, $file_name, $this->session->uid, false, $type);
				$bln_image = true;
			}else{
				//其它文件
				$objFile = MF_File::Add($file, $file_name, $this->session->uid, false, $type);
			}
			//移动文件至目标目录
			$objFile->move(new MF_Person_Dir('0', $this->session->uid));
			if($objFile->sid){
				echo json_encode(true);
			}else{
				echo json_encode(false);
			}
		} catch (Exception $e) {
			echo json_encode(false);
			return false;
		}
		return true;
	}
	
	/**
	 * 使用MF组件添加文件至当前人资源目录
	 * @return	mixed;
	 */
	protected function _MFAddFile($path_id, $file, $file_name, $bln_update, $type){
		if($path_id=='' || $file=='' || $file_name=='' || $type=='') return false;
		try {
			$bln_image = false;
			if (MF_Utils::IsImage($file_name)){
				//图片
				$objFile = MF_Image::Add($file, $file_name, $this->session->uid, $bln_update, $type);
				$bln_image = true;
			}else{
				//其它文件
				$objFile = MF_File::Add($file, $file_name, $this->session->uid, $bln_update , $type);
			}
			//移动文件至目标目录
			$objFile->move(new MF_Person_Dir($path_id, $this->session->uid));
			$arrRet = array(
					'fid'=>$objFile->fid,
					'sid'=>$objFile->sid,
					'type'=>$objFile->type,
					'filter'=>MF_Utils::GetFileType($objFile->title),
					'destription'=>$objFile->destription,
					'name'=>$objFile->title,
					'size'=>$objFile->size,
					'create_time'=>$objFile->create_time,
					'suffix'=>$objFile->suffix,
					//'src'=>MFConfig::_root_host.'/'.$objFile->getResources()
					'src'=>'http://192.168.1.189'.HTTP_ROOT_PATH.'/'.$objFile->getResources()
			);
			if($bln_image){
				$arrRet['width'] = $objFile->width; 
				
				$arrRet['height'] = $objFile->height;
			}
		} catch (Exception $e) {
			return array();
		}
		return $arrRet;
	}
	
	/**
	 * MF_MIM_file_dump() 聊天文件转存
	 * @param  $file_id string 文件SID
	 * @return boolean
	 */
	function MF_MIM_file_dump($file_id){
		if($file_id=='') return false;
		try{
			$objFile = new MF_File($file_id);
			$file = MFConfig::_root_path.'/'.$objFile->getResources();
			$file_name =  $objFile->title;
			$objMOAUser = new MOA_User($this->_moa_session->uid);
			$uid =$objMOAUser->uid;
			$type = $objFile->type;
	
			$bln_image = false;
			if (MF_Utils::IsImage($file_name)){
				//图片
				$objFile = MF_Image::Add($file, $file_name, $uid, false, $type);
				$bln_image = true;
			}else{
				//其它文件
				$objFile = MF_File::Add($file, $file_name, $uid, false, $type);
			}
			//移动文件至目标目录
			$objFile->move(new MF_Person_Dir('0', $uid));
			if($objFile->sid){
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){
		}
	}
	
	function chatlog(){
		$uid = $this->input->get('uid');
		$group_id = $this->input->get('group');
		if($uid!=''){
			$objUser = new MIM_User($uid);
		}else{
			$objGroup = new MIM_Group($group_id);
		}
		$this->Render('appchat/chatlog',array('uid'=>$objUser->uid,'sid'=>$objUser->sid,'group_id'=>$objGroup->sid));
	}
	
	function ajaxChatlog(){
		$usid_to = $this->input->post('usid');
		$group_id = $this->input->post('group_id');
		$date_begin = $this->input->post('date_begin');
		$date_end = $this->input->post('date_end');
		$p = $this->input->post('p');
		if($p-1==0){
			$previous_page=1;
		}else{
			$previous_page=$p-1;
		}
		
		if($usid_to!=''){
			$objMIM_user=MIM_User::GetInstanceByUID($this->_moa_session->uid);
			$data = $objMIM_user->getChatLog($usid_to,20,$date_begin,$date_end,$p);
		}else if($group_id!=''){
			$objGroup = new MIM_Group($group_id);
			$data = $objGroup->getChatLog(20,$date_begin,$date_end,$p);
		}else{
			echo json_encode(false);exit();
		}
		
		if($data){
			if($usid_to!=''){
				foreach ($data as $key=>$val){
					$objFromuser = new MIM_User($val['from']);
					$data[$key]['from_img']=$objFromuser->img;
					$data[$key]['from_name']=$objFromuser->name;
					$objTouser = new MIM_User($val['to']);
					$data[$key]['to_img']=$objTouser->img;
					$data[$key]['to_name']=$objTouser->name;
					unset($objFromuser);
					unset($objTouser);
				}
			}
			if($group_id!=''){
				foreach($data as $key=>$val){
					$objFromuser = new MIM_User($val['from_usid']);
					$data[$key]['from_name']=$objFromuser->name;
					$data[$key]['from_img']=$objFromuser->img;
					$data[$key]['from']=$val['from_user'];
					unset($objFromuser);
				}
			}
		}
		$result=array();
		$result['data'] = $data;
		$result['previous_page']=$previous_page;
		if(!$data){
			$result['next_page']=$p;
		}else{
			$result['next_page']=$p+1;
		}
		echo json_encode($result);
	}
	
	function download_file(){
		$file_url = $this->input->get('url');
		$url_array = explode("/", $file_url);
		$file = end($url_array);
		header('Content-type: application/x-msdownload');
		header('Content-Disposition: attchament; filename='.$file);
		readfile($file_url);
		exit();
	}
}
?>