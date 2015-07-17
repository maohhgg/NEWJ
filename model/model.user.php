<?php
	/*
	用户操作model
	*密码加密/解密
	*检查用户邮箱是否存在
	*检查邮箱和密码是否
	*更新登录时间 -----------   (有待测试，更新时会不会清楚除lastlogin的其他数据，但代码理论上没问题的(所以说要测试))
	*以email更新这个用户的数据

	*/
	
	class usermode{

		private $db;

		public function __construct(){
			$this->db = new mysql();
		}

		private function mc_encrypt($passwd, $email){
			$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
			$passcrypt = trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, MD5($email), trim($passwd), MCRYPT_MODE_ECB, $iv));
			$encode = base64_encode($passcrypt);
			return $encode;
		}


		/*    暂时还没有用 只是把解密方法写着而已   */

		private function mc_decrypt($decrypt, $email) {
			$decoded = base64_decode($decrypt);
			$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
			$decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, MD5($email), trim($decoded), MCRYPT_MODE_ECB, $iv));
			return $decrypted;
		}

		private function mk_code($i){
			$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
			return substr(str_shuffle($str), 0,$i);
		}

		public function reg_tmp($data){
			$data['mktime'] = time();
			$data['codekey'] = $this->mk_code(10);
			$this->db->autoExecute($data,'regtmp');
			return $data['codekey'];
		}
		public function up_tmp($data){
			$data['mktime'] = time();
			$data['codekey'] = $this->mk_code(10);
			$this->db->autoExecute($data,'regtmp','update',"email='{$data['email']}'");
			return $data['codekey'];
		}
		
		public function reg($data){
			$data['password'] = $this->mc_encrypt($data['password'],$data['email']);
			$this->db->autoExecute($data,'users');
			$this->db->query("DELETE FROM regtmp WHERE email = '{$data['email']}' ");
        	return true;
		}

		public function fm_data($data){
			$arr = array(
				'headimg' => 'user.png',
				'name' => $data['name'],
				'password' => $data['password'],
				'email' => $data['email'],
				'mktime' => time(),
				'lastlogin' => 0,
				'proba' => 0.0
			);
			return $arr;
		}


		/*			
			chkuser() 
			1.检查用户注册的email是否已经注册过了 
			2.登录验证密码和email
			3.(我的数据库设计问题) 验证是否已经申请注册了
		*/

		public function chk_user($data,$table='') {
			if($table == ''){
		        if(isset($data['password'])==FALSE){
		            $sql = "select count(*) from users where email = '{$data['email']}'";
		            return $this->db->getOne($sql);
		        }else{
		            $data['password'] = $this->mc_encrypt($data['password'],$data['email']);
		            // echo $data['password'];
		            $sql = "select email,password from users where email = '{$data['email']}' 
		            		and password = '{$data['password']}'";
		            if($this->db->getRow($sql)){
		            	$this->up_login($data);
		            	return true;
		            }
		        }
		    }else{
		    	$sql = "select count(*) from {$table} where email = '{$data['email']}'";
		        return $this->db->getOne($sql);
		    }
	    }
	    public function chk_code($code) {
            $sql = "select count(*) from regtmp where codekey = '$code'";
           	return $this->db->getOne($sql);
	    }

		public function up_login($data) {
	        $arr = array('lastlogin'=>time());
	        return $this->db->autoExecute($arr,'users','update',"email='{$data['email']}'");
	    }

	    public function user_update($data){
	    	if(isset($data['password'])){
	    		$data['password'] = $this->mc_encrypt($data['password'],$data['email']);
	    	}
	        return $this->db->autoExecute($data,'users','update',"email='{$data['email']}'");
	    }

	    public function user_info($name){
	    	$sql = "select headimg,name,email from users where email='{$name}'";
	    	$list = $this->db->getRow($sql);
	    	$list['headimg'] = "data/images/".$list['headimg'];
	    	return $list;
	 	}

	 	public function user_time_info($name,$str='mktime'){
	 		$sql = "select {$str},email from users where email='{$name}'";
	 		return $this->db->getAll($sql);
	 	}

	 	public function get_user_obj($name){
	 		$sql = "SELECT mktime,name,url FROM project WHERE parent='{$name}'";
	 		return $this->db->getAll($sql);
	 	}

	 	public function get_user_obj_all($name){
	 		$sql = "SELECT name,itsover,url FROM project WHERE parent='{$name}'";
	 		return $this->db->getAll($sql);
	 	}

	 	/*
			页面较多 下面是提供 user表出来的格式❀所需的函数
	 	*/
		public function time_array($array,$arr,$str=""){

			foreach($arr as $value) {
				$date = strtotime(date("Y-m-d",reset($value)));
				$array[$date][] = array(
					'0' => reset($value),
					'1' => next($value),
					'2' => next($value),
					'type' => $str
				);
			}
			return $array;
		}

		public function son_info($arr){
			foreach ($arr as $value) {
				$sql = "SELECT COUNT(*) FROM profile WHERE parent = '{$value['url']}'";
				$sql1 = "SELECT COUNT(*) FROM proword WHERE parent = '{$value['url']}'";
				$sql2 = "SELECT COUNT(*) FROM objorder WHERE parent = '{$value['url']}'";
				$num = $this->db->getOne($sql)+$this->db->getOne($sql1)+$this->db->getOne($sql2);
				$value['num'] = $num;
				$array[] = $value;
			}
			return $array;
		}


		public function get_cour($arr){
			$array = array(
				'obj' => count($arr),
				'update' => 0,
				'over' => 0
			);
			foreach ($arr as $value) {
				$array['update'] = $value['num'] + $array['update'];
				$array['over'] = $value['itsover'] + $array['over'];
			}
			return $array;
		}
	}

?>