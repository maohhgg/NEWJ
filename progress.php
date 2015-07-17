<?php
	require("class/init.php");
	if(!isset($_COOKIE['towerId'])){
		header("location:index.php");
	}
	$userarr = array();
	$userinfo = $user->user_info($_COOKIE['towerId']);

	$userarr = $user->time_array($userarr,$user->user_time_info($_COOKIE['towerId']),"注册");
	$userarr = $user->time_array($userarr,$user->user_time_info($_COOKIE['towerId'],'lastlogin'),"登录");
	$userarr = $user->time_array($userarr,$user->get_user_obj($_COOKIE['towerId']),"创建");

	krsort($userarr);
	//print_r($userarr);
	
	include("public/progress.html");
?>