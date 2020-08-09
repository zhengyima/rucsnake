<?php
	session_start();
	$student_id = $_POST['student_id'];
	$game_id = $_POST['game_id'];
	$map = explode(" ",$_POST['map']);
	//用于判断该同学的蛇是否已死亡，死亡则不再请求数据
	$error_id = $_POST['error_id'];
	//项目目录
	$server_place = "/var/www/html/snake/";
	//每局对战地图目录
	$map_place = "map/";

	foreach($student_id as $sid) {
		$l4 = substr($sid, 3, 1).substr($sid, strlen($sid) - 3);
		$game_id = $game_id.$l4;
	}
	$fp = fopen($server_place . $map_place . $game_id . ".txt", "w");
	foreach($map as $i) {
		//echo $i;
		fwrite($fp,$i);
		fwrite($fp," ");
	}
	fclose($fp);
	$index = 0;
	foreach($student_id as $sid) {
		if($error_id[$index] == "1") {
			$index ++;
			continue;
		}
		$index ++;
		$object_path = "upload/".(string)$sid . "/" . (string)$sid;
		chmod($server_place . $map_place . $game_id . ".txt", 0777);
		echo " ".$sid." ";
		//system会自己给出返回值，返回给前端
		system($server_place . $object_path . " < " . $server_place . $map_place . $game_id . ".txt", $output);
		// echo $output;
	}
?>