<?php

	require("class/init.php");
	function lastmonth_monday($one,$two){  
		$first = strtotime($one."-".$two."-01");
		$start = $first-(86400*(date("N",$first)-1));
		for($i = 0;$i < 42;$i++){
			$arr[$i] = $start+(86400*$i);
		}
		return $arr;
	}
	
	function gettoday($date){
		for($i = 0;$i < 42;$i++){
			if(date("Ymd",$date[$i])==date("Ymd")){
				return $i+1;
			}
		}
	}

	function showarray($array){
		if(count($array)){
			foreach ($array as $value) {
				echo $value;
			}
		}
	}


	if(!$_GET){
		$year = date("Y");
		$mouth = date("m");
	}else{
		$year = array_keys($_GET)[0];
		$mouth = array_keys($_GET)[1];
	}
	if($mouth==12){
		$nmouth = 1;
		$nyear = $year+1;
	}else{
		$nmouth = $mouth+1;
		$nyear = $year;
	}
	if($mouth==1){
		$lmouth = 12;
		$lyear = $year-1;
	}else{
		$lmouth = $mouth-1;
		$lyear = $year;
	}

	$date = lastmonth_monday($year,$mouth);
	$datainfo = $obj->get_date_info($_COOKIE['towerId'],$date[0],$date[41]);
	foreach ($datainfo as  $value) {
		$array[$value['mktime']][]= "<a class='red'>".$value['title']."</a>";
	}
	$today = gettoday($date);

	$user = $user->user_info($_COOKIE['towerId']);
	include("public/calendars.html")
?>