<?php 
    # this file handles editing a profile's bio and / or picture
    session_start();
    
    require_once('Connect.php');
    require_once('UserDBFuncs.php');
    require_once('PhotoDBFuncs.php');

    $dbh = ConnectDB();

    $uid = $_SESSION['uid'];

    $bio = $_POST['bio'];

    $cleanedBio = htmlspecialchars($bio);
    editProfile($dbh, $uid, str_replace(array("\r\n", "\n\r", "\r", "\n"), "<br/>", $cleanedBio));


    if(isset($_FILES['userfile'])&& $_FILES['userfile']['size'] > 0) {
        $errors     = array();
        $maxsize    = 2097152;
        $acceptable = array(
            'image/jpeg',
            'image/jpg',
            'image/gif',
            'image/png'
        );

        if(($_FILES['userfile']['size'] >= $maxsize) || ($_FILES['userfile']['size'] == 0)) {
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
        }else{
            if (!file_exists("./UPLOADED/archive/" . $_SESSION["username"])) {
                mkdir("./UPLOADED/archive/". $_SESSION["username"], 0777);
                chmod("./UPLOADED/archive/". $_SESSION["username"], 0777);
            }

            if (!file_exists("./UPLOADED/archive/" . $_SESSION["username"]."/icon")) {
                mkdir("./UPLOADED/archive/". $_SESSION["username"]."/icon", 0777);
                chmod("./UPLOADED/archive/". $_SESSION["username"]."/icon", 0777);
            }
            // Make sure it was uploaded
            if (!is_uploaded_file( $_FILES["userfile"]["tmp_name"])) {
                #echo "<pre>\n"; print_r($_FILES["userfile"]); echo "</pre>";
                die("Error: " . $_FILES["userfile"]["name"] . " did not upload.");
            }
            $targetname = "./UPLOADED/archive/" . $_SESSION["username"] . "/icon/" . basename($_FILES["userfile"]["name"]);

            if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $targetname) ) {
                // if we don't do this, the file will be mode 600, owned by
                // www, and so we won't be able to read it ourselves
                chmod($targetname, 0444);
                // but we can't upload another with the same name on top,
                // because it's now read-only
                $title = null;
                $caption = null;

                $ppid = Upload($dbh,$targetname,$_SESSION["uid"],$_SESSION["username"], $caption, $title);
              
                if(!is_null(getProfilePicId($dbh, $_SESSION["username"]))){
                    $old_ppid = getProfilePicId($dbh,$_SESSION["username"]);
                    deletePhoto($dbh,$old_ppid,$_SESSION["uid"]);
                }
                setProfilePicId($dbh,$_SESSION["username"],$ppid);

                header('Location: ./profile.php?username='.$_SESSION["username"]);
                //file + timestamp caption default null
            } else {
                die("Error copying ". $_FILES["userfile"]["name"]);
            }

        }
    }
    header('Location: ./u/' . $_SESSION['username']); 
?>