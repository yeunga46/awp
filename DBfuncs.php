<?php

/* This file has useful database functions in it for the photo
 * site.
 */

// ListAllPhones() - return an array of phone objects
// USAGE: $phonelist = ListAllPhones($dbh)
// $dbh is database handle
function ListAllUsers($dbh)
{
    // fetch the data
    try {
        // set up query
        $user_query = "SELECT * FROM photo_users";
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

// Upload() -  need to test after some questions of gow to store info
// USAGE: upload file location to database
// $dbh is database handle
function Upload($dbh,$file_location,$uid)
{
     try {

        $query = 'INSERT INTO `photo_files`(`filelocation`, `user_id`) ' .
                 'VALUES (:filelocation, :uid)';
        $stmt = $dbh->prepare($query);
		
        // Note each parameter must be bound separately
        $stmt->bindParam(':filelocation', $file_location);
		$stmt->bindParam(':uid', $uid);

        $stmt->execute();
        $inserted = $stmt->rowCount();

        $stmt = null;
    
        echo "<p>inserted $inserted record(s).</p>\n";

    }
    catch(PDOException $e)
    {
        die ('PDO error inserting(): ' . $e->getMessage() );
    }
}


// getUsername() - return username
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

// getUsername() - return true/false
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
        die ('PDO error in getUsername(): ' . $e->getMessage() );
    }
}

?>
