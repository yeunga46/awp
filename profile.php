<?php

session_start();

require_once('Connect.php');
require_once('PhotoDBFuncs.php');
require_once('UserDBFuncs.php');

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
            echo '<div class="row">';
                echo '<div class="col-lg-2">';
                    if(isset($profile_pic) && !empty($profile_pic))
                    {
                        echo '<img id="profile_img" src='; echo str_replace(' ', '%20', $profile_pic[0]->filelocation); echo ' width=100%></img>';
                    }
                    else
                    {
                        #add href to photo.php with the appropriate query
                        echo '<img src="./res/placeholder.png" width=100% id="profile_img"></img>';
                    }
                echo '</div>';
                echo '<div class="col-lg-1" id="bio-div">';
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
                        echo "<button class='btn btn-success' id='btn_edit'>Edit Profile</button>";
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
                echo '<div class="thumbnail" id="photo-'; echo $i; echo '-div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img src='; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo ' width=100%></img>';
                            echo '<div class="caption">';
                                echo '<p>'; echo $photos[$i]->caption; echo '</p>';
                            echo '</div>';
                    echo '</a>';
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
<script>
$().ready(function(){
    $('#btn_edit').on('click', function(){
            //photo-i-div
            //bio-div
            $('#bio-div').empty();
            var form = $('<form/>', { action: './editProfile.php', method: 'POST'});
            var username = $('<h2>').html('<?php echo $_SESSION["username"]; ?>')
            var file_input = $('<input/>').attr('type', 'file').attr('id','profile_upload').attr('name', 'userfile').on('change', function(){
                console.log(this);
                    if (this[0].files && this[0].files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                        $('#profile_img').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this[0].files[0]);
                }
            });
            
            
            ;
            var bio_area = $('<textarea/>')
                           .attr('placeholder', 
                           '<?php echo (!is_null($bio) ? $bio : 'Write something about yourself...'); ?>')
                           .attr('width', '100%').attr('name','bio');
            var submit = $('<button />').attr('type', 'submit').attr('class', 'btn btn-success').text('Submit changes');
            var cancel = $('<button />').attr('type', 'button').attr('class', 'btn btn-danger').text('Cancel').on('click', function() {location.reload();});
            form.append(username);
            form.append(bio_area);
            form.append($('<br/>'));
            form.append($('<br/>'));
            form.append(file_input);
            form.append($('<br/>'));
            form.append(submit);
            form.append($('<p> </p>'))
            form.append(cancel);
            $('#bio-div').append(form);
    });
});
</script>

