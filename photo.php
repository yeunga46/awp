<?php 
session_start();

require_once('database/Connect.php');
require_once('database/UserDBFuncs.php');
require_once('database/PhotoDBFuncs.php');
require_once('database/CommentDBFuncs.php');

$dbh = ConnectDB();

$pid = $_GET["pid"];

$photo = getPhoto($dbh, $_GET["pid"]);

if(empty($photo)){
    header("Location: /photosite/404.php");
    exit();
}

$comments = getComments($dbh, $_GET["pid"]);

$title = $photo[0]->title;

include("header.php");

# doing this so we can get the pid in the javascript file
echo '<input type="hidden" id="hidden_pid" value="' . $pid . '">';

?>

<div class="container-fluid">
    <div class="row">
        <div id="cb-container" class="col-lg-4 comment-box">
             <div class="comment-box-header" id="cbheader">
                <h2 id="header_title"><?php echo htmlspecialchars($photo[0]->title);?></h2>
                <p id="header_likes" style="width:max-content"><?php echo "Likes: ".$photo[0]->likes;?></p>
                <?php
                    if($_SESSION['login'])
                    {
                        # like button
                        echo '<button class="btn btn-info like" id="like" title="Like">👌</button>';
                        if($_SESSION['username'] == $photo[0]->uploader)
                        { 
                            echo ' '; # need this for the space in between
                            # delete photo button
                            echo '<button class="btn btn-danger" title="Delete Photo" 
                            data-toggle="modal" data-target="#div_deletePhotoModal"type="button">
                            Delete Photo</button>';
                        }
                        echo '</br></br>';
                    }
                    # caption
                echo '<p><em>' . htmlspecialchars($photo[0]->caption) . '</em></p>';
                # uploader name + datetime
                echo '<p>Uploaded by: <a href="./u/' . $photo[0]->uploader . '" >'; 
                echo $photo[0]->uploader . '</a> on ' . $photo[0]->uploaddate . '</p>';
                ?>
                <hr>
             </div>
             <?php if(!is_null($comments) && !empty($comments))
             {  
                # render each comment
                for($i = 0; $i < count($comments); $i++) 
                    { 
                        echo '<div id="comment-' . $comments[$i]->comment_id . '">';
                            $thisUser = $comments[$i]->uploader;
                            echo'<h5><b>';
                            # show username
                            echo (isset($_SESSION['username']) && $thisUser == $_SESSION['username']) 
                            ? 'You' : $thisUser;
                            echo '</b> said:</h5>';
                            # comment itself
                            echo '<p class="comment-text">'; echo $comments[$i]->comment_text; echo '</p>';   
                            if($_SESSION['login'] && $thisUser == $_SESSION['username']) 
                                {
                                    # edit comment button
                                    echo '<button class="btn btn-info edit" id="edit-' 
                                    . $comments[$i]->comment_id . '">Edit Comment</button>';

                                    # delete comment button
                                    echo '<a href="database/comment.php?cid=' . $comments[$i]->comment_id 
                                    . '&pid=' . $pid 
                                    . '&action=delete"><button class="btn btn-danger">Remove Comment</button></a>';
                            } 
                        else if($_SESSION['login'] && $photo[0]->uploader == $_SESSION['username']) 
                            { 
                                # owner delete comment
                                echo '<a href="database/comment.php?cid=' . $comments[$i]->comment_id 
                                . '&pid=' . $pid . '&action=adminDelete">';
                                echo '<button class="btn btn-danger" 
                                title="You can remove this comment if you find it offensive.">
                                Remove Comment</button></a>';
                            }
                            echo '<p><em>' . $comments[$i]->comment_time . '</em></p>';
                            echo '<hr>';
                            echo '</div>';
                }} if($_SESSION['login']) {?>
                 <form method="post" enctype="multipart/form-data" action="database/comment.php?action=add&pid=<?php echo $pid; ?>">
                    <div class="form-group">
                        <!-- show add comment form -->
                        <p><em>Commenting as <?php echo $_SESSION['username'];?></em></p>
                        <textarea style="width: 100%;" name="comment"></textarea>
                        <br/>
                        <br/>
                        <button type="submit" class="btn btn-success">Submit comment</button>
                    </div>
                </form>
                <?php } else { ?>
                <!-- display a message that you can't if not logged in -->
                <div><em>You must register an account to comment on this website.</em><br/><br/></div>
                <?php }?>
        </div>
        <div id="photo-container" class="col-lg-8" >
            <img src='<?php echo str_replace(' ', '%20', $photo[0]->filelocation); ?>' height=500px>
        </div>
</div>
<div id="likes_tooltip" class="like_tooltip"></div>
<div id="btn_expand" class="expand_btn">◀</div>
<div class="modal fade" id="div_deletePhotoModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Are you sure?</h4>
            </br>
            <p>This photo, along with any comments, will be deleted.</p>
          </div>
          <div class="modal-body">
            <form method="POST" action="database/delete.php?obj=photo&pid=<?php echo $pid; ?>" id="form-deletePhoto">
              <div class="form-group">
                <label for="username">Enter this photo's title.</label>
                <input class="form-control" type="text" id="input_deleteTitle">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Delete Photo</button>
          </div>
          </form>
        </div>
      </div>
</div>
<script src="js/photo.js"></script>
<script>
</script>

