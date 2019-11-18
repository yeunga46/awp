<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
    <title>Web Database Sample Display</title>
</head> 
<body>

<h1>Data from userlist</h1>
<?php

// access information in directory with no web access
require_once('Connect.php');

// other functions are right here
require_once('DBfuncs.php');


$dbh = ConnectDB();

$userlist = ListAllUsers($dbh);

echo "<p>Here is the data:<p>\n";
$counter = 0;
foreach ( $userlist as $number ) {
    $counter++;
}

echo "<p> $counter record(s) returned.<p>\n";

// uncomment next line for debugging
echo '<pre>'; print_r($userlist); echo '</pre>';



echo "<p> Comments<p>\n";

$comments = getComments($dbh,0);
// addComment($dbh,22,0,"hello world");
// editComment($dbh,2,0,22,"Howdy");
echo '<pre>'; print_r($comments); echo '</pre>';

echo "<p> user photos<p>\n";

$photos = getUserPhotos($dbh,6);
// addComment($dbh,22,0,"hello world");
// editComment($dbh,2,0,22,"Howdy");
echo '<pre>'; print_r($photos); echo '</pre>';
// changePassword($dbh, "tester", "test", "testing");
// changePassword($dbh, "tester", "testing", "test");

?>



</body>
</html>
