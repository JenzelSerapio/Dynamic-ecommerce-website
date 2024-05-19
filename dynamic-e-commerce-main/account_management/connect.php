<?php

include ('./account_management/login.php');

function display_login()
{
	echo '
	<form method="POST" action=".">
		<div class="login">
			Login: <input type="text" class="loginforms" name="login" value="">
		</div>
		<div class="login">
			Password: <input type="password" class="loginforms" name="passwd" value="">
		</div>
		<div class="login">
			<input type="submit" class="loginsubm" name="submitlogin" value="Log in" />
			<input type="submit" class="loginsubm" name="create_account" value="Create account" />
		</div>
	</form>
	';
}

function display_logout()
{
	global $link;

	$query = 'SELECT * FROM usr WHERE login="'.$_SESSION['logged_in_user'].'"';
	$result = mysqli_query($link, $query);
	$arr = mysqli_fetch_assoc($result);

	echo '
	<div class="login">
	Welcome '.$arr['name']." ".$arr['surname'].'!
	</div>
	<div class="login">
	What would you like to buy today?
	</div>
	<form method="POST" action=".">
		<div class="login">
			<input type="submit" class="loginsubm" name="submitlogout" value="Log out" />
			<input type="submit" class="loginsubm" name="delete_account" value="Delete account" />
		</div>
	</form>
	';
}

function connect_main()
{
	if (!isset($_SESSION['logged_in_user']))
		display_login();
	else
		display_logout();
}

?>