<?php
#TODO: 
#add hrefs to photos to link to photo.php 
#create photo.php 
#decide between adding a new page to edit preferences or to dynamically edit this one
#                        ^^^^ much easier - call it settings.php

session_start();

require_once('Connect.php');
require_once('DBfuncs.php');

$dbh = ConnectDB();
    $title = $_GET["username"];
    $uid = getUid($dbh, $title);
    include("header.php");

    $profile = getProfile($dbh, $uid);
    //echo '<pre>'; print_r($profile); echo '</pre>';
    
    $username = $profile[0]->username;
    $profile_pic_id = $profile[0]->profile_pic_id;
    $bio = $profile[0]->bio;

    if(!is_null($profile_pic_id))
    {
        $profile_pic = getPhoto($dbh, $profile_pic_id);
    }
    #set up profile pic + bio
    echo '<div class="flex-container">';
        echo '<div class="container">';
            echo '<div class= "row">';
                echo '<div class="col-lg-2">';
                    if(isset($profile_pic) && !empty($profile_pic))
                    {
                        echo '<img src='; echo str_replace(' ', '%20', $profile_pic[0]->filelocation); echo ' width=100%></img>';
                    }
                    else
                    {
                        echo '<img src="/awp/res/placeholder.png" width=100%></img>';
                    }
                echo '</div>';
                echo '<div class="col-lg-2">';
                    echo '<h2>'; echo $username; echo '</h2>';
                    if(!is_null($bio))
                    {
                        echo '<p>'; echo $bio; echo '</p>';
                    }
                    else {
                        echo "<p>This person hasn't written a bio yet.</p>";
                    }
                    //present button for editing preferences
                    if($_SESSION["username"] == $title)
                    {
                        echo "<button class='btn btn-success'>Edit Profile</button>";
                    }
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    echo '</br>';
    #echo '<p>'; print_r($profile); echo '</p>';
    
    #load in photos
    $photos = getUserPhotos($dbh, $uid);
    #echo '<p>'; print_r($photos); echo '</p>';

    $rowsize = 3;

    if(count($photos) > 0)
    {
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
                    echo '<img src='; echo str_replace('./', '/awp/', $photos[$i]->filelocation); echo ' width=100%></img>';
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
    }
    else {
        echo '<div class="flex-container">';
            echo '<div class="container">';
                echo '<div class="col-lg-auto">';
                    echo "<h1> This person doesn't seem to have uploaded any photos.</h1>";
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }

?>


