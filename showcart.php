<?php
session_start();
//connect to database
include("include/DBConn.inc");
require("include/Product.php");
require("include/include.php");
// NEED TO ADD FUNCTIONS FOR REPEATING CODE DONT FORGET
$styles=" <style>
        .smalls{
            margin-top: 3%;

            margin-right: 10%;
            float:right;
        }
    </style>";
$display_block = "<div class=\"col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 \">

<h1>Your Shopping Cart</h1>";



if (isset($_SESSION['products'])) {
    $rs =unserialize($_SESSION["products"]);
    $total = 0;
    $totalDis = 0;

    define("HST",.14975);



//get info and build cart display
    $display_block .= "

    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"98%\">
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Total Price with discount</th>
    <th>Discount</th>
     <th>Total Price with discount</th>

    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Action</th>
    </tr>";

    foreach ($rs as $item) {
        $get_Price= "Select item_price from store_items where id= ".$item->getId();
        $rp = $conn->query($get_Price) or die("Couldn't connect");


            if ($rp->num_rows < 1) {
                echo "invalid price";
            }
            else {

                while ($price = $rp->fetch_array()) {
                    $item_price = $price["item_price"];

                }
                $test=readMyFile();
                if ($test=="File is Empty"){

                }
                else{
                    $discount=null;

                    foreach ($test as $key=>$items) {
                        $get_item = "Select item_size_id, item_color_id ,store_items_id from store_item_inventory Inner Join store_items on store_item_inventory.store_items_id = store_items.id where Inventory_id= " . $key;
                        $rp = $conn->query($get_item) or die("Couldn't connect");
                        if ($rp->num_rows < 1) {
                            echo "invalid price";
                        } else {
                            while ($iteminfo = $rp->fetch_array()) {

                                $get_item_color="Select item_color from store_item_color where item_color_id =".$iteminfo["item_color_id"];
                                $rc=$conn->query($get_item_color) or die("could't connect");
                                while($color=$rc->fetch_array()){
                                    $colors = $color["item_color"];

                                }
                                $get_item_size="Select item_size from store_item_size where item_size_id =".$iteminfo["item_size_id"];
                                $rs=$conn->query($get_item_size) or die("could't connect");
                                while($size=$rs->fetch_array()){
                                    $sizes = $size["item_size"];

                                }
                                if($iteminfo["store_items_id"]==$item->getId() && $colors==$item->getColor() && $sizes==$item->getSize()){

                                  $discount=(float)$items;

                            }

                                elseif($discount==null){
                                    $discount=0;
                                }
                        }

                        }
                    }
                }
            }
            $session_id = $item->getSessionId();
            $id_no = $item->getId();
            $item_title = $item->getTitle();
            $item_qty = $item->getQuantity();
            $item_size = $item->getSize();
            $item_color = $item->getColor();
            $time_of_creation = $item->getTimeOfCreation();

            $total_price = sprintf("%.02f", ($item_price * $item_qty));
            $total= $total+$total_price;
            $tdiscount= ((100-$discount)/100*$total_price);
             $totalDis= $totalDis+$tdiscount;


        $display_block .= "
   	    <tr>
   	    <td align=\"center\">$item_title <br></td>
   	    <td align=\"center\">$ $item_price <br></td>
   	    <td align=\"center\">$ $total_price <br></td>
   	    <td align=\"center\">% $discount <br></td>
   	    <td align=\"center\">$ $tdiscount <br></td>

   	    <td align=\"center\">$item_qty <br></td>
   	    <td align=\"center\">$item_size <br>
   	    <td align=\"center\">$item_color</td>
   	    
   	    <td align=\"center\"><a href=\"removefromcart.php?id=" . $id_no . "&time=" . $time_of_creation . "\">remove</a></td>
   	    </tr>";

        }
        $display_block .= "</table>";
        $display_block.="<form class='smalls' action=\"address.php\">
  
            <button type=\"submit\">Proceed to checkout</button>

        </form>";
        $display_block .= "<br/> Subtotal: $ ".sprintf("%.02f",$total);
        $display_block .= "<br/> Subtotal with discount: $ ".sprintf("%.02f",$totalDis);
        $standardshipping=9.99;
    $display_block .= "<br/> Standard Shipping $ ".sprintf("%.02f",$standardshipping);



    $display_block .= "<br/> tax: $ ".sprintf("%.02f",$totalDis*HST);

        $display_block .= "<br/> Total : $ ".sprintf("%.02f",$totalDis*HST*10+$standardshipping);
        $display_block .= "<br/>

    <form action='seestore.php'>
      <button type=\"submit\">Go Back to Catalog</button>
    </form>";
        $display_block .= "<br/> <form action=\"removefromcart.php\" > 
      <button type=\"submit\">Remove All</button>
    </form>";
    }

else {
    $display_block .= "
    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"98%\">
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Total Price</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
    <th>Action</th>
    </tr>";
    $display_block .= "</table>";


    $display_block .= "


      <button type=\"submit\">Go Back to Catalog</button>
    </form>";
    $display_block .= "<br/> <form action=\"removefromcart.php\" > 
      <button type=\"submit\">Remove All</button>
    </form> ";
}



require "footer.php";

?>
