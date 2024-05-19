<?php

function logout()
{
	if (isset($_SESSION['logged_in_user']))
		unset($_SESSION['logged_in_user']);
}

function login()
{
	global $link;

	if (!isset($_POST['login']) || $_POST['login'] == '')
		echo "<script type='text/javascript'>alert('No login submitted!')</script>";
	else if (!isset($_POST['passwd']) || $_POST['passwd'] == '')
		echo "<script type='text/javascript'>alert('No password submitted!')</script>";
	else
	{
		$passwd = hash("SHA1", $_POST['passwd']);
		$query = 'SELECT login, passwd FROM usr WHERE login="'.$_POST['login'].'" AND passwd="'.$passwd.'"';
		$array = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($array) === NULL)
			echo "<script type='text/javascript'>alert('Login details incorrect!')</script>";
		else
			$_SESSION['logged_in_user'] = $_POST['login'];
	}
}

function check_admin()
{
	global $link;

	$result = mysqli_query($link, 'SELECT * FROM `admin` WHERE login="'.$_SESSION['logged_in_user'].'"');
	if (mysqli_fetch_assoc($result) !== NULL)
		return (TRUE);
	else
		return (FALSE);
}

function check_potential_error()
{
	global $link;

	if (strlen($_POST['passwd']) < 6)
		echo "<script type='text/javascript'>alert('Password needs to be minimum 6 characters long!')</script>";
	else if (!preg_match("/^.+@.+\..+$/", $_POST['email']))
		echo "<script type='text/javascript'>alert('Invalid e-mail address!')</script>";
	else if (!isset($_POST['login']))
		echo "<script type='text/javascript'>alert('No login submitted!')</script>";
	else if (!isset($_POST['name']))
		echo "<script type='text/javascript'>alert('No name submitted!')</script>";
	else if (!isset($_POST['surname']))
		echo "<script type='text/javascript'>alert('No surname submitted!')</script>";
	else
	{
		$result = mysqli_query($link, 'SELECT * FROM `usr` WHERE login="'.$_POST['login'].'"');
		if (mysqli_fetch_assoc($result) !== NULL)
			echo "<script type='text/javascript'>alert('Account already exists!')</script>";
		else
			return (TRUE);
	}
}

function create_account()
{
	global $link;

	if (check_potential_error())
	{
		$query = 'INSERT INTO `usr` (`login`, `name`, `surname`, `email`, `passwd`) VALUES ("'.$_POST['login'].'", "'.$_POST['name'].'", "'.$_POST['surname'].'", "'.$_POST['email'].'", "'.hash('SHA1', $_POST['passwd']).'")';
		mysqli_query($link, $query);
		unset($_POST['create_user']);
		echo "<script type='text/javascript'>alert('Account successfully created!')</script>";
	}
}

function delete_account()
{
	global $link;

	$query = 'DELETE FROM `usr` WHERE login="'.$_SESSION['logged_in_user'].'"';
	mysqli_query($link, $query);
	$query = 'DELETE FROM `usr_itm` WHERE login="'.$_SESSION['logged_in_user'].'"';
	mysqli_query($link, $query);
	logout();
	echo "<script type='text/javascript'>alert('Account deleted!')</script>";
}

function login_main()
{
	if (isset($_POST['submitlogin']))
		login();
	else if (isset($_POST['submitlogout']))
		logout();
	else if (isset($_POST['create_user']))
		create_account();
	else if (isset($_POST['delete_user']) && $_SESSION['logged_in_user'] != 'root')
		delete_account();
}
?>