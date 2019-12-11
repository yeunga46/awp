<?php 
session_start();


if(isset($_SESSION["login"]) && $_SESSION["login"])
{
    $title = 'Upload Photo';
    include("header.php");
}
else {

    //header('Location: ./start.php'); 
}
?>
<div class="container-fluid">
        <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img id="img_preview" src=".\res\placeholder.png" height="500" width="500">
            </div>
            <div class="col-md-6">
                <form id="form-upload-file" method="post" enctype="multipart/form-data" action="./store_it.php">
                    <div class="form-group">
                    <!-- make sure to require title -->
                        <label for="title">Choose a title for your photo:</label>
                        <input type="text" name="title" id="title" placeholder="required">
                    </div>
                    <div class="form-group">
                        <label for="caption">Enter a caption:</label>
                        <textarea name="caption" placeholder="optional" style="width: 100%; height: 100%;"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" name="userfile" id="userfile" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    //function to replace image when a file is chosen
    //submit button should not work until a valid picture is submitted
    $(document).ready(function () {
        $('#userfile').on('change', function () {
            if ($('#userfile')[0].files && $('#userfile')[0].files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL($('#userfile')[0].files[0]);
            }
        });
        $('#form-upload-file').on('submit', function(e) {
            if($('#title').val() === "")
            {
                //change this to something more pleasing later
                alert('Please fill out a title for your photo before continuing.');
                e.preventDefault();
            }
            else if ($('#userfile').get(0).files.length === 0) {
                alert('Please upload a photo.');
                e.preventDefault();
            }       
        });
    });
</script>