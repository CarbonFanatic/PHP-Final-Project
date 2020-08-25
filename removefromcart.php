<?php
session_start();
//connect to database
include("include/DBConn.inc");
require("include/Product.php");

if (isset($_GET["id"])) {
    $products =array();
    if (isset($_SESSION['products'])) {
        $products=unserialize($_SESSION["products"]);
        $testingtime=$_GET["time"];
        foreach($products as $item=>$val) {
            if ($val->getId() == $_GET["id"] && $val->getTimeOfCreation() == $_GET["time"] ) {
                unset($products[$item]);
            }
        }
        $_SESSION["products"]=serialize($products);

    }
//redirect to showcart page
header("Location: showcart.php");
exit();
}
else {
//send them somewhere else
    Session_destroy();
    header("Location: showcart.php");
    exit();
}
$conn->close();
?>