<?php 
session_start();

require_once('Connect.php');
require_once('DBfuncs.php');

$dbh = ConnectDB();

$photo = getPhoto($dbh, $_GET["pid"]);
# how do i get comments?

$title = $photo[0]->title;

echo '<pre>'; print_r($photo); echo '</pre>';

include("header.php");
?>