<?php
session_start();
//connect to database
include("include/DBConn.inc");
include("include/Product.php");


if (!isset($_POST["id"])) {
   //validate item and get title
    $get_iteminfo_sql = "SELECT item_title FROM store_items WHERE id =".$_POST["sel_item_id"];
    $rs = $conn->query($get_iteminfo_sql) or die("Couldn't connect");

    if ($rs->num_rows < 1) {
   	    //invalid id, send away
		$conn->close();

		header("Location: seestore.php");
   	    exit();
    } else {
		if ($rs->num_rows > 0) {
			//get info
			while ($item_info = $rs->fetch_array()) {
				$item_title = stripslashes($item_info['item_title']);
			}
			$rs->free();
			$products = array();
			}
			if (isset($_SESSION['products'])) {
				$products = unserialize($_SESSION["products"]);


			}
//obtain size and color id
			$get_item_color_id = 'select item_color_id from store_item_color where item_color = "' . $_POST['sel_item_color'] . '"';
			$rc = $conn->query($get_item_color_id) or die("Couldn't connect to store_item_color");
			if ($rc->num_rows < 1) {
				$conn->close();
				header("Location: seestore&nocolor.php");
				exit();
			}
			if ($rc->num_rows > 0) {
				//get info
				while ($item_color = $rc->fetch_array()) {
					$color_ID = $item_color['item_color_id'];
				}
				}
				$get_item_size_id = 'select item_size_id from store_item_size where item_size = "' . $_POST['sel_item_size'] . '"';
				$rc = $conn->query($get_item_size_id) or die("Couldn't connect to store_item_size");
				if ($rc->num_rows < 1) {
					$conn->close();
					header("Location: seestore&nosize.php");
					exit();
				}
				if ($rc->num_rows > 0) {
					//get info
					while ($item_size = $rc->fetch_array()) {
						$size_ID = $item_size['item_size_id'];
					}
}
//check remaining stock
					$get_stock_sql = "SELECT inventory_item_stock FROM store_item_inventory WHERE store_items_id =" . $_POST["sel_item_id"] . " and item_size_id =" . $size_ID . " and item_color_id=" . $color_ID;
					$rs = $conn->query($get_stock_sql) or die("Couldnt connect to store_item_inventory");
					if ($rs->num_rows < 1) {
						$conn->close();
						header("Location: seestore.php");
						exit();
					}

					if ($rs->num_rows > 0) {
						//get info
						while ($item_stock = $rs->fetch_array()) {
							$itemQuantitiy = $item_stock['inventory_item_stock'];
						}

					}
					if($itemQuantitiy<1){
						header("Location: showitem.php?item_id=".$_POST["sel_item_id"]."&msg=1");
						exit();
					}
					else if(($itemQuantitiy -($_POST["sel_item_qty"]))<0) {
						header("Location: showitem.php?item_id=".$_POST["sel_item_id"]."&msg=2");
						exit();
					}


						$prod = new Product($_COOKIE["PHPSESSID"], $_POST["sel_item_id"], $item_title, $_POST["sel_item_size"], $_POST["sel_item_color"], $_POST["sel_item_qty"], date("Y-m-d h:i:sa"));
						$products[] = $prod;

						//redirect to showcart page

						$_SESSION["products"] = serialize($products);

						$conn->close();

						header("Location: showcart.php");
						exit();
					}

}


 else {
    //send them somewhere else
    header("Location: seestore.php");
	$conn->close();

	exit();
}
?>
