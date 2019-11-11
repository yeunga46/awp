<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <title>Uploading Files With PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="Author" content="Darren Provine" />
  <meta name="generator" content="GNU Emacs" />

<style type="text/css">
    <!--
    table.fancy    { border-width: 1px 3px 3px 1px;
                     border-collapse: collapse;
                     border: solid blue; }
    table.fancy td { border: 1px dotted black;
                     padding: 2px 5px;
                     margin: 5px 20px;
                     text-align: right; }
    -->
</style>

</head>
<body>
<h1>Uploading A File</h1>

<p>
The form is pretty plain: you just have an
</p>
<pre>
    input type="file" name="userfile"
</pre>
<p>
in the form, and the browser is responsible for letting the user pick
a file and sending the file up to the server.
</p>

<form enctype="multipart/form-data" method="post" action="store_it.php">

<table class="fancy">
<tr>
    <td> Enter Your Name:
    </td>
    <td> <input type="text" name="username" />
    </td>
</tr>
<tr>
    <td> Choose your file to submit:
    </td>
    <td> <input type="file" name="userfile" />
    </td>
</tr>
<tr>
    <td>
    </td>
    <td><input type="submit" value="Upload This File"/>
    </td>
</tr>
</table>

</form>

<hr style="margin-bottom:0px;" />
<p style="margin: 0px 0px 10px 0px;">
<a href="http://jigsaw.w3.org/css-validator/check/referer"><img
style="border:0;width:88px;height:31px;float:right;padding:0px 5px;"
       src="http://jigsaw.w3.org/css-validator/images/vcss" 
       alt="Valid CSS!" />
</a>
<a href="http://validator.w3.org/check/referer"><img
style="border:0;width:88px;height:31px;float:right;padding:0px 5px;"
       src="http://www.w3.org/Icons/valid-xhtml11"
       alt="Valid XHTML 1.1!" />
</a>
This page's URI:

<?php
    $my_uri = sprintf("http://%s%s",
                       $_SERVER["HTTP_HOST"],
                       rawurldecode($_SERVER["REQUEST_URI"]));
    echo "<i>$my_uri</i>";
?>
</p>

</body>
</html>
