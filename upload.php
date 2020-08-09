<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Snake</title>
	<link rel="stylesheet" type="text/css" href="semantic.min.css">
	<link rel="stylesheet" type="text/css" href="my.css">
</head>
<body>
	<div class="ui menu">
		<div class="ui container">
			<div class="header item">Snake</div>
			<a class="item" href="game.php">Game</a>
			<div class="active item" href="upload.php">Upload</div>
			<a class="item" href="rule.php">Rule</a>
			<div class="right menu">
				<div class="item">
					<?php echo $_SESSION['username']; ?>		
				</div>
				<a href="signout.php" class="item">退出</a>
			</div>
		</div>
	</div>
	<?php 
		$username = $_SESSION['username'];
		if(is_null($username)) {
			?>
				<div class="ui middle aligned center aligned grid" style="height:100%">
					<div class="left aligned column" style="max-width: 450px;">
						<div class="ui negative message">
							<div class="header">错误</div>
							<p>记得登录呀...
							<br/>
							<a href="index.html">返回</a>
							</p>
						</div>
					</div>
				</div>
			<?php
		}
		else {
	?>
	<div class="ui container">
		<div class="ui segment">
			<form class="ui form" id="uploadform">
				<div class="ui dividing header">上传文件</div>
				<div class="field">
					<input type="file" placeholder="Your AI..." name="file">
					<input type="hidden" name="userid" value="<?php echo $_SESSION['username'];?>" id="userid">
				</div>
				<div class="ui button" onclick="doUpload()">上传</div>
			</form>
		</div>
	</div>
	<?php } ?>
	<script type="text/javascript" src="jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="upload.js"></script>
</body>
</html>