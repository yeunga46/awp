<?php 
session_start();

if(isset($_SESSION["login"]) && $_SESSION["login"])
{
    $title = $_SESSION['username']; 
    include("header.php");
}
else {
    header('Location: ./start.php'); 
}
?>