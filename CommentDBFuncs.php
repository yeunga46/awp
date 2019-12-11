<?php

/* This file has useful database functions in it for the photo
 * site for the tables likes and photo_comments.
 */



// addComment() - adds comment to table photo_comments.
// $dbh is database handle , $uid is user id, $pid is photo id, $uploader is user name , $comment is comment
function addComment($dbh, $uid, $pid,$uploader, $comment)
{
    try {

        $query = 'INSERT INTO photo_comments(user_id, photo_id,  uploader, comment_text)' .
                 'VALUES (:uid, :pid, :uploader, :comment)';
        $stmt = $dbh->prepare($query);
        
        // Note each parameter must be bound separately
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':uploader', $uploader);
        $stmt->bindParam(':comment', $comment);

        $stmt->execute();
        $inserted = $stmt->rowCount();

        $stmt = null;
    

    }
    catch(PDOException $e)
    {
        die ('PDO error addComment(): ' . $e->getMessage() );
    }
}

// editComment() -  Update comment in table photo_comments.
// $dbh is database handle , $uid is user id, $pid is photo id, $cid is comment id, $comment is comment
function editComment($dbh, $cid, $pid, $uid, $comment)
{
    try {

        $query = 'UPDATE photo_comments SET comment_text = :comment ' .
                 'WHERE comment_id =:cid AND photo_id =:pid AND user_id =:uid';
        $stmt = $dbh->prepare($query);

        // Note each parameter must be bound separately
        $stmt->bindParam(':cid', $cid);
        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':comment', $comment);

        $stmt->execute();

        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error editComment(): ' . $e->getMessage() );
    }
}

// getComment() - return array of comments for a photo
// $dbh is database handle, $pid is photo id
function getComments($dbh,$pid)
{
    // fetch the data
    try {
       
        $query = "SELECT * FROM photo_comments " .
                       "WHERE  photo_id=:pid";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        return $comments;   
    }
    catch(PDOException $e)
    {
        die ('PDO error in getComments(): ' . $e->getMessage() );
    }
}

// checkCommentOwner() - return true/false if photo_comment table user id  matches input user id 
// $dbh is database handle, $uid is user id, $cid is comment id
function checkCommentOwner($dbh,$cid,$uid)
{
    // fetch the data
    try {
       
        $query = "SELECT user_id FROM photo_comments WHERE comment_id = :cid";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':cid', $cid);
        $stmt->execute();
        $check = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;

        // echo '<pre>'; print_r($check); echo '</pre>';

        if ($check == $uid ) {
            return true;
        } else {
            return false;
        } 

    }
    catch(PDOException $e)
    {
        die ('PDO error in getComments(): ' . $e->getMessage() );
    }
}

// deleteCommentAdmin() - allows deletion of every comment only if photo ownwer 
// $dbh is database handle, $uid is user id, $pid is photo id, $cid is comment id,
function deleteCommentAdmin($dbh, $cid, $pid, $uid)
{
    if (checkPhotoOwner($dbh, $pid, $uid)){
        // fetch the data
        try {
           
            $query = "DELETE FROM photo_comments WHERE comment_id = :cid";
            // prepare to execute
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':cid', $cid);
            $stmt->execute();
            $stmt = null;

        }
        catch(PDOException $e)
        {
            die ('PDO error in deleteCommentAdmin(): ' . $e->getMessage() );
        }
    }
}

// checkPhotoOwner() - return true/false if photo is owned by user
// $dbh is database handle, $uid is user id, $pid is photo id
function checkPhotoOwner($dbh,$pid,$uid)
{
    // fetch the data
    try {
       
        $query = "SELECT user_id FROM photo_files WHERE photo_id = :pid";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        $check = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;

        // echo '<pre>'; print_r($check); echo '</pre>';

        if ($check == $uid ) {
            return true;
        } else {
            return false;
        } 

    }
    catch(PDOException $e)
    {
        die ('PDO error in checkPhotoOwner(): ' . $e->getMessage() );
    }
}



// deleteComment() - delete comment only if input uid matches the comment uid
// $dbh is database handle, $uid is user id, $cid is comment id,
function deleteComment($dbh,$cid,$uid)
{
    if (checkCommentOwner($dbh,$cid,$uid)){
        // fetch the data
        try {
           
            $query = "DELETE FROM photo_comments WHERE comment_id = :cid";
            // prepare to execute
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':cid', $cid);
            $stmt->execute();
            $stmt = null;

        }
        catch(PDOException $e)
        {
            die ('PDO error in deleteComment(): ' . $e->getMessage() );
        }
    }
}
// like() - insert a unique input that didn't exist into likes table
// USAGE: 
// $dbh is database handle, $uid is user id, $pid is photo id
function like($dbh,$pid,$uid)
{
    try {
       
        $query = "INSERT INTO likes (photo_id, user_id)".
        " SELECT * FROM (SELECT :pid, :uid) AS tmp WHERE NOT EXISTS ".
        "(SELECT photo_id, user_id FROM likes WHERE photo_id = :pid AND user_id = :uid) LIMIT 1";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error in like(): ' . $e->getMessage() );
    }
}

// unlike() - deletes a like only if input uid and pid matches the like uid and pid
// $dbh is database handle, $uid is user id, $pid is photo id
function unlike($dbh,$pid,$uid)
{
    try {
       
        $query = "DELETE FROM likes WHERE photo_id = :pid AND user_id = :uid";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error in unlike(): ' . $e->getMessage() );
    }
}
// liked() - return true/false if liked photo like by a user
// $dbh is database handle, $uid is user id, $pid is photo id
function liked($dbh,$pid,$uid)
{
    // fetch the data
    try {
       
        $query = "SELECT 1 FROM likes WHERE photo_id = :pid AND user_id = :uid";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':uid', $uid);

        $stmt->execute();
        $check = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        // echo '<pre>'; print_r($check); echo '</pre>';
        if ($check) {

            return true;
        } else {
            return false;
        } 
    }
    catch(PDOException $e)
    {
        die ('PDO error in liked(): ' . $e->getMessage() );
    }
}

function getLikers($dbh, $pid)
{
    try {
        $query = "SELECT * FROM likes WHERE photo_id = :pid";
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        $likers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;
        return $likers;
    }
    catch(PDOException $e)
    {
        die ('PDO error in liked(): ' . $e->getMessage() );
    }
}
?>
