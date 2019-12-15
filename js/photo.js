$().ready(function() {

    // grab the pid from the hidden input
    let pid = $('#hidden_pid').val();

    // set up the page
    $('#likes_tooltip').hide();

    // calculate coords for the expand / collapse button
    let commentPos = $('#cb-container').position();
    let commentWidth = $('#cb-container').outerWidth();
    let bodyHeight = $('#body').outerHeight();
    let btnY = commentPos.top + (bodyHeight/2) - 62.5;

    /* how many user names are shown in the tooltip 
     * before "and others" begins */
    let tooltipLikerLength = 3;

    //set the expand / collapse button's properties
    $('#btn_expand').css({
        position: 'absolute',
        top: btnY + "px",
        left: commentWidth + "px",
    });
    $('#cb-container').css({ height: bodyHeight });

    /* determine whether or not the photo has been liked;
     * set the like button's color accordingly */
    $.ajax({
            url: 'database/comment.php',
            type: 'GET',
            data: {action: 'liked', 'pid': pid },
            success: function(response)
            {
                if($.trim(response) === "true")
                {
                    $("#like")
                    .css("background-color", "#d43f3a")
                    .css("border-color", "#d43f3a");
                }
            }
        });

    /* make the likers tooltip pop up 
     * when the number of likes is moused-over */
    $('#header_likes').on('mouseover', function() 
    {
        // get the coords of the likes counter
        let pos = $('#header_likes').position();

        // get who actually liked the picture from the server
        $.ajax({
            url:'database/comment.php',
            type: 'GET',
            data: {action: 'getLikers', pid: pid},
            success:function(response) 
            {
                let likers = $.parseJSON($.trim(response));
                $('#likes_tooltip').html('Liked by: ');
                if(likers.length > 0)
                {
                    for(var i = 0; i < likers.length && i < tooltipLikerLength; i++)
                    {
                        (i != likers.length - 1) 
                        ? ( (likers[i] == "") 
                        ? $('#likes_tooltip').append('[deleted], ') 
                        : $('#likes_tooltip').append(likers[i] +', '))
                        : ( (likers[i] == "") 
                        ? $('#likes_tooltip').append('[deleted]') 
                        : $('#likes_tooltip').append(likers[i]));
                    }
                    if(likers.length > tooltipLikerLength)
                    {
                        (likers.length - tooltipLikerLength === 1) 
                        ? $('#likes_tooltip')
                          .append('and ' + (likers.length - tooltipLikerLength) + ' other.') 
                        : $('#likes_tooltip')
                          .append('and ' + (likers.length - tooltipLikerLength) + ' others.');
                    }
                // position the tooltip and make it appear
                $('#likes_tooltip').css({
                    top: pos.top*2.5 + "px",
                    left: (pos.left) + "px",}).show();
                }
            }});
    });
    
    // handle liking / unliking a photo when clicking the like button
    $('#like').on('click', function(e) {
        $.ajax({
            url: 'database/comment.php',
            type: 'GET',
            data: {action: 'liked', 'pid': pid},
            success: function(response)
            {
                if($.trim(response) === "true")
                {
                    $.ajax({
                        url:'database/comment.php',
                        type: 'GET',
                        data: {action: 'unlike', pid: pid},
                       success:function(html) {
                        $( "#header_likes" )
                        .load(window.location.href + " #header_likes" );
                        $( "#like" )
                        .css("background-color", "#5bc0de")
                        .css("border-color", "#5bc0de");
                       }
                    });
                }
                else
                {
                    $.ajax({
                        url:'database/comment.php',
                        type: 'GET',
                        data: {action: 'like', pid: pid},
                       success:function(html) 
                       {
                         $( "#header_likes" )
                         .load(window.location.href + " #header_likes" );
                         $( "#like" )
                         .css("background-color", "#d43f3a")
                         .css("border-color", "#d43f3a");
                       }
                    });
                }
            }
        });
    });
    // shows the edit comment form for a particular comment
    $('.edit').on('click', function() {
        let cid = this.id.replace('edit-', '');
        let oldCommentText = $('#comment-' + cid)
                             .children('.comment-text').html();
        $('#comment-' + cid).children('p').remove();
        $('#comment-' + cid).children('button').remove();
        $('#comment-' + cid).children('a').remove();
        $('#comment-' + cid).children('br').remove();
        let action = './comment.php?cid=' + cid + '&pid=' + pid + '&action=edit';
        let editCommentForm = $('<form/>', { action: action, method: 'POST'});
        let newComment = $('<textarea/>')
                         .attr('width', '100%')
                         .val(oldCommentText)
                         .attr('name','newComment');
        var submit = $('<button />')
                     .attr('type', 'submit')
                     .attr('class', 'btn btn-success')
                     .text('Submit changes');
        var cancel = $('<button />')
                     .attr('type', 'button')
                     .attr('class', 'btn btn-danger')
                     .text('Cancel')
                     .on('click', function() {location.reload();});
        editCommentForm.append(newComment);
        editCommentForm.append($('<br/>'));
        editCommentForm.append($('<br/>'));
        editCommentForm.append(submit);
        editCommentForm.append(cancel);
        $('#comment-' + cid).append(editCommentForm);
    });
    // handles showing / hiding the comment box on click
    $('#btn_expand').on('click', function() {
        if($('#btn_expand').html() === "◀")
        {
            $('#btn_expand').html("▶");
            $('#btn_expand').css({
                position: 'absolute',
                left: 0+ "px",
                transition: "1s"
            });
            $('#cb-container').css({
                    position: 'absolute',   
                    width: 0 + "px",
                    transition: "width 1s",
                    left:-10 +"px",
                    overflow: "hidden"
                });
            $('#photo-container').css({
                    'text-align': 'center',
                     width: 100 + '%' });
            setTimeout(() => {
                $('#cb-container').children().hide();
                $('#cb-container').css({
                    height: 0 + "px"
                });
                $('#cb-container').hide();
            }, 700);
    }
        else
        {
            $('#cb-container').show();
            $('#cb-container').children().show();
            $('#cb-container').removeAttr('style');
            $('#photo-container').removeAttr('style');
            $('#cb-container').css({ height: bodyHeight, transition: 'width 1s'});
            $('#btn_expand').html("◀");
            $('#btn_expand').css({
                position: 'absolute',
                top: btnY + "px",
                left: commentWidth + "px",
                transition: "1s"
            })
        }
    });
    // check that the user REALLY wanted to delete their photo               
    $('#form-deletePhoto').on('submit', function(e) {
        if($('#input_deleteTitle').val() !== $.trim($('#header_title').innerhtml()))
        {
            alert('Make sure that you typed the title correctly and try again.');
            e.preventDefault();
        }
    });
    // hides the like tooltip on mouse out
    $('#header_likes').on('mouseout onmouseleave', function() {
        $('#likes_tooltip').hide();
    });
});