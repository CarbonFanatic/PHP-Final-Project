<?php
//connect to database
include("include/DBConn.inc");
require ('include/include.php');
if (isset($_GET['clear'])){
    clearfile();
    header("Location: AdminPage.php");}
else{
if (isset($_POST["id"])) {
    //obtain size and color id (***** TURN THIS INTO A FUNCTION TOMORROW, THIS IS BEING USED IN COMPLETE ORDER, WE DONT WANT REPEATING CODE
    $get_item_color_id = 'select item_color_id from store_item_color where item_color = "' . $_POST["item_color"] . '"';
    $rc = $conn->query($get_item_color_id) or die("Couldn't connect to store_item_color");
    if ($rc->num_rows < 1) {
        $conn->close();
        header("Location: AdminPage&nocolor.php");
        exit();
    }
    if ($rc->num_rows > 0) {
        //get info
        while ($item_color = $rc->fetch_array()) {
            $color_ID = $item_color['item_color_id'];
        }
    }
    $get_item_size_id = 'select item_size_id from store_item_size where item_size = "' . $_POST["item_size"]. '"';
    $rc = $conn->query($get_item_size_id) or die("Couldn't connect to store_item_size");
    if ($rc->num_rows < 1) {
        $conn->close();
         header("Location: AdminPage&nosize.php");
         exit();
    }
    if ($rc->num_rows > 0) {
        //get info
        while ($item_size = $rc->fetch_array()) {
            $size_ID = $item_size['item_size_id'];
        }
    }



    $get_item_sql  = "SELECT Inventory_id FROM store_item_inventory WHERE store_items_id ='" . $_POST["id"] . "' and item_size_id ='" . $size_ID. "' and item_color_id='" . $color_ID."'";

    $rs = $conn->query($get_item_sql) or die("Couldn't connect");
if ($rs->num_rows < 1) {
    //invalid id, send away
    $conn->close();

    header("Location: AdminPage.php");
    exit();
} else {
if ($rs->num_rows > 0) {
    //get info
    while ($item_id = $rs->fetch_array()) {
        $item = ($item_id['Inventory_id']);

    }

    writeToFile($item,$_POST['PercentDiscount']);

    $rs->free();
}
else {
    //send them somewhere else
   header("Location: AdminPage.php");
    $conn->close();

    exit();
}
}
}
}
?>
