<?php

session_start();

require_once('Connect.php');
require_once('CommentDBFuncs.php');

$dbh = ConnectDB();

addComment($dbh, $_SESSION['uid'], $_GET["pid"], $_POST['comment']);


header('Location: ./photo.php?pid=' . $_GET["pid"]); 

?>