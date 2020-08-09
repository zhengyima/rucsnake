<?php session_start();?>
<?php
	$_SESSION['username'] = "";
	session_unset();
	session_destroy();
	header("Location: index.html");
?>