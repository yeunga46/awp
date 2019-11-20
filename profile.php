<?php 
session_start();

require_once('Connect.php');
require_once('DBfuncs.php');

$dbh = ConnectDB();

if(isset($_SESSION["login"]) && $_SESSION["login"])
{
    $title = $_SESSION['username'];
    include("header.php");
    #set up profile page
    $profile = getProfile($dbh, $_SESSION['uid']);
    #echo '<p>'; print_r($profile); echo '</p>';
    
    #load in photos
    $photos = getUserPhotos($dbh, $_SESSION['uid']);
    #echo '<p>'; print_r($photos); echo '</p>';

    $rowsize = 5;


    ?> <div class="flex-container"> 
    <?php
    #calculate how many we can fit on one row / col - assume 5

    for($i = 0; $i < count($photos); $i++)
    {
        if($i % $rowsize == 0)
        {
            echo '<div class="row mx-auto" style="margin-left: 0.1%">';
        }
        echo '<div class="col-sm-4 mx-auto">';
            echo '<div class="thumbnail">';
                echo '<img src='; echo $photos[$i]->filelocation; echo ' width=200px; height=200px;></img>';
            echo '<div class="caption">';
                echo '<p>'; echo $photos[$i]->caption; echo '</p>';
            echo '</div>';
        echo '</div>';

        if($i % $rowsize == 0)
        {
            #generate the closing tag for that row
            echo '</div>';
        }
    }
    ?> </div><?php
}
else {
    header('Location: ./start.php'); 
}?>


