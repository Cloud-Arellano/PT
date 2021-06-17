<?php 
	$username = "root";
	$password = "";

	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=ProgramacionDocentev3;charset=utf8',$username,$password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

