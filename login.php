<?php
// login.php
// NOTE: PHP for starting session must appear before any HTML is
// sent!

require_once('Connect.php');
require_once('DBfuncs.php');

$dbh = ConnectDB();

if ( isset($_POST['username'])   &&  !empty($_POST['username'])   && 
     isset($_POST['pwd'])  &&  !empty($_POST['pwd'])     ){

	if (checkPassword($dbh, $_POST["username"], $_POST["pwd"])){
		session_start();

		$_SESSION['time']    = time();
		$_SESSION['username'] =  $_POST["username"];
		$_SESSION['uid']  =  getUid($dbh, $_POST["username"]);
		$_SESSION['login'] =  True;
		//redirect
		header("Location:start.php");
		session_write_close();

	}else{
		echo "<br>Invalid Username or Password!<br />";
	}
}



?>
<!-- <p>
	Here's the SID:
	<?php echo session_id(); ?> <br />
	Here's the raw session info:
	<pre>
	<?php print_r($_SESSION); ?>
	</pre>
</p> -->