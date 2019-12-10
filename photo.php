<?php 
session_start();

require_once('Connect.php');
require_once('UserDBFuncs.php');
require_once('PhotoDBFuncs.php');
require_once('CommentDBFuncs.php');

$dbh = ConnectDB();

$pid = $_GET["pid"];

$photo = getPhoto($dbh, $_GET["pid"]);
if(empty($photo)){

    header('HTTP/1.1 404 Not Found');
    ?>  <img src='./res/404.png' height=500px><?php 
    exit();
}

$comments = getComments($dbh, $_GET["pid"]);

$title = $photo[0]->title;

include("header.php");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 comment-box float-left">
             <div class="comment-box-header" id="cbheader">
                <h2 id="header_title"><?php echo htmlspecialchars($photo[0]->title);?></h2>
                <h3 id="header_likes"><?php echo "Likes:".$photo[0]->likes;?> </h3>
                <?php
                    if($_SESSION['login'])
                    {?>
                        <button class="btn btn-info like" id="like" title="Like">👌</button>
                    <?php } 
                    if($_SESSION['login'] && $_SESSION['username'] == $photo[0]->uploader){ ?> 
                        <button class="btn btn-danger" title="Delete Photo" 
                        data-toggle="modal" data-target="#div_deletePhotoModal"type="button">
                        Delete Photo</button>
                    <?php }?> 
                <br></br><p>Uploaded by: <?php echo '<a href="./u/'; echo $photo[0]->uploader; echo '" >'; echo $photo[0]->uploader; echo '</a>';?> on <?php echo $photo[0]->uploaddate; ?> </p>
                <p><em><?php echo htmlspecialchars($photo[0]->caption); ?></em></p>
             </div>
            <br></br>
             <?php if(!is_null($comments) && !empty($comments)){  
                        for($i = 0; $i < count($comments); $i++) { ?>
                        <div id="comment-<?php echo $comments[$i]->comment_id; ?>">
                            <h5><b><?php $thisUser = getUsername($dbh, $comments[$i]->user_id);
                            echo (isset($_SESSION['username']) && $thisUser == $_SESSION['username']) ? 'You' : $thisUser;?></b> said:</h5>
                            <br/>
                            <p class="comment-text"><?php echo $comments[$i]->comment_text; ?></p>
                            <?php if($_SESSION['login'] && $thisUser == $_SESSION['username']) { ?>
                                <button class="btn btn-info edit" id="edit-<?php echo $comments[$i]->comment_id; ?>">Edit Comment</button>
                                <a href="./comment.php?cid=<?php echo $comments[$i]->comment_id; ?>&pid=<?php echo $pid;?>&action=delete">
                                <button class="btn btn-danger">Remove Comment</button></a>
                            <?php } ?>
                            <br/>
                            <br/>
                            <p><em><?php echo $comments[$i]->comment_time;?></em></p>
                        </div>
                <?php }} if($_SESSION['login']) {?>
                 <form method="post" enctype="multipart/form-data" action="./comment.php?action=add&pid=<?php echo $pid; ?>">
                    <div class="form-group">
                        <p><em>Commenting as <?php echo $_SESSION['username'];?></em></p>
                        <textarea style="width: 100%;" name="comment"></textarea>
                        <br>
                        <br/>
                        <button type="submit" class="btn btn-success">Submit comment</button>
                    </div>
                </form>
                <?php } else { ?>
                <div><em>You must register an account to comment on this website.</em></div>
                <?php }?>
        </div>
        <div class="col-lg-4 float-left">
            <img src='<?php echo str_replace(' ', '%20', $photo[0]->filelocation); ?>' height=500px>
        </div>
</div>
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
          <!-- again, no way to delete photos-->
            <form method="POST" action="./delete.php?obj=photo&pid=<?php echo $pid; ?>" id="form-deletePhoto">
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

<script>
$().ready(function () {
    $('#form-deletePhoto').on('submit', function(e) {
        if($('#input_deleteTitle').val() !== $.trim($('#header_title').innerhtml()))
        {
            alert('Make sure that you typed the title correctly and try again.');
            e.preventDefault();
        }
    });
    
    $(document).on('click','.like', function(e) {
        $.ajax({
            url: 'comment.php',
            type: 'GET',
            data: {action: 'liked', 'pid': <?php echo $pid; ?> },
            success: function(response)
            {
                if($.trim(response) === "true")
                {
                    $.ajax({
                        url:'comment.php',
                        type: 'GET',
                        data: {action: 'unlike', pid: <?php echo $pid; ?>},
                       success:function(html) {
                         $( "#cbheader" ).load(window.location.href + " #cbheader" );
                       }
                    });
                }
                else
                {
                    $.ajax({
                        url:'comment.php',
                        type: 'GET',
                        data: {action: 'like', pid: <?php echo $pid; ?>},
                       success:function(html) {
                         $( "#cbheader" ).load(window.location.href + " #cbheader" );
                       }
                    });
                }
            }
        });

    });

    $('.edit').on('click', function() {
        let cid = this.id.replace('edit-', '');
        let oldCommentText = $('#comment-' + cid).children('.comment-text').html();
        $('#comment-' + cid).children('p').remove();
        $('#comment-' + cid).children('button').remove();
        $('#comment-' + cid).children('a').remove();
        $('#comment-' + cid).children('br').remove();
        let action = './comment.php?cid=' + cid + "&pid=<?php echo $pid; ?>&action=edit";
        let editCommentForm = $('<form/>', { action: action, method: 'POST'});
        let newComment = $('<textarea/>').attr('width', '100%').val(oldCommentText).attr('name','newComment');
        var submit = $('<button />').attr('type', 'submit').attr('class', 'btn btn-success').text('Submit changes');
        var cancel = $('<button />').attr('type', 'button').attr('class', 'btn btn-danger').text('Cancel').on('click', function() {location.reload();});

        editCommentForm.append(newComment);
        editCommentForm.append($('<br/>'));
        editCommentForm.append($('<br/>'));
        editCommentForm.append(submit);
        editCommentForm.append(cancel);
        $('#comment-' + cid).append(editCommentForm);
    });
});

</script>
