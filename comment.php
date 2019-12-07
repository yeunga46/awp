<?php

session_start();

require_once('Connect.php');
require_once('CommentDBFuncs.php');


if(isset($_POST['action']) && !empty($_POST['action'])) {
	$dbh = ConnectDB();
    $action = $_POST['action'];
    switch($action) {
        case 'add' : addComment($dbh, $_SESSION['uid'], $_POST["pid"], $_POST["uploader"],$_POST['comment']);
        	header('Location: ./photo/' . $_POST["pid"]); break;
        case 'delete' : deleteComment($dbh,$_POST['cid'],$_SESSION['uid']);
        	header('Location: ./photo/' . $_POST["pid"]); break;
        case 'edit' : editComment($dbh, $_POST['cid'], $_POST['pid'], $_SESSION['uid'], $_POST['newComment']);
        	header('Location: ./photo/' . $_POST["pid"]); break;
        case 'adminDelete' : deleteCommentAdmin($dbh, $_POST['cid'], $_POST['pid'], $_SESSION['uid']);
        	header('Location: ./photo/' . $_POST["pid"]); break;
    }

}

?>