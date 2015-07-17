<?php


class mysql{

    private $db_host;
    private $db_user;
    private $db_pwd;
    private $port=3306;
    private $db_database;
    private $result;
    private $coding='UTF8';

 
    public function __construct(){
        $arr=json_decode(file_get_contents('class/config.json'));   //这句不要问我为什么  仅仅是偷懒而已
        $this->db_host = $arr->host;
        $this->db_user = $arr->user;
        $this->db_pwd = $arr->pwd;
        $this->db_database = $arr->db;
        $this->coding || $this->coding = $arr->coding;
        $this->port || $this->port = $arr->port;
        $this->connect();
        $this->setCoding();
        if($this->db_database)
            $this->setDB();

    }

    public function connect(){
        $this->result=mysqli_connect($this->db_host,$this->db_user,$this->db_pwd);
        if(!$this->result){
            $error = $this->db_host.":".$this->port." ".$this->db_user.":\n".mysqli_error();
            error::log($error);
        }
    }

    public function query($sql){
        $result = mysqli_query($this->result,$sql);
        if(!$result){
            $error = $sql."\n".mysqli_error();
            error::log($error);
            return false;
        }
        return $result;
    }

    public function getAll($sql) {
        $result = $this->query($sql);
        if(!$result) {
            return false;
        }

        $list = array();
        while($row = mysqli_fetch_assoc($result)) {
            $list[] = $row;
        }
        return $list;
    }

    public function getRow($sql) {
        $result = $this->query($sql);
        if(!$result) {
            return false;
        }

        return mysqli_fetch_assoc($result);
    }

    public function getOne($sql) {
        $result = $this->query($sql);
        if(!$result) {
            return false;
        }

        $tmp = mysqli_fetch_row($result);
        return $tmp[0];
    }

    public function setDB(){
        $sql = "use ".$this->db_database;
        if(!$this->query($sql))
            return false;
    }

        public function setCoding(){
        $sql = "set names ".$this->coding;
        if(!$this->query($sql))
            return false;
    }

    public function autoExecute($data,$table,$act='insert',$where='') {
    
        if($act == 'insert') {
            $sql = 'insert into ' . $table . ' (id,';
            $sql .= implode(',',(array_keys($data)));
            $sql .= ') values (NULL,\'';
            $sql .= implode("','",array_values($data));
            $sql .= "')";
        } 
        else if($act == 'update') {
            if(!trim($where)){
                return false;
            }
            
            $sql = 'update ' . $table . ' set ';
            foreach($data as $k=>$v) {
                $sql .= $k;
                $sql .= '=';
                $sql .= "'".$v."',";
            }
            
            $sql = substr($sql,0,-1);
            $sql .= ' where ';
            $sql .= $where;

        } else {
            return false;
        }
        return $this->query($sql);
    }

}
