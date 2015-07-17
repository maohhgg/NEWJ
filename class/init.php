<?php
	
	session_start();
	
	define('ROOT', str_replace('class/init.php','',str_replace("\\","/", __FILE__)));
	$arr=json_decode(file_get_contents('class/config.json'));

	require('class.log.php');
	require('class.mysql.php');
	require('class.upload.php');
	require('class.mail.php');

	require('model/model.user.php');
	require('model/model.mail.php');
	require('model/model.object.php');
	require('model/model.post.php');

	$user = new usermode();
	$obj = new object();
?>
