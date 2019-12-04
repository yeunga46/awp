<?php
// Variable to check
// $email = "john.doe@as.net";
$email = $_POST['email'];

// Remove all illegal characters from email
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// Validate e-mail
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo("true");
} else {
    echo("false");
}
?> 