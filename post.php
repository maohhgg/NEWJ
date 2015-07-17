<?php
	/*
		POST.php
		项目新建、删除等发来的数据
		这个只是处理ajax发来的数据，既是只处理POST的数据

	*/
	require("class/init.php");
	if(!$_POST){
		exit;
	}else{

		$data =$_POST;
		unset($data['type']);
		$type = $_POST['type'];

		$mod = new postmodel();
		$mod->$type($data);
	}

?>