<?php 
session_start();

require_once('Connect.php');
require_once('DBfuncs.php');

$dbh = ConnectDB();

$pid = $_GET["pid"];

$photo = getPhoto($dbh, $_GET["pid"]);

$comments = getComments($dbh, $_GET["pid"]);

$title = $photo[0]->title;

include("header.php");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 comment-box">
             <div class="comment-box-header">
                <h2><?php echo $photo[0]->title; 
                    if($_SESSION['login'])
                    {?>
                        <button class="btn btn-info" title="Like">👌</button></h2>
                    <?php } ?> </h2>
                <p>Uploaded by: <?php echo $photo[0]->uploader;?> on <?php echo $photo[0]->uploaddate; ?> </p>
                <p><em><?php echo $photo[0]->caption; ?></em></p>
             </div>
            </br>
             <?php if(!is_null($comments) && !empty($comments)){  
                        for($i = 0; $i < count($comments); $i++) { ?>
                        <div id="comment-<?php echo $comments[$i]->comment_id; ?>">
                            <h5><b><?php $thisUser = getUsername($dbh, $comments[$i]->user_id);
                            echo ($thisUser == $_SESSION['username']) ? 'You' : $thisUser;?></b> said:</h5>
                            <br/>
                            <p class="comment-text"><?php echo $comments[$i]->comment_text; ?></p>
                            <?php if($_SESSION['login'] && $thisUser == $_SESSION['username']) { ?>
                                <button class="btn btn-info edit" id="edit-<?php echo $comments[$i]->comment_id; ?>">Edit Comment</button>
                                <a href="./deleteComment.php?cid=<?php echo $comments[$i]->comment_id; ?>&pid=<?php echo $pid;?>">
                                <button class="btn btn-danger">Remove Comment</button></a>
                            <?php } ?>
                            <br/>
                            <br/>
                            <p><em><?php echo $comments[$i]->comment_time;?></em></p>
                        </div>
                    <?php }} if($_SESSION['login']) {?>
                <form method="post" enctype="multipart/form-data" action="./addComment.php?pid=<?php echo $pid; ?>">
                    <div class="form-group">
                        <p><em>Commenting as <?php echo $_SESSION['username'];?></em></p>
                        <textarea style="width: 100%;" name="comment"></textarea>
                        <br/>
                        <br/>
                        <button type="submit" class="btn btn-success">Submit comment</button>
                    </div>
                </form>
                <?php } else { ?>
                <div><em>You must register an account to comment on this website.</em></div>
                <?php }?>
        </div>
        <div class="col-lg-4 text-center">
            <img src='<?php echo str_replace(' ', '%20', $photo[0]->filelocation); ?>' height=500px>
        </div>
    </div>
</div>
<script>
$('.edit').on('click', function() {
    let cid = this.id.replace('edit-', '');
    let oldCommentText = $('#comment-' + cid).children('.comment-text').html();
    $('#comment-' + cid).children('p').remove();
    $('#comment-' + cid).children('button').remove();
    $('#comment-' + cid).children('a').remove();
    $('#comment-' + cid).children('br').remove();
    let action = './editComment.php?cid=' + cid + "&pid=<?php echo $pid; ?>";
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

</script>
