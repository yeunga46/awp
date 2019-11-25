<?php
// access information in directory with no web access
require_once('Connect.php');

// other functions are right here
require_once('DBfuncs.php');

$dbh = ConnectDB();
// was there a name entered for the search?
if (isset($_GET['searchbar']) && !empty($_GET['searchbar'])) {
	$search = $_GET['searchbar'];
	echo json_encode(array(getProfileByName($dbh, $search), getPhotosByTitle($dbh,$search)));
}
?>