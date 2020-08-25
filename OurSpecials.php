<?php
session_start();

include("include/DBConn.inc");
include("include/Product.php");
require ('include/include.php');






$display_block = "<div class=\"col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 \">
<h1>Our Specials</h1>


    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"100%\">
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Current Discount %</th>
    <th>Price with Discount</th>
    <th>action</th>
    </tr>";
$rs=readMyFile();
if ($rs=="File is Empty"){

}
else
    foreach ($rs as $key=>$item) {
        $get_item = "Select item_size_id, item_color_id,item_price ,store_items_id,inventory_item_stock,item_title from store_item_inventory Inner Join store_items on store_item_inventory.store_items_id = store_items.id where Inventory_id= " . $key;
        $rp = $conn->query($get_item) or die("Couldn't connect");
        $discount=(float)$item;

        if ($rp->num_rows < 1) {
            echo "invalid price";
        } else {
            while ($iteminfo = $rp->fetch_array()) {
                $get_item_color="Select item_color from store_item_color where item_color_id =".$iteminfo["item_color_id"];
                $rc=$conn->query($get_item_color) or die("could't connect");
                while($color=$rc->fetch_array()){
                    $item_color = $color["item_color"];

                }
                $get_item_size="Select item_size from store_item_size where item_size_id =".$iteminfo["item_size_id"];
                $rs=$conn->query($get_item_size) or die("could't connect");
                while($size=$rs->fetch_array()){
                    $item_size = $size["item_size"];

                }
                $item_price = $iteminfo["item_price"];
                $item_title = $iteminfo["item_title"];
                $item_qty = $iteminfo["inventory_item_stock"];
                $itemid=$iteminfo["store_items_id"];
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
   	    <td align=\"center\">". ((100-$discount)/100*$item_price) ."<br></td>
   	     <td><form method='post' action='addtocart.php'>
   	       <input type=\"hidden\"  name=\"sel_item_color\" value=".$item_color."> 
   	       
   	         <input type=\"hidden\"  name=\"sel_item_size\" value='".$item_size."'> 
   	           <input type=\"hidden\"  name=\"sel_item_qty\" value=\"1\">   
   	           <input type=\"hidden\"  name=\"sel_item_id\" value=".$itemid."> 
            <input type=\"submit\" value=\"Add To Cart\">   	           
</form></td>
	    </tr>";

    }
$display_block .= "</table>

<td><form  action='seestore.php'>
   	   
            <input type=\"submit\" value=\"See all products\">   	           
</form></td>



</div>";

//show


//close connection to MSSQL
$conn->close();
require "footer.php";
?>