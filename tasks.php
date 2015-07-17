<?php
	require("class/init.php");
	if(!isset($_COOKIE['towerId'])){
		header("location:index.php");
	}
	$parent = array_keys($_GET)[0];
	$id = array_keys($_GET)[1];
	if(!$id&&!$parent){
		include("404.html");
		exit;
	}
	$user = $user->user_info($_COOKIE['towerId']);
	$info = $obj->get_order($id,$parent);
	$view = $obj->get_orderview($id);
	include("public/tasks.html");
?>