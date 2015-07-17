<?php
	/*
	邮件发送的方法
	*这个适合没有邮件服务器的  借用现有的邮件服务商 qq gmail hotmail。。。
	*发送指定的消息给指定的人
	*OK

	*/
	class sendmail{

		protected $smtp;
		protected $arr;

		public function __construct(){
			$this->arr = json_decode(file_get_contents('class/config.json'));
			$this->smtp = new smtp($this->arr->MailServer,25,true,$this->arr->MailId,$this->arr->MailPw);
		}

		public function sendeamil($data){
			$this->smtp->debug = false;
			if($this->smtp->sendmail($data['email'],$this->arr->MailId, $data['Title'], $data['Content'], "HTML")){
				return true;
			}else{
				print_r($this->arr);
				print_r($this->smtp);
				print_r($data);
				return false;
			}
		}

	}

?>