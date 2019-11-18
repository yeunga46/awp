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
<?php

$File_Handle = fopen($_FILES["userfile"]["name"], "r");

$File_Contents = fread($File_Handle, $_FILES["userfile"]["size"]);

##echo "<pre>\n";
#echo htmlspecialchars($File_Contents, ENT_QUOTES);
#echo "</pre>\n";

fclose($File_Handle);

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

if (!file_exists("./UPLOADED/archive/" . $_SESSION["username"])) {
    mkdir("./UPLOADED/archive/". $_SESSION["username"], 0777);
    chmod("./UPLOADED/archive/". $_SESSION["username"], 0777);
}
// Make sure it was uploaded
if (!is_uploaded_file( $_FILES["userfile"]["tmp_name"])) {
    #echo "<pre>\n"; print_r($_FILES["userfile"]); echo "</pre>";
    die("Error: " . $_FILES["userfile"]["name"] . " did not upload.");
}


$targetname = "./UPLOADED/archive/" . $_SESSION["username"] . "/" . basename($_FILES["userfile"]["name"]);;

if(file_exists($targetname))
{
    ?> <script>alert("File already uploaded.")</script> <?php
    header('Location: ./upload.php');
}
else {
    if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $targetname) ) {
        // if we don't do this, the file will be mode 600, owned by
        // www, and so we won't be able to read it ourselves
        chmod($targetname, 0444);
        // but we can't upload another with the same name on top,
        // because it's now read-only
        $dbh = ConnectDB();
        
        Upload($dbh,$targetname,$_SESSION["uid"],$_SESSION["username"], $_POST["caption"],$_POST["title"]);
        header('Location: ./profile.php');
		//file + timestamp caption default null
} else {
    die("Error copying ". $_FILES["userfile"]["name"]);
}
}
?>