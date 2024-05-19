<?php

function addusr()
{
	global $link;

	if ($_POST['login'] != '' && $_POST['name'] != ''&& $_POST['surname'] != ''
		&& $_POST['email'] != '' && $_POST['passwd'] != '')
	{
		$query = 'SELECT * FROM usr WHERE login="'.$_POST['login'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) !== NULL)
		{
			echo "<script type='text/javascript'>alert('Account already exists!')</script>";
			include ('./htmls/addusr.html');
		}
		else
		{
			$query = 'INSERT INTO `usr` (`login`, `name`, `surname`, `email`, `passwd`) VALUES ("'.$_POST['login'].'", "'.$_POST['name'].'", "'.$_POST['surname'].'", "'.$_POST['email'].'", "'.hash('SHA1', $_POST['passwd']).'")';
			mysqli_query($link, $query);
			echo "<script type='text/javascript'>alert('Account ".$_POST['login']." successfully created!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Field empty!')</script>";
		include ('./htmls/addusr.html');
	}
}

function mdfusr()
{
	global $link;

	$modified = '';
	if ($_POST['login'] != '')
	{
		$query = 'SELECT * FROM usr WHERE login="'.$_POST['login'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) == NULL)
		{
			echo "<script type='text/javascript'>alert('Account does not exist!')</script>";
			include ('./htmls/mdfusr.html');
		}
		else
		{ 
			if ($_POST['name'] != '')
			{
				mysqli_query($link, 'UPDATE `usr` SET name="'.$_POST['name'].'" WHERE login="'.$_POST['login'].'"');
				$modified .= "name ";
			}
			if ($_POST['surname'] != '')
			{
				mysqli_query($link, 'UPDATE `usr` SET surname="'.$_POST['surname'].'" WHERE login="'.$_POST['login'].'"');
				$modified .= "surname ";
			}
			if ($_POST['email'] != '')
			{
				mysqli_query($link, 'UPDATE `usr` SET email="'.$_POST['email'].'" WHERE login="'.$_POST['login'].'"');
				$modified .= "email ";
			}
			if ($_POST['passwd'] != '')
			{
				mysqli_query($link, 'UPDATE `usr` SET passwd="'.hash('SHA1', $_POST['passwd']).'" WHERE login="'.$_POST['login'].'"');
				$modified .= "passwd ";
			}
			echo "<script type='text/javascript'>alert('Modified ".$modified."!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Login empty!')</script>";
		include ('./htmls/mdfusr.html');
	}
}

function delusr()
{
	global $link;

	if ($_POST['login'] != '')
	{
		$query = 'SELECT * FROM usr WHERE login="'.$_POST['login'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) == NULL)
		{
			echo "<script type='text/javascript'>alert('Account does not exist!')</script>";
			include ('./htmls/delusr.html');
		}
		else
		{
			$query = 'DELETE FROM usr WHERE login="'.$_POST['login'].'"';
			mysqli_query($link, $query);
			$query = 'DELETE FROM usr_itm WHERE login="'.$_POST['login'].'"';
			mysqli_query($link, $query);
			echo "<script type='text/javascript'>alert('Deleted user ".$_POST['login']."!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Login empty!')</script>";
		include ('./htmls/delusr.html');
	}
}

function additm()
{
	global $link;

	if ($_POST['name'] != '' && $_POST['stock'] != '' && $_POST['price'] != '')
	{
		$query = 'SELECT * FROM itm WHERE name="'.$_POST['name'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) !== NULL)
		{
			echo "<script type='text/javascript'>alert('Item already exists!')</script>";
			include ('./htmls/additm.html');
		}
		else
		{
			$query = 'INSERT INTO `itm` (`name`, `stock`, `price`) VALUES ("'.$_POST['name'].'", "'.$_POST['stock'].'", "'.$_POST['price'].'")';
			mysqli_query($link, $query);
			if ($_POST['category'] != '')
			{
				$query = 'SELECT cat_id from cat WHERE name="'.$_POST['category'].'"';
				$result = mysqli_query($link, $query);
				if (($cat_id = mysqli_fetch_row($result)[0]) != NULL)
				{
					$query = 'SELECT itm_id from itm WHERE name="'.$_POST['name'].'"';
					$result = mysqli_query($link, $query);
					$itm_id = mysqli_fetch_row($result)[0];
					mysqli_query($link, 'INSERT INTO `itm_cat` (`itm_id`, `cat_id`) VALUES ("'.$itm_id.'", "'.$cat_id.'")');
				}
				else
					echo "<script type='text/javascript'>alert('Category ".$_POST['category']." does not exist!')</script>";
			}
			echo "<script type='text/javascript'>alert('Item ".$_POST['name']." successfully created!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Field empty!')</script>";
		include ('./htmls/additm.html');
	}
}

function mdfitm()
{
	global $link;

	$modified = '';
	if ($_POST['name'] != '')
	{
		$query = 'SELECT * FROM itm WHERE name="'.$_POST['name'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) == NULL)
		{
			echo "<script type='text/javascript'>alert('Item does not exist!')</script>";
			include ('./htmls/mdfitm.html');
		}
		else
		{ 
			if ($_POST['stock'] != '')
			{
				mysqli_query($link, 'UPDATE `itm` SET stock="'.$_POST['stock'].'" WHERE name="'.$_POST['name'].'"');
				$modified .= "stock ";
			}
			if ($_POST['price'] != '')
			{
				mysqli_query($link, 'UPDATE `itm` SET price="'.$_POST['price'].'" WHERE name="'.$_POST['name'].'"');
				$modified .= "price ";
			}
			if ($_POST['category'] != '')
			{
				$query = 'SELECT cat_id from cat WHERE name="'.$_POST['category'].'"';
				$result = mysqli_query($link, $query);
				if (($cat_id = mysqli_fetch_row($result)[0]) != NULL)
				{
					$query = 'SELECT itm_id from itm WHERE name="'.$_POST['name'].'"';
					$result = mysqli_query($link, $query);
					$itm_id = mysqli_fetch_row($result)[0];
					mysqli_query($link, 'INSERT INTO `itm_cat` (`itm_id`, `cat_id`) VALUES ("'.$itm_id.'", "'.$cat_id.'")');
				}
				else
					echo "<script type='text/javascript'>alert('Category ".$_POST['category']." does not exist!')</script>";
			}
			echo "<script type='text/javascript'>alert('Modified ".$modified."!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Name empty!')</script>";
		include ('./htmls/mdfitm.html');
	}
}

function delitm()
{
	global $link;

	if ($_POST['name'] != '')
	{
		$query = 'SELECT * FROM itm WHERE name="'.$_POST['name'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) == NULL)
		{
			echo "<script type='text/javascript'>alert('Item does not exist!')</script>";
			include ('./htmls/delitm.html');
		}
		else
		{
			$query = 'SELECT itm_id from itm WHERE name="'.$_POST['name'].'"';
			$result = mysqli_query($link, $query);
			$itm_id = mysqli_fetch_row($result)[0];

			$query = 'DELETE FROM itm_cat WHERE itm_id="'.$itm_id.'"';
			mysqli_query($link, $query);

			$query = 'DELETE FROM usr_itm WHERE itm_id="'.$itm_id.'"';
			mysqli_query($link, $query);

			$query = 'DELETE FROM itm WHERE name="'.$_POST['name'].'"';
			mysqli_query($link, $query);
			
			echo "<script type='text/javascript'>alert('Deleted item ".$_POST['name']."!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Item name empty!')</script>";
		include ('./htmls/delitm.html');
	}
}

function addcat()
{
	global $link;

	if ($_POST['name'] != '')
	{
		$query = 'SELECT * FROM cat WHERE name="'.$_POST['name'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) != NULL)
		{
			echo "<script type='text/javascript'>alert('Category already exists!')</script>";
			include ('./htmls/addcat.html');
		}
		else
		{
			$query = 'INSERT INTO `cat` (`name`) VALUES ("'.$_POST['name'].'")';
			mysqli_query($link, $query);
			echo "<script type='text/javascript'>alert('Category ".$_POST['name']." successfully created!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Category name empty!')</script>";
		include ('./htmls/addcat.html');
	}
}

function mdfcat()
{
	global $link;

	$modified = '';
	if ($_POST['cat_name'] != '' && $_POST['itm_name'])
	{
		$query = 'SELECT * FROM itm WHERE name="'.$_POST['itm_name'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) == NULL)
		{
			echo "<script type='text/javascript'>alert('Item does not exist!')</script>";
			include ('./htmls/mdfcat.html');
		}
		else
		{ 
			$query = 'SELECT cat_id from cat WHERE name="'.$_POST['cat_name'].'"';
			$result = mysqli_query($link, $query);
			if (($cat_id = mysqli_fetch_row($result)[0]) != NULL)
			{
				$query = 'SELECT itm_id from itm WHERE name="'.$_POST['itm_name'].'"';
				$result = mysqli_query($link, $query);
				$itm_id = mysqli_fetch_row($result)[0];
				mysqli_query($link, 'DELETE FROM `itm_cat` WHERE itm_id="'.$itm_id.'" AND cat_id="'.$cat_id.'"');
				echo "<script type='text/javascript'>alert('Deleted item ".$_POST['itm_name']." from category ".$_POST['cat_name']."!')</script>";
				include ('./htmls/adminmenu.html');
			}
			else
				echo "<script type='text/javascript'>alert('Category ".$_POST['category']." does not exist!')</script>";
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Field empty!')</script>";
		include ('./htmls/mdfcat.html');
	}
}

function delcat()
{
	global $link;

	if ($_POST['name'] != '')
	{
		$query = 'SELECT * FROM cat WHERE name="'.$_POST['name'].'"';
		$result = mysqli_query($link, $query);
		if (mysqli_fetch_assoc($result) == NULL)
		{
			echo "<script type='text/javascript'>alert('Category does not exist!')</script>";
			include ('./htmls/delcat.html');
		}
		else
		{
			$query = 'SELECT cat_id from cat WHERE name="'.$_POST['name'].'"';
			$result = mysqli_query($link, $query);
			$cat_id = mysqli_fetch_row($result)[0];
			$query = 'DELETE FROM itm_cat WHERE cat_id="'.$cat_id.'"';
			mysqli_query($link, $query);
			$query = 'DELETE FROM cat WHERE name="'.$_POST['name'].'"';
			mysqli_query($link, $query);
			echo "<script type='text/javascript'>alert('Deleted category ".$_POST['name']."!')</script>";
			include ('./htmls/adminmenu.html');
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Category name empty!')</script>";
		include ('./htmls/delcat.html');
	}
}

function check_admin_query()
{
	if ($_POST['adminquery'] == 'Add User')
		addusr();
	else if ($_POST['adminquery'] == 'Mdf User')
		mdfusr();
	else if ($_POST['adminquery'] == 'Del User')
		delusr();
	else if ($_POST['adminquery'] == 'Add Itm')
		additm();
	else if ($_POST['adminquery'] == 'Mdf Itm')
		mdfitm();
	else if ($_POST['adminquery'] == 'Del Itm')
		delitm();
	else if ($_POST['adminquery'] == 'Add Cat')
		addcat();
	else if ($_POST['adminquery'] == 'Mdf Cat')
		mdfcat();
	else if ($_POST['adminquery'] == 'Del Cat')
		delcat();
}

function adminquery()
{
	if ($_POST['adminquery'] == 'addusr')
		include ('./htmls/addusr.html');
	else if ($_POST['adminquery'] == 'mdfusr')
		include ('./htmls/mdfusr.html');
	else if ($_POST['adminquery'] == 'delusr')
		include ('./htmls/delusr.html');
	else if ($_POST['adminquery'] == 'additm')
		include ('./htmls/additm.html');
	else if ($_POST['adminquery'] == 'mdfitm')
		include ('./htmls/mdfitm.html');
	else if ($_POST['adminquery'] == 'delitm')
		include ('./htmls/delitm.html');
	else if ($_POST['adminquery'] == 'addcat')
		include ('./htmls/addcat.html');
	else if ($_POST['adminquery'] == 'mdfcat')
		include ('./htmls/mdfcat.html');
	else if ($_POST['adminquery'] == 'delcat')
		include ('./htmls/delcat.html');
	else
		check_admin_query();
}
?>