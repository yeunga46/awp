<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <title>The Uploaded File</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="Author" content="Darren Provine" />
  <meta name="generator" content="GNU Emacs" />

</head>
<body>

<!-- <h1>Now To Save The Uploaded File</h1>

<h2>Information about the upload</h2> -->
<?php

session_start();
// access information in directory with no web access
require_once('Connect.php');

// other functions are right here
require_once('DBfuncs.php');

// Note: "userfile" is the name from the form which we used for the
//       file input tag.

// echo "Name On Client: ", $_FILES["userfile"]["name"], "<br />";
// echo "Name On Server: ", $_FILES["userfile"]["tmp_name"], "<br />";
// echo "File Size: ", $_FILES["userfile"]["size"], " bytes <br />";

?>

<!-- <h2>Here's the file itself</h2>
 -->
<?php

#$File_Handle = fopen($_FILES["userfile"]["tmp_name"], "r");

#$File_Contents = fread($File_Handle, $_FILES["userfile"]["size"]);

#echo "<pre>\n";
#echo htmlspecialchars($File_Contents, ENT_QUOTES);
#echo "</pre>\n";

#fclose($File_Handle);

?>



<?php

// In order for this to work, there has to be a directory where
// the web server can save files, and where you can go in and work
// with them later.  That directory has to be mode 777, which are
// the permissions on "./UPLOADED/archive/".
// To keep everybody in the world from monkeying around in there,
// the directory UPLOADED is mode 701.  So people on Elvis in
// group "everyone" can't go in, but you can, and the webserver can.
// This is not great security, and it could be hacked, but it'll keep
// out the casual visitor.
// NOTE: the Makefile to set all this up isn't as bad as it sounds.

// echo "<p>Making directory " . $_SESSION["username"] . " . . . ";

if (file_exists("./UPLOADED/archive/" . $_SESSION["username"])) {
    echo "I see it already exists; you've uploaded before.</p>";
} else {
    // bug in mkdir() requires you to chmod()
    mkdir("./UPLOADED/archive/". $_SESSION["username"], 0777);
    chmod("./UPLOADED/archive/". $_SESSION["username"], 0777);
    echo "done.</p>";
}

echo "<h2>Copying File And Setting Permission</h2>";

// Make sure it was uploaded
if (!is_uploaded_file( $_FILES["userfile"]["tmp_name"])) {
    #echo "<pre>\n"; print_r($_FILES["userfile"]); echo "</pre>";
    die("Error: " . $_FILES["userfile"]["name"] . " did not upload.");
}


$targetname = "./UPLOADED/archive/" . $_SESSION["username"] . "/" .
              $_FILES["userfile"]["name"];

if (file_exists($targetname)) {
    echo "<p>Already uploaded one with this name.  I'm confused.</p>";
} else {
    if ( copy($_FILES["userfile"]["tmp_name"], $targetname) ) {
        // if we don't do this, the file will be mode 600, owned by
        // www, and so we won't be able to read it ourselves
        chmod($targetname, 0444);
        // but we can't upload another with the same name on top,
        // because it's now read-only
		$dbh = ConnectDB();
		Upload($dbh,$targetname,$_SESSION["uid"],$_SESSION["username"], $_POST["caption"],$_POST["title"]);
		//file + timestamp caption default null
    } else {
        die("Error copying ". $_FILES["userfile"]["name"]);
    }
}
?>

<h2>Done!</h2>

</body>
</html>
