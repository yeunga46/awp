
<?php 
session_start();
require_once('Connect.php');
require_once('PhotoDBFuncs.php');
$dbh = ConnectDB();


if(!isset($_SESSION["login"]))
{
  $_SESSION["login"] = false;
}
if ($_SESSION["login"])
{
  $title = 'Welcome '.$_SESSION["username"];
}else{
  $title = 'Welcome';
}

include("header.php");
?>
<div class="container-fluid">
<div class="latest float-center">
<h1>Latest 5 Images</h1>
<?php 
        $rowsize = 5;
        $photos = getLatestNumPhotos($dbh, 5);
<<<<<<< HEAD

        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            #should be adjusted to according to row size
            echo '<div class="col-sm-2">';
                echo '<div class="thumbnail" id="photo-'; echo $i; echo '-div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '" width=100%></img>';
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

=======

        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            #should be adjusted to according to row size
            echo '<div class="col-sm-2">';
                echo '<div class="thumbnail" id="photo-'; echo $i; echo '-div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '" width=100%></img>';
                            echo '<div class="caption">';
                                echo '<p>'; echo $photos[$i]->caption; echo '</p>';
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

>>>>>>> e7a83e07aac58eb5b795e7757294a0a7e2d4e229
?>

<div class="liked float-center">
<h1>5 Most Liked Images</h1>
<?php 
        $rowsize = 5;
        $photos = getNTopLikePhotos($dbh, 5);

        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            #should be adjusted to according to row size
            echo '<div class="col-sm-2">';
                echo '<div class="thumbnail" id="photo-'; echo $i; echo '-div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '" width=100%></img>';
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