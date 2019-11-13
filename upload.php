<?php $title = 'Upload Photo'; include("header.php");?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-auto">
        <!-- Center img div-->
            <form method="post" action="./store_it.php">
                <div class="form-group">
                    <label for="userfile">Choose a photo to upload:</label>
                    <input type="file" name="userfile" accept=".png, .jpg, .jpeg, .gif">
                </div>
                <div class="form-group">
                    <label for="caption">Enter a caption:</label> 
                    <input type="textarea" name="caption" placeholder="optional">
                </div>
                <button type="submit" class="btn btn-success">Submit</button> 
            </form>
        </div>
        <div class="col-md-auto">
            <img id="preview" src=".\res\placeholder.png">
        </div>
    </div>
</div>
<script>
//function to replace image when a file is chosen
//submit button should not work until a valid picture is submitted

</script>


