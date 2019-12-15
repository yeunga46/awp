<?php
session_start();
unset($_SESSION["uid"]);
unset($_SESSION["username"]);
unset($_SESSION["time"]);
$_SESSION['login'] =  False;
header("Location:../start.php");
session_write_close();
?>