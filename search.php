<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
    <title>Web Database Sample Search</title>
</head>

<body>

<?php

// access information in directory with no web access
require_once('Connect.php');

// other functions are right here
require_once('DBfuncs.php');

$dbh = ConnectDB();



// was there a name entered for the search?
if (isset($_POST['searchbar']) && !empty($_POST['searchbar']) ) {

    echo '<p>Searching for ' . $_POST['searchbar'] . "...</p>\n";

    $username = getUsername($dbh, $_POST['searchbar']);
	echo "<p> $username <p>\n";
	// uncomment next line for debugging
	echo '<pre>'; print_r($username); echo '</pre>';
} else {

    echo "<p>No search specified; here's the whole list.</p>\n";

}



?>


<h1>Search for an entry</h1>

<form method="post">
      User Id: <input type="text" name='uid'><br>
       <input type="submit">
</form>

</body>
</html>

