<?php session_start();?>
<?php
$allowedExts = array("c");
$temp = explode(".", $_FILES["file"]["name"]);
$student_id = $_SESSION['username'];
$extension = end($temp);
if (($_FILES["file"]["size"] < 204800) && in_array($extension, $allowedExts)) {
	if ($_FILES["file"]["error"] > 0) {	
		echo "error: " . $_FILES["file"]["error"] . "<br>";
	}
	else {	
		//上传目录
		$path = "upload/".(string)$student_id . "/" . (string)$student_id . ".c";
		$object_path = "upload/".(string)$student_id . "/" . (string)$student_id;
		$server_place = "/var/www/html/snake/";
		//如果该同学学号命名的目录不存在，则新建
		if (!file_exists("upload/".(string)$student_id)) {	
			mkdir("upload/".(string)$student_id);
			chmod("upload/".(string)$student_id, 0777);
		}

		if (file_exists($path)) {	
			unlink($path);
		}

		move_uploaded_file($_FILES["file"]["tmp_name"], $path);
		chmod($server_place . $path,0777);
		//编译
		system("gcc " . $server_place . $path . " -o " . $server_place . $object_path, $output);
		//echo "gcc " . $server_place . $path . " -o " . $server_place . $object_path;
		chmod($server_place . $object_path, 0777);
		echo $student_id;
	}
}
else {
	echo "invalid file, please check size and type";
}
?>
