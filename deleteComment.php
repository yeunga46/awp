<?php 
session_start();

require_once('Connect.php');
require_once('CommentDBFuncs.php');

$dbh = ConnectDB();

#implement login check here

deleteComment($dbh,$_GET['cid'],$_SESSION['uid']);

header('Location: ./photo.php?pid=' . $_GET["pid"]); 
?>