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
		$_SESSION['username'] = $username;
		$flag = 0;
		$mysqli = new mysqli("localhost", "root", "PASSWORD", "syzoj");		
		if($mysqli) {
			$sql = "select sno,spsw from student where sno='".$username."' and spsw='".$password."'";
			$result = $mysqli->query($sql);
			if($result) {
				while($row = $result->fetch_row()) {
					$check_password = $row[1];
					if(strcmp($check_password, $password) == 0) {
						$flag = 1;
					}
				}
			}
		}
		if($flag == 1) { ?> 
			<div class="left aligned column">
				<div class="ui positive message">
					<div class="header">成功</div>
					<p>登陆成功
					<br/>
					<a href="game.php">确认</a>
					</p>
				</div>
			</div>
		<?php
		}
		else { ?>
			<div class="left aligned column">
				<div class="ui negative message">
					<div class="header">错误</div>
					<p>系统进入备战，暂停登录，敬请谅解...
					<br/>
					<a href="index.html">返回</a>
					</p>
				</div>
			</div>
		<?php } 
		$mysqli->close();
		?>	
	</div>
	<script type="text/javascript" src="jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="semantic.min.js"></script>
</body>
</html>