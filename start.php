
<?php 
session_start();

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

<h1>Popular images</h1>
<!-- will want to dynamically create these -->
<div class="row" id="div_popular">
<div class="col-sm-4">
    <div class="thumbnail">
      <a href="#">
      <img src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fstatic.zerochan.net%2FAyanami.Rei.full.1035527.jpg&f=1&nofb=1" style="width:100%">
        <div class="caption">
          <p>Lorem ipsum...</p>
        </div>
      </a>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="thumbnail">
      <a href="#">
      <img src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fstatic.zerochan.net%2FAyanami.Rei.full.1035527.jpg&f=1&nofb=1" style="width:100%">
        <div class="caption">
          <p>Lorem ipsum...</p>
        </div>
      </a>
    </div>
  </div>
<div class="col-sm-4">
    <div class="thumbnail">
      <a href="#">
      <img src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fstatic.zerochan.net%2FAyanami.Rei.full.1035527.jpg&f=1&nofb=1" style="width:100%">
        <div class="caption">
          <p>Lorem ipsum...</p>
        </div>
      </a>
    </div>
  </div>
</div>
</div>
</body>
</html>