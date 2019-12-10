<?php

session_start();

require_once('Connect.php');
require_once('CommentDBFuncs.php');

if(isset($_GET['action']) && !empty($_GET['action'])) {
	$dbh = ConnectDB();
    $action = $_GET['action'];

    switch($action) {
        case 'add' : addComment($dbh, $_SESSION['uid'], $_GET["pid"], $_SESSION["username"], htmlspecialchars($_POST['comment']));
        	header('Location: ./photo/' . $_GET["pid"]); break;
        case 'delete' : deleteComment($dbh,$_GET['cid'],$_SESSION['uid']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
        case 'edit' : editComment($dbh, $_GET['cid'], $_GET['pid'], $_SESSION['uid'], htmlspecialchars($_POST['newComment']));
        	header('Location: ./photo/' . $_GET["pid"]); break;
        case 'adminDelete' : deleteCommentAdmin($dbh, $_GET['cid'], $_GET['pid'], $_SESSION['uid']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
        case 'like' : like($dbh, $_GET['pid'], $_SESSION['uid']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
    	case 'unlike' : unlike($dbh, $_GET['pid'], $_SESSION['uid']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
    }
}

?>