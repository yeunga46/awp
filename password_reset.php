<?php
// access information in directory with no web access
require_once('Connect.php');

// other functions are right here
require_once('DBfuncs.php');


// die("The confirmation code I got was " . $_GET['code'] . ". " .
//     "But I don't have a database or anything to check it against.");

if ( $_POST['pwd1'] != $_POST['pwd2'] ) {
    die("Password doesn't match.  Try again.");
}
else{
    try {
        $en_password = password_hash( $_POST['pwd1'], PASSWORD_DEFAULT );
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
        die ('PDO error Resetting Password: ' . $e->getMessage() );
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Reset your password</title>
  <meta charset="utf-8" />
</head>

<body>

<h1>Reset your password</h1>

<p>
Don't worry! You may have forgotten your password, but we can help you out. Enter your username below and we'll email you a link to reset your password. 
</p>


<form action="./sendemail.php" method="post">
<fieldset>
<table>
    <tr>
        <td> Username: </td>
        <td> <input name="username" type="text" /> </td>
    </tr>
    <tr>
        <td> E-mail Address: </td>
        <td> <input name="email" type="text" /> </td>
    </tr>
    <tr>
         <td><input type="submit" />  </td>
    </tr>
</table>
</fieldset>
</form>



</body>
</html>
