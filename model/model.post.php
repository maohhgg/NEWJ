<?php

	class postmodel{

		private $user;
		private $obj;

		public function __construct(){
			$this->user = new usermode();
			$this->obj = new object();
		}

		private function send_content($str,$data){
			if(!$str){
				return flase;
			}
			$email = new sendmail();
			$data['Title'] = '注册邀请';
			$data['Content'] = "Hi:{$data['email']}<br/>我们开始使用 Tower 来管理项目吧，点击这个
			<a href='http://127.0.0.1/newJ/user.php?type=reg&codekey={$str}'>连接</a>，马上加入我们<br/>";
			
			if(!$email->sendeamil($data)){
				return flase;
			}
		}

		public function user_chk($data){
			if($this->user->chk_user($data)>0){
				echo "true";
			}
		}

		public function user_reg_tmp($data){
			if($this->user->chk_user($data,'regtmp')>0){
				$this->send_content($this->user->up_tmp($data),$data);
			}else{
				$this->send_content($this->user->reg_tmp($data),$data);
			}
		}

		public function user_srue($data){
			if($this->user->chk_code($data['codekey']) == 1){
				
				$my = new mysql();
				$data['email'] = $my->getOne("select email from regtmp where codekey='{$data['codekey']}'");
				$data = $this->user->fm_data($data);
				if($this->user->reg($data)){
					setcookie("towerId", $data['email']);
					echo 'true'; 
				}else{
					echo '未知原因，注册失败，请重试'; //return 2;
				}
			}else{
				echo "你提供的数据不对哦，请重试"; //return 3;
			}
		}

		public function user_login($data){
			if($this->user->chk_user($data)){
				if($data['checked']=='checked'){
					setcookie("towerId", $data['email'], time() + 100000);
				}else{
					setcookie("towerId", $data['email']);
				}
				echo 'true'; 
			}
		}

		public function user_update($data){
			if($this->user->user_update($data)){
				echo 'true';
			}else{
				echo 'flase';
			}
		}

		public function user_headimg($data){
			echo $this->user->user_info($data['email'])['headimg'];
		}

		public function obj_new_file($data){
			echo "data/images/".$this->obj->get_new_file($data['parent']);
		}
		public function obj_new($data){
			$data = $this->obj->fm_data($data);
			if($this->obj->cr_object($data)){
				echo 'true';
			}
		}

		public function obj_order($data){
			$data = $this->obj->fm_order($data);
			if($this->obj->cr_order($data)){
				echo 'true';
			}
		}

		public function obj_order_view($data){
			$data = $this->obj->fm_orderview($data);
			if($this->obj->cr_orderview($data)){
				echo 'true';
			}
		}

		public function obj_update($data){
			$url = $data['url'];
			unset($data['url']);
			if($this->obj->up_object($data,$url)){
				echo 'true';
			}
		}

		public function obj_word($data){
			$data = $this->obj->fm_word($data);
			if($this->obj->cr_word($data)){
				echo 'true';
			}
		}


		/*  日历的创建新的**
			因为只有一两个内容 暂时归到obj下
		*/
		public function date_new($data){
			$data = $this->obj->fm_calen($data);
			if($this->obj->cr_calen($data)){
				echo 'true';
			}
		}

		public function date_info($data){
			$data['time'] = strtotime($data['time']);
			$arr = $this->obj->get_date($data);
			$json = json_encode($arr);
			print_r($json);
		}
	}

?>