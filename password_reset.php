<?php
// access information in directory with no web access
require_once('Connect.php');
// other functions are right here
require_once('UserDBFuncs.php');
include("header.php");
$dbh = ConnectDB();



if ((isset($_GET['code']) && !empty($_GET['code'])) || (isset($_GET['u']) && !empty($_GET['u']))) {
	if (!checkReset($dbh,$_GET['u'])) {
		die("Link has expired.");
	}
	if (!checkConfrimCode($dbh,$_GET['u'],$_GET['code'])) {
		die("Invalid link.");
	}
}else{
	header("Location:start.php");
}

if((isset($_POST['pwd1'])&&!empty($_POST['pwd1']))&&(isset($_POST['pwd2'])&&!empty($_POST['pwd1']))){

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
		?>
		<script type="text/javascript">
		window.location = "./start.php";
		</script> <?php    
	}
	catch(PDOException $e)
	{
		die ('PDO error Resetting Password: ' . $e->getMessage() );
	}
	
}
?>
<div class="text-center">
		<h1>Reset your password</h1>
		<form method="post" action="password_reset.php">
			<fieldset>
				<table>
					<tr>
						<td> New Password: </td>
						<td> <input name="pwd1" type="password"> </td>
					</tr>
					<tr>
						<td> Re-confirm Password: </td>
						<td> <input name="pwd2" type="password"> </td>
					</tr>
					<tr>
						<td><input value="Submit" type="submit"> </td>
					</tr>
				</table>
			</fieldset>
		</form>
</div>
