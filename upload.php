<?php 
session_start();
if(isset($_SESSION["login"]) && $_SESSION["login"])
{
    $title = 'Upload Photo';
    include("header.php");
}
else {
    header('Location: ./start.php'); 
}
?>
<div class="container-fluid">
    <div class="row">
    <div class="col-md-auto col-centered text-center">
            <img id="img_preview" src=".\res\placeholder.png" height="500" width="500">
        </div>
    </div>
    </br></br>
    <div class="row"></div>
        <div class="col-sm-auto col-centered text-center">
            <form method="post" action="./store_it.php">
                <div class= "form-group">
                    <label for="title">Choose a title for your photo:</label>
                    <input type="text" name="title" id="title">
                </div>
                <div class="form-group">
                    <label for="userfile">Choose a photo to upload:</label>
                    <!-- center pesky input -->
                    <input type="file" name="userfile" id="userfile" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="caption">Enter a caption:</label> 
                    <input type="textarea" name="caption" placeholder="optional">
                </div>
                <button type="submit" class="btn btn-success">Submit</button> 
            </form>
        </div>
    </div>
</div>
<script>
//function to replace image when a file is chosen
//submit button should not work until a valid picture is submitted
$(document).ready(function () 
{
    $('#userfile').on('change', function() {
        if($('#userfile')[0].files && $('#userfile')[0].files[0])
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL($('#userfile')[0].files[0]);   
        }
        
    });
});

</script>


