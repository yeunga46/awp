<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- <base href="/~yeunga46/awp/photosite/"> -->
<!-- fixed the rewrite problem by loading everything from a cdn
<!-- Bootstrap 3 works but not bootstrap 4...-->
<base href="/photosite/">
<!-- now all the links on the profile page are broken
 because its looking for everything in a relative manner -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
$('#searchbar').on('change keyup paste', function() {
  console.log($('#form_search').serialize());
  $.ajax(
        {
          url: './search.php',           
          type: 'GET',
          data: $('#form_search').serialize(),
          success: function (response) {
              let data = $.parseJSON($.trim(response));
              console.log(data);
              //probably will use https://select2.org/getting-started/basic-usage here
          }
        });
});
$('#btn_login').on('click', function() {
  $.ajax(
    {
      url: './login.php',
      type: 'POST',
      data: $('#form_login').serialize(),
      success: function(response) {
        //need to trim because otherwise there's extra whitespace and the string won't compare properly
        if($.trim(response) === "invalid")
        {
          $('#form_login').trigger("reset");
          alert('Invalid username or password');
          //I'll change this to a tooltip later for extra eye-candy
        }
        else
        {
          //refreshes the page to get the new session variables
          location.reload();
        }
      }
    }); 
});
});
</script>
<title><?php echo $title; ?></title>
</head>
<body>
<header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <!-- had to change # to ./start or else it goes to index -->
      <a class="navbar-brand" href="./start.php"><?php echo $title;?></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="./start.php">Home</a></li>
    </ul>
    <form class="navbar-form" id="form_search" style="float: inherit; display: inline-block; !important">
      <div class="form-group">
        <input class="form-control" type="text" name="searchbar" id="searchbar" placeholder="search">
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
    <button class="btn btn-info" data-toggle="modal" data-target="#div_registerModal" type="button">Register</button>
    </form>
    <?php } else{ ?>
    <ul class="nav navbar-nav">
      <li><a href="./u/<?php echo $_SESSION["username"]; ?>">Profile</a></li>
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
