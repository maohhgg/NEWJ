<?php

	/*
		user.php
		既是只处理get的数据

	*/
	
	require("class/init.php");

	if(!$_GET){
		include(ROOT."/public/reg.html");
	}else if($_GET['type']=='reg'){

		if(isset($_GET['codekey']) && 
			$user->chk_code($_GET['codekey']) == 1){

			include('/public/regin.html');
			exit;
			
		}
		header("Location:index.php");
		
	}

?>