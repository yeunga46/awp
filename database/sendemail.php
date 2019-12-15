<?php
// access information in directory with no web access
require_once('database/Connect.php');
// other functions are right here
require_once('database/UserDBFuncs.php');
$dbh = ConnectDB();

if ( empty($_POST['username'])  || empty($_POST['email'])) {
  die("You did not fill in the form correctly.  Try again.");
}
if(checkUserExist($dbh, $_POST['username']) && checkEmailExist($dbh, $_POST['email'])){

  $host = "elvis.rowan.edu/~yeunga46/awp/photosite";
  $site = "Photosite";
  $link = "/password_reset.php";
  $myemail = "noreply@photosite.com";
  // Put together the confirmation ID:
  $now = time();
  $confirmcode = sha1("confirmation" . $now . $_POST['email']);
  $username=$_POST['username'];

  try {
    $query = "UPDATE photo_users SET reset_password = 1, confirm_code = :confirmcode " .
    "WHERE username=:username";
    $stmt = $dbh->prepare($query);
    // Note each parameter must be bound separately
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':confirmcode', $confirmcode);
    $stmt->execute();
    $stmt = null;
   
    // put together the email:
    $to      = $_POST['email'];
    $subject = "$site: Please reset Your Password.";
    $headers = "From: $myemail \r\n" .
    "Reply-To: $myemail \r\n" .
    'X-Mailer: PHP/' . phpversion() ;
    $message = "We heard that you lost your $site. Sorry about that!\r\n\r\n" .
    "But don’t worry! You can use the following link to reset your password:\r\n\r\n" .
    "http://$host$link?code=$confirmcode&u=$username \r\n";
    mail($to, $subject, $message, $headers);
    header("Location:start.php");
  }
  catch(PDOException $e){
    die ('PDO error Confrim Code For Resetting Password: ' . $e->getMessage() );
  }
}
else{
  die("Invalid username or email address.");
}
?>