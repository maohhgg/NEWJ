<?php

	require("class/init.php");

	if(!isset($_COOKIE['towerId'])){

		include(ROOT."/public/login.html");
		exit;

	}else if($_COOKIE['towerId']){
		$obj = new object();
		$user = $user->user_info($_COOKIE['towerId']);
		$objinfo = $obj->obj_info($user['email']);
		//print_r($objinfo);

		include(ROOT."/public/index.html");
	}

?>