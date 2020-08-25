<?php
session_start();
if(!empty($_POST)){
    $MyStr=$_POST;
    setcookie("paymentinfo", serialize($MyStr),time()+60);
}

//connect to database
include("include/DBConn.inc");
require("include/Product.php");
include('include/include.php');
$styles="<style>
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

<h1>Your Invoice</h1>";
if (isset($_POST['type'])) {
if(($_POST['type'])== 'Standard'){
    $shiptype='Standard';
}
else if(($_POST['type'])=='Expedited'){
    $shiptype='Expedited';
}
if (array_key_exists($_POST['type'],$shipping)) {
    $shipprice = ($shipping[($_POST['type'])]);
}

if (isset($_SESSION['products'])) {
    $rs = unserialize($_SESSION["products"]);
    $total = 0;
    $totalDis = 0;
    define("HST", .14975);


//get info and build cart display
    $display_block .= "


    <table celpadding=\"3\" cellspacing=\"2\" border=\"1\" width=\"50%\">
    <tr>
     <th>Title</th>
    <th>Price</th>
    <th>Total Price with discount</th>
    <th>Discount</th>
     <th>Total Price with discount</th>
    <th>Quantity</th>
    <th>Size</th>
    <th>Colour</th>
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
   	    
   	   
   	    </tr>";

    }
    $display_block .= "<button type='button'> Edit Payment Info</button> </a>
";

    $display_block .= "<div class='smalls'><br/> Subtotal: $ " . sprintf("%.02f", $total);
    $display_block .= "<br/> Subtotal with discount: $ ".sprintf("%.02f",$totalDis);

$mytax=$totalDis * HST;
    $display_block .= "<br/> tax: $ " . sprintf("%.02f", $mytax);
    $display_block .= "<br/> Shipping without discount: $" . $shipprice;

$grandtotal=sprintf("%.02f", $totalDis + $mytax + $shipprice);
    $display_block .= "<br/> Total : $ " . $grandtotal . "</div>";


    $display_block .= " <br><span>Name : </span>" . $_POST["fname"] . " " . $_POST["lname"] . "<br>
       <span>card type : </span>" . $_POST["typeCard"] . " 
<br><span>card number: </span>" . $_POST["cardNumber"] . " 
    <br><span>Address : </span>" . $_POST["street"] . " <h4>City : </h4>" . $_POST["city"] . " <h4>Province : </h4>" . $_POST["province"] . "
        <br><span>Shipping Type : </span>" . $shiptype . " $ " . $shipprice;

    $display_block.="<form  action=\"completeOrder.php\" method='post'>
    <input type='hidden' id='total' name='total' value='$grandtotal'> <br>
            <button type=\"submit\">CompleteOrder</button>

        </form>";

}


}





?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/all.css">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="myCss/Css.css">
    <style>
        .smalls{
            font-size: 20px;
            margin-right: 10%;
            float:right;
        }
        span{
            font-size: 20px;

        }

    </style>
</head>
<body>
<div class="row">
    <div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">
        <div class="center">
            <img src="Images/bannerstore.png" alt="Temp" class="responsive">
        </div>
        <nav class="navbar navbar-inverse">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>




            </button>
            <div class="navbar-brand">Menu</div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">

                    <li><a href="index.html">Home</a></li>
                    <li><a href="AboutUs.html">About Us</a></li>
                    <li><a href="ContactUs.html">Contact Us</a></li>
                    <li><a href="OurSpecials.php">StorePage</a>
                        <?php
                        if(isset($_SESSION['acctype'])) {
                            if ($_SESSION['acctype'] == 'Admin') {
                                echo '<li><a href="AdminPage.php">Admin Options</a>';
                                echo '<li><a href="AdminComment.php">Comment Approval</a>';
                            }
                        }
                        ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if(isset($_SESSION['uid'])) {
                        echo '<li><a>User : '.$_SESSION["uid"].'</a>
                        </li>';
                        echo '<li><a href="include/logoutCode.php">Log out</a></li>';

                    }else{
                        echo '<li><a href="loginPage.php">Login</a></li>';

                    }
                    ?>
                    <li><a href="showcart.php" id="cart"><i class="fas fa-shopping-cart"></i> Cart </a></li>
                </ul> <!--end navbar-right -->
            </div> <!--end container -->
        </nav>
    </div>
</div>
<?php echo $display_block; ?>

</body>
<script src="https://use.fontawesome.com/c0ae1644e6.js"></script>
<script src="js/jquery-3.2.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
