<?php 
session_start();

require_once('Connect.php');
require_once('DBfuncs.php');

$dbh = ConnectDB();
    $title = $_GET["username"];

    $uid = getUid($dbh, $title);

    include("header.php");
    #set up profile page
    $profile = getProfile($dbh, $uid);
    #echo '<p>'; print_r($profile); echo '</p>';
    
    #load in photos
    $photos = getUserPhotos($dbh, $uid);
    #echo '<p>'; print_r($photos); echo '</p>';

    $rowsize = 3;

     echo '<div class="flex-container">';
    #calculate how many we can fit on one row / col - assume 5
    echo '<div class="container">';
    for($i = 0; $i < count($photos); $i++)
    {
        if($i % $rowsize == 0)
        {
            echo '<div class="row">';
        }
        #should be adjusted to according to row size
        echo '<div class="col-sm-4">';
            echo '<div class="thumbnail">';
                echo '<img src='; echo $photos[$i]->filelocation; echo ' width=100%></img>';
                    echo '<div class="caption">';
                        echo '<p>'; echo $photos[$i]->caption; echo '</p>';
                    echo '</div>';
            echo '</div>';
        echo '</div>';

        if($i % $rowsize == $rowsize-1)
        {
            #generate the closing tag for that row
            echo '</div>';
        }
    }
    echo '</div>';
    echo '</div>';
?>


