<?php
session_start();

include("include/DBConn.inc");
include("include/Product.php");


$display_block = "
<div class=\"col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 \">
<h1>My Categories</h1>
<p>Select a category to see its items.</p>";

//show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";

$rs = $conn ->query($get_cats_sql) or die ("Unable to retrieve records");

if ($rs->num_rows < 1) {
    $display_block = "<p><em>Sorry, no categories to browse.</em></p>";
    }
else{
    while ($cats = $rs->fetch_array()) {
        $cat_id = $cats['id'];
        $cat_title = strtoupper(stripslashes($cats['cat_title']));
        $cat_desc = stripslashes($cats['cat_desc']);

        $display_block .= "<p><strong><a href=\"" . $_SERVER["PHP_SELF"] . "?cat_id=" . $cat_id . "\">" . $cat_title . "</a></strong><br/>" . $cat_desc . "</p>";
}
    $rs->free();
}
        if (isset($_GET["cat_id"])) {
            $cat_id=$_GET["cat_id"];
                //get items
                $get_items_sql = "SELECT id, item_title, item_price FROM store_items WHERE cat_id = '" . $cat_id . "' ORDER BY item_title";
                $rs = $conn->query($get_items_sql) or die("Couldn't connect");

                if ($rs->num_rows < 1) {
                    $display_block = "<p><em>Sorry, no items in this category.</em></p>";
                } else {
                    $display_block .= "<ul>";

                    while ($items = $rs->fetch_array()) {
                        $item_id = $items['id'];
                        $item_title = stripslashes($items['item_title']);
                        $item_price = $items['item_price'];

                        $display_block .= "<li><a href=\"showitem.php?item_id=" . $item_id .  "&msg=0\">" . $item_title ."</a></strong> (\$" . $item_price . ")</li>";
                    }

                    $display_block .= "</ul>";
                }
                $rs->free();



            //free results

        }
       $display_block.=" <form action=\"Index.php\" >
    <button type=\"submit\">Go Back to Homepage</button>
</form>";


$conn->close();
require "footer.php";

?>

