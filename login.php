<?php
require_once('Connect.php');
require_once('DBfuncs.php');
$dbh = ConnectDB();
if ( isset($_POST['username'])   &&  !empty($_POST['username'])   && 
     isset($_POST['pwd'])  &&  !empty($_POST['pwd'])){
	if (checkPassword($dbh, $_POST["username"], $_POST["pwd"])){
		session_start();

		$_SESSION['time']    = time();
		$_SESSION['username'] =  $_POST["username"];
		$_SESSION['uid']  =  getUid($dbh, $_POST["username"]);
		$_SESSION['login'] =  True;
		//redirect
		session_write_close();
		exit();
	}else{
		echo 'invalid';
		exit();
	}
}?>