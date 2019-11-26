<?php

if ( empty($_POST['username'])  ||
     empty($_POST['email'])) {
    die("You did not fill in the form correctly.  Try again.");
}


$host = "elvis.rowan.edu/~yeunga46/awp/photosite";
$site = "Photosite";
$link = "/password_reset.php";
$myemail = "yeunga46@students.rowan.edu";

// Put together the confirmation ID:
$now = time();
$confirmcode = sha1("confirmation" . $now . $_POST['email']);

// put together the email:
$to      = $_POST['email'];
$subject = "$site: Please reset Your Password.";
$headers = "From: $myemail \r\n" .
           "Reply-To: $myemail \r\n" .
           'X-Mailer: PHP/' . phpversion() ;
$message = "We heard that you lost your $site. Sorry about that!\r\n\r\n" .
           "But don’t worry! You can use the following link to reset your password:\r\n\r\n" .
           "http://$host$link?code=$confirmcode \r\n";

mail($to, $subject, $message, $headers);


?>

<p>
A link for resetting your password has been sent to "<?php echo $_POST['email'];?>".
</p>

