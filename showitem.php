<?php
session_start();

include("include/DBConn.inc");

$display_block = "<div class=\"col-xs-o col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 \">
<h1>My Store - Item Detail</h1>";
$msg=0;
if($_GET['msg']==1){
    $display_block.="<h4>There is no more of that item available please select a new item</h4>";
}
 else if($_GET['msg']==2){
     $display_block.="<h4>Not enough stock available for that item please re-adjust the quantity</h4>";
 }
else if($_GET['msg']=='emptyfields'){
    $display_block.="<h3>Please enter a comment</h3>";
}
//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image FROM store_items AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '".$_GET["item_id"]."'";
$rs = $conn->query($get_item_sql) or die("Couldn't connect");

if ($rs->num_rows < 1) {
   //invalid item
   $display_block .= "<p><em>Invalid item selection.</em></p>";
   //valid item, get info
    }
    else{
        while ($item_info = $rs->fetch_array()) {
            $cat_id = $item_info['cat_id'];
            $cat_title = strtoupper(stripslashes($item_info['cat_title']));
            $item_title = stripslashes($item_info['item_title']);
            $item_price = $item_info['item_price'];
            $item_desc = stripslashes($item_info['item_desc']);
            $item_image = "Images/".$item_info['item_image'];

        }


        //make breadcrumb trail
        $display_block .= "<p><strong><em>You are viewing:</em><br/>
   <a href=\"seestore.php?cat_id=" . $cat_id . "\">" . $cat_title . "</a> &gt; " . $item_title . "</strong></p>
   <table cellpadding=\"3\" cellspacing=\"3\">
   <tr>
   <td valign=\"middle\" align=\"center\"> <img src=\"$item_image\"></td>
   <td valign=\"middle\"><p><strong>Description:</strong><br/>" . $item_desc . "</p>
   <p><strong>Price:</strong> \$" . $item_price . "</p>
   <form method=\"post\" action=\"addtocart.php\">";

   //free result
 $rs->free();
}
   //get colors
   $get_colors_sql = "SELECT DISTINCT c.item_color FROM store_item_color AS c JOIN store_item_inventory as i on c.item_color_id = i.item_color_id WHERE store_items_id  = '".$_GET["item_id"]."' ORDER BY c.item_color";
   $rs = $conn->query($get_colors_sql) or die("Couldn't connect to color");
   if ($rs->num_rows> 0) {
        $display_block .= "<p><strong>Available Colors:</strong><br/>
        <select name=\"sel_item_color\">";
        $colorsComment="<p><strong>Available Colors:</strong><br/>
        <select name=\"sel_item_color\">";

        while ($colors = $rs->fetch_array()) {
           $item_color = $colors['item_color'];
           $display_block .= "<option value=\"".$item_color."\">".$item_color."</option>";
            $colorsComment .= "<option value=\"".$item_color."\">".$item_color."</option>";

        }
       $display_block .= "</select>";
           $colorsComment.="</select>";

   }

   //free result
 $rs->free();

   //get sizes
   $get_sizes_sql = "SELECT DISTINCT s.item_size FROM store_item_size AS s JOIN store_item_inventory as i on s.item_size_id = i.item_size_id  WHERE store_items_id = ".$_GET["item_id"]." ORDER BY s.item_size";
   $rs = $conn->query($get_sizes_sql) or die("Couldn't connect to size");

   if ($rs->num_rows > 0) {
      $display_block .= "<p><strong>Available Sizes:</strong><br/>
       <select name=\"sel_item_size\">";
      //for comment section
       $sizeComment= "<p><strong>Available Sizes:</strong><br/>
       <select name=\"sel_item_size\">";

       while ($sizes = $rs->fetch_array()) {
          $item_size = $sizes['item_size'];
            $display_block .= "<option value=\"".$item_size."\">".$item_size."</option>";

           $sizeComment.="<option value=\"".$item_size."\">".$item_size."</option>";
       }
   }

$display_block .= "</select>";
$sizeComment.="</select>";

   //free result
 $rs->free();

   $display_block .= "
   <p><strong>Select Quantity:</strong>
   <select name=\"sel_item_qty\">";

   for($i=1; $i<11; $i++) {
       $display_block .= "<option value=\"".$i."\">".$i."</option>";
   }

   $display_block .= "
   </select>
   <input type=\"hidden\" name=\"sel_item_id\" value=\"".$_GET["item_id"]."\"/>


   <p><input type=\"submit\" name=\"submit\" value=\"Add to Cart\"/></p>
   </form>
   </td>
   </tr>
   </table>";
   $display_block.="
    <h2>Comment Section</h2>
   <form  action='include/addComment.php' method='post'> ".$colorsComment.$sizeComment."<br>
   
   <textarea name=\"iComment\" rows=\"4\" cols=\"50\"></textarea>
   <input type='hidden' name='validation' value='pending'/>
   <input type='hidden' name='itemid' value='".$_GET["item_id"]."'/>
     <input type='hidden' name='itemName' value='".$item_title."'/>
        <input type='hidden' name='uid' value='".$_SESSION["uid"]."'/>



   <br>
   <input type=\"submit\" name=\"comment\" value=\"Add Comment\"/>
</form>
   
   ";

$xml= simplexml_load_file("include/comment.xml");

   foreach ($xml as $item){
    if($item->id == $_GET["item_id"] && $item->Approval=='Approved'){

        $display_block.= "<div><p><strong>User : </strong>".$item->uid."</p> 
<p><strong Item : </strong>". $item->name."</p>
<p><Strong> Item Color : </Strong>".$item->color. " &nbsp;&nbsp;<strong> Size : </strong>". $item->size."</p>
<p> Comment : ".$item->comment."</p>-----------------------------------------</div>";


    }

   }




//close connection to MSSQL
$conn->close();
require "footer.php";
?>
