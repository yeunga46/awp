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
    header("Location: /photosite/404.php");
    exit();
}

$comments = getComments($dbh, $_GET["pid"]);

$title = $photo[0]->title;

include("header.php");
?>

<div class="container-fluid">
    <div class="row">
        <div id="cb-container" class="col-lg-4 comment-box">
             <div class="comment-box-header" id="cbheader">
                <h2 id="header_title"><?php echo htmlspecialchars($photo[0]->title);?></h2>
                <p id="header_likes"><?php echo "Likes: ".$photo[0]->likes;?> </p>
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
                <hr>
             </div>
             <?php if(!is_null($comments) && !empty($comments)){  
                        for($i = 0; $i < count($comments); $i++) { ?>
                        <div id="comment-<?php echo $comments[$i]->comment_id; ?>">
                            <h5><b><?php $thisUser = $comments[$i]->uploader;
                            echo (isset($_SESSION['username']) && $thisUser == $_SESSION['username']) ? 'You' : $thisUser;?></b> said:</h5>
                            <p class="comment-text"><?php echo $comments[$i]->comment_text; ?></p>
                            
                            <?php if($_SESSION['login'] && $thisUser == $_SESSION['username']) { ?>
                                <button class="btn btn-info edit" id="edit-<?php echo $comments[$i]->comment_id; ?>">Edit Comment</button>
                                <a href="./comment.php?cid=<?php echo $comments[$i]->comment_id; ?>&pid=<?php echo $pid;?>&action=delete">
                                <button class="btn btn-danger">Remove Comment</button></a>
                            <?php } else if($_SESSION['login'] && $photo[0]->uploader == $_SESSION['username']) { ?>
                                     <a href="./comment.php?cid=<?php echo $comments[$i]->comment_id; ?>&pid=<?php echo $pid;?>&action=adminDelete">
                                     <button class="btn btn-danger" title="You can remove this comment if you find it offensive.">Remove Comment</button></a>
                            <?php } ?>

                            <p><em><?php echo $comments[$i]->comment_time;?></em></p>
                            <hr>
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

        <div class="text-center" width=500px>
            <img src='<?php echo str_replace(' ', '%20', $photo[0]->filelocation); ?>' height=500px>
        </div>
</div>
<div id="likes_tooltip" class="my_tooltip"></div>
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

    $('#likes_tooltip').hide();
    let commentPos = $('#cb-container').position();
    let commentWidth = $('#cb-container').outerWidth();
    let tooltipLikerLength = 3;
    let bodyHeight = $('#body').outerHeight();
    var btnY = commentPos.top + (bodyHeight/2) - 62.5;
    $('#btn_expand').css({
        position: 'absolute',
        top: btnY + "px",
        left: commentWidth + "px",
    })
    $('#cb-container').css({ height: bodyHeight });


    $.ajax({
            url: 'comment.php',
            type: 'GET',
            data: {action: 'liked', 'pid': <?php echo $pid; ?> },
            success: function(response)
            {
                if($.trim(response) === "true")
                {
                    $("#like").css("background-color", "#d43f3a").css("border-color", "#d43f3a");
                }
            }
        });
                
    $('#form-deletePhoto').on('submit', function(e) {
        if($('#input_deleteTitle').val() !== $.trim($('#header_title').innerhtml()))
        {
            alert('Make sure that you typed the title correctly and try again.');
            e.preventDefault();
        }
    });

    $('#header_likes').on('mouseover', function() {
        let pos = $('#header_likes').position();
        let height = $('#header_likes').outerHeight();
        let width = $('#header_likes').outerWidth();
        $.ajax({
            url:'comment.php',
            type: 'GET',
            data: {action: 'getLikers', pid: <?php echo $pid; ?>},
            success:function(response) {
                let likers = $.parseJSON($.trim(response));
                
                $('#likes_tooltip').html('Liked by: ');
                if(likers.length > 0)
                {
                    for(var i = 0; i < likers.length && i < tooltipLikerLength; i++)
                    {
                        (i != likers.length - 1) ? $('#likes_tooltip').append(likers[i] +', ') :  $('#likes_tooltip').append(likers[i]);
                    }
                    if(likers.length > tooltipLikerLength)
                    {
                        (likers.length - tooltipLikerLength === 1) ? $('#likes_tooltip').append('and ' + (likers.length - tooltipLikerLength) + ' other.') : $('#likes_tooltip').append('and ' + (likers.length - tooltipLikerLength) + ' others.')
                        
                    }
                $('#likes_tooltip').css({
                    top: pos.top*2.5 + "px",
                    left: (pos.left) + "px",}).show();
                }
            }});
    });

    $('#header_likes').on('mouseout', function() {
        $('#likes_tooltip').hide();
    });
    
    $('#like').on('click', function(e) {
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
                        $( "#header_likes" ).load(window.location.href + " #header_likes" );
                        $( "#like" ).css("background-color", "#5bc0de").css("border-color", "#5bc0de");
                         
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
                         $( "#header_likes" ).load(window.location.href + " #header_likes" );
                         $( "#like" ).css("background-color", "#d43f3a").css("border-color", "#d43f3a");
                         
                       }
                    });
                }
            }
        });

    });

    $('#btn_expand').on('click', function() {
        if($('#btn_expand').html() === "◀")
        {
            $('#btn_expand').html("▶");
            $('#cb-container').css({
                    width: 0 + "px",
                    height: 0 + "px",
                    transition: "1s",
                    overflow: "hidden",
                });
                setTimeout(() => {
                    $('#cb-container').hide();
                }, 999);

                $('#btn_expand').css({
                position: 'absolute',
                left: 0+ "px",
                transition: "1s"
                });
        }
        else
        {
            $('#cb-container').removeAttr('style');
            $('#cb-container').css({ height: bodyHeight, transition: 'width 1s'});
            $('#btn_expand').html("◀");
            $('#btn_expand').css({
                position: 'absolute',
                top: btnY + "px",
                left: commentWidth + "px",
            })
        }
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

