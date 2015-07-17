<?php
	require("class/init.php");
	if(!isset($_COOKIE['towerId'])){
		header("location:index.php");
	}
	$info = array(
		'name' => '',
		'mark' => 'A',
		'color' => 'D6DDE9');
	if($_GET){
		$id = array_keys($_GET)[0];
		$info = $obj->get_object($id);
	}
	$user = $user->user_info($_COOKIE['towerId']);
	include("public/newjob.html")
?>