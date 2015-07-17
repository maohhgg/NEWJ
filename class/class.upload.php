<?php

	class upload{

		protected $fileType = array("txt","csv","htm","html","xml", 
     	"css","doc","xls","rtf","ppt","pdf","swf","flv","avi", 
    	"wmv","mov","jpg","jpeg","gif","png");
		protected $fileSize = 2;
		public $errno = 0;
		protected $errorCode = array(
			0=>'上传完成',
	        1=>'文件大小超出了能上传的值',
	        2=>'文件大小超出表单能接收的值',
	        3=>'文件只有部分被上传',
	        4=>'没有文件被上传',
	        6=>'找不到临时目录',
	        7=>'文件定入失败',
	        8=>'文件大小超出配置文件的限制',
	        9=>'不允许的文件类型',
	        10=>'创建目录失败',
	        11=>'未知错误,反思中'
		);

		function __construct(){
		
		}

	    private function getType($file) {
        	$type = strtolower(strrchr($file,'.'));
        	return $type;
    	}

    	private function checkType($type) {
	        return in_array(ltrim($type,'.'),$this->fileType);
	    }

	    private function getSize($size){
	    	return $size < $this->fileSize*1024*1024;
	    }

	    private function makeDir(){

	    	$dir = ROOT.'/data/images/'.date("Ymd",time());

	    	if(!is_dir($dir)){
	    		if(!mkdir($dir,0777,ture)){
	    			return false;
	    		}
	    	}
	    	return $dir;
	    }

	    private function makeFileName($i = 10){

	    	if($i<=0){
	    		return '';
	    	}
	    	$str = 'abcdefghijkmnpqrstuvwxyz';
	    	return substr(str_shuffle($str),0,$i);

	    }

	    public function up(){
	    	if(!$_FILES){
	    		return false;
	    	}
	    	$file = array();
	    	$file = $_FILES['uploadfile'];
			if($file['error'] > 0){
				$this->errno = $file['error'];
				return false;
			}

	        if(!$this->getSize($file['size'])) {
	            $this->errno = 8;
	            return false;
	        }
	        
	        $ext = $this->getType($file['name']);
	        if(!$this->checkType($ext)) {
	            $this->errno = 9;
	            return false;
	        }

	        $path = $this->makedir();
	        if(!$path) {
	            $this->errno = 10;
	            return false;
	        }

	        $filename = $this->makeFileName(5).date('His',time());
       		$path = $path . '/' . $filename . $ext;

       		if(!move_uploaded_file($_FILES['uploadfile']['tmp_name'],$path)) {
	            $this->errno = 11;
	            return false;
	        }

	    	$path = str_replace(ROOT."/data/images/",'',$path);
	        return $path;
	    }

	    public function getError() {
	        return $this->error[$this->errno];
	    }

	    public function setType($arr) {
	        $this->allowExt = $arr;
	    }

	    public function setSize($num = 2) {
	        $this->allowSize = $num;
	    }
	
	}

?>