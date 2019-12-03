<?php
// access information in directory with no web access
require_once('Connect.php');
// other functions are right here
require_once('UserDBFuncs.php');


$dbh = ConnectDB();

if ((isset($_GET['code']) && !empty($_GET['code']))|| (isset($_GET['u'])&&!empty($_GET['u']))) {
	if (!checkReset($dbh,$_GET['u'])) {
		die("Link has expired.");
	}
	if (!checkConfrimCode($dbh,$_GET['u'],$_GET['code'])) {
		die("Invalid link.");
	}
}else{
	header("Location:start.php");
}

if(isset($_POST['pwd1'])&&isset($_POST['pwd2'])){

	if ( $_POST['pwd1'] != $_POST['pwd2'] ) {
		die("Password doesn't match.  Try again.");
	}

	try {
		$en_password = password_hash( $_POST['pwd1'], PASSWORD_DEFAULT );
		$query = 'UPDATE photo_users SET password = :new_pwd, reset_password = 0 WHERE username=:username';
		$stmt = $dbh->prepare($query);
		// Note each parameter must be bound separately
		$stmt->bindParam(':username', $_GET['u']);
		$stmt->bindParam(':new_pwd', $en_password);
		$stmt->execute();
		$stmt = null;
		header("Location:start.php");
	}
	catch(PDOException $e)
	{
		die ('PDO error Resetting Password: ' . $e->getMessage() );
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title>Reset your password</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1>Reset your password</h1>
		<form method="post">
			<fieldset>
				<table>
					<tr>
						<td> New Password: </td>
						<td> <input name="pwd1" type="password" /> </td>
					</tr>
					<tr>
						<td> Re-confirm Password: </td>
						<td> <input name="pwd2" type="password" /> </td>
					</tr>
					<tr>
						<td><input type="submit" />  </td>
					</tr>
				</table>
			</fieldset>
		</form>
	</body>
</html>