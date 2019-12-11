<?php

session_start();

require_once('Connect.php');
require_once('PhotoDBFuncs.php');
require_once('UserDBFuncs.php');

$dbh = ConnectDB();
$title = $_GET["username"];
$uid = getUid($dbh, $title);
if(empty($uid)){
    header("Location: /photosite/404.php");
    exit();
}
include("header.php");

$profile = getProfile($dbh, $uid);

$username = $profile[0]->username;
$profile_pic_id = $profile[0]->profile_pic_id;
$bio = $profile[0]->bio;

if(!is_null($profile_pic_id))
{
    $profile_pic = getPhoto($dbh, $profile_pic_id);
}
#set up profile pic + bio
echo '<div class="container-fluid">';
        echo '<div class="row">';
            echo '<div class="col-lg-2" id="profile_icon">';
                if(isset($profile_pic) && !empty($profile_pic))
                {
                    echo '<img id="profile_img" src="'; echo str_replace(' ', '%20', $profile_pic[0]->filelocation); echo '" width=100%></img>';
                }
                else
                {
                    #add href to photo.php with the appropriate query
                    echo '<img src="./res/placeholder.png" width=100% id="profile_img"></img>';
                }
                echo '</div>';
                echo '<div class="col-lg-4" id="bio-div">';
                echo '<h2>'; echo $username; echo '</h2>';
                if(!is_null($bio))
                {
                    echo '<p>'; echo $bio; echo '</p>';
                }
                else 
                {
                    echo "<p>This person hasn't written a bio yet.</p>";
                }
                //present button for editing preferences
                if(isset($_SESSION["username"]) && $_SESSION["username"] == $title)
                {
                    echo "<button class='btn btn-success' id='btn_edit'>Edit Profile</button> ";
                    echo "<button class='btn btn-danger'  data-toggle='modal' data-target='#div_deleteProfile' type='button'>Delete Profile</button>";
                }
            echo '</div>';
        echo '</div>';
echo '</div>';
echo '</br>';
$photos = getUserPhotos($dbh, $uid);
$rowsize = 4;
if(count($photos) > 0)
{
    echo '<div class="container-fluid">';
    #calculate how many we can fit on one row / col - assume 5

        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            #should be adjusted to according to row size
            echo '<div class="col-sm-3">';
                echo '<div class="thumbnail" id="photo-'; echo $i; echo '-div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '" width=100%></img>';
                            echo '<div class="caption">';
                                echo '<p>'; echo htmlspecialchars($photos[$i]->caption); echo '</p>';
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
}
else { ?>
    <div class="flex-container">
        <div class="container">
            <div class="col-lg-auto">
                <h1>This person doesn't seem to have uploaded any photos.</h1>
            </div>
        </div>
    </div>
<?php }?>
<script>
$().ready(function(){
    var passwordsMatch = false;
    $('#btn_edit').on('click', function(){
            //photo-i-div
            //bio-div
            $('#bio-div').empty();
            //change action here to whatever you set the query string to
            var form = $('<form/>', { action: './editProfile.php', method: 'POST', enctype:"multipart/form-data"});
            var username = $('<h2>').html('<?php echo $_SESSION["username"]; ?>')
            var file_input = $('<input/>').attr('type', 'file').attr('accept', 'image/*').attr('name', 'userfile').on('change', function(){
                    if (this.files[0]) 
                    {
                        var reader = new FileReader();
                        reader.onload = function (e) 
                        {
                            $('#profile_img').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                    }});
            var bio_area = $('<textarea/>')
                           .val( 
                           '<?php echo (!is_null($bio) ? $bio : "Write something about yourself..."); ?>')
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
    $('#form_deleteAccount').on('submit', function(e){
        if(!passwordsMatch)
        {
            
            e.preventDefault();
        }
    });

    $('.delete_password_input').on('change keyup paste', function(){
        if($('#delete_confirm_password').val() !== "" && ($('#delete_confirm_password').val() === $('#delete_password').val()))
        {
            $('#form_deleteAccount p').remove();
            $('#delete_confirm_password').css({
                "border-color": "#00ff00",
                "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(0, 255, 0, 0.6)"
            });
            $('#delete_password').css({
                "border-color": "#00ff00",
                "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(0, 255, 0, 0.6)"
            });
            passwordsMatch = true;
            
        }
        else if($('#delete_password').val() === "" || $('#delete_confirm_password').val() === ""){
            $('#form_deleteAccount p').remove();
            $('#delete_confirm_password').removeAttr('style');
            $('#delete_password').removeAttr('style');
            passwordsMatch = false;
        }
        else
        {
            $('#form_deleteAccount p').remove();
            $('#delete_confirm_password').css({
                "border-color": "#FF0000",
                "box-shadow": "inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6)"
            });
            $('#delete_password').removeAttr('style');

            var error = $('<p>Passwords should match.</p>').css('color', 'red');
            $('#form_deleteAccount').append(error);
            passwordsMatch = false;
        }
    });
});
</script>
<div class="modal fade" id="div_deleteProfile" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Are you sure?</h4>
            </br>
            <p>All of your account information and pictures will be deleted.</p>
          </div>
          <div class="modal-body">
            <form method="POST" action="./delete.php?obj=profile" id="form_deleteAccount">
              <div class="form-group">
                <label for="delete_pass">Password</label>
                <input class="form-control delete_password_input" type="password" name="delete_pass" id="delete_password">
              </div>
              <div class="form-group">
                <label for="delete_confirm_pass">Confirm Password</label>
                <input class="form-control delete_password_input" type="password" name="delete_confirm_pass" id="delete_confirm_password">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Delete Account</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    </div>
    </div>
