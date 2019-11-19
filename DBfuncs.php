<?php

/* This file has useful database functions in it for the photo
 * site.
 */

// ListAllUsers() - return an array of user objects
// USAGE: $userlist = ListAllUsers($dbh)
// $dbh is database handle
function ListAllUsers($dbh)
{
    // fetch the data
    try {
        // set up query
        $user_query = "SELECT user_id, username FROM photo_users";
        // prepare to execute (this is a security precaution)
        $stmt = $dbh->prepare($user_query);
        // run query
        $stmt->execute();
        // get all the results from database into array of objects
        $userdata = $stmt->fetchAll(PDO::FETCH_OBJ);
        // release the statement
        $stmt = null;

        return $userdata;
    }
    catch(PDOException $e)
    {
        die ('PDO error in ListAllUsers()": ' . $e->getMessage() );
    }
}

// Upload() - upload file location  and othe information to database
// USAGE: 
// $dbh is database handle, $file_location is file location,$uid is user id,
// $uploader is username of uploader,$caption is photo caption,$title is photo title
function Upload($dbh,$file_location,$uid,$uploader,$caption,$title)
{
    try {

        $query = 'INSERT INTO photo_files(filelocation, user_id, uploader, caption, title) ' .
                 'VALUES (:filelocation, :uid, :uploader,:caption, :title)';
        $stmt = $dbh->prepare($query);
    	
        // Note each parameter must be bound separately
        $stmt->bindParam(':filelocation', $file_location);
    	$stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':uploader', $uploader);
        $stmt->bindParam(':caption', $caption);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        $inserted = $stmt->rowCount();

        $stmt = null;

        // echo "<p>inserted $inserted record(s).</p>\n";
    }
    catch(PDOException $e)
    {
        die ('PDO error Upload(): ' . $e->getMessage() );
    }
}

// getUid() - return uid from username
// USAGE: $username = getUid($dbh, $username)
// $dbh is database handle, $username is what to search
function getUid($dbh, $username)
{
    // fetch the data
    try {
       
        $query = "SELECT user_id FROM photo_users " .
                       "WHERE  username=:username";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $uid = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;

        return $uid;
    }
    catch(PDOException $e)
    {
        die ('PDO error in getUid(): ' . $e->getMessage() );
    }
}

// getUsername() - return username from uid
// USAGE: $username = getUsername($dbh, $uid)
// $dbh is database handle, $uid is what to search
function getUsername($dbh, $uid)
{
    // fetch the data
    try {
       
        $query = "SELECT username FROM photo_users " .
                       "WHERE  user_id=:uid";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':uid', $uid);

        $stmt->execute();
        $username = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;

        return $username;
    }
    catch(PDOException $e)
    {
        die ('PDO error in getUsername(): ' . $e->getMessage() );
    }
}

// checkUserExist() - return true/false if user exist
// USAGE: $bool = checkUserExist($dbh, $username)
// $dbh is database handle, $username is what to search
function checkUserExist($dbh, $username)
{
    // fetch the data
    try {
       
        $query = "SELECT 1 FROM photo_users WHERE username = :username";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':username', $username);

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
        die ('PDO error in checkUserExist(): ' . $e->getMessage() );
    }
}

// checkEmailExist() - return true/false if email exist
// USAGE: $bool = checkEmailExist($dbh, $email)
// $dbh is database handle, $email is what to search
function checkEmailExist($dbh, $email)
{
    // fetch the data
        try {
       
        $query = "SELECT 1 FROM photo_users WHERE email = :email";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':email', $email);

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
        die ('PDO error in checkEmailExist(): ' . $e->getMessage() );
    }
}

// getUsername() - return true/false if password is valid
// USAGE: $bool = checkPassword($dbh, $username, $pword)
// $dbh is database handle, $username is what to search, $pword check against
function checkPassword($dbh, $username, $pword)
{
    // fetch the data
    try {
       
        $query = "SELECT password FROM photo_users " .
                       "WHERE  username=:username";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $en_password = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;
		
        return password_verify( $pword, $en_password );
    }
    catch(PDOException $e)
    {
        die ('PDO error in checkPassword(): ' . $e->getMessage() );
    }
}

// changePassword() - changes the password if the old password is valid
// USAGE: 
// $dbh is database handle,$pwd is old password, $new_pwd is new password
function changePassword($dbh, $username, $pwd, $new_pwd)
{
    if (checkPassword($dbh, $username, $pwd)){
        try {
            $en_password = password_hash( $new_pwd, PASSWORD_DEFAULT );
            $query = 'UPDATE photo_users SET password = :new_pwd ' .
                     'WHERE username=:username';
            $stmt = $dbh->prepare($query);

            // Note each parameter must be bound separately
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':new_pwd', $en_password);

            $stmt->execute();

            $stmt = null;

        }
        catch(PDOException $e)
        {
            die ('PDO error changePassword(): ' . $e->getMessage() );
        }
    }
}

// editProfile() - update user bio
// USAGE: 
// $dbh is database handle
function editProfile($dbh, $uid, $bio)
{
    try {

        $query = 'UPDATE photo_users SET bio = :bio ' .
                 'WHERE user_id =:uid';
        $stmt = $dbh->prepare($query);

        // Note each parameter must be bound separately
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':bio', $bio);

        $stmt->execute();

        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error editProfile(): ' . $e->getMessage() );
    }
}

// getProfile() -  return user info
// USAGE: 
// $dbh is database handle
function getProfile($dbh, $uid)
{
    // fetch the data
    try {
        // set up query
        $query = 'SELECT username, profile_pic_id, bio FROM photo_users ' .
                 'WHERE user_id =:uid';
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':uid', $uid);
        // run query
        $stmt->execute();
        // get all the results from database into array of objects
        $userdata = $stmt->fetchAll(PDO::FETCH_OBJ);
        // release the statement
        $stmt = null;

        return $userdata;
    }
    catch(PDOException $e)
    {
        die ('PDO error in getProfile()": ' . $e->getMessage() );
    }
}

// addComment() -  adds comment to table
// USAGE: upload file location to database
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
// USAGE: upload file location to database
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
// USAGE: upload file location to database
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

// getLatestNumPhotos() - return array of latest n number of photos
// USAGE: upload file location to database
// $dbh is database handle, $n_photos is the number of photos you want         
function getLatestNumPhotos($dbh,$n_photos)
{
    // fetch the data
    try {
        
        $query = "SELECT photo_id, uploaddate, uploader, title, caption, filelocation FROM photo_files ORDER BY uploaddate LIMIT " .$n_photos;
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $photos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        return $photos;
    
    }
    catch(PDOException $e)
    {
        die ('PDO error in getLatestNumPhotos(): ' . $e->getMessage() );
    }
}

// getPhotosBetween() - return array of photos between x to x + n
// USAGE: upload file location to database
// $dbh is database handle,$n_size_unit is offset ,$limit_size is limit
// LIMIT 150 or LIMIT 0,150 : first 150 rows 0-150
// LIMIT 150,150 : next 150 rows 151-300
// LIMIT 300,150 : next 150 rows 301-450           
function getPhotosBetween($dbh,$n_size_unit,$limit_size)
{
    // fetch the data
    try {
        
        $query = "SELECT photo_id, uploaddate, uploader, caption, filelocation FROM photo_files LIMIT  " . $n_size_unit . ", " . $limit_size;
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $photos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        return $photos;
    
    }
    catch(PDOException $e)
    {
        die ('PDO error in getPhotosBetween(): ' . $e->getMessage() );
    }
}

// getUserPhotos() - return array of photos of user
// USAGE: upload file location to database
// $dbh is database handle
function getUserPhotos($dbh,$uid)
{
    // fetch the data
    try {
       
        $query = "SELECT photo_id, uploaddate, uploader, caption, filelocation FROM photo_files " .
                       "WHERE  user_id=:uid";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $photos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        return $photos;
    
    }
    catch(PDOException $e)
    {
        die ('PDO error in getUserPhotos(): ' . $e->getMessage() );
    }
}

// editPhotoCaption() - update photo caption
// USAGE: upload file location to database
// $dbh is database handle
function editPhotoCaption($dbh, $cid, $pid, $uid, $caption)
{
    try {

        $query = 'UPDATE photo_files SET caption = :caption ' .
                 'WHERE photo_id =:pid AND user_id =:uid';
        $stmt = $dbh->prepare($query);

        // Note each parameter must be bound separately
        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':caption', $caption);

        $stmt->execute();

        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error inserting(): ' . $e->getMessage() );
    }
}

?>
