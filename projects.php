<?php
	require("class/init.php");
	if(!isset($_COOKIE['towerId'])){
		header("location:index.php");
	}
	$id = array_keys($_GET)[0];
	if(!$id){
		include("404.html");
		exit;
	}
	$user = $user->user_info($_COOKIE['towerId']);
	$info = $obj->get_projects($id);
	$file = $obj->get_file($id);
	include("public/projects.html");
?>