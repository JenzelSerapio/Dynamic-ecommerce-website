<?php

function add_to_cart($itm_id)
{
	global $link;

	$query = 'SELECT * FROM usr_itm WHERE login="'.$_SESSION['logged_in_user'].'" AND itm_id="'.$itm_id.'"';
	$result = mysqli_query($link, $query);

	if (mysqli_fetch_assoc($result) == NULL)
	{
		$query = 'INSERT INTO usr_itm (login, itm_id, amount) VALUES ("'.$_SESSION['logged_in_user'].'", "'.$itm_id.'", "1")';
		mysqli_query($link, $query);
		$query = 'UPDATE itm SET stock = stock-1 WHERE itm_id="'.$itm_id.'"';
		mysqli_query($link, $query);
	}
	else
	{
		$query = 'UPDATE usr_itm SET amount = amount+1 WHERE login="'.$_SESSION['logged_in_user'].'" AND itm_id="'.$itm_id.'"';
		mysqli_query($link, $query);
		$query = 'UPDATE itm SET stock = stock-1 WHERE itm_id="'.$itm_id.'"';
		mysqli_query($link, $query);
	}
}

function add_to_cart_session($itm_id)
{
	if (!isset($_SESSION['cart']))
		$_SESSION['cart'] = '';
	$_SESSION['cart'] .= $itm_id.';';
}

function add_session_cart()
{
	$arr = explode(';', $_SESSION['cart']);
	foreach ($arr as $itm_id)
	{
		if ($itm_id != '')
			add_to_cart($itm_id);
	}
	unset($_SESSION['cart']);
}

function rm_cart($itm_id)
{
	global $link;

	$query = 'SELECT amount FROM usr_itm WHERE login="'.$_SESSION['logged_in_user'].'" AND itm_id="'.$itm_id.'"';
	$result = mysqli_query($link, $query);
	$amount = mysqli_fetch_row($result)[0];

	$query = 'UPDATE itm SET stock = stock+'.$amount.' WHERE itm_id="'.$itm_id.'"';
	mysqli_query($link, $query);

	$query = 'DELETE FROM usr_itm WHERE login="'.$_SESSION['logged_in_user'].'" AND itm_id="'.$itm_id.'"';
	$result = mysqli_query($link, $query);

	show_cart();
}

function show_cart()
{
	global $link;

	if (isset($_SESSION['logged_in_user']))
	{
		$query =	'select itm.*, usr_itm.amount
					from itm
					join usr_itm on itm.itm_id=usr_itm.itm_id
					where usr_itm.login="'.$_SESSION['logged_in_user'].'"';
		$result = mysqli_query($link, $query);
		$nbprod = mysqli_query($link, 'SELECT COUNT(*) FROM usr_itm WHERE login="'.$_SESSION['logged_in_user'].'"');
		echo '<div class="itmtitle">'.$_SESSION['logged_in_user']."'s cart: ".mysqli_fetch_row($nbprod)[0]." type(s) of product(s)</div>";
		echo '
			<div class="cartitm" style="margin-bottom: 3%;">
				<div class="cartcol" style="border-right-style: none; margin-left: 3%;">Name</div>
				<div class="cartcol" style="border-right-style: none">Amount</div>
				<div class="cartcol">Price (PHP)</div>
			</div>
			';
		$total = 0;
		while ($cartitm = mysqli_fetch_row($result))
		{
			$total += $cartitm[3] * $cartitm[4];
			echo '
			<div class="cartitm">
				<div class="cartcol" style="border-right-style: none; margin-left: 3%;">'.$cartitm[1].'</div>
				<div class="cartcol" style="border-right-style: none">'.$cartitm[4].'</div>
				<div class="cartcol style="border-right-style: none">'.$cartitm[3] * $cartitm[4].'</div>
				<form action="." method="POST" class="cartcol" style="width:5%; margin-left:2%">
					<button type="submit" class="rmcart" name="rm_cart" value="'.$cartitm[0].'">Del</button>
				</form>
			</div>
			';
		}
		echo '
			<div class="cartitm" style="margin-top: 3%;">
				<div class="cartcol" style="border-right-style: none; margin-left: 3%;">Total: </div>
				<div class="cartcol" style="border-right-style: none">'.$total.'</div>
				<div class="cartcol">Buy</div>
			</div>
			';
	}
	else if (isset($_SESSION['cart']))
	{
		$arr = explode(';', $_SESSION['cart']);
		echo '<div class="itmtitle" style="margin-bottom: 3%;">Temporary cart: (log in to add to account'."'".'s cart)</div>';
		global $total;

		foreach($arr as $itm_id)
		{
			if ($itm_id != '')
			{
				$query = 'SELECT * FROM itm WHERE itm_id="'.$itm_id.'"';
				$result = mysqli_query($link, $query);
				$cartitm = mysqli_fetch_row($result);

				$total += $cartitm[3];

				echo '
				<div class="cartitm">
					<div class="cartcol" style="border-right-style: none; margin-left: 3%;">'.$cartitm[1].'</div>
					<div class="cartcol" style="border-right-style: none">1</div>
					<div class="cartcol style="border-right-style: none">'.$cartitm[3].'</div>
				</div>
				';
			}
		}

		if (!isset($total))
			$total = 0;

		echo '
			<div class="cartitm" style="margin-top: 3%;">
				<div class="cartcol" style="border-right-style: none; margin-left: 3%;">Total: </div>
				<div class="cartcol" style="border-right-style: none">'.$total.'</div>
				<div class="cartcol">Log in</div>
			</div>
			';

	}
	else
		echo '<div class="itmtitle">Temporary cart is empty!</div>';
}

?>