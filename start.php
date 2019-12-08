
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

<h1>Latest images</h1>
<?php 
        $rowsize = 3;
        $photos = getLatestNumPhotos($dbh, 15);

        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            #should be adjusted to according to row size
            echo '<div class="col-sm-4">';
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

?>

</div>
</body>
</html>