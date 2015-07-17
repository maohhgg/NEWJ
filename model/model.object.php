<?php
	/*

	项目操作model

	*/
	

	class object{

		private $db;

		public function __construct(){
			$this->db = new mysql();
		}

		private function mk_code($i){
			if($i<=0){
	    		return '';
	    	}
			$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
			return substr(str_shuffle($str), 0,$i);
		}

		/*
			格式化post来的数据 以达到适应insert数据库的作用
		*/
		public function fm_data($data){
			$arr = array(
				'name' => $data['name'],
				'parent' => $data['parent'],
				'mark' => $data['mark'],
				'color' => $data['color'],
				'mktime' => time(),
				'url' => $this->mk_code(5).time()
			);
			return $arr;
		}

		public function fm_order($data){
			$arr = array(
				'name' => $data['name'],
				'parent' => $data['parent'],
				'starttime' => time(),
				'endtime' => 0,
				'newstat' => 0
			);
			return $arr;
		}

		public function fm_word($data){
			$arr = array(
				'name' => $data['name'],
				'ctime' => time(),
				'parent' => $data['parent'],
				'content' => htmlspecialchars($data['content'],ENT_QUOTES,"UTF-8")
			);
			return $arr;
		}

		public function fm_file($data){
			$arr = array(
				'uptime' => time(),
				"url" => $data['url'],
				"parent" => $data['parent']
			);
			return $arr;
		}

		public function fm_orderview($data){
			$arr = array(
				'parent' => $data['parent'],
				'starttime' => time(),
				'content' => $data['content']
			);
			return $arr;
		}

		public function fm_calen($data){
			$arr = array(
				'title' => $data['title'],
				'mktime' => strtotime($data['time']),
				'content' => $data['content'],
				'parent' => $data['parent']
			);
			return $arr;
		}



		/* 
		 	各种的mysql插入数据
		*/
		public function cr_object($data){
			return $this->db->autoExecute($data,'project');
		}

		public function cr_calen($data){
			return $this->db->autoExecute($data,'calendar');
		}

		public function cr_order($data){
			return $this->db->autoExecute($data,'objorder');
		}

		public function cr_word($data){
			return $this->db->autoExecute($data,'proword');
		}

		public function cr_orderview($data){
			$this->db->query("UPDATE objorder set newstat=newstat+1 where id ='{$data['parent']}'");
			return $this->db->autoExecute($data,'orderview');
		}

		public function cr_file($data){
			return $this->db->autoExecute($data,'profile');
		}



		/*
			数据库的更新操作
		*/
		public function up_object($data,$name){
			return $this->db->autoExecute($data,'project','update',"url='{$name}'");
		}



		/*
			数据库的删除操作  （删除树操作）
		*/
		public function del_object($name){
			$this->db->query("DELETE FROM orderview WHERE parent IN (SELECT id FROM objorder WHERE parent='{$name}')");
			$this->db->query("DELETE FROM objorder WHERE parent='{$name}')");
			$sql = "DELETE FROM project WHERE url = '{$name}'";
			return $this->db->query($sql);
		}



		/*
		各种从数据库得到数据
		*/

		public function obj_info($name){
			$sql = "SELECT name,mark,color,url FROM project WHERE parent='{$name}'";
			return $this->db->getAll($sql);
		}

		public function get_object($name){
			$sql = "SELECT name,mark,color FROM project WHERE url='{$name}'";
			return $this->db->getRow($sql);
		}

		public function get_new_file($name){
			$sql = "SELECT url FROM profile WHERE parent='{$name}' ORDER BY id DESC limit 1";
			return $this->db->getOne($sql);
		}

		public function get_file($name){
			$sql = "SELECT url FROM profile WHERE parent='{$name}'";
			return $this->db->getAll($sql);
		}

		public function get_projects($name){
			$arr = array(
				'self' => $this->db->getOne("SELECT name FROM project WHERE url='{$name}'"), 
				'order' => $this->db->getAll("SELECT id,name,endtime,newstat FROM objorder WHERE parent='{$name}'"),
				'file' => $this->db->getAll("SELECT url FROM profile WHERE parent='{$name}'"), 
				'word' => $this->db->getAll("SELECT name,ctime,content FROM proword WHERE parent='{$name}'")
			);
			return $arr;
		}

		public function get_order($id,$name){
			$sql = "SELECT name,starttime,endtime,newstat FROM objorder WHERE parent = '{$name}' AND id = '{$id}'";
			return $this->db->getRow($sql);
		}

		public function get_orderview($name){
			$sql = "SELECT starttime,content FROM orderview WHERE parent='{$name}'";
			return $this->db->getAll($sql);
		}


		public function get_date($data){
			$sql = "SELECT title,content FROM calendar WHERE parent='{$data['parent']}' AND mktime = '{$data['time']}' AND title = '{$data['title']}'";
			return $this->db->getRow($sql);
		}
		public function get_date_info($parent,$start,$end){
			$sql = "SELECT mktime,title FROM calendar WHERE parent='{$parent}' AND mktime BETWEEN '{$start}' AND '{$end}'";
			return $this->db->getAll($sql);
		}
	}