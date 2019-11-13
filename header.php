<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap 3 works but not bootstrap 4...-->
<link rel="stylesheet" href=".\css\bootstrap.min.css">
<link rel="stylesheet" href=".\css\main.css">
<script src=".\scripts\jquery-3.4.1.min.js"></script>
<script src=".\scripts\bootstrap.min.js"></script>
<title><?php echo $title; ?></title>
</head>
<body id="body">
<header></header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><?php echo $title; ?></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
    </ul>
    <form class="navbar-form navbar-right">
    <div class="form-group">
        <input class="form-control" type="text" placeholder="username">
    </div>
    <div class="form-group">
        <input class="form-control" type="password" placeholder="password">
    </div>
    <button class="btn btn-success" type="submit">Log in</button>
    <button class="btn btn-info">Register</button>
    </form>

  </div>
</nav>
</header>