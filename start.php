
<?php 
session_start();
require_once('database/Connect.php');
require_once('database/PhotoDBFuncs.php');
$dbh = ConnectDB();
if(!isset($_SESSION["login"]))
{
  $_SESSION["login"] = false;
}
$title = ($_SESSION["login"]) 
          ? 'Welcome ' . $_SESSION["username"] 
          : $title = 'Welcome';
include("header.php");
?>
<div class="container-fluid">
<div class="latest float-center">
<h1>Latest 5 Images</h1>
<?php 
    # draw the latest 5 images on the site
        $rowsize = 5;
        $photos = getLatestNumPhotos($dbh, 5);

        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            echo '<div class="col-sm-2">';
                echo '<div class="thumbnail" id="photo-'; echo $i; echo '-div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img class="preview_img"src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '" width=100%></img>';
                            echo '<hr>';
                            echo '<div class="caption">';
                                echo '<p>'; echo htmlspecialchars($photos[$i]->caption);  echo '</p>';
                            echo '</div>';
                    echo '</a>';
                echo '</div>';
            echo '</div>';
            if($i % $rowsize == $rowsize-1)
            {
                #generate the closing tag for that row
                echo '</div>';
            }
        }
        echo '</div>';

?>

<div class="liked float-center">
<h1>5 Most Liked Images</h1>
<?php 
    # draw the most liked images on the site
        $rowsize = 5;
        $photos = getNTopLikePhotos($dbh, 5);

        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            echo '<div class="col-sm-2">';
                echo '<div class="thumbnail" id="photo-'; echo $i; echo '-div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img class="preview_img" src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '"></img>';
                            echo '<hr>';
                            echo '<div class="caption">';
                                echo '<p>'; echo htmlspecialchars($photos[$i]->caption);  echo '</p>';
                            echo '</div>';
                    echo '</a>';
                echo '</div>';
            echo '</div>';
            if($i % $rowsize == $rowsize-1)
            {
                #generate the closing tag for that row
                echo '</div>';
            }
        }
        echo '</div>';
?>
</div>
</div>
</body>
</html>