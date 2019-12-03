<?php
#I suggest you refactor this into several files because its hard to figure out where each
#function is - do something like photoDBfuncs, userDBfuncs etc.
/* This file has useful database functions in it for the photo
 * site.
 */


// addComment() -  adds comment to table
// USAGE: 
// $dbh is database handle , $uid is user id, $pid is photo id, 
function addComment($dbh, $uid, $pid, $comment)
{
    try {

        $query = 'INSERT INTO photo_comments(user_id, photo_id, comment_text)' .
                 'VALUES (:uid, :pid, :comment)';
        $stmt = $dbh->prepare($query);
        
        // Note each parameter must be bound separately
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':pid', $pid);
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

// editComment() -  Update comment in table
// USAGE: 
// $dbh is database handle
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

// getComment() - return array of comments fo a photo
// USAGE: 
// $dbh is database handle
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

// checkCommentOwner() - return true/false
// USAGE: 
// $dbh is database handle
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


        // return $check;   
    }
    catch(PDOException $e)
    {
        die ('PDO error in getComments(): ' . $e->getMessage() );
    }
}

// deleteCommentAdmin() - delete comment only if photo ownwer 
// USAGE: 
// $dbh is database handle
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

// deleteComment() - delete comment only if input uid matches the comment uid
// USAGE: 
// $dbh is database handle
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


?>
