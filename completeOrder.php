<?php
session_start();
//connect to database
include("include/DBConn.inc");
include("include/Product.php");


if (isset($_SESSION['products'])) {
    $products = unserialize($_SESSION["products"]);
    $display_block='<div class="col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">
<h1>Your total</h1> $'.$_POST["total"].'<br>';

foreach ($products as $item) {
    $id_no = $item->getId();
    $item_title = $item->getTitle();

    $item_qty = $item->getQuantity();
    $item_size = $item->getSize();
    $item_color = $item->getColor();
    $time_of_creation = $item->getTimeOfCreation();
//obtain size and color id
    $get_item_color_id = 'select item_color_id from store_item_color where item_color = "' . $item_color . '"';
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
    $get_item_size_id = 'select item_size_id from store_item_size where item_size = "' . $item_size . '"';
    $rc = $conn->query($get_item_size_id) or die("Couldn't connect to store_item_size");
    if ($rc->num_rows < 1) {
        $conn->close();
        // header("Location: seestore&nosize.php");
        // exit();
    }
    if ($rc->num_rows > 0) {
        //get info
        while ($item_size = $rc->fetch_array()) {
            $size_ID = $item_size['item_size_id'];
        }
    }
//check remaining stock
    $get_stock_sql = "SELECT inventory_item_stock FROM store_item_inventory WHERE store_items_id =" . $id_no . " and item_size_id =" . $size_ID . " and item_color_id=" . $color_ID;
    $rs = $conn->query($get_stock_sql) or die("Couldnt connect to store_item_inventory");
    if ($rs->num_rows < 1) {
        $conn->close();
        // header("Location: ourspecials.php");
        // exit();
    }

    if ($rs->num_rows > 0) {
        //get info
        while ($item_stock = $rs->fetch_array()) {
            $itemQuantitiy = $item_stock['inventory_item_stock'];
        }

    }

     if (($itemQuantitiy - $item_qty) < 0) {
    echo"not enough quantity";
    } else {

   $updatetable="Update store_item_inventory SET inventory_item_stock = inventory_item_stock - ".$item_qty." WHERE store_items_id =".$id_no." and item_size_id =" . $size_ID ." and item_color_id=" . $color_ID;
						if($conn->query($updatetable)===TRUE){
							$msg= "purchase was succesfull";
					}
						else {
							echo "Error updating record: " . $conn->error;
						}
    }
}
$display_block.=$msg;
}?>
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

                    <li><a href="index.php">Home</a></li>
                    <li><a href="AboutUs.php">About Us</a></li>
                    <li><a href="ContactUs.php">Contact Us</a></li>
                    <li><a href="ourspecials.php">StorePage</a>
                        <?php
                        if(isset($_SESSION['acctype'])) {
                            if ($_SESSION['acctype'] == 'Admin'){
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
<?php
unset($_SESSION["products"]);
echo $display_block; ?>

</body>
<script src="https://use.fontawesome.com/c0ae1644e6.js"></script>
<script src="js/jquery-3.2.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>

