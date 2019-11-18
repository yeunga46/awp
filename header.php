<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap 3 works but not bootstrap 4...-->
<link rel="stylesheet" href=".\css\bootstrap.min.css">
<script src=".\scripts\jquery-3.4.1.min.js"></script>
<script src=".\scripts\bootstrap.min.js"></script>
<title><?php echo $title; ?></title>
</head>
<body id="body">
<header></header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><?php echo $title;?></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="./start.php">Home</a></li>
    </ul>
    <form class="navbar-form" style="float: inherit; display: inline-block; !important" action="./search.php">
      <div class="form-group">
        <input class="form-control" type="text" name="searchbar" placeholder="search">
      </div>
    </form> 
    <!-- Login / Register part of header-->
    <?php if(!$_SESSION["login"]) { ?>
    <form class="navbar-form navbar-right" method="post" action="./login.php">
      <div class="form-group">
          <input class="form-control" type="text" name="username" placeholder="username">
      </div>
      <div class="form-group">
          <input class="form-control" type="password" name="pwd" placeholder="password">
      </div>
    <button class="btn btn-success" type="submit">Log in</button>

    <button class="btn btn-info" data-toggle="modal" data-target="#div_registerModal" type="button">Register</button>
    </form>
    <?php } else{ ?>
    <ul class="nav navbar-nav">
      <li><a href="./profile.php">Profile</a></li>
    </ul>
    <ul class="nav navbar-nav">
      <li><a href="./upload.php">Upload</a></li>
    </ul>
    
    <!-- Log out form-->
    <form class="navbar-form navbar-right" method="post" action="./logout.php">
      <div class="form-group">
        <button class="btn btn-danger" type="submit" onclick="alert('Logging out...')">Log out</button>
      </div>
    </form>
    <?php }?>
  </div>
</nav>
</header>
<!-- Register modal-->
<div class="modal fade" id="div_registerModal" role="dialog">
<div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Register</h4>
        </div>
        <div class="modal-body">
        <form method="post" action="./register.php">
          <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" name="username">
          </div>
          <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" name="email">
          </div>
          <div class="form-group">
          <label for="pword">Password:</label>
          <input type="password" id="pword" name="pword">
          </div>
          <!-- need to add pword confirm field-->
          <button type="submit" class="btn btn-success">Register</button>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</div>
</div>
