<?php
// checkemail.php
// 
// D Provine, 4 August 2013


// Check the form was filled in correctly
if ( !isset($_POST['username'])  ||
     !isset($_POST['email1'])  ||
     !isset($_POST['email2'])     ) {
    die("You did not fill in the form correctly.  Try again.");
}

if ( $_POST['email1'] != $_POST['email2'] ) {
    die("Email addresses don't match.  Try again.");
}


# SYNTAX ERROR


$host = "localhost/photosite/";
$site = "Email Checkers Incorporated";
$confirmsite = "/confirm.php";
$myemail = "yeunga46@students.rowan.edu";

// Put together the confirmation ID:
$now = time();
$confirmcode = sha1("confirmation" . $now . $_POST['email1']);

// put together the email:
$to      = $_POST['email1'];
$subject = "$site: Verify Your Registration.";
$headers = "From: $myemail \r\n" .
           "Reply-To: $myemail \r\n" .
           'X-Mailer: PHP/' . phpversion() ;
$message = "Welcome to $site!\r\n\r\n" .
           "To confirm your username, please click this link:\r\n\r\n" .
           "http://$host$confirmsite?code=$confirmcode \r\n" .
           "(If you did not register at $site, \r\n" .
           "just ignore this message.)\r\n";

mail($to, $subject, $message, $headers);

?>

<p>
Down here you'd probably put a message like "I have sent email to
the address you gave" or something.
</p>

