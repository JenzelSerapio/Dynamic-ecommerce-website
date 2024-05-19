<?php

include ('./data_management/admin.php');
include ('./account_management/cart.php');

function populate_catlist()
{
	global $link;

	$query = 'SELECT * FROM cat ORDER BY name';
	$result = mysqli_query($link, $query);
	while ($cat = mysqli_fetch_row($result))
		echo '<input type="submit" class="catlist" name="cat" value="'.$cat[1].'" />';
}

function populate_allitms()
{
	global $link;

	$query = 'SELECT * FROM itm';
	$result = mysqli_query($link, $query);
	$nbprod = mysqli_query($link, 'SELECT COUNT(*) FROM itm');
	echo '<div class="itmtitle">Total: '.mysqli_fetch_row($nbprod)[0]." products</div>";
	while ($cat = mysqli_fetch_row($result))
		echo '
	<div class="itmlist">
		<div class="itmname">'.$cat[1].'</div>
		<div class="itmimg">
			<img src="./imgs/'.$cat[1].'.png">
		</div>
		<div class="itmmidcontainer">
			<div class="itmstock">Stock: '.$cat[2].'</div>
		</div>
		<div class="itmbotcontainer">
			<div class="itmprice">Php '.$cat[3].'</div>
			<form method="POST" action=".">
				<button type="submit" class="itmbuy" name="add_cart" value="'.$cat[0].'">Add to Cart</button>
			</form>
		</div>
	</div>
	';
}

function populate_uncategorized()
{
	global $link;

	$query = 'SELECT * FROM itm WHERE itm_id NOT IN (SELECT itm_id FROM itm_cat)';
	$result = mysqli_query($link, $query);
	$nbprod = mysqli_query($link, 'SELECT COUNT(*) FROM itm WHERE itm_id NOT IN (SELECT itm_id FROM itm_cat)');
	echo '<div class="itmtitle">Total uncategorized: '.mysqli_fetch_row($nbprod)[0]." products</div>";
	while ($cat = mysqli_fetch_row($result))
		echo '
	<div class="itmlist">
		<div class="itmname">'.$cat[1].'</div>
		<div class="itmimg">
			<img src="./imgs/'.$cat[1].'.png">
		</div>
		<div class="itmmidcontainer">
			<div class="itmstock">Stock: '.$cat[2].'</div>
		</div>
		<div class="itmbotcontainer">
			<div class="itmprice">Php '.$cat[3].'</div>
			<form method="POST" action=".">
				<button type="submit" class="itmbuy" name="add_cart" value="'.$cat[0].'">Add to Cart</button>
			</form>
		</div>
	</div>
	';
}

function populate_category()
{
	global $link;

	$query = 'SELECT cat_id from cat WHERE name="'.$_GET['cat'].'"';
	$result = mysqli_query($link, $query);
	$cat_id = mysqli_fetch_row($result)[0];
	$query =	'select itm.*
				from itm
				join itm_cat on itm.itm_id=itm_cat.itm_id
				join cat on itm_cat.cat_id=cat.cat_id
				where cat.cat_id='.$cat_id;
	$result = mysqli_query($link, $query);
	$nbprod = mysqli_query($link, 'SELECT COUNT(*) FROM itm_cat WHERE cat_id="'.$cat_id.'"');
	echo '<div class="itmtitle">'.$_GET['cat'].'</div>';
	while ($cat = mysqli_fetch_row($result))
		echo '
	<div class="itmlist">
		<div class="itmname">'.$cat[1].'</div>
		<div class="itmimg">
			<img src="./imgs/'.$cat[1].'.png">
		</div>
		<div class="itmmidcontainer">
			<div class="itmstock">Stock: '.$cat[2].'</div>
		</div>
		<div class="itmbotcontainer">
			<div class="itmprice">Php '.$cat[3].'</div>
			<form method="POST" action=".">
				<button type="submit" class="itmbuy" name="add_cart" value="'.$cat[0].'">Add to Cart</button>
			</form>
		</div>
	</div>
	';
}

function populate_home()
{
	global $link;

	include ('./htmls/home.html');

	$result = mysqli_query($link, "SELECT * FROM `itm` ORDER BY RAND() LIMIT 3");
	while ($cat = mysqli_fetch_row($result))
		echo '
	<div class="itmlist">
		<div class="itmname">'.$cat[1].'</div>
		<div class="itmimg">
			<img src="./imgs/'.$cat[1].'.png">
		</div>
		<div class="itmmidcontainer">
			<div class="itmstock">Stock: '.$cat[2].'</div>
		</div>
		<div class="itmbotcontainer">
			<div class="itmprice">Php '.$cat[3].'</div>
			<form method="POST" action=".">
				<button type="submit" class="itmbuy" name="add_cart" value="'.$cat[0].'">Add to Cart</button>
			</form>
		</div>
	</div>
	';
}

function populate_search()
{
	global $link;

	if (!isset($_GET['searchtext']) || $_GET['searchtext'] == '')
	{
		echo "<script type='text/javascript'>alert('Search query empty!')</script>";
		unset($_GET['searchtext'], $_GET['submitsearch']);
		populate_main();
	}
	else
	{
		echo '<div class="itmtitle">Products that match the search "'.$_GET['searchtext'].'":</div>';
		$result = mysqli_query($link, 'SELECT * FROM `itm` WHERE name LIKE "%'.$_GET['searchtext'].'%"');
		if ($cat = mysqli_fetch_row($result))
		{
			echo '
			<div class="itmlist">
				<div class="itmname">'.$cat[1].'</div>
				<div class="itmimg">
					<img src="./imgs/'.$cat[1].'.png">
				</div>
				<div class="itmmidcontainer">
					<div class="itmstock">Stock: '.$cat[2].'</div>
				</div>
				<div class="itmbotcontainer">
					<div class="itmprice">Php' .$cat[3].'</div>
					<form method="POST" action=".">
						<button type="submit" class="itmbuy" name="add_cart" value="'.$cat[0].'">Add to Cart</button>
					</form>
				</div>
			</div>
			';
			while ($cat = mysqli_fetch_row($result))
				echo '
				<div class="itmlist">
					<div class="itmname">'.$cat[1].'</div>
					<div class="itmimg">
						<img src="./imgs/'.$cat[1].'.png">
					</div>
					<div class="itmmidcontainer">
						<div class="itmstock">Stock: '.$cat[2].'</div>
					</div>
					<div class="itmbotcontainer">
						<div class="itmprice">Php '.$cat[3].'</div>
						<form method="POST" action=".">
							<button type="submit" class="itmbuy" name="add_cart" value="'.$cat[0].'">Add to Cart</button>
						</form>
					</div>
				</div>
				';
		}
		else
		{
			echo "<script type='text/javascript'>alert('Search returned nothing! :(')</script>";
			unset($_GET['searchtext'], $_GET['submitsearch']);
			populate_main();
		}
	}
}

function populate_admin()
{
	global $link;

	include ('./htmls/adminmenu.html');

	echo '
		<div class="cartitm" style="margin-bottom: 1%; margin-top:3%; ">Users carts:</div>
		';
	echo '
		<div class="cartitm" style="margin-bottom: 3%; margin-top: 0;">
			<div class="cartcol" style="border-right-style: none; margin-left: 3%;">Item Name</div>
			<div class="cartcol" style="border-right-style: none">Amount</div>
			<div class="cartcol">Price (Php)</div>
		</div>
		';
	$result = mysqli_query($link, 'SELECT login FROM usr_itm GROUP BY login');
	while ($login = mysqli_fetch_row($result))
	{
		$res2 = mysqli_query($link, 'SELECT itm.*, usr_itm.amount FROM itm JOIN usr_itm ON usr_itm.itm_id = itm.itm_id WHERE login="'.$login[0].'"');
		echo '<div class="itmtitle">'.$login[0]."'s cart:</div>";
		while ($itmb = mysqli_fetch_row($res2))
			echo '
				<div class="cartitm" style="margin-bottom: 0;">
					<div class="cartcol" style="border-right-style: none; margin-left: 3%;">'.$itmb[1].'</div>
					<div class="cartcol" style="border-right-style: none">'.$itmb[4].'</div>
					<div class="cartcol">'.$itmb[3].'</div>
				</div>
				';
		echo '<div class="cartitm" style="margin-bottom: 0.5%; margin-top:1.5%; background-color:transparent; height: 1%;"></div>';
	}

}

function populate_addeditem()
{
	global $link;

	$result = mysqli_query($link, 'SELECT * FROM `itm` WHERE itm_id="'.$_POST['add_cart'].'"');
	$cat = mysqli_fetch_row($result);

	if ($cat[2] > 0)
	{
		if (isset($_SESSION['logged_in_user']))
			add_to_cart($_POST['add_cart']);
		else
			add_to_cart_session($_POST['add_cart']);
	}
	else
		echo "<script type='text/javascript'>alert('There are no ".$cat[1]." in stock!')</script>";
	$result = mysqli_query($link, 'SELECT * FROM `itm` WHERE itm_id="'.$_POST['add_cart'].'"');
	$cat = mysqli_fetch_row($result);
	echo '<div class="itmtitle">Added to cart:</div>';
	echo '
	<div class="itmlist" style="position: absolute; top: 25%; left:30%;">
		<div class="itmname">'.$cat[1].'</div>
		<div class="itmimg">
			<img src="./imgs/'.$cat[1].'.png">
		</div>
		<div class="itmmidcontainer">
			<div class="itmstock">Stock: '.$cat[2].'</div>
		</div>
		<div class="itmbotcontainer">
			<div class="itmprice">Php '.$cat[3].'</div>
			<form method="POST" action=".">
				<button type="submit" class="itmbuy" name="add_cart" value="'.$cat[0].'">Add Another</button>
			</form>
		</div>
	</div>
	';
}

function populate_main()
{
	if (isset($_SESSION['cart'], $_SESSION['logged_in_user']))
		add_session_cart();
	if (isset($_POST['rm_cart']))
		rm_cart($_POST['rm_cart']);
	else if (isset($_POST['create_account']) || isset($_POST['create_user']))
		include ('./htmls/create_account.html');
	else if (isset($_POST['delete_account']))
		include ('./htmls/delete_account.html');
	else if (isset($_GET['submitsearch']))
		populate_search();
	else if (isset($_POST['adminquery']))
		adminquery();
	else if (isset($_POST['add_cart']))
		populate_addeditem();
	else if (isset($_GET['cat']) && $_GET['cat'] != 'Home')
	{
		if ($_GET['cat'] == 'Info')
			echo '<iframe src="https://drive.google.com/file/d/0B2v9WdT_KGFWNU5tVEtycE1uMWs/preview" width="98%" height="100%"></iframe>';
		else if ($_GET['cat'] == 'Subject')
			echo '<iframe src="https://drive.google.com/file/d/0B2v9WdT_KGFWSDB2bkFmWlJOckU/preview" width="98%" height="100%"></iframe>';
		else if ($_GET['cat'] == 'Admin')
		{
			if (check_admin())
				populate_admin();
			else
				populate_home();
		}
		else if ($_GET['cat'] == 'mycart')
			show_cart();
		else if ($_GET['cat'] == 'All Products')
			populate_allitms();
		else if ($_GET['cat'] == 'Uncategorized')
			populate_uncategorized();
		else
			populate_category();	
	}
	else
		populate_home();

}
?>

