<?php
# handles storing files
session_start();
// access information in directory with no web access
require_once('Connect.php');
// other functions are right here
require_once('PhotoDBFuncs.php');


if(isset($_FILES['userfile'])) {
    $errors     = array();
    $maxsize    = 2097152;
    $acceptable = array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    );

    if(($_FILES['userfile']['size'] >= $maxsize) || ($_FILES['userfile']['size'] == 0))  {
        $errors[] = 'File too large. File must be less than 2 megabytes.';
    }

    if((!in_array($_FILES['userfile']['type'], $acceptable)) && (!empty($_FILES["userfile"]["type"]))) {
        $errors[] = 'Invalid file type. Only JPG, GIF and PNG types are accepted.';
    }

    if(count($errors) > 0) {
        foreach($errors as $error) {
            echo '<script>alert("'.$error.'");</script>';
        }

        die(); //Ensure no more processing is done
    }

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
        $inipath = php_ini_loaded_file();

        if ($inipath) {
            echo 'Loaded php.ini: ' . $inipath;
        } else {
           echo 'A php.ini file is not loaded';
        }
        echo "<pre>\n"; print_r($_FILES["userfile"]); echo "</pre>";
        die("Error: " . $_FILES["userfile"]["name"] . " did not upload.");
    }
    $targetname = "./UPLOADED/archive/" . $_SESSION["username"] . "/" . basename($_FILES["userfile"]["name"]);
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
            $title = null;
            $caption = null;
            if(!empty($_POST["title"])){
              $title = $_POST["title"];
            }
            if(!empty($_POST["caption"])){
              $caption = $_POST["caption"];
            }
            $ppid = Upload($dbh,$targetname,$_SESSION["uid"],$_SESSION["username"], $caption, $title);
          
            header('Location: ./profile.php?username='.$_SESSION["username"]);

        } else {
            die("Error copying ". $_FILES["userfile"]["name"]);
        }
    }
}


?>