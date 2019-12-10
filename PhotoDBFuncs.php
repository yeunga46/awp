
<?php
#I suggest you refactor this into several files because its hard to figure out where each
#function is - do something like photoDBfuncs, userDBfuncs etc.
/* This file has useful database functions in it for the photo
 * site.
 */

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
        $inserted =$dbh->lastInsertId();
        $stmt = null;

        return $inserted;
    }
    catch(PDOException $e)
    {
        die ('PDO error Upload(): ' . $e->getMessage() );
    }
}


// getPhoto() - return array of phot0 info
// USAGE: 
// $dbh is database handle, $n_photos is the number of photos you want         
function getPhoto($dbh,$pid)
{
    // fetch the data
    try {
        
        $query = "SELECT photo_id, uploaddate, uploader, title, caption, filelocation, likes FROM photo_files WHERE  photo_id=:pid";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        $photo = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        return $photo;
    
    }
    catch(PDOException $e)
    {
        die ('PDO error in getPhoto(): ' . $e->getMessage() );
    }
}
// getLatestNumPhotos() - return array of latest n number of photos
// USAGE: 
// $dbh is database handle, $n_photos is the number of photos you want         
function getLatestNumPhotos($dbh,$n_photos)
{
    // fetch the data
    try {
        
        $query = "SELECT photo_id, uploaddate, uploader, title, caption, filelocation FROM photo_files WHERE title IS NOT NULL ORDER BY uploaddate DESC LIMIT " .$n_photos;
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
// USAGE: 
// $dbh is database handle,$n_size_unit is offset ,$limit_size is limit
// LIMIT 150 or LIMIT 0,150 : first 150 rows 0-150
// LIMIT 150,150 : next 150 rows 151-300
// LIMIT 300,150 : next 150 rows 301-450           
function getPhotosBetween($dbh,$n_size_unit,$limit_size)
{
    // fetch the data
    try {
        
        $query = "SELECT photo_id, uploaddate, uploader, title, caption, filelocation FROM photo_files WHERE title IS NOT NULL LIMIT  " . $n_size_unit . ", " . $limit_size;
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

// getPhotosByTitle() - return array of photos of user
// USAGE: 
// $dbh is database handle
function getPhotosByTitle($dbh,$title)
{
    $title = "%{$title}%";
    // fetch the data
    try {
       
        $query = "SELECT photo_id, uploaddate, uploader, title, caption, filelocation FROM photo_files " .
                       "WHERE title LIKE :title";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        $photos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt = null;

        return $photos;
    
    }
    catch(PDOException $e)
    {
        die ('PDO error in getPhotosByTitle(): ' . $e->getMessage() );
    }
}

// getUserPhotos() - return array of photos of user
// USAGE: 
// $dbh is database handle
function getUserPhotos($dbh,$uid)
{
    // fetch the data
    try {
       
        $query = "SELECT photo_id, uploaddate, uploader, title, caption, filelocation FROM photo_files " .
                       "WHERE  user_id=:uid AND title IS NOT NULL";
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

// checkPhotoOwner() - return true/false
// USAGE: 
// $dbh is database handle
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

// getPhotoLocation() - return photo location
// USAGE: 
// $dbh is database handle, $n_photos is the number of photos you want         
function getPhotoLocation($dbh,$pid)
{
    // fetch the data
    try {
        
        $query = "SELECT filelocation FROM photo_files WHERE photo_id=:pid";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        $location = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;

        // echo '<pre>'; print_r($location); echo '</pre>';

        return $location;
    
    }
    catch(PDOException $e)
    {
        die ('PDO error in getPhotoLocation(): ' . $e->getMessage() );
    }
}

// deletePhoto() - delete photo only if input uid matches the comment uid
// USAGE: 
// $dbh is database handle
function deletePhoto($dbh,$pid,$uid)
{
    if (checkPhotoOwner($dbh,$pid,$uid)){
        $location = getPhotoLocation($dbh, $pid);
        chmod($location, 0777);
        unlink($location);

        // fetch the data
        try {
           
            $query = "DELETE FROM photo_files WHERE photo_id = :pid";
            // prepare to execute
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':pid', $pid);
            $stmt->execute();
            $stmt = null;

        }
        catch(PDOException $e)
        {
            die ('PDO error in deletePhoto(): ' . $e->getMessage() );
        }
    }
}

// editPhotoCaption() - update photo caption
// USAGE: 
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
        die ('PDO error editPhotoCaption(): ' . $e->getMessage() );
    }
}

// getPhotoTotal() - return total number of photos that have a title
// USAGE: 
// $dbh is database handle, $n_photos is the number of photos you want         
function getPhotoTotal($dbh)
{
    // fetch the data
    try {
        
        $query = "SELECT COUNT(*) FROM photo_files WHERE title IS NOT NULL";
        // prepare to execute
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        $total = implode($stmt->fetchAll(PDO::FETCH_COLUMN, 0));
        $stmt = null;

        return $total;
    
    }
    catch(PDOException $e)
    {
        die ('PDO error in getPhotoTotal(): ' . $e->getMessage() );
    }
}
// getNTopLikePhotos() - return array of top n number of photos based on likes
// USAGE: 
// $dbh is database handle, $n_photos is the number of photos you want         
function getNTopLikePhotos($dbh,$n_photos)
{
    // fetch the data
    try {
        
        $query = "SELECT photo_id, uploaddate, uploader, title, caption, filelocation FROM photo_files WHERE title IS NOT NULL ORDER BY likes DESC LIMIT " .$n_photos;
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

?>
