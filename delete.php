<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
    <title>Web Database Sample Deleting</title>
</head>

<body>

<?php

// access information in directory with no web access
require_once('/home/kilroy/public_html/awp/Wk9.2-php2/Connect.php');

// other functions are right here
require_once('DBfuncs.php');

$dbh = ConnectDB();

// was a name and phone entered?
if ( isset($_GET['name'])   &&  !empty($_GET['name'])   &&
     isset($_GET['phone'])  &&  !empty($_GET['phone'])     ) {

    try {
        echo "<p>Removing all records for " . $_GET['name'] . ", " .
             $_GET['phone'] . "</p>\n";
        $query = 'DELETE FROM phonelist WHERE name=:name and phone=:phone';
        $stmt = $dbh->prepare($query);

        // Copying $_GET[] values to local variables, so nothing
        // happens to values in $_GET[] array.
        $name = $_GET['name'];
        $phone = $_GET['phone'];

        // Note each parameter bound separately (or can use array)
        $stmt->bindParam('name', $name);
        $stmt->bindParam('phone', $phone);

        $stmt->execute();
        $removed = $stmt->rowCount();

        $stmt = null;

        echo "<p>Removed $removed record(s).</p>\n";
    }
    catch(PDOException $e)
    {
        die ('PDO error deleting(): ' . $e->getMessage() );
    }


} else {

    echo "<p>No deletion was requested.</p>\n";

}


$phonelist = ListAllPhones($dbh);

echo "<p>Here is the data in the table now:<p>\n";
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

<h1>Delete an entry</h1>

<form action="delete.php" method="get">
      Name: <input type="text" name='name'><br>
      Phone: <input type="text" name='phone'><br>
      <input type="submit">
</form>


<?php include('foot.php'); ?>

</body>
</html>

