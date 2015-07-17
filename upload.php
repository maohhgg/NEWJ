<?php
	
	require("class/init.php");
	if(!isset($_COOKIE['towerId'])){
		header("location:index.php");
	}
	$data['email'] = $_COOKIE['towerId'];
	$refreer = substr(strrchr($_SERVER['HTTP_REFERER'],"/"),1);

	$up = new upload();
	if($refreer=='me.php'){

		$myfile = $user->user_info($data['email'])['headimg'];

		if (file_exists($myfile)){
			unlink($myfile);
		}

		$data['headimg'] = $up->up();
		if($user->user_update($data)){
			echo "true";
		}

	}else{
		$data['parent'] = substr($refreer,strlen($refreer)-15);
		$data['url'] = $up->up();
		$data = $obj->fm_file($data);
		if($obj->cr_file($data)){
			echo "true";
		}
	}
	

?>