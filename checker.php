<?php

require_once('Connect.php');
require_once('UserDBFuncs.php');


if(isset($_POST['check']) && !empty($_POST['check'])) {
    $dbh = ConnectDB();
    $check = $_POST['check'];
    switch($check) {
        case 'userExist' : boolOutput(checkUserExist($dbh, $_POST["username"])); break;
        case 'emailExist($dbh' : boolOutput(checkEmailExist($dbh, $_POST['email'])); break;
    }

}

function boolOutput($b){
    if ($b) {
        echo("true");
    } else {
        echo("false");
    }
}
?>