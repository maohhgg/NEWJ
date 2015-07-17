<?php
	require("class/init.php");
	if(!isset($_COOKIE['towerId'])){
		header("location:index.php");
	}
	
	$user = $user->user_info($_COOKIE['towerId']);
	include(ROOT."/public/me.html");
?>