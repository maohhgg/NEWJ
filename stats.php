<?php
	
	require("class/init.php");
	if(!isset($_COOKIE['towerId'])){
		header("location:index.php");
	}
	
	$userinfo = $user->user_info($_COOKIE['towerId']);
	$num = $user->get_user_obj_all($_COOKIE['towerId']);
	$num = $user->son_info($num);
	$obj = $user->get_cour($num);
	$obj['over'] = sprintf("%.1f",$obj['over']/$obj['obj']*100);

	include("public/stats.html");

?>