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
if (isset($_POST['name']) && !empty($_POST['name']) ) {

    echo '<p>Searching for ' . $_POST['name'] . "...</p>\n";

    $phonelist = ListMatchingPhones($dbh, $_POST['name']);

} else {

    echo "<p>No search specified; here's the whole list.</p>\n";

    $phonelist = ListAllPhones($dbh);
}

$counter = 0;
echo "<ul>\n";
foreach ( $phonelist as $number ) {
    $counter++;
    echo "    <li> $number->name, $number->phone </li>\n";
    // modification: add delete link
}
echo "</ul>\n";

echo "<p> $counter record(s) returned.<p>\n";

// uncomment next line for debugging
# echo '<pre>'; print_r($phonelist); echo '</pre>';

?>


<h1>Search for an entry</h1>

<form action="search.php" method="post">
      Name: <input type="text" name='name'><br>
       <input type="submit">
</form>

<p>(Note: try to search for the name '0' (zero), and
the name '5', and the name ' ' (space), and think
about situations in which using <i>strlen()</i> instead
of <i>isempty()</i> might be a better choice.)</p>

<?php include('foot.php'); ?>

</body>
</html>

