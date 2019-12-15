
<?php 
# set up our connections
session_start();
require_once('database/Connect.php');
require_once('database/PhotoDBFuncs.php');
$dbh = ConnectDB();

if(!isset($_SESSION["login"]))
{
  $_SESSION["login"] = false;
}

$title = ($_SESSION["login"]) ? 'Welcome ' . $_SESSION["username"] : 'Welcome';
$page = (isset($_GET["page"]) && $_GET["page"] >= 1 ) ? $_GET["page"] - 1 : $page = 0;
$total = getPhotoTotal($dbh);

include("header.php");
?>
<div class="container-fluid">
    <h1>Gallery</h1>
    <?php 
        echo '<div class="limit">';
        echo 'Display: ';
        $n = 4;
        # render the number of images per page option
        for ($i=1; $i <= $n; $i++) { 
            echo '<a href="./gallery.php?page=1&size=' . $i*$n . '">'
            . $i * $n . ' </a>';
        }
        echo ' images per page</div>';
        echo '</br>';   
        $rowsize = 4;
        # get how many pictures we want per page
        if(isset($_GET["size"]))
        {
            $size = $_GET["size"];
            $_SESSION['size'] = $_GET["size"];
        }
        else
        {
            if(isset($_SESSION['size']))
            {
                $size = $_SESSION['size'];
            }
            else{
                $size = 4;
            }
        }
        $photos = getPhotosBetween($dbh, $page * $size, $size);

        // total per page = total % size
        # draw the pictures
        echo '<div class="container-fluid">';
        for($i = 0; $i < count($photos); $i++)
        {
            if($i % $rowsize == 0)
            {
                echo '<div class="row">';
            }
            echo '<div class="col-sm-3">';
                echo '<div class="thumbnail" id="photo-'; echo $i; echo 'div">';
                    echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                        echo '<img class="preview_img" src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '" width=100%></img>';
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

    $n = ($total / $size);
?>
            <nav aria-label="Pages">
              <ul class="pagination justify-content-center">
                 <?php if($page-1 < 0){
                    echo '<li class="page-item disabled">';
                 }else{
                    echo '<li class="page-item">';
                 }
                 if($page != 0)
                 {
                     #we only want previous to show up if we have somewhere to go back to
                    echo '<a href="gallery.php?page='; echo $page; echo '"class="page-link" >Previous</a></li>';
                 }  
                for ($i=0; $i < $n; $i++) {
                    if($i == $page){
                        echo'<li class="page-item active" aria-current="page"><span class="page-link">'.($i+1);
                        echo '<span class="sr-only">(current)</span></span></li>';
                    }else{
                    echo '<li class="page-item"><a class="page-link" href="./gallery.php?page='.($i+1).'">';
                    echo $i+1; echo ' </a></li>';  
                    }
                }   
                if($page + 1 <  $n){
                    echo '<li class="page-item">';
                    echo '<a class="page-link" href="gallery.php?page='; echo $page+2; echo '">Next</a>';
                    echo '</li>';
                 }
                ?>
              </ul>
            </nav>
        </div>
    </body>
</html>