<?php 

    session_start();
    
    require_once('Connect.php');
    require_once('UserDBFuncs.php');
    require_once('PhotoDBFuncs.php');

    $dbh = ConnectDB();

    $uid = $_SESSION['uid'];

    $bio = $_POST['bio'];

    editProfile($dbh, $uid, $bio);

    if(!is_null($_POST['userfile']))
    {
        //add functionality to store the photo
    }

    header('Location: ./u/' . $_SESSION['username']); 

?>