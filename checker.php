<?php

require_once('Connect.php');
require_once('UserDBFuncs.php');

if(isset($_GET['check']) && !empty($_GET['check'])) {
    $dbh = ConnectDB();
    $check = $_GET['check'];
    switch($check) {
        case 'userExist' : boolOutput(checkUserExist($dbh, $_GET['username'])); break;
        case 'emailExist' : boolOutput(checkEmailExist($dbh, $_GET['email'])); break;
    }

}

function boolOutput($b){
    if ($b) {
        echo "true";
    } else {
        echo "false";
    }
}
?>