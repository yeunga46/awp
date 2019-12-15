<?php
# handles user registration
session_start();

// access information in directory with no web access
require_once('Connect.php');
require_once('UserDBFuncs.php');
$dbh = ConnectDB();
// was a name and phone entered?
if ( isset($_POST['username'])   &&  !empty($_POST['username'])   && 
     isset($_POST['email'])  &&  !empty($_POST['email'])      && 
     isset($_POST['pword'])  &&  !empty($_POST['pword'])     ){

    try {
        $query = 'INSERT INTO photo_users (username, password, email) ' .
                 'VALUES (:username, :en_password, :email)';
        $stmt = $dbh->prepare($query);

        // Copying $_POST[] values to local variables, so nothing
        // happens to values in $_POST[] array.
        // Another way to do this is to use bindValue(), which
        // is pass-by-value, not pass-by-reference.
        $username = $_POST['username'];
        $email = $_POST['email'];
		$pword = $_POST['pword'];
		$en_password = password_hash( $pword, PASSWORD_DEFAULT );

        // Note each parameter must be bound separately
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
		$stmt->bindParam(':en_password', $en_password);

        $stmt->execute();
        $inserted = $stmt->rowCount();

        $stmt = null;
    
        // echo "<p>inserted $inserted record(s).</p>\n";

        # make sure to log in after registering

        $_SESSION['time']    = time();
		$_SESSION['username'] =  $username;
		$_SESSION['uid']  =  getUid($dbh, $username);
		$_SESSION['login'] =  True;
        session_write_close();

        header("Location:start.php");

    }
    catch(PDOException $e)
    {
        die ('PDO error inserting(): ' . $e->getMessage() );
    }
}
?>