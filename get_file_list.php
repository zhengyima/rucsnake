<?php 
	//获取所有可用文件
	$server_place = "/var/www/html/snake/upload";
	$result = "";
	foreach(scandir($server_place) as $afile) {
		if($afile == "." || $afile=="..") continue;
		if(is_dir($server_place."/".$afile) && file_exists($server_place."/".$afile."/".$afile)){  
			$result = $result.$afile." ";
		}
	}
	echo $result
?>
