<?php
// access information in directory with no web access
require_once('Connect.php');

// other functions are right here
require_once('DBfuncs.php');

$dbh = ConnectDB();

// was there a name entered for the search?
if (isset($_GET['searchbar']) && !empty($_GET['searchbar'])) {

    echo '<p>Searching for ' . $_GET['searchbar'] . "...</p>\n";
	$uid = getUid($dbh,$_GET['searchbar']);
    $profile = getProfile($dbh, $uid);
	// uncomment next line for debugging
	echo '<pre>'; print_r($profile); echo '</pre>';
	$photos = getUserPhotos($dbh,$uid);
	echo '<pre>'; print_r($photos); echo '</pre>';
} else {

    echo "<p>No search specified; here's the whole list.</p>\n";

}

?>