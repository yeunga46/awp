<?php

/* This file has useful database functions in it for the phone
 * project.
 */

// ListAllPhones() - return an array of phone objects
// USAGE: $phonelist = ListAllPhones($dbh)
// $dbh is database handle
function ListAllPhones($dbh)
{
    // fetch the data
    try {
        // set up query
        $phone_query = "SELECT name, phone FROM phonelist";
        // prepare to execute (this is a security precaution)
        $stmt = $dbh->prepare($phone_query);
        // run query
        $stmt->execute();
        // get all the results from database into array of objects
        $phonedata = $stmt->fetchAll(PDO::FETCH_OBJ);
        // release the statement
        $stmt = null;

        return $phonedata;
    }
    catch(PDOException $e)
    {
        die ('PDO error in ListAllPhones()": ' . $e->getMessage() );
    }
}


// ListMatchingPhones() - return an array of phone objects
// USAGE: $phonelist = ListAllPhones($dbh, $name)
// $dbh is database handle, $name is what to search
function ListMatchingPhones($dbh, $name)
{
    // fetch the data
    try {
        // Note use of ":name" in query as placeholder
        $phone_query = "SELECT name, phone FROM phonelist " .
                       "WHERE  name like :name";
        // prepare to execute
        $stmt = $dbh->prepare($phone_query);

        // bind $name to :name placeholder
        // Note use of "%" as wildcard, same as "*" for shell
        // or ".*" in sed/grep.
        $match = "%$name%";
        $stmt->bindParam('name', $match);

        $stmt->execute();
        $phonedata = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        return $phonedata;
    }
    catch(PDOException $e)
    {
        die ('PDO error in ListMatchingPhones(): ' . $e->getMessage() );
    }
}

?>
