<?php 
# this file handles deleting users and photos
session_start();
    
require_once('Connect.php');
require_once('UserDBFuncs.php');
require_once('PhotoDBFuncs.php');

if(isset($_GET['obj']) && !empty($_GET['obj'])) {
	$dbh = ConnectDB();
    $obj = $_GET['obj'];

    switch($obj) {
        case 'profile': 
            deleteUser($dbh, $_SESSION['username'], $_POST['delete_pass']);
            unset($_SESSION["uid"]);
            unset($_SESSION["username"]);
            unset($_SESSION["time"]);
            $_SESSION['login'] =  False;  
            session_write_close();
            header("Location:../start.php");
            break;
        case 'photo': 
            deletePhoto($dbh, $_GET['pid'], $_SESSION['uid']); 
            header("Location:../start.php");
            break;
    }
}
?>