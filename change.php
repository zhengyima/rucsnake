<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Snake</title>
	<link rel="stylesheet" type="text/css" href="semantic.min.css">
	<link rel="stylesheet" type="text/css" href="signin.css">
</head>
<body>
	<div class="ui menu">
		<div class="ui container">
			<div class="header item">Snake</div>
			<div class="active item">Sign-in</div>
		</div>
	</div>
	<div class="ui middle aligned center aligned grid">
	<?php
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$new_password = md5($_POST['newpassword']);
		$mysqli = new mysqli("localhost", "root", "PASSWORD", "syzoj");		
		$flag = 0;
		if($mysqli) {
			$sql = "select * from student where sno='".$username."' and spsw='". $password ."'";
			$result = $mysqli->query($sql);
			if($result) {
				while($row = $result->fetch_row()) {
					$check_password = $row[2];
					if(strcmp($check_password, $password) == 0) {
						$sql = "update student set sno='".$new_password."'where spsw='".$username."'";
						$result2 = $mysqli->query($sql);
						if($result2) {
							$flag = 1;
						}
					}
					break;
				
				}
			}
		}
		if($flag == 1) { ?>
			<div class="left aligned column">
				<div class="ui positive message">
					<div class="header">成功</div>
					<p>修改成功
					<br/>
					重新<a href="index.html">登录</a>
					</p>
				</div>
			</div>
		<?php
		}
		else { ?>
			<div class="left aligned column">
				<div class="ui negative message">
					<div class="header">失败</div>
					<p>修改失败，请检查你的用户名和密码是否正确
					<br/>
					<a href="change_pass.html">返回</a>
					</p>
				</div>
			</div>	
		
		<?php
		$mysqli->close();
		}
	?>
	</div>
	<script type="text/javascript" src="jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="semantic.min.js"></script>
</body>
</html>