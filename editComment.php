<?php 
session_start();

require_once('Connect.php');
require_once('CommentDBFuncs.php');

$dbh = ConnectDB();
#implement login check here

editComment($dbh, $_GET['cid'], $_GET['pid'], $_SESSION['uid'], $_POST['newComment']);

header('Location: ./photo.php?pid=' . $_GET["pid"]); 
?>