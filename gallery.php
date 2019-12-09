
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
if(isset($_GET["page"]) && $_GET["page"] >= 1 )
{ 
    $page = $_GET["page"] - 1;
}else{
    $page = 0;
}
$total = getPhotoTotal($dbh);
include("header.php");
?>
<div class="container-fluid">

<h1>Gallery</h1>
<?php 
    echo '<div class="limit">';
    echo "Display: ";
    $n = 4;
    for ($i=1; $i <= $n; $i++) { 
        echo '<a href="./gallery.php?page=1'; echo '&size='; echo $i*$n; echo '">';
        echo $i * $n; echo ' </a>';
    }
    
    echo '</div>';

    $rowsize = 4;
    if(isset($_GET["size"]))
    {
        $size = $_GET["size"];
        $_SESSION['size'] = $_GET["size"];
    }else{
        if(isset($_SESSION['size'])){
            $size = $_SESSION['size'];
        }else{
            $size = 4;
        }

    }
    $photos = getPhotosBetween($dbh, $page * $size, $size);

    // total page  = total mod size

    for($i = 0; $i < count($photos); $i++)
    {
        if($i % $rowsize == 0)
        {
            echo '<div class="row">';
        }
        #should be adjusted to according to row size
        $n = 12 / $rowsize;
        echo '<div class="col-sm-'.$n.'">';
            echo '<div class="thumbnail" id="photo-'; echo $i; echo '/div">';
                echo '<a href="./photo/'; echo $photos[$i]->photo_id; echo '">';
                    echo '<img src="'; echo str_replace(' ', '%20', $photos[$i]->filelocation); echo '" width=100%></img>';
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
                    echo '<a href="gallery.php?page='; echo $page; echo '"class="page-link" >Previous</a>';
                 }
                 ?>
                </li>

                <?php    
                for ($i=0; $i < $n; $i++) {
                    if($i == $page){
                        echo'<li class="page-item active" aria-current="page"><span class="page-link">'.($i+1);
                        echo '<span class="sr-only">(current)</span></span></li>';
                    }else{
                    echo '<li class="page-item"><a class="page-link" href="./gallery.php?page='.($i+1).'">';
                    echo $i+1; echo ' </a></li>';  
                    }
                }   
                if($page + 1 >  $n){
                    echo '<li class="page-item disabled">';
                 }else{
                    echo '<li class="page-item">';
                 }
                ?>
                  <a class="page-link" href="gallery.php?page=<?php echo $page+2; ?>">Next</a>
                </li>
              </ul>
            </nav>
        </div>
    </body>
</html>