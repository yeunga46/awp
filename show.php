<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
    <title>Web Database Sample Display</title>
</head> 
<body>

<h1>Quick testing</h1>
<?php

// access information in directory with no web access
require_once('Connect.php');

// other functions are right here
require_once('PhotoDBFuncs.php');
require_once('UserDBFuncs.php');
require_once('CommentDBFuncs.php');



// $dbh = ConnectDB();

// $userlist = ListAllUsers($dbh);

// echo "<p>Here is the data:<p>\n";
// $counter = 0;
// foreach ( $userlist as $number ) {
//     $counter++;
// }

// echo "<p> $counter record(s) returned.<p>\n";

// uncomment next line for debugging
// echo '<pre>'; print_r($userlist); echo '</pre>';

// echo "<p> Comments<p>\n";

// $comments = getComments($dbh,3);
// addComment($dbh,22,0,"hello world");
// editComment($dbh,2,0,22,"Howdy");
// echo '<pre>'; print_r($comments); echo '</pre>';

// echo "<p> user profile and photo test<p>\n";

// $profile = getProfile($dbh,22);
// addComment($dbh,22,0,"hello world");
// // editComment($dbh,2,0,22,"Howdy");
// echo '<pre>'; print_r($profile); echo '</pre>';
// changePassword($dbh, "tester", "test", "testing");
// changePassword($dbh, "tester", "testing", "test");
// $photos = getUserPhotos($dbh,6);
// echo '<pre>'; print_r($photos); echo '</pre>';


// echo "<p> user check test<p>\n";

// $bool_val = checkUserExist($dbh,"test9");
// echo '<pre>'; echo $bool_val ? 'true' : 'false'; echo '</pre>';
// $bool_val = checkUserExist($dbh,"test");
// echo '<pre>'; echo $bool_val ? 'true' : 'false'; echo '</pre>';

// echo "<p> email check test<p>\n";

// $bool_val = checkEmailExist($dbh,"tes.ting.com");
// echo '<pre>'; echo $bool_val ? 'true' : 'false'; echo '</pre>';
// $bool_val = checkEmailExist($dbh,"test");
// echo '<pre>'; echo $bool_val ? 'true' : 'false'; echo '</pre>';

// echo "<p> get latest 5  photos<p>\n";
// $photos = getLatestNumPhotos($dbh,5);
// echo '<pre>'; print_r($photos); echo '</pre>';
// echo "<p> getPhotosBetween  test<p>\n";
// $photos = getPhotosBetween($dbh,0,2);
// echo '<pre>'; print_r($photos); echo '</pre>';
// $photos = getPhotosBetween($dbh,2,2);
// echo '<pre>'; print_r($photos); echo '</pre>';
// $photos = getPhotosBetween($dbh,4,2);
// echo '<pre>'; print_r($photos); echo '</pre>';
// $photos = getPhoto($dbh,14);
// echo '<pre>'; print_r($photos); echo '</pre>';


// echo '<pre>'; print_r(checkCommentOwner($dbh,2, 22)); echo '</pre>';
// deleteComment($dbh,2, 22)
// checkPhotoOwner($dbh,14,24);
// getPhotoLocation($dbh,15);
// chmod(getPhotoLocation($dbh,15), 0777);
// unlink(getPhotoLocation($dbh,15));
// deletePhoto($dbh, 15, 24);
// deleteUser($dbh, "test", "test");
// $t = getProfileByName($dbh, "test");
// echo '<pre>'; print_r($t); echo '</pre>';

// $bool_val = checkReset($dbh,"tester");
// echo '<pre>'; echo $bool_val ? 'true' : 'false'; echo '</pre>';

// $bool_val = checkConfrimCode($dbh,"tester","a1c46293f88f10caae38203c442f5630a36938e");
// echo '<pre>'; echo $bool_val ? 'true' : 'false'; echo '</pre>';

// $ppid = Upload($dbh,"./UPLOADED/archive/tester/blue duck.png",24,"tester", "","");
// echo '<pre>'; print($ppid); echo '</pre>';
// setProfilePicId($dbh,"tester",$ppid);


?>


</body>
</html>
