<?php
// regemail.php - register with an email address
//
// D Provine, 4 August 2013

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Register With Email Sample Page</title>
  <meta charset="utf-8" />
  <meta name="Author" content="Darren Provine" />
  <meta name="generator" content="vi" />
</head>

<body>

<h1>Register With Email Sample Page</h1>

<p>
This allows someone to enter a username and a password, and
sends a confirmation link to that email address.
</p>

<p>
NOTE: To do this on an actual site, you have to create a
database table of the confirmation code you send out and what email
address it is for.
You should check that table <i>before</i> you send email.
Otherwise
someone can write a bot to register a couple hundred times and
use your computer to spam someone else.  A good rule of thumb
would be to require at least a one-hour wait before sending
another email confirmation, and to not send any more after five
attempts.
</p>


<form action="./checkemail.php" method="post">
<fieldset>
<legend>New User?  Register Now!</legend>
<table>
    <tr>
        <td> Name: </td>
        <td> <input name="username" type="text" /> </td>
    </tr>
    <tr>
        <td> E-mail Address: </td>
        <td> <input name="email1" type="text" /> </td>
    </tr>
    <tr>
        <td> Confirm E-mail: </td>
        <td> <input name="email2" type="text" /> </td>
    </tr>
    <tr>
         <td><input type="submit" />  </td>
    </tr>
</table>
</fieldset>
</form>

<footer>
<a href="http://elvis.rowan.edu/~kilroy/">D Provine</a>

<span style="float: right;">
<a href="http://validator.w3.org/check/referer">HTML5</a> /
<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
   CSS3</a>
</span>
</footer>

</body>
</html>
