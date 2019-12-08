<!doctype html>
<html>

<head>
  <base href="/photosite/">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/header.js"></script>
  <title><?php echo $title; ?></title>
</head>

<body>
  <header>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="./start.php"><?php echo $title;?></a>
        </div>
        <ul class="nav navbar-nav">
          <li <?php $script = $_SERVER['SCRIPT_NAME']; if($script == '/photosite/start.php'){ echo 'class="active"';} ?>><a href="./start.php">Home</a></li>
        </ul>
        <ul class="nav navbar-nav">
          <li <?php if($script == '/photosite/gallery.php'){ echo 'class="active"';} ?>><a href="./gallery.php">Gallery</a></li>
        </ul>
        <form class="navbar-form" id="form_search" style="float: inherit; display: inline-block; !important">
          <div class="form-group">
            <input class="form-control" type="text" name="searchbar" id="searchbar" placeholder="search">
            <select class="form-control" id="searchbar_dropdown"></select>
          </div>
        </form>
        <!-- Login / Register part of header-->
        <?php if(!$_SESSION["login"]) { ?>
        <form class="navbar-form navbar-right" id="form_login">
          <div class="form-group">
            <input class="form-control" type="text" name="username" placeholder="username">
          </div>
          <div class="form-group">
            <input class="form-control" type="password" name="pwd" placeholder="password">
          </div>
          <button class="btn btn-success" type="button" id="btn_login">Log in</button>
          <button class="btn btn-info" data-toggle="modal" data-target="#div_registerModal"
            type="button">Register</button>
          <button class="btn btn-danger" data-toggle="modal" data-target="#div_forgotPassword" type="button">Forgot
            password?</button>
        </form>
        <?php } else{ ?>
        <ul class="nav navbar-nav">
          <li <?php if($script == '/photosite/profile.php'){ echo 'class="active"';} ?>><a href="./u/<?php echo $_SESSION["username"]; ?>">Profile</a></li>
        </ul>
        <ul class="nav navbar-nav">
          <li <?php if($script == '/photosite/upload.php'){ echo 'class="active"';} ?>><a href="./upload.php">Upload</a></li>
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
    <!-- Register modal-->
    <div class="modal fade" id="div_registerModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Register</h4>
          </div>
          <div class="modal-body">
            <form method="post" action="./register.php" id="form-register">
              <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" name="username" id="input_username">
              </div>
              <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="text" name="email" id="input_email">
              </div>
              <div class="form-group">
                <label for="pword">Password:</label>
                <input class="form-control" type="password" id="input_pword" name="pword">
              </div>
              <div class="form-group">
                <label for="pword">Confirm Password:</label>
                <input class="form-control" type="password" id="input_confirm_pword">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Register</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    </div>
    </div>
    <div class="modal fade" id="div_forgotPassword" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Forgot Password</h4>
          </div>
          <div class="modal-body">
            <form method="post" action="./sendemail.php" id="form-forgotPassword">
              <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" name="username" id="input_forgotUsername">
              </div>
              <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="text" name="email" id="input_forgotEmail">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Send Email</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    </div>
    </div>
  </header>