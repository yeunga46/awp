<?php

session_start();

require_once('Connect.php');
require_once('CommentDBFuncs.php');
echo '<pre>'; echo print_r($_SERVER['action']); echo '</pre>';

if(isset($_GET['action']) && !empty($_GET['action'])) {
	$dbh = ConnectDB();
    $action = $_GET['action'];

    switch($action) {
        case 'add' : addComment($dbh, $_SESSION['uid'], $_GET["pid"], $_SESSION["username"],$_POST['comment']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
        case 'delete' : deleteComment($dbh,$_GET['cid'],$_SESSION['uid']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
        case 'edit' : editComment($dbh, $_GET['cid'], $_GET['pid'], $_SESSION['uid'], $_POST['newComment']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
        case 'adminDelete' : deleteCommentAdmin($dbh, $_GET['cid'], $_GET['pid'], $_SESSION['uid']);
        	header('Location: ./photo/' . $_GET["pid"]); break;
    }
}

?>