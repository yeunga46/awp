<?php
/* This file has useful database functions in it for the photo
 * site table photo_user.
 */

// ListAllUsers() - return an array of user objects
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


// getProfilePicId() - return profile pic id from username
// $dbh is database handle, $username is username
function getProfilePicId($dbh, $username)
{
    // fetch the data
    try {
       
        $query = "SELECT profile_pic_id FROM photo_users " .
                       "WHERE  username=:username";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $ppid = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;

        return $ppid;
    }
    catch(PDOException $e)
    {
        die ('PDO error in getProfilePicId(): ' . $e->getMessage() );
    }
}
// setProfilePicId() - update the profile pic id of user
// $dbh is database handle,$ppid is profile pic id, $username is username
function setProfilePicId($dbh, $username, $ppid)
{

    try {
        $query = 'UPDATE photo_users SET profile_pic_id = :ppid ' .
                 'WHERE username=:username';
        $stmt = $dbh->prepare($query);

        // Note each parameter must be bound separately
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':ppid', $ppid);
        $stmt->execute();

        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error setProfilePicId(): ' . $e->getMessage() );
    }

}

// getUid() - return uid from username
// $dbh is database handle, $username is username
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
// $dbh is database handle, $uid is user id
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
// $dbh is database handle, $username is username
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
// $dbh is database handle, $email is email
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

// deleteFiles() - delete directory and files in it 
// USAGE: helper for deleteUser()
// $directory the directory of the user files
function deleteFiles($directory) {
    if(is_dir($directory))
    {
        $recursive = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($recursive, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                chmod($file->getRealPath(), 0777);
                rmdir($file->getRealPath());
            } else {
                chmod($file->getRealPath(), 0777);
                unlink($file->getRealPath());
            }
        }
        rmdir($directory);
    }
}

// deleteUser() - delete user if username and password is valid
// $dbh is database handle, $username is username, $pword password
function deleteUser($dbh, $username, $pword)
{
    if(checkPassword($dbh, $username, $pword)){
        #this only works if the user has uploaded files before

        deleteFiles("./UPLOADED/archive/". $username);
        // fetch the data
        try {
            $query = "DELETE FROM photo_users WHERE  username=:username";
            // prepare to execute
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $stmt = null;
        }
        catch(PDOException $e)
        {
            die ('PDO error in deleteUser(): ' . $e->getMessage() );
        }
    }
}

// checkPassword() - return true/false if password is valid with the table entry
// $dbh is database handle, $username is username, $pword password
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

// getProfile() -  return array of user info
// $dbh is database handle, $uid is user id
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

// getProfileByName() -  return  array of user info from username
// $dbh is database handle, $username is username
function getProfileByName($dbh, $username)
{
    $username = "%{$username}%";
    // fetch the data
    try {
        // set up query
        $query = "SELECT username, profile_pic_id, bio FROM photo_users WHERE username LIKE :username";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':username', $username);
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
        die ('PDO error in getProfileByName()": ' . $e->getMessage() );
    }
}

// checkReset() - return true/false if user can reset password with recovery link
// $dbh is database handle, $username username
function checkReset($dbh, $username)
{
    // fetch the data
    try {
       
        $query = "SELECT reset_password FROM photo_users " .
                       "WHERE  username=:username";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $reset = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;
        
        return $reset;
    }
    catch(PDOException $e)
    {
        die ('PDO error in checkReset(): ' . $e->getMessage() );
    }
}
// checkConfrimCode() - return true/false if confrim code is valid
// $dbh is database handle, $username is username, $code is confirmaton code
function checkConfrimCode($dbh,$username, $code)
{
    // fetch the data
    try {
       
        $query = "SELECT confirm_code FROM photo_users " .
                       "WHERE  username=:username";
        // prepare to execute
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $confirm_code = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;
        
        if ($code === $confirm_code ) {
            return true;
        } else {
            return false;
        } 

    }
    catch(PDOException $e)
    {
        die ('PDO error in checkConfrimCode(): ' . $e->getMessage() );
    }
}

?>
