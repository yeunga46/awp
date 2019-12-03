<?php 
session_start();

require_once('Connect.php');
// require_once('UserDBFuncs.php');
require_once('PhotoDBFuncs.php');
require_once('CommentDBFuncs.php');

$dbh = ConnectDB();

$photo = getPhoto($dbh, $_GET["pid"]);
# how do i get comments?

$comments = getComments($dbh, $_GET["pid"]);

$title = $photo[0]->title;

include("header.php");
?>
<div class="container">
    <div class="row-md-2">
        <img src='<?php echo str_replace(' ', '%20', $photo[0]->filelocation); ?>' height=500px>
    </div>
</div>
<div class="flex-container">
    <div class="row-md-2">
        <h2><?php echo $photo[0]->title; ?></h2>
        <p>Uploaded by: <?php echo $photo[0]->uploader;?> on <?php echo $photo[0]->uploaddate; ?> </p>
        <p><em><?php echo $photo[0]->caption; ?></em></p>
    </div>
</div>
