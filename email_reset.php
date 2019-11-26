
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Reset your password</title>
  <meta charset="utf-8" />
</head>

<body>

<h1>Reset your password</h1>

<p>
Don't worry! You may have forgotten your password, but we can help you out. Enter your username below and we'll email you a link to reset your password. 
</p>


<form action="./sendemail.php" method="post">
<fieldset>
<table>
    <tr>
        <td> Username: </td>
        <td> <input name="username" type="text" /> </td>
    </tr>
    <tr>
        <td> E-mail Address: </td>
        <td> <input name="email" type="text" /> </td>
    </tr>
    <tr>
         <td><input type="submit" />  </td>
    </tr>
</table>
</fieldset>
</form>



</body>
</html>
