<?php
session_start();
include("include/DBConn.inc");
require("include/Product.php");
include ("include/include.php");
$styles="  <style>
        .smalls{
            font-size: 20px;
            margin-right: 10%;
            float:right;
        }
        span{
            font-size: 20px;

        }

    </style>";
$display_block = "<div class=\"col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 \">

<h1>Your Discounted Items</h1>";
if(isset($_SESSION['acctype'])) {
    if ($_SESSION['acctype'] != 'Admin') {
        $display_block .= 'To view Discounted items please log into an admin account';
    } else {
        $display_block .= "
    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"50%\">
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Current Discount %</th>
    <th>Price with Discount</th>
    
    </tr>";

        $rs = readMyFile();
        if ($rs == "File is Empty") {

        } else
            foreach ($rs as $key => $item) {
                $get_item = "Select item_size_id, item_color_id,item_price ,store_items_id,inventory_item_stock,item_title from store_item_inventory Inner Join store_items on store_item_inventory.store_items_id = store_items.id where Inventory_id= " . $key;
                $rp = $conn->query($get_item) or die("Couldn't connect");
                $discount = (float)$item;

                if ($rp->num_rows < 1) {
                    echo "invalid price";
                } else {
                    while ($iteminfo = $rp->fetch_array()) {
                        $get_item_color = "Select item_color from store_item_color where item_color_id =" . $iteminfo["item_color_id"];
                        $rc = $conn->query($get_item_color) or die("could't connect");
                        while ($color = $rc->fetch_array()) {
                            $item_color = $color["item_color"];

                        }
                        $get_item_size = "Select item_size from store_item_size where item_size_id =" . $iteminfo["item_size_id"];
                        $rs = $conn->query($get_item_size) or die("could't connect");
                        while ($size = $rs->fetch_array()) {
                            $item_size = $size["item_size"];

                        }
                        $item_price = $iteminfo["item_price"];
                        $item_title = $iteminfo["item_title"];
                        $item_qty = $iteminfo["inventory_item_stock"];
                    }

                }


                $display_block .= "
   	    <tr>
  	    <td align=\"center\">$item_title <br></td>
 	    <td align=\"center\">$ $item_price <br></td>
 	    <td align=\"center\">$item_qty <br></td>
 	    <td align=\"center\">$item_size <br></td>
 	       	    <td align=\"center\">$item_color<br></td>
 	    <td align=\"center\"> $item %<br></td>
   	    <td align=\"center\">" . ((100 - $discount) / 100 * $item_price) . "<br></td>
	    </tr>";

            }
        $display_block .= "</table> <a href=\"AddDiscount.php?clear\"><button type=\"button\">Clear Weekly Specials</button></a>";

// Get Items
        $get_item_sql = "SELECT  item_title, id  FROM store_items  ORDER BY id";
        $rs = $conn->query($get_item_sql) or die("Couldn't connect to Items");
        if ($rs->num_rows > 0) {
            $display_block .= "<p> <form name=\"form1\" action=\"\" method=\"post\"><strong>Select item to apply discount to:</strong><br/>
        <select id='item_Names' name=\"item_id\"  onchange='this.form.submit();'>
            <option value=\"\" disabled selected>Select your option</option>";


            while ($item = $rs->fetch_array()) {
                $item_id = $item['id'];
                $item_name = $item['item_title'];
                if (!empty($_POST["item_id"])) {
                    if ($_POST['item_id'] == $item_id) {
                        $display_block .= "<option value=\"" . $item_id . "\" selected>" . $item_name . "</option>";
                    } else {
                        $display_block .= "<option value=\"" . $item_id . "\">" . $item_name . "</option>";
                    }
                } else {
                    $display_block .= "<option value=\"" . $item_id . "\">" . $item_name . "</option>";
                }

            }
            $display_block .= "</select></form>";
        }
        $rs->free();

//get colors
        if (isset($_POST["item_id"])) {

            $get_colors_sql = "SELECT DISTINCT c.item_color FROM store_item_color AS c JOIN store_item_inventory as i on c.item_color_id = i.item_color_id WHERE store_items_id  = '" . $_POST["item_id"] . "' ORDER BY c.item_color";
            $rs = $conn->query($get_colors_sql) or die("Couldn't connect to color");
            if ($rs->num_rows > 0) {
                $display_block .= "<form name='form1' action='AddDiscount.php' method='post'><p><strong>Available Colors:</strong><br/>
        <select name=\"item_color\">";

                while ($colors = $rs->fetch_array()) {
                    $item_color = $colors['item_color'];
                    $display_block .= "<option value=\"" . $item_color . "\">" . $item_color . "</option>";
                }
                $display_block .= "</select>";
            }
            $rs->free();

        }
//free result

//get sizes
        if (isset($_POST["item_id"])) {
            $get_sizes_sql = "SELECT DISTINCT s.item_size FROM store_item_size AS s JOIN store_item_inventory as i on s.item_size_id = i.item_size_id  WHERE store_items_id = '" . $_POST["item_id"] . "' ORDER BY s.item_size";
            $rs = $conn->query($get_sizes_sql) or die("Couldn't connect to size");

            if ($rs->num_rows > 0) {
                $display_block .= "<p><strong>Available Sizes:</strong><br/>
       <select name=\"item_size\">";

                while ($sizes = $rs->fetch_array()) {
                    $item_size = $sizes['item_size'];
                    $display_block .= "<option value=\"" . $item_size . "\">" . $item_size . "</option>";
                }
            }

            $display_block .= "</select><br><strong>Please enter the percentage that you will discount this item  by :</strong>
<input id='number' type='number' min='1' max='100' name='PercentDiscount' value='0'><br>
  <input type='hidden' name='id' value='" . $_POST['item_id'] . "'>
<input type=\"submit\"  value=\"Add to discount\"/>


</form>";

            $rs->free();


        }
    }
}
else    $display_block .= 'To view Discounted items please log into an admin account';


require "footer.php";

?>

